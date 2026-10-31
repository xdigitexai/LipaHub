# LipaHub VPS installation

Requirements: Ubuntu 22.04/24.04, Nginx or Apache, PHP 8.1+ with pdo_mysql and fileinfo, and MySQL 8+ or MariaDB 10.5+.

1. Create the database and user:
   CREATE DATABASE lipahub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   CREATE USER 'lipahub_user'@'localhost' IDENTIFIED BY 'LONG_RANDOM_PASSWORD';
   GRANT ALL PRIVILEGES ON lipahub.* TO 'lipahub_user'@'localhost';
   FLUSH PRIVILEGES;

2. Clone and select this implementation branch:
   git clone https://github.com/xdigitexai/LipaHub.git
   cd LipaHub
   git checkout build/php-mysql-cms

3. Set the web server document root to the repository's public/ directory. Keep app/, database/ and config.php outside the public web root.

4. Configure:
   cp config.example.php config.php
   Edit database credentials, base_url and timezone. Registration URL defaults to https://lipahub.com/register.php?ref=ItsVee.

5. Import schema:
   mysql -u lipahub_user -p lipahub < database/schema.sql

6. Allow image uploads:
   mkdir -p public/uploads
   chown -R www-data:www-data public/uploads
   chmod 755 public/uploads
   For Nginx, deny PHP execution in /uploads/ and deny access to dotfiles. Use HTTPS.

7. Visit /admin/setup.php and create the first administrator with a unique password of at least 12 characters. Setup locks after the first admin is created. Then sign in at /admin/login.php.

Admin includes editable brand/hero/about/footer/CTA/SEO/contact settings; media uploads; CRUD for pages, articles, country guides, reviews and FAQs; drafts/publishing and display order.

Production: back up MySQL and uploads, use strong credentials, patch PHP/OS, deny access to non-public directories, and restrict /admin/ if appropriate. Add password reset, audit logging and login rate limiting before adding multiple admin accounts.
