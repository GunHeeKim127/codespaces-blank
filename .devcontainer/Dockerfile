FROM mcr.microsoft.com/devcontainers/php:1-8.3-bookworm

USER root

# 문제가 되는 Yarn 저장소 제거
RUN find /etc/apt/sources.list.d -type f \
    -exec sh -c 'grep -q "dl.yarnpkg.com" "$1" && rm -f "$1" || true' _ {} \;

# MariaDB 설치
RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y \
        mariadb-server \
        mariadb-client \
    && rm -rf /var/lib/apt/lists/*

# PHP MySQL 확장 설치
RUN mkdir -p /usr/local/etc/php/conf.d \
    && docker-php-ext-install pdo_mysql || true \
    && echo "extension=pdo_mysql" \
        > /usr/local/etc/php/conf.d/docker-php-ext-pdo_mysql.ini \
    && php -m | grep -q '^pdo_mysql$'

# DB 자동 설정 스크립트
COPY setup-db.sh /usr/local/bin/setup-db.sh

RUN chmod +x /usr/local/bin/setup-db.sh

USER vscode