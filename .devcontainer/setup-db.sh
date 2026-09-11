#!/bin/bash

set -e

echo "================================="
echo " MariaDB 자동 설정 시작"
echo "================================="

sudo service mariadb start

echo "MariaDB 서비스 시작 완료"

sleep 2

sudo mariadb <<'EOF'
CREATE DATABASE IF NOT EXISTS admin_lab;

DROP USER IF EXISTS 'adminlab'@'localhost';
DROP USER IF EXISTS 'adminlab'@'127.0.0.1';

CREATE USER 'adminlab'@'localhost'
IDENTIFIED BY 'adminlab123';

CREATE USER 'adminlab'@'127.0.0.1'
IDENTIFIED BY 'adminlab123';

GRANT ALL PRIVILEGES ON admin_lab.* TO 'adminlab'@'localhost';
GRANT ALL PRIVILEGES ON admin_lab.* TO 'adminlab'@'127.0.0.1';

FLUSH PRIVILEGES;
EOF

echo "DB 및 adminlab 계정 생성 완료"

sudo mysql < /workspaces/codespaces-blank/schema.sql

echo "================================="
echo " DB 스키마 적용 완료"
echo "================================="

sudo mariadb -e "SHOW DATABASES;"
sudo mariadb -e "SELECT User, Host FROM mysql.user WHERE User='adminlab';"

echo "================================="
echo " MariaDB 자동 설정 완료"
echo "================================="