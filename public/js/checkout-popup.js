// ===== CHECKOUT POPUP MANAGEMENT =====

function getProvincesDataUrl() {
  const base =
    typeof BASE_URL !== "undefined" && BASE_URL
      ? String(BASE_URL).replace(/\/?$/, "/")
      : "/";
  return base + "vietnam_provinces-2025.10.1/vietnam_provinces/data/nested-divisions.json";
}

// Lưu trữ data tỉnh/phường/xã
let provincesData = [];
let currentProvinceWards = [];

// Mở popup checkout
function openCheckoutPopup() {
  if (typeof window.isLoggedIn !== "undefined" && !window.isLoggedIn) {
    const base =
      typeof BASE_URL !== "undefined" && BASE_URL
        ? String(BASE_URL).replace(/\/?$/, "/")
        : "/";
    window.location.href =
      base + "auth/login?redirect=" + encodeURIComponent("cart");
    return;
  }

  const popup = document.getElementById("checkoutPopup");
  console.log("Popup element:", popup);

  if (!popup) {
    console.error("Không tìm thấy checkout popup");
    alert("Lỗi: Không tìm thấy popup checkout!");
    return;
  }

  popup.style.display = "flex";
  document.body.style.overflow = "hidden"; // Ngăn scroll khi popup mở

  console.log("Popup đã được hiển thị");

  // Load data ban đầu
  loadProvinces();
  loadCheckoutProducts();
  calculateCheckoutTotal();
  loadSavedAddressList(); // Load danh sách địa chỉ đã lưu
}

// Đóng popup checkout
function closeCheckoutPopup() {
  const popup = document.getElementById("checkoutPopup");
  if (!popup) return;

  popup.style.display = "none";
  document.body.style.overflow = "auto"; // Cho phép scroll lại
}

// Load danh sách tỉnh/thành phố từ file JSON local
async function loadProvinces() {
  try {
    console.log("Đang load danh sách tỉnh/thành phố từ file local...");
    const response = await fetch(getProvincesDataUrl(), { credentials: "same-origin" });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    provincesData = await response.json();
    console.log("Đã load được provinces:", provincesData.length);

    const provinceSelect = $('#province');
    if (!provinceSelect.length) {
      console.error("Không tìm thấy element #province");
      return;
    }

    // Clear và populate select
    provinceSelect.empty();
    provinceSelect.append('<option value="">-- Chọn Tỉnh/Thành phố --</option>');

    provincesData.forEach((province, index) => {
      const option = $('<option></option>')
        .val(index)
        .text(province.name);
      provinceSelect.append(option);
    });

    // Initialize Select2 với search
    provinceSelect.select2({
      placeholder: "Tìm kiếm hoặc chọn tỉnh/thành phố...",
      allowClear: true,
      width: '100%',
      dropdownParent: $('#checkoutPopup'),
      language: {
        noResults: function() {
          return "Không tìm thấy kết quả";
        },
        searching: function() {
          return "Đang tìm kiếm...";
        }
      }
    });

    // Handle change event
    provinceSelect.on('change', function() {
      const selectedIndex = $(this).val();
      if (selectedIndex !== "") {
        loadWards(parseInt(selectedIndex));
      } else {
        // Clear ward select
        const wardSelect = $('#ward');
        wardSelect.empty();
        wardSelect.append('<option value="">-- Chọn Phường/Xã --</option>');
        if (wardSelect.hasClass("select2-hidden-accessible")) {
          wardSelect.select2('destroy');
        }
        wardSelect.select2({
          placeholder: "Vui lòng chọn tỉnh/thành phố trước",
          allowClear: true,
          width: '100%',
          dropdownParent: $('#checkoutPopup')
        });
      }
    });

    console.log("Đã load xong danh sách tỉnh/thành phố");
  } catch (error) {
    console.error("Lỗi khi load danh sách tỉnh:", error);
    alert("Không thể tải danh sách tỉnh/thành phố. Vui lòng thử lại!");
  }
}

// Load danh sách phường/xã theo tỉnh/thành phố đã chọn
function loadWards(provinceIndex) {
  const wardSelect = $('#ward');

  if (!wardSelect.length) {
    console.error("Không tìm thấy element #ward");
    return;
  }

  try {
    console.log(`Đang load phường/xã cho tỉnh index: ${provinceIndex}`);

    // Lấy danh sách wards từ province đã chọn
    const province = provincesData[provinceIndex];

    if (!province) {
      console.error("Không tìm thấy province với index:", provinceIndex);
      return;
    }

    currentProvinceWards = province.wards || [];
    console.log(`Đã load được ${currentProvinceWards.length} phường/xã từ ${province.name}`);

    // Destroy existing Select2 if any
    if (wardSelect.hasClass("select2-hidden-accessible")) {
      wardSelect.select2('destroy');
    }

    // Clear và populate select
    wardSelect.empty();
    wardSelect.append('<option value="">-- Chọn Phường/Xã --</option>');

    currentProvinceWards.forEach((ward, index) => {
      const option = $('<option></option>')
        .val(index)
        .text(ward.name);
      wardSelect.append(option);
    });

    // Initialize Select2 với search
    wardSelect.select2({
      placeholder: "Tìm kiếm hoặc chọn phường/xã...",
      allowClear: true,
      width: '100%',
      dropdownParent: $('#checkoutPopup'),
      language: {
        noResults: function() {
          return "Không tìm thấy kết quả";
        },
        searching: function() {
          return "Đang tìm kiếm...";
        }
      }
    });

    console.log("Đã load xong danh sách phường/xã");
  } catch (error) {
    console.error("Lỗi khi load danh sách phường/xã:", error);
    alert("Không thể tải danh sách phường/xã. Vui lòng thử lại!");
  }
}

// Alias để tương thích
function handleProvinceChange() {
  // Not needed with Select2
}

function loadDistricts() {
  // Not needed with Select2
}

// Load sản phẩm đã chọn vào popup
function loadCheckoutProducts() {
  const productsListElement = document.getElementById("checkout_products_list");
  if (!productsListElement) return;

  // Lấy data từ sessionStorage
  const checkoutProducts = JSON.parse(
    sessionStorage.getItem("checkout_products") || "[]"
  );

  if (checkoutProducts.length === 0) {
    productsListElement.innerHTML =
      '<p style="text-align: center; color: #999;">Chưa có sản phẩm nào</p>';
    return;
  }

  // Render danh sách sản phẩm
  productsListElement.innerHTML = "";
  checkoutProducts.forEach((product) => {
    // Lấy thông tin sản phẩm từ DOM hiện tại (nếu có)
    const cartItem = document.querySelector(
      `[data-product-id="${product.product_id}"]`
    );
    let productName = "Sản phẩm";
    let productImage = "";

    if (cartItem) {
      const titleElement = cartItem.querySelector(".item-title");
      const imageElement = cartItem.querySelector(".item-image img");

      if (titleElement) productName = titleElement.textContent;
      if (imageElement) productImage = imageElement.src;
    }

    const productHTML = `
      <div class="checkout-product-item">
        <div style="display: flex; align-items: center; gap: 15px; flex: 1;">
          ${
            productImage
              ? `<img src="${productImage}" alt="${productName}" style="width: 60px; height: 80px; object-fit: cover; border-radius: 4px;">`
              : ""
          }
          <div>
            <div style="font-weight: 600; margin-bottom: 5px;">${productName}</div>
            <div style="color: #666; font-size: 14px;">Số lượng: ${product.quantity}</div>
          </div>
        </div>
        <div style="font-weight: 700; color: var(--phuongnam-red);">
          ${formatCurrency(product.price * product.quantity)}
        </div>
      </div>
    `;

    productsListElement.innerHTML += productHTML;
  });
}

// Tính tổng tiền trong popup
function calculateCheckoutTotal() {
  const checkoutProducts = JSON.parse(
    sessionStorage.getItem("checkout_products") || "[]"
  );

  let subtotal = 0;
  checkoutProducts.forEach((product) => {
    subtotal += product.price * product.quantity;
  });

  const shipping = 30000; // Phí ship cố định
  const total = subtotal + shipping;

  // Cập nhật UI
  const subtotalEl = document.getElementById("checkout_subtotal");
  const shippingEl = document.getElementById("checkout_shipping");
  const totalEl = document.getElementById("checkout_total");
  const finalTotalEl = document.getElementById("final_total");

  if (subtotalEl) subtotalEl.textContent = formatCurrency(subtotal);
  if (shippingEl) shippingEl.textContent = formatCurrency(shipping);
  if (totalEl) totalEl.textContent = formatCurrency(total);
  if (finalTotalEl) finalTotalEl.textContent = formatCurrency(total);
}

// Hiển thị form thêm địa chỉ mới
function showAddAddressForm() {
  const addressForm = document.getElementById("address_form");
  if (addressForm) {
    addressForm.style.display = "block";
  }
}

// Load địa chỉ đã lưu khi chọn từ dropdown
function loadSavedAddress() {
  const selectedIndex = document.getElementById("saved_addresses").value;

  if (!selectedIndex || selectedIndex === "") {
    // Reset form
    document.getElementById("recipient_name").value = '';
    document.getElementById("recipient_phone").value = '';
    $('#province').val('').trigger('change');
    $('#ward').val('').trigger('change');
    document.getElementById("street_address").value = '';
    return;
  }

  // Lấy địa chỉ từ danh sách đã load
  const address = savedAddressesList[parseInt(selectedIndex)];

  if (!address) {
    console.error("Không tìm thấy địa chỉ với index:", selectedIndex);
    return;
  }

  // Fill form với thông tin đã lưu
  document.getElementById("recipient_name").value = address.recipient_name;
  document.getElementById("recipient_phone").value = address.recipient_phone;
  document.getElementById("street_address").value = address.street_address;

  // Tìm province index từ tên
  const provinceIndex = provincesData.findIndex(p => p.name === address.province_name);
  if (provinceIndex !== -1) {
    $('#province').val(provinceIndex).trigger('change');

    // Đợi ward load xong rồi tìm và set ward
    setTimeout(() => {
      const wardIndex = currentProvinceWards.findIndex(w => w.name === address.ward_name);
      if (wardIndex !== -1) {
        $('#ward').val(wardIndex).trigger('change');
      }
    }, 500);
  }
}

// Validate thông tin trước khi submit
function validateCheckoutForm() {
  const recipientName = document.getElementById("recipient_name").value.trim();
  const recipientPhone = document.getElementById("recipient_phone").value.trim();
  const provinceIndex = $('#province').val();
  const wardIndex = $('#ward').val();
  const streetAddress = document.getElementById("street_address").value.trim();

  if (!recipientName) {
    alert("Vui lòng nhập tên người nhận!");
    document.getElementById("recipient_name").focus();
    return false;
  }

  if (!recipientPhone) {
    alert("Vui lòng nhập số điện thoại!");
    document.getElementById("recipient_phone").focus();
    return false;
  }

  const digits = recipientPhone.replace(/\D/g, '');
  const normalized =
    digits.startsWith('84') && digits.length >= 10 ? '0' + digits.slice(2) : digits;
  const phoneRegex = /^0(3|5|7|8|9)[0-9]{8}$/;
  if (!phoneRegex.test(normalized)) {
    alert("Số điện thoại không hợp lệ!");
    document.getElementById("recipient_phone").focus();
    return false;
  }

  if (!provinceIndex || provinceIndex === "") {
    alert("Vui lòng chọn Tỉnh/Thành phố!");
    $('#province').select2('open');
    return false;
  }

  if (!wardIndex || wardIndex === "") {
    alert("Vui lòng chọn Phường/Xã!");
    $('#ward').select2('open');
    return false;
  }

  if (!streetAddress) {
    alert("Vui lòng nhập số nhà, tên đường!");
    document.getElementById("street_address").focus();
    return false;
  }

  return true;
}

// Submit đơn hàng
async function submitOrder() {
  // 1. Validate form
  if (!validateCheckoutForm()) {
    return;
  }

  // 2. Thu thập thông tin từ form
  const formData = collectCheckoutFormData();

  // 3. Gửi request tạo đơn hàng
  try {
    const response = await fetch(BASE_URL + 'order/submitOrder', {
      method: 'POST',
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: new URLSearchParams({
        recipient_name: formData.recipientName,
        recipient_phone: formData.recipientPhone,
        shipping_address: formData.fullAddress,
        payment_method: formData.paymentMethod,
        products: JSON.stringify(formData.products),
        subtotal: formData.subtotal,
        shipping_fee: formData.shippingFee,
        total: formData.total,
        note: formData.note || ''
      })
    });

    const result = await response.json();

    if (result.success) {
      // 4. Thành công: Xóa session, đóng popup, redirect
      alert("Đặt hàng thành công!");
      sessionStorage.removeItem('checkout_products');
      closeCheckoutPopup();

      // Redirect đến trang đơn hàng
      window.location.href = result.redirect_url || (BASE_URL + 'customer/orders');
    } else {
      alert(result.message || "Lỗi khi đặt hàng. Vui lòng thử lại!");
    }
  } catch (error) {
    console.error("Lỗi khi đặt hàng:", error);
    alert("Lỗi kết nối. Vui lòng thử lại!");
  }
}

// Thu thập thông tin từ form checkout
function collectCheckoutFormData() {
  // Lấy thông tin người nhận
  const recipientName = document.getElementById("recipient_name").value.trim();
  const recipientPhone = document.getElementById("recipient_phone").value.trim();

  // Lấy địa chỉ
  const provinceIndex = parseInt($('#province').val());
  const wardIndex = parseInt($('#ward').val());
  const provinceName = provincesData[provinceIndex].name;
  const wardName = currentProvinceWards[wardIndex].name;
  const streetAddress = document.getElementById("street_address").value.trim();
  const fullAddress = `${streetAddress}, ${wardName}, ${provinceName}`;

  // Lấy phương thức thanh toán
  const paymentMethodEl = document.querySelector('input[name="payment_method"]:checked');
  const paymentMethod = paymentMethodEl ? paymentMethodEl.value : "COD";

  // Lấy danh sách sản phẩm
  const products = JSON.parse(sessionStorage.getItem("checkout_products") || "[]");

  // Tính tổng tiền
  let subtotal = 0;
  products.forEach((product) => {
    subtotal += product.price * product.quantity;
  });
  const shippingFee = 30000;
  const total = subtotal + shippingFee;

  // Lấy ghi chú (nếu có)
  const noteEl = document.getElementById("order_note");
  const note = noteEl ? noteEl.value.trim() : '';

  return {
    recipientName,
    recipientPhone,
    fullAddress,
    paymentMethod,
    products,
    subtotal,
    shippingFee,
    total,
    note
  };
}

// ===== QUẢN LÝ ĐỊA CHỈ ĐÃ LƯU =====

// Biến global để lưu danh sách địa chỉ
let savedAddressesList = [];

// Load danh sách địa chỉ đã lưu từ server
async function loadSavedAddressList() {
  const selectElement = document.getElementById("saved_addresses");
  if (!selectElement) return;

  try {
    const response = await fetch(BASE_URL + 'address/getAddresses', { credentials: 'same-origin' });
    const result = await response.json();

    if (!result.success) {
      console.log("Không thể load địa chỉ:", result.message);
      return;
    }

    savedAddressesList = result.addresses || [];

    // Clear options cũ (trừ option đầu tiên)
    selectElement.innerHTML = '<option value="">-- Chọn thông tin đã lưu --</option>';

    // Thêm các địa chỉ đã lưu vào dropdown
    savedAddressesList.forEach((address, index) => {
      const option = document.createElement('option');
      option.value = index;
      // Format: "Tên - SĐT | Địa chỉ"
      const displayText = `${address.recipient_name} - ${address.recipient_phone} | ${address.full_address}`;
      option.textContent = displayText;
      selectElement.appendChild(option);
    });

    console.log(`Đã load ${savedAddressesList.length} địa chỉ đã lưu`);
  } catch (error) {
    console.error("Lỗi khi load địa chỉ:", error);
  }
}

// Lưu địa chỉ mới - được gọi khi nhấn nút "Lưu thông tin"
function saveNewAddress() {
  // Validate form trước khi lưu
  const recipientName = document.getElementById("recipient_name").value.trim();
  const recipientPhone = document.getElementById("recipient_phone").value.trim();
  const provinceIndex = $('#province').val();
  const wardIndex = $('#ward').val();
  const streetAddress = document.getElementById("street_address").value.trim();

  if (!recipientName) {
    alert("Vui lòng nhập tên người nhận!");
    document.getElementById("recipient_name").focus();
    return;
  }

  if (!recipientPhone) {
    alert("Vui lòng nhập số điện thoại!");
    document.getElementById("recipient_phone").focus();
    return;
  }

  const digits = recipientPhone.replace(/\D/g, '');
  const normalized =
    digits.startsWith('84') && digits.length >= 10 ? '0' + digits.slice(2) : digits;
  const phoneRegex = /^0(3|5|7|8|9)[0-9]{8}$/;
  if (!phoneRegex.test(normalized)) {
    alert("Số điện thoại không hợp lệ!");
    document.getElementById("recipient_phone").focus();
    return;
  }

  if (!provinceIndex || provinceIndex === "") {
    alert("Vui lòng chọn Tỉnh/Thành phố!");
    $('#province').select2('open');
    return;
  }

  if (!wardIndex || wardIndex === "") {
    alert("Vui lòng chọn Phường/Xã!");
    $('#ward').select2('open');
    return;
  }

  if (!streetAddress) {
    alert("Vui lòng nhập số nhà, tên đường!");
    document.getElementById("street_address").focus();
    return;
  }

  // Validate thành công, gọi API lưu địa chỉ
  saveCurrentAddress();
}

// Lưu địa chỉ hiện tại vào database (gọi API)
async function saveCurrentAddress() {
  const recipientName = document.getElementById("recipient_name").value.trim();
  const recipientPhone = document.getElementById("recipient_phone").value.trim();

  const provinceIndex = parseInt($('#province').val());
  const wardIndex = parseInt($('#ward').val());

  const provinceName = provincesData[provinceIndex].name;
  const wardName = currentProvinceWards[wardIndex].name;
  const streetAddress = document.getElementById("street_address").value.trim();

  try {
    const response = await fetch(BASE_URL + 'address/addAddress', {
      method: 'POST',
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: new URLSearchParams({
        recipient_name: recipientName,
        recipient_phone: recipientPhone,
        province_name: provinceName,
        ward_name: wardName,
        street_address: streetAddress,
        is_default: 0
      })
    });

    const result = await response.json();

    if (result.success) {
      alert("Đã lưu thông tin giao hàng thành công!");
      // Reload danh sách địa chỉ
      await loadSavedAddressList();
    } else {
      alert(result.message || "Lỗi khi lưu địa chỉ");
    }
  } catch (error) {
    console.error("Lỗi khi lưu địa chỉ:", error);
    alert("Lỗi kết nối khi lưu địa chỉ");
  }
}

// Đóng popup khi click ra ngoài
document.addEventListener("DOMContentLoaded", function () {
  const popup = document.getElementById("checkoutPopup");
  if (popup) {
    popup.addEventListener("click", function (e) {
      if (e.target === popup) {
        closeCheckoutPopup();
      }
    });
  }
});

// Format tiền tệ
if (typeof formatCurrency === "undefined") {
  function formatCurrency(amount) {
    return new Intl.NumberFormat("vi-VN", {
      style: "currency",
      currency: "VND",
    })
      .format(amount)
      .replace("₫", "đ");
  }
}
