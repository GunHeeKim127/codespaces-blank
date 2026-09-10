CREATE DATABASE IF NOT EXISTS admin_lab CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE admin_lab;
DROP TABLE IF EXISTS videos;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 username VARCHAR(50) UNIQUE NOT NULL,
 password VARCHAR(255) NOT NULL,
 name VARCHAR(100) NOT NULL,
 role ENUM('admin','editor','viewer') NOT NULL DEFAULT 'viewer',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE posts (
 id INT AUTO_INCREMENT PRIMARY KEY,
 title VARCHAR(200) NOT NULL,
 content TEXT NOT NULL,
 author_id INT NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 FOREIGN KEY (author_id) REFERENCES users(id)
);

CREATE TABLE videos (
 id INT AUTO_INCREMENT PRIMARY KEY,
 title VARCHAR(200) NOT NULL,
 filename VARCHAR(255) NOT NULL,
 original_name VARCHAR(255) NOT NULL,
 uploader_id INT NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (uploader_id) REFERENCES users(id)
);

INSERT INTO users(username,password,name,role) VALUES
('admin','admin123','관리자','admin'),
('editor','editor123','콘텐츠 편집자','editor'),
('viewer','viewer123','조회 사용자','viewer');

INSERT INTO posts(title,content,author_id) VALUES
('화이트해커 실습 안내','웹 취약점 점검을 위한 더미 콘텐츠입니다.',1),
('관리자 페이지 테스트','로그인, 권한, CRUD, 업로드를 점검하세요.',2),
('동영상 업로드 안내','파일 검증 방식을 확인해 보세요.',1);
