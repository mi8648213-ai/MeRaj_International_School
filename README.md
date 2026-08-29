# Me’Raj International School Maiduguri — Website + Admission Portal

## What this project includes
- Modern responsive school website using the school's purple/green/gold visual identity.
- Online admission form.
- Automatic application number after submission.
- Secure admin login with password hashing.
- Admin dashboard for admission applications.
- Search/filter applications.
- View, print, review, accept, reject and add notes to applications.
- Dynamic Gallery, Video Library and Audio Library.
- Admin can upload, publish/hide and delete media without changing the website code.
- Supplied school logo, student photo and welcome video are included as starter assets.

## Recommended hosting
PHP 8.1+ and MySQL/MariaDB. This is suitable for typical cPanel/Hostinger PHP hosting.

## Installation
1. Create a MySQL database and user.
2. Import `database.sql` using phpMyAdmin.
3. Open `config.php` and replace:
   - `DB_NAME`
   - `DB_USER`
   - `DB_PASS`
4. Upload the entire project to your domain's public folder (usually `public_html`).
5. Make sure these folders are writable by PHP:
   - `uploads/gallery`
   - `uploads/videos`
   - `uploads/audio`
   - `uploads/documents`
   - `uploads/passports`
6. Visit `https://YOUR-DOMAIN/setup_admin.php` once and create the first Admin account.
7. IMPORTANT: delete `setup_admin.php` immediately after creating the admin.
8. Admin login: `https://YOUR-DOMAIN/admin/login.php`

## Media uploading
From Admin Portal → Media:
- Gallery: JPG/JPEG/PNG/WEBP
- Audio: MP3/WAV/M4A/OGG
- Video: MP4/WEBM/MOV/M4V
- Videos are allowed up to 500 MB in this starter configuration.
If your host has a smaller PHP upload limit, increase `upload_max_filesize` and `post_max_size` in the hosting PHP settings.

## Admission uploads
- Passport: JPG/JPEG/PNG/WEBP up to 5 MB.
- Supporting document: PDF/JPG/JPEG/PNG up to 10 MB.

## Important production hardening
Before public launch, enable HTTPS/SSL, use a strong unique admin password, keep PHP/MySQL updated, and configure server rules to prevent direct execution of scripts inside upload folders. Consider adding email/SMS notifications and an application-status lookup page as the next phase.
