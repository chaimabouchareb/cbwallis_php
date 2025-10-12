-- db.sql
CREATE DATABASE IF NOT EXISTS wallpaper_site CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE wallpaper_site;

-- users table
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  email VARCHAR(255) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  is_admin TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- wallpapers table
CREATE TABLE wallpapers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  filename VARCHAR(255) NOT NULL,
  original_filename VARCHAR(255),
  category ENUM('mobile','pc') NOT NULL,
  uploader_id INT,
  likes_count INT DEFAULT 0,
  added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (uploader_id) REFERENCES users(id) ON DELETE SET NULL
);

-- likes table (one row per user+wallpaper)
CREATE TABLE likes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  wallpaper_id INT NOT NULL,
  liked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY user_wallpaper (user_id, wallpaper_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (wallpaper_id) REFERENCES wallpapers(id) ON DELETE CASCADE
);

-- sample admin user (change password!)
INSERT INTO users (username, email, password_hash, is_admin)
VALUES ('admin', 'admin@example.com', '{REPLACE_WITH_HASH}', 1);

-- Note: Replace {REPLACE_WITH_HASH} with the result of PHP password_hash('yourpassword', PASSWORD_DEFAULT)
