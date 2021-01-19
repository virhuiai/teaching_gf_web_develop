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

# v0.0.2

```
Docker镜像中配置好开发Codeigniter相应的环境
```

