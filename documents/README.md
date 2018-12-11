## 后台管理系统

> 本项目的初衷是为了学习技术

### 项目架构

- 后端框架使用Yii2

### 项目初始化

- 本项目使用git管理，[采用forking工作流](https://github.com/xirong/my-git/blob/master/git-workflow-tutorial.md#24-forking%E5%B7%A5%E4%BD%9C%E6%B5%81)

- 项目部署工具使用[deployer](https://deployer.org/docs)

- 代码clone下来后运行

```php
composer install
```
```php
./yii init
```

- 如果报Class xxx not found 运行

```php
composer up
```

- 域名配置

> 配置前端域名指向 backendapp 后端域名指向 backend/web；apache服务器自行添加.htaccess重写index.php

```apacheconfig
<IfModule mod_rewrite.c>
   RewriteEngine On
   RewriteCond %{REQUEST_FILENAME} !-d
   RewriteCond %{REQUEST_FILENAME} !-f
   RewriteRule ^(.*)$ index.php [L,QSA]
</IfModule>

```

- 项目配置

> backend/config/params-local.php
```php
return [
    'CorsOrigin' => [
        'admindev.wenjy.top', //跨域域名，和前端域名一致
    ],
    'accessTokenExpire' => 7200, //accessToken过期时间，单位秒
];
```

> backend/config/main-local.php 或者 common/config/main-local.php

```php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=rbac_system',
            'username' => 'root',
            'password' => 'root',
            'tablePrefix' => '',
            'charset' => 'utf8',
        ],
    ],
];
```

- 运行数据库迁移

```php
./yii migrate
```

### 单元测试

> 使用codeception [codeception文档](https://codeception.com/docs/10-WebServices#REST)

#### 运行框架的测试

- 修改 common/config/test-local.php 配置

```php
'components' => [
            'db' => [
                'dsn' => 'mysql:host=localhost;dbname=rbac_system_test',
            ],
            'request' => [
                'cookieValidationKey' => new \yii\helpers\UnsetArrayValue(),
            ],
        ],
```

> 运行命令迁移

```php
./yii_test migrate
```

#### API测试

- 配置接口测试域名：**localhost.wenjy.top** 指向 **backend/web/index-test.php**

- 创建测试

>
```php
cd backend
../vendor/bin/codecept generate:cest api "测试文件名"
```

- 运行测试，指定运行backend里的api测试

> 命令格式：vendor/bin/codecept run [suiteName] [testName] [-c moduleName]

例如

```php
vendor/bin/codecept run api -c backend

vendor/bin/codecept run api UserLoginCest -c backend
```

### API授权验证

- 接口验证

1. 使用[JWT官方文档](https://jwt.io/introduction/)来实现接口认证
2. [什么是 JWT -- JSON WEB TOKEN](https://www.jianshu.com/p/576dbf44b2ae)

- 防止重放攻击(未实现)，可参考下面资料

1. [基于timestamp和nonce的防止重放攻击方案](https://blog.csdn.net/koastal/article/details/53456696)
2. [jwt 相关问题](https://github.com/bigmeow/JWT/issues/4)
3. [有关JWT(Json Web Token)如何解决并发问题的思考](https://zhuanlan.zhihu.com/p/22693223)


