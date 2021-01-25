# teaching_gf_web_develop
教女朋友学习网页开发

## v0.0.6

docker-compose.yml：

```yaml
version: "3"
services:
  web_ci:
    image: virhuiai/teaching_gf_web_develop:version-0.0.6
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
  vue_element:
    dockerfile: /Users/virhuiaivirhuiai/Documents/virhuiai-github/teaching_gf_web_develop_element/Dockerfile
    ports:
      - "8080:80"
    volumes:
      - /Users/virhuiaivirhuiai/Documents/virhuiai-github/teaching_gf_web_develop_element/:/web-proj/
    working_dir: /web-proj/
```

运行

```
docker-compose up
```


