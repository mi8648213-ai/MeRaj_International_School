CREATE DATABASE IF NOT EXISTS meraj_school CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE meraj_school;

CREATE TABLE admins (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE applications (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  application_no VARCHAR(40) NOT NULL UNIQUE,
  full_name VARCHAR(180) NOT NULL,
  dob DATE NULL,
  gender VARCHAR(30) NULL,
  nationality VARCHAR(80) NULL,
  state_of_origin VARCHAR(100) NULL,
  lga VARCHAR(100) NULL,
  address TEXT NULL,
  passport_path VARCHAR(255) NULL,
  parent_name VARCHAR(180) NOT NULL,
  parent_phone VARCHAR(40) NOT NULL,
  parent_email VARCHAR(190) NULL,
  parent_address TEXT NULL,
  applying_section VARCHAR(80) NOT NULL,
  class_applied VARCHAR(100) NOT NULL,
  previous_school VARCHAR(180) NULL,
  previous_class VARCHAR(100) NULL,
  quran_level VARCHAR(180) NULL,
  arabic_level VARCHAR(180) NULL,
  additional_info TEXT NULL,
  document_path VARCHAR(255) NULL,
  status ENUM('Pending','Under Review','Accepted','Rejected') NOT NULL DEFAULT 'Pending',
  admin_note TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX(status), INDEX(created_at), INDEX(full_name)
);

CREATE TABLE media (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  type ENUM('gallery','video','audio') NOT NULL,
  title VARCHAR(200) NOT NULL,
  description TEXT NULL,
  category VARCHAR(120) NULL,
  file_path VARCHAR(255) NOT NULL,
  thumbnail_path VARCHAR(255) NULL,
  published TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX(type), INDEX(published), INDEX(created_at)
);

-- Create your first admin after editing config.php:
-- Use setup_admin.php, then delete that file from the server.
