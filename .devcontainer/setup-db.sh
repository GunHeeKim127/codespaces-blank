#!/bin/bash

set -e

echo "================================="
echo " MariaDB 자동 설정 시작"
echo "================================="

sudo service mariadb start

echo "MariaDB 서비스 시작 완료"

sleep 2

sudo mysql < /workspaces/codespaces-blank/sql/schema.sql

echo "================================="
echo " DB 스키마 적용 완료"
echo "================================="

sudo mysql -e "SHOW DATABASES;"
