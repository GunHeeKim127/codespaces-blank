#!/bin/bash

set -e

echo "================================="
echo " MariaDB 자동 설정 시작"
echo "================================="

# MariaDB 시작
sudo service mariadb start

echo "MariaDB 서비스 시작 완료"

sleep 2

# DB 및 사용자 생성
sudo mariadb <<'EOF'
CREATE DATABASE IF NOT EXISTS admin_lab;

CREATE USER IF NOT EXISTS 'adminlab'@'localhost'
IDENTIFIED BY 'adminlab123';

GRANT ALL PRIVILEGES ON admin_lab.* TO 'adminlab'@'localhost';

FLUSH PRIVILEGES;
EOF

echo "DB 및 adminlab 사용자 생성 완료"

# 스키마 적용
sudo mysql < /workspaces/codespaces-blank/schema.sql

echo "================================="
echo " DB 스키마 적용 완료"
echo "================================="

# 확인
sudo mariadb -e "SHOW DATABASES;"
sudo mariadb -e "SELECT User, Host FROM mysql.user WHERE User='adminlab';"

echo "================================="
echo " MariaDB 설정 완료"
echo "================================="