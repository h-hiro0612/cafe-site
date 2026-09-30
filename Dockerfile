FROM php:8.2-apache

# zip, unzip, git 等のツールと PDO MySQL 拡張をまとめてインストール
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql mysqli

# Apacheの mod_rewrite を有効化
RUN a2enmod rewrite

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# src ディレクトリの中身を Apache のドキュメントルートにコピー
COPY ./src /var/www/html/

# 作業ディレクトリを /var/www/html に指定
WORKDIR /var/www/html/

# Composerパッケージのインストール
RUN composer install --no-dev --optimize-autoloader

EXPOSE 80