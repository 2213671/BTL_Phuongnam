"""Extract <style> blocks from admin partials and prefix selectors with #main-content."""
import pathlib
import re
import subprocess


def prefix_selectors(css: str, prefix: str = "#main-content ") -> str:
    out = []
    i = 0
    n = len(css)
    while i < n:
        start = i
        while i < n and css[i] in " \t\r\n":
            i += 1
        if i >= n:
            break
        line_start = i
        if css.startswith("@", i):
            br_open = css.find("{", i)
            at_end = css.find(";", i)
            if br_open != -1 and (at_end == -1 or br_open < at_end):
                depth = 0
                j = br_open
                while j < n:
                    if css[j] == "{":
                        depth += 1
                    elif css[j] == "}":
                        depth -= 1
                        if depth == 0:
                            j += 1
                            break
                    j += 1
                head = css[i:br_open].strip().lower()
                inner = css[br_open + 1 : j - 1]
                if head.startswith("@keyframes") or head.startswith("@font-face"):
                    out.append(css[start:j])
                else:
                    fixed_inner = prefix_selectors(inner, prefix)
                    out.append(css[start : br_open + 1] + fixed_inner + css[j - 1 : j])
                i = j
                continue
            semi = css.find(";", i)
            if semi == -1:
                out.append(css[start:])
                break
            semi += 1
            out.append(css[start:semi])
            i = semi
            continue
        if css.startswith("/*", i):
            end = css.find("*/", i)
            if end == -1:
                out.append(css[start:])
                break
            end += 2
            out.append(css[start:end])
            i = end
            continue
        br = css.find("{", i)
        if br == -1:
            out.append(css[start:])
            break
        prelude = css[start:br].strip()
        depth = 0
        j = br
        while j < n:
            if css[j] == "{":
                depth += 1
            elif css[j] == "}":
                depth -= 1
                if depth == 0:
                    j += 1
                    break
            j += 1
        block = css[br:j]
        if prelude:
            parts = [p.strip() for p in prelude.split(",")]
            new_parts = []
            pfx = prefix.rstrip()
            for p in parts:
                if p.startswith(pfx + " ") or p == pfx:
                    new_parts.append(p)
                else:
                    new_parts.append(pfx + " " + p)
            indent = css[start:line_start]
            out.append(indent + ", ".join(new_parts) + " " + block.strip())
        else:
            out.append(css[start:j])
        i = j
    return "".join(out)


def read_source(root: pathlib.Path, rel: str) -> str:
    """Prefer working tree; if inline styles were stripped, fall back to last git revision."""
    p = root / rel
    t = p.read_text(encoding="utf-8")
    if "<style>" in t:
        return t
    try:
        out = subprocess.check_output(
            ["git", "show", f"HEAD:{rel}"],
            cwd=str(root),
            stderr=subprocess.DEVNULL,
        )
        return out.decode("utf-8", errors="replace")
    except (subprocess.CalledProcessError, FileNotFoundError):
        return t


def main() -> None:
    root = pathlib.Path(__file__).resolve().parents[1]
    # News create/edit share many Bootstrap-like overrides; scope them so the news list page is unaffected.
    scope_by_file: dict[str, str] = {
        "app/views/admin/news/create.php": "#main-content .pn-admin-news-editor ",
        "app/views/admin/news/edit.php": "#main-content .pn-admin-news-editor ",
    }
    default_scope = "#main-content "
    files = [
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
    chunks = [
        "/* Auto-built by tools/build_admin_partials_css.py — scoped for Nu HTML validator */\n"
    ]
    seen: set[tuple[str, str]] = set()
    for rel in files:
        t = read_source(root, rel)
        m = re.search(r"<style>(.*?)</style>", t, re.DOTALL)
        if not m:
            print("NO STYLE", rel)
            continue
        css = m.group(1).strip() + "\n"
        scope = scope_by_file.get(rel, default_scope)
        key = (scope, css)
        if key in seen:
            chunks.append(f"/* duplicate skipped: {rel} */\n")
            continue
        seen.add(key)
        chunks.append(f"/* --- {rel} --- */\n")
        chunks.append(prefix_selectors(css, scope))
        chunks.append("\n")
    out_path = root / "public/css/admin-partials.css"
    out_path.write_text("".join(chunks), encoding="utf-8")
    print("Wrote", out_path, "size", out_path.stat().st_size)


if __name__ == "__main__":
    main()
