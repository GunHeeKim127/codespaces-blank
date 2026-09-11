CREATE DATABASE IF NOT EXISTS admin_lab;

USE admin_lab;


-- =========================================
-- users
-- =========================================

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,

    username VARCHAR(50) NOT NULL UNIQUE,

    password VARCHAR(255) NOT NULL,

    name VARCHAR(100) NOT NULL,

    role ENUM('admin', 'editor', 'viewer')
        NOT NULL DEFAULT 'viewer',

    created_at TIMESTAMP
        DEFAULT CURRENT_TIMESTAMP
);


-- =========================================
-- roles
-- =========================================

CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(50) NOT NULL UNIQUE,

    description VARCHAR(255)
);


-- =========================================
-- permissions
-- =========================================

CREATE TABLE IF NOT EXISTS permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100) NOT NULL UNIQUE,

    description VARCHAR(255)
);


-- =========================================
-- role_permissions
-- =========================================

CREATE TABLE IF NOT EXISTS role_permissions (
    role_id INT NOT NULL,

    permission_id INT NOT NULL,

    PRIMARY KEY (role_id, permission_id),

    FOREIGN KEY (role_id)
        REFERENCES roles(id)
        ON DELETE CASCADE,

    FOREIGN KEY (permission_id)
        REFERENCES permissions(id)
        ON DELETE CASCADE
);


-- =========================================
-- posts
-- =========================================

CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,

    title VARCHAR(200) NOT NULL,

    content TEXT NOT NULL,

    author_id INT NOT NULL,

    created_at TIMESTAMP
        DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP
        DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (author_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);


-- =========================================
-- videos
-- =========================================

CREATE TABLE IF NOT EXISTS videos (
    id INT AUTO_INCREMENT PRIMARY KEY,

    title VARCHAR(200) NOT NULL,

    filename VARCHAR(255) NOT NULL,

    original_name VARCHAR(255) NOT NULL,

    uploader_id INT NOT NULL,

    created_at TIMESTAMP
        DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (uploader_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);


-- =========================================
-- roles
-- =========================================

INSERT IGNORE INTO roles
(name, description)
VALUES
('admin', '전체 관리자'),
('editor', '콘텐츠 편집자'),
('viewer', '콘텐츠 조회자');


-- =========================================
-- permissions
-- =========================================

INSERT IGNORE INTO permissions
(name, description)
VALUES

('dashboard.read', '대시보드 조회'),

('posts.read', '게시물 조회'),
('posts.write', '게시물 작성'),
('posts.update', '게시물 수정'),
('posts.delete', '게시물 삭제'),

('videos.read', '동영상 조회'),
('videos.write', '동영상 등록'),
('videos.update', '동영상 수정'),
('videos.delete', '동영상 삭제'),

('users.read', '사용자 조회'),
('users.write', '사용자 생성'),
('users.update', '사용자 수정'),
('users.delete', '사용자 삭제');


-- =========================================
-- admin permissions
-- =========================================

INSERT IGNORE INTO role_permissions
(role_id, permission_id)

SELECT
    r.id,
    p.id

FROM roles r

CROSS JOIN permissions p

WHERE r.name = 'admin';


-- =========================================
-- editor permissions
-- =========================================

INSERT IGNORE INTO role_permissions
(role_id, permission_id)

SELECT
    r.id,
    p.id

FROM roles r

JOIN permissions p

WHERE r.name = 'editor'

AND p.name IN (
    'dashboard.read',

    'posts.read',
    'posts.write',
    'posts.update',
    'posts.delete',

    'videos.read',
    'videos.write',
    'videos.update'
);


-- =========================================
-- viewer permissions
-- =========================================

INSERT IGNORE INTO role_permissions
(role_id, permission_id)

SELECT
    r.id,
    p.id

FROM roles r

JOIN permissions p

WHERE r.name = 'viewer'

AND p.name IN (
    'dashboard.read',
    'posts.read',
    'videos.read'
);


-- =========================================
-- 기본 사용자
-- =========================================

INSERT IGNORE INTO users
(username, password, name, role)

VALUES
('admin', 'admin123', '관리자', 'admin'),
('editor', 'editor123', '편집자', 'editor'),
('viewer', 'viewer123', '조회자', 'viewer');