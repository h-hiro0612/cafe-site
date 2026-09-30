FROM php:8.2-fpm

# パッケージのインストール（msmtp を追加）
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    msmtp \
    msmtp-mta \
    && docker-php-ext-install pdo pdo_mysql

# msmtp の設定（Mailpit コンテナの 1025 ポートへメールを転送）
RUN echo "defaults" > /etc/msmtprc && \
    echo "account default" >> /etc/msmtprc && \
    echo "host mailpit" >> /etc/msmtprc && \
    echo "port 1025" >> /etc/msmtprc && \
    echo "from info@example.com" >> /etc/msmtprc

# PHP の sendmail 設定を msmtp に変更
RUN echo "sendmail_path = '/usr/bin/msmtp -t'" > /usr/local/etc/php/conf.d/sendmail.ini