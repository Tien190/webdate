-- DATABASE heartmatch
CREATE DATABASE IF NOT EXISTS heartmatch CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE heartmatch;

-- DROP nếu có bảng cũ
DROP TABLE IF EXISTS messages, matches, likes, reports, personal_information, users;

-- BẢNG users
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('user', 'admin') DEFAULT 'user',
  is_locked TINYINT(1) DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- BẢNG personal_information
CREATE TABLE personal_information (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(200),
  education VARCHAR(200),
  height INT,
  current_residence VARCHAR(200),
  hometown VARCHAR(200),
  job VARCHAR(200),
  gender ENUM('Nam','Nữ','Khác'),
  avatar VARCHAR(200),
  user_id INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- BẢNG likes
CREATE TABLE likes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sender_id INT NOT NULL,
  receiver_id INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_like (sender_id, receiver_id),
  FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- BẢNG matches
CREATE TABLE matches (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user1_id INT NOT NULL,
  user2_id INT NOT NULL,
  matched_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_match (user1_id, user2_id),
  FOREIGN KEY (user1_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (user2_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- BẢNG messages
CREATE TABLE messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sender_id INT NOT NULL,
  receiver_id INT NOT NULL,
  message TEXT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- BẢNG reports
CREATE TABLE reports (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reporter_id INT NOT NULL,
  reported_id INT NOT NULL,
  reason TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (reporter_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (reported_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- DỮ LIỆU MẪU
INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@gmail.com', '$2y$10$Z/4Kus4fRjYw3vZs/XOUM.vYT/8yFEpHEHWpxLIhGv03iH4zNmFb.', 'admin'),
('Tien', 'tien@gmail.com', '$2y$10$MMdffKPExI.8YASx79AGYOdqReImB6zII27af7dlWFbFG2.vNmXcy', 'user'),
('Thang', 'thang@gmail.com', '$2y$10$jdvD6HmP74y6uUPJtMj/Q.O8EsRWGM5gCsdSLLooIBm7l5YUD9oo2', 'user');

INSERT INTO personal_information (full_name, education, height, current_residence, hometown, job, gender, avatar, user_id)
VALUES 
('Huỳnh Tiến', 'Đại học CNTT', 170, 'TP.HCM', 'Bình Định', 'Sinh viên', 'Nam', 'tien.jpg', 2),
('Nguyễn Thắng', 'Cao đẳng Kỹ thuật', 165, 'Đồng Nai', 'Đà Nẵng', 'Lập trình viên', 'Nam', 'thang.jpg', 3);
