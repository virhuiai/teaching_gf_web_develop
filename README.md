# teaching_gf_web_develop
教女朋友学习网页开发

## v0.0.1

```shell
docker run -d -p 80:80 --name my-apache-php-app -v "$PWD":/var/www/html virhuiai/teaching_gf_web_develop:lasted
# 进入容器运行初始化一个显示phpinfo()的脚本，
docker exec -it 9716fb75aded /bin/sh
/bin/bash /virhuiai/initFirstPhp.sh
```

此时打开本地浏览器就能看到效果

# v0.0.3

https://www.toutiao.com/i6919534118367691277/

# v0.0.4

docker-compose.yml：


```yaml
version: "3"
services:
  web_ci:
    image: virhuiai/teaching_gf_web_develop:version-0.0.3
    ports:
      - "80:80"
    volumes:
      - /Users/virhuiaivirhuiai/Documents/virhuiai-github/teaching_gf_web_develop/framework-4.0.4:/virhuiai/framework-4.0.4/
    depends_on:
      - "mysql_db"
  mysql_db:
    image: mysql:5.7
    environment:
      - MYSQL_ROOT_PASSWORD=Passw0rd!
      - MYSQL_DATABASE=ci4_database_name
```

运行

```
docker-compose up
```


