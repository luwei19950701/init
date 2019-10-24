# 本项目基于Laravel 5.8的项目初始化

## 基础依赖
* PHP >= 7.1.3
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* Ctype PHP Extension
* JSON PHP Extension

## 功能特性
* password token机制,拥有单用户登录(默认关闭，去事件里开启就行了)


## 环境部署
```bash
# 执行安装命令
composer install

# 执行一些表的migrate
php artsian migrate

# passport安装密钥
php artsian passport:keys

# passport 生成有固定命名的oauth client(注意填上env里对应的clientname)
php artsian passport:client --password

```


> 一些说明

migration之类按需自己去修改

