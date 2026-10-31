# LipaHub

Premium responsive PHP/MySQL website and custom CMS.

## Features
- Custom responsive public website.
- Database-driven homepage section builder: add, edit, hide, delete and reorder sections.
- Section layouts: hero, text, image/text, feature cards, article grid, country guides, testimonials, FAQ list, stats and CTA.
- Admin-managed footer columns, labels, URLs, legal note and copyright.
- Content manager for pages, articles, country guides, reviews and FAQs.
- Global site settings, SEO description, header navigation labels and media uploads.
- Secure admin login, password hashing, session cookies, CSRF validation and one-time initial admin setup.
- All registration CTA links default to `https://lipahub.com/register.php?ref=ItsVee`.

## Install
Follow [VPS installation](docs/INSTALL.md). For an existing installation, also run [the homepage sections migration](database/migrations/001_homepage_sections.sql).

After login, use **Homepage builder** to manage sections and **Footer editor** to manage footer columns.
