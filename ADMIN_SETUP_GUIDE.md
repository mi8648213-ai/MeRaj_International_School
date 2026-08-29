# ADMIN / HOSTING SETUP GUIDE

## Requirements
- PHP 8.1 or newer
- MySQL/MariaDB
- HTTPS/SSL strongly recommended
- A hosting account such as a standard PHP/MySQL shared hosting plan

## Installation
1. Create a MySQL database and database user.
2. Import `database.sql` into the database using phpMyAdmin.
3. Open `config.php`.
4. Replace:
   DB_NAME = your database name
   DB_USER = your database username
   DB_PASS = your database password
5. Upload the complete project into the website public folder (normally `public_html`).
6. Ensure the `uploads/` subfolders are writable by PHP.
7. Open `/setup_admin.php` in the browser once.
8. Create the first administrator account.
9. DELETE `setup_admin.php` immediately after the admin is created.
10. Open `/admin/login.php` to manage the school website.

## Important
The current starter is designed so Gallery, Audio and Video content can be uploaded from the Admin Portal without reprogramming the website.

Before public launch, configure:
- HTTPS/SSL
- Strong unique admin password
- PHP upload limits appropriate for school videos
- Server restrictions for upload directories
- Regular backups of the MySQL database and uploads

## Media Uploads
Gallery: JPG/JPEG/PNG/WEBP
Audio: MP3/WAV/M4A/OGG
Video: MP4/WEBM/MOV/M4V

## Admission Uploads
Passport: JPG/JPEG/PNG/WEBP
Supporting document: PDF/JPG/JPEG/PNG

## Future optional upgrades
- Student application status lookup
- Email notifications
- SMS/WhatsApp notifications
- Multiple admin roles
- Staff management
- Online result checking
- Fees/payment module
- News/announcements manager
- Automated admission interview scheduling
