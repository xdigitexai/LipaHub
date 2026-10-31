# LipaHub VPS installation

Requirements: Ubuntu 22.04/24.04, Nginx or Apache, PHP 8.1+ with pdo_mysql and fileinfo, and MySQL 8+ or MariaDB 10.5+.

1. Create the database and user:
   CREATE DATABASE lipahub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   CREATE USER 'lipahub_user'@'localhost' IDENTIFIED BY 'LONG_RANDOM_PASSWORD';
   GRANT ALL PRIVILEGES ON lipahub.* TO 'lipahub_user'@'localhost';
   FLUSH PRIVILEGES;

2. Clone:
   git clone https://github.com/xdigitexai/LipaHub.git
   cd LipaHub

3. Set the web server document root to repository public/. Keep app/, database/ and config.php outside the public web root.

4. Configure:
   cp config.example.php config.php
   Edit database credentials, base_url and timezone. Registration URL defaults to https://lipahub.com/register.php?ref=ItsVee.

5. New database:
   mysql -u lipahub_user -p lipahub < database/schema.sql

   Existing installation:
   git pull
   mysql -u lipahub_user -p lipahub < database/migrations/001_homepage_sections.sql

6. Allow image uploads:
   mkdir -p public/uploads
   chown -R www-data:www-data public/uploads
   chmod 755 public/uploads
   For Nginx, deny PHP execution in /uploads/ and deny access to dotfiles. Use HTTPS.

7. Visit /admin/setup.php to create the first administrator with a unique password of at least 12 characters. Setup locks after the first admin is created. Then sign in at /admin/login.php.

## Admin
- Homepage builder: add/edit/hide/delete sections, select layouts and background themes, set display order, image, heading, copy, button and content count. Layouts include hero, text, image/text, feature cards, article cards, country guides, testimonials, FAQs, stats and CTA.
- Footer editor: edit footer copy, two column headings, link labels and URLs, copyright and legal note.
- Site settings: edit brand, hero defaults, navigation labels, registration destination, contact and SEO.
- Content: CRUD for pages, articles, country guides, reviews and FAQs. Draft/publish and display order supported.
- Upload images through the admin editor; supported formats JPG, PNG, WebP and GIF, maximum 5 MB.

## Production checklist
- Use HTTPS and strong unique DB/admin passwords.
- Keep config.php and non-public application directories outside web root.
- Deny PHP execution in uploads and block dotfiles.
- Back up MySQL and uploads.
- Restrict /admin/ at network layer if possible and keep PHP/OS packages patched.
- Add login rate limiting, password recovery and audit logs before multi-admin production use.
