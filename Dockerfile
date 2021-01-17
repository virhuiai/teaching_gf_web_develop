FROM php:7.4.8-apache
WORKDIR /var/www/html/
RUN mkdir /virhuiai/ && \
echo "#!/bin/bash" >> /virhuiai/initFirstPhp.sh && \
echo "if [ ! -f '/virhuiai/index.php' ];then" >> /virhuiai/initFirstPhp.sh && \
echo "  echo '<?php phpinfo();' > /var/www/html/index.php" >> /virhuiai/initFirstPhp.sh && \
echo "fi" >> /virhuiai/initFirstPhp.sh && \
/bin/bash /virhuiai/initFirstPhp.sh

# docker build . -t virhuiai/teaching_gf_web_develop:lasted

# cd /Users/virhuiaivirhuiai/Documents/virhuiai-github/teaching_gf_web_develop
# docker run -d -p 80:80 --name my-apache-php-app -v "$PWD":/var/www/html virhuiai/teaching_gf_web_develop:lasted