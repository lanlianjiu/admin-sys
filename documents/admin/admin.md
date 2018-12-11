### 接口说明
路由
### 一、请求参数

请求地址环境	| HTTP请求地址  | 请求方式
---|--- | ---
本地测试地址 | http://backendapi.wenjy.top/admin/admin |  GET  POST  PUT/PATCH DELETE
正式环境	| http://api.wenjy.top/admin/admin |  GET  POST  PUT/PATCH DELETE

公共的请求参数

名称 | 类型 | 是否必须 | 描述| 示例
---|---|---|---|---
Authorization | string | 是 |  接口权限验证，使用HTTP头发送|i.e  Authorization : Bearer + token值
access-token | string |  否 | 接口权限验证，使用get的方式进行验证，方便测试的调试，正式版不支持| i.e: xxx?access-token=123

### 二、获取权限列表

- 请求方式 GET
- 请求地址 : admin/permission
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---
page | integer | 否 | 获取请求所在的分页  i.e: xxx?page=4
perPage | integer | 否 | 每页显示的数量,默认是20条 e.g : xxx?perPage=20

AdminSearch[username] | string | 否 | 角色名
AuthItemSearch[email] | string | 否 | 规则名称
    
- 响应的参数如下：

名称 | 类型 | 示例值 | 描述
---|---|---|---
type| integer | 1 | 角色标识
name| string | permission_a | 角色名


- 响应事例如下:

```json
{
    "items": [
        {
            "id": 1,
            "username": "wen",
            "email": "123456@qq.com",
            "status": 10,
            "created_at": 1531549534,
            "updated_at": 1532157450
        },
        {
            "id": 2,
            "username": "admin",
            "email": "admin@gmail.com",
            "status": 10,
            "created_at": 1532354973,
            "updated_at": 1532787735
        },
        {
            "id": 3,
            "username": "admin_a",
            "email": "123@qq.com",
            "status": 10,
            "created_at": 1532787916,
            "updated_at": 1532787916
        },
        {
            "id": 6,
            "username": "admin_c",
            "email": "12357@qq.com",
            "status": 10,
            "created_at": 1532791335,
            "updated_at": 1532791335
        }
    ],
    "_links": {
        "self": {
            "href": "http://backendapi.wenjy.top/admin/admin?access-token=eyJ0eXAiOiJKV1QiLCJhbGciOiJTSEEyNTYifQ.eyJpc3MiOiJodHRwOlwvXC9iYWNrZW5kYXBpLndlbmp5LnRvcCIsImV4cCI6MTUzMjc5NDkzNSwiaWF0IjoxNTMyNzg3NzM1LCJ1aWQiOjIsImp0aSI6IiJ9.4f1d3ad697e4c1edfdf37a1e2d984ccf9de2826a445b73957e866e5ec0d8e1c5&page=1"
        }
    },
    "_meta": {
        "totalCount": 4,
        "pageCount": 1,
        "currentPage": 1,
        "perPage": 20
    }
}

```

### 三、创建管理员

- 请求方式 POST
- 请求地址 : admin/admin/create
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---
Admin[username] | string | 是 | role_a
AdminSearch[password] | string | 是 | rule_a
AdminSearch[email] | string | 是 | 

    
- 响应的参数如下：

名称 | 类型 | 示例值 | 描述
---|---|---|---
status| bool | true | 添加成功
code| integer | 0 | 状态码
message| string |  | 提示信息
meta| array |  | 额外的信息


- 响应事例如下:

```json
{
    "status": false,
    "code": 1001,
    "message": "Unknown class 'aaaa'",
    "meta": []
}

```
