#第1部分
FROM virhuiai/teaching_gf_web_develop:version-0.0.4
RUN apt-get update && \
apt-get install -y --no-install-recommends libfreetype6-dev libjpeg62-turbo-dev libpng-dev && \
rm -r /var/lib/apt/lists/* && \
docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && \
docker-php-ext-install -j$(nproc) gd

WORKDIR /virhuiai/framework-4.0.4/public

## 镜像信息
LABEL Author="virhuiai"
LABEL Version="0.0.5"
LABEL Description="PHP APACHE CODEIGNITER 镜像,添加GD拓展"

# docker build . -t tmpimg