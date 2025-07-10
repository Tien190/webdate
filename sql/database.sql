-- Tạo bảng `users`
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Thêm tài khoản test
INSERT INTO users (email, password) VALUES (
  'test@gmail.com',
  '$2y$10$yCVF1rENAZrDqD1UyBOqUOM49azO9VtfgrI0SnhFjRmdjKhgyU5Se'
);
-- Mật khẩu là: 1234
