FROM mcr.microsoft.com/devcontainers/php:1-8.3-bookworm

USER root

RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y \
        mariadb-server \
        mariadb-client \
    && rm -rf /var/lib/apt/lists/*

COPY setup-db.sh /usr/local/bin/setup-db.sh

RUN chmod +x /usr/local/bin/setup-db.sh

USER vscode
