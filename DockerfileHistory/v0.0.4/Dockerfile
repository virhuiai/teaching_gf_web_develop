#第1部分
FROM php:7.4.8-apache
#第2部分 apt update 加速
RUN echo '# 默认注释了源码镜像以提高 apt update 速度，如有需要可自行取消注释' > /etc/apt/sources.list && \
echo 'deb https://mirrors.tuna.tsinghua.edu.cn/debian/ buster main contrib non-free' >> /etc/apt/sources.list && \
echo '# deb-src https://mirrors.tuna.tsinghua.edu.cn/debian/ buster main contrib non-free' >> /etc/apt/sources.list && \
echo 'deb https://mirrors.tuna.tsinghua.edu.cn/debian/ buster-updates main contrib non-free' >> /etc/apt/sources.list && \
echo '# deb-src https://mirrors.tuna.tsinghua.edu.cn/debian/ buster-updates main contrib non-free' >> /etc/apt/sources.list && \
echo 'deb https://mirrors.tuna.tsinghua.edu.cn/debian/ buster-backports main contrib non-free' >> /etc/apt/sources.list && \
echo '# deb-src https://mirrors.tuna.tsinghua.edu.cn/debian/ buster-backports main contrib non-free' >> /etc/apt/sources.list && \
echo 'deb https://mirrors.tuna.tsinghua.edu.cn/debian-security buster/updates main contrib non-free' >> /etc/apt/sources.list && \
echo '# deb-src https://mirrors.tuna.tsinghua.edu.cn/debian-security buster/updates main contrib non-free' >> /etc/apt/sources.list && \
#第3部分，安装 vim mlocate unzip wget
set -eux; \
	apt-get update && \
	apt-get install -y --no-install-recommends \
        vim \
        mlocate \
        unzip \
        tree \
        wget && \
	rm -rf /var/lib/apt/lists/* && \
  apt-get clean
#第4部分 安装intl:
RUN apt-get update && \
apt-get install -y --no-install-recommends libicu-dev && \
rm -r /var/lib/apt/lists/* && \
docker-php-ext-install -j$(nproc) intl && \
docker-php-ext-install mysqli
# 第5部分,安装libcurl：
RUN apt-get update && \
apt-get install -y --no-install-recommends libcurl4-openssl-dev && \
rm -r /var/lib/apt/lists/*
# 第6部分:
RUN mkdir /virhuiai/ && cd /virhuiai && wget https://github.com/codeigniter4/framework/archive/v4.0.4.zip && unzip v4.0.4.zip
# /virhuiai/framework-4.0.4
# 第7.1部分
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini && \
# 第7.2部分
sed -ri -e 's!;extension=intl!extension=intl!g' /usr/local/etc/php/php.ini && \
sed -ri -e 's!;extension=mysqli!extension=mysqli!g' /usr/local/etc/php/php.ini && \
sed -ri -e 's!;extension=mbstring!extension=mbstring!g' /usr/local/etc/php/php.ini && \
sed -ri -e 's!;extension=mbstring!extension=mbstring!g' /usr/local/etc/php/php.ini && \
sed -ri -e 's!;extension=pdo_sqlite!extension=pdo_sqlite!g' /usr/local/etc/php/php.ini
# 第8部分
RUN sed -ri -e 's!/var/www/html!/virhuiai/framework-4.0.4/public!g' /etc/apache2/sites-available/*.conf && \
sed -ri -e 's!/var/www/!/virhuiai/framework-4.0.4/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
WORKDIR /virhuiai/framework-4.0.4/public

## 镜像信息
LABEL Author="virhuiai"
LABEL Version="0.0.4"
LABEL Description="PHP APACHE CODEIGNITER 镜像"