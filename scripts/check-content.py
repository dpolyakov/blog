"""Check Hugo post bundles and uploaded-file links without extra dependencies."""

import argparse
from html.parser import HTMLParser
from pathlib import Path
from urllib.parse import unquote, urlsplit


def check_structure(content):
    errors = []
    for path in sorted((content / "blog").rglob("*.md")):
        relative = path.relative_to(content / "blog")
        if relative == Path("_index.md"):
            continue
        if len(relative.parts) != 2 or relative.name != "index.md":
            errors.append(
                f"{path}: expected content/blog/<unique-address>/index.md; "
                "move a colliding article into its own folder"
            )
    return errors


class UploadLinks(HTMLParser):
    def __init__(self):
        super().__init__()
        self.paths = set()

    def handle_starttag(self, tag, attrs):
        for name, value in attrs:
            if name not in ("src", "href", "content") or not value:
                continue
            url = urlsplit(value)
            if url.netloc and url.netloc != "dimapolyakov.ru":
                continue
            if url.path.startswith("/uploads/"):
                self.paths.add(unquote(url.path))


def check_uploads(site):
    errors = {}
    for page in sorted(site.rglob("*.html")):
        parser = UploadLinks()
        parser.feed(page.read_text(encoding="utf-8"))
        for url in parser.paths:
            target = site / url.lstrip("/")
            if not target.is_file():
                errors.setdefault(url, f"{page}: missing uploaded file {url}")
    return list(errors.values())


def main():
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("--site", type=Path, help="Hugo output built with drafts")
    args = parser.parse_args()
    errors = check_structure(Path("content"))
    if args.site:
        if not (args.site / "index.html").is_file():
            errors.append(f"{args.site}: missing Hugo build")
        else:
            errors.extend(check_uploads(args.site))
    if errors:
        for error in errors:
            print(error)
        raise SystemExit(1)
    print("Post structure and requested upload-link checks passed.")


if __name__ == "__main__":
    main()
