"""Remove first <style>...</style> block from admin partials (styles moved to admin-partials.css)."""
import pathlib
import re

FILES = [
    "app/views/admin/news/create.php",
    "app/views/admin/news/edit.php",
    "app/views/admin/products/index.php",
    "app/views/admin/products/create.php",
    "app/views/admin/products/edit.php",
    "app/views/admin/orders/index.php",
    "app/views/admin/orders/detail.php",
    "app/views/admin/orders/order_detail_modal.php",
    "app/views/admin/customers/index.php",
    "app/views/admin/customers/detail.php",
    "app/views/admin/categories/index.php",
    "app/views/admin/staff/index.php",
    "app/views/admin/staff/create.php",
    "app/views/admin/staff/edit.php",
]


def main() -> None:
    root = pathlib.Path(__file__).resolve().parents[1]
    for rel in FILES:
        p = root / rel
        t = p.read_text(encoding="utf-8")
        t2, n = re.subn(r"<style>.*?</style>\s*", "", t, count=1, flags=re.DOTALL)
        if n != 1:
            raise SystemExit(f"{rel}: expected 1 style block, removed {n}")
        p.write_text(t2, encoding="utf-8")
        print("stripped", rel)


if __name__ == "__main__":
    main()
