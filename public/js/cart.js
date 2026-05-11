(function () {
  "use strict";

  function getApiBase() {
    if (typeof BASE_URL !== "undefined" && BASE_URL) {
      return String(BASE_URL).replace(/\/?$/, "/");
    }
    return "/";
  }

  class CartManager {
    constructor() {
      this.storageKey = "local_cart";
      this.isLoggedIn = !!window.isLoggedIn;
      try {
        this.migrateLegacyPhuongnamCart();
      } catch (e) {
        console.warn("Cart migrate:", e);
      }
    }

    migrateLegacyPhuongnamCart() {
      try {
        const raw = localStorage.getItem("phuongnam_cart");
        if (!raw) return;
        const legacy = JSON.parse(raw);
        localStorage.removeItem("phuongnam_cart");
        if (!Array.isArray(legacy) || legacy.length === 0) return;

        const cur = this.getLocalCart();
        const map = new Map();
        const addItems = (items) => {
          items.forEach((item) => {
            const pid = Number(item.product_id);
            const q = Number(item.quantity) || 1;
            if (pid > 0) map.set(pid, (map.get(pid) || 0) + q);
          });
        };
        addItems(Array.isArray(cur) ? cur : []);
        addItems(legacy);
        const merged = [...map.entries()].map(([product_id, quantity]) => ({
          product_id,
          quantity,
        }));
        this.saveLocalCart(merged);
      } catch (e) {
        console.warn("migrateLegacyPhuongnamCart:", e);
      }
    }

    syncLocalCartCookie(cart) {
      try {
        document.cookie = `local_cart=${JSON.stringify(
          cart
        )}; path=/; max-age=${3600 * 24 * 7}`;
      } catch (e) {
        /* ignore */
      }
    }

    getLocalCart() {
      try {
        const cart = localStorage.getItem(this.storageKey);
        return cart ? JSON.parse(cart) : [];
      } catch (e) {
        return [];
      }
    }

    saveLocalCart(cart) {
      try {
        localStorage.setItem(this.storageKey, JSON.stringify(cart));
      } catch (e) {
        console.warn("localStorage.setItem blocked or full:", e);
      }
      this.syncLocalCartCookie(cart);
    }

    clearLocalCart() {
      try {
        localStorage.removeItem(this.storageKey);
      } catch (e) {
        /* ignore */
      }
      try {
        document.cookie = "local_cart=; path=/; max-age=0";
      } catch (e) {
        /* ignore */
      }
    }

    async addToCart(productId, quantity) {
      quantity = Number(quantity) || 1;
      productId = Number(productId);
      try {
        const response = await fetch(getApiBase() + "cart/add", {
          method: "POST",
          credentials: "same-origin",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: "product_id=" + encodeURIComponent(productId) + "&quantity=" + encodeURIComponent(quantity),
        });

        const data = await response.json();

        if (data.success) {
          if (data.storage === "local") {
            this.addToLocalCart(productId, quantity);
          }
          this.updateCartCount(data.cartCount || this.getLocalCartCount());
          this.showNotification(data.message, "success");
        } else {
          this.showNotification(data.message || "Không thể thêm vào giỏ", "error");
        }
      } catch (error) {
        console.error("Add to cart error:", error);
        this.showNotification("Có lỗi xảy ra khi thêm vào giỏ", "error");
      }
    }

    addToLocalCart(productId, quantity) {
      productId = Number(productId);
      quantity = Number(quantity) || 1;
      const cart = this.getLocalCart();
      const existing = cart.find((item) => Number(item.product_id) === productId);

      if (existing) {
        existing.quantity = Number(existing.quantity) + quantity;
      } else {
        cart.push({ product_id: productId, quantity: quantity });
      }

      this.saveLocalCart(cart);
    }

    async syncCartOnLogin() {
      const localCart = this.getLocalCart();
      if (localCart.length === 0) return;

      try {
        const response = await fetch(getApiBase() + "cart/syncFromLocal", {
          method: "POST",
          credentials: "same-origin",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ cart: localCart }),
        });

        const data = await response.json();

        if (data.success) {
          this.clearLocalCart();
          const cnt = Number(data.cartCount);
          this.updateCartCount(Number.isFinite(cnt) ? cnt : 0);
        }
      } catch (error) {
        console.error("Sync cart error:", error);
      }
    }

    getLocalCartCount() {
      const cart = this.getLocalCart();
      return cart.reduce((sum, item) => sum + (Number(item.quantity) || 0), 0);
    }

    updateCartCount(count) {
      count = Number(count) || 0;
      document.querySelectorAll(".cart-badge, .cart-count").forEach((badge) => {
        badge.textContent = count;
        badge.style.display = "flex";
      });
    }

    showNotification(message, type) {
      alert(message);
    }
  }

  window.cartManager = new CartManager();

  const cm = window.cartManager;

  (async function bootCartBadge() {
    const localHas = cm.getLocalCart().length > 0;
    if (window.isLoggedIn && localHas) {
      await cm.syncCartOnLogin();
      return;
    }
    if (window.isLoggedIn) {
      const n =
        typeof window.initialCartCount !== "undefined"
          ? Number(window.initialCartCount)
          : 0;
      cm.updateCartCount(Number.isFinite(n) ? n : 0);
    } else {
      try {
        if (cm.getLocalCart().length === 0 && document.cookie) {
          const parts = document.cookie.split("; ");
          for (let i = 0; i < parts.length; i++) {
            if (!parts[i].startsWith("local_cart=")) continue;
            const rawVal = parts[i].slice("local_cart=".length);
            let parsed = null;
            try {
              parsed = JSON.parse(decodeURIComponent(rawVal));
            } catch {
              parsed = JSON.parse(rawVal);
            }
            if (Array.isArray(parsed) && parsed.length > 0) {
              cm.saveLocalCart(parsed);
            }
            break;
          }
        }
      } catch (e) {
        console.warn("Guest cart bootstrap:", e);
      }
      cm.updateCartCount(cm.getLocalCartCount());
    }
  })();

  window.updateCartBadge = function (count) {
    cm.updateCartCount(count);
  };
})();
