FROM php:8.2-apache

# 必要な拡張モジュール（PDO MySQL）をインストール
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Apacheの mod_rewrite を有効化
RUN a2enmod rewrite

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# src ディレクトリの中身を Apache のドキュメントルートにコピー
COPY ./src /var/www/html/

# 作業ディレクトリを /var/www/html に指定
WORKDIR /var/www/html/

# Composerパッケージのインストール（src直下の composer.json を参照します）
RUN composer install --no-dev --optimize-autoloader

EXPOSE 80