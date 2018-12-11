### 接口说明
角色
### 一、请求参数

请求地址环境	| HTTP请求地址  | 请求方式
---|--- | ---
本地测试地址 | http://backendapi.wenjy.top/admin/role |  GET  POST  PUT/PATCH DELETE
正式环境	| http://api.wenjy.top/admin/role |  GET  POST  PUT/PATCH DELETE

公共的请求参数

名称 | 类型 | 是否必须 | 描述| 示例
---|---|---|---|---
Authorization | string | 是 |  接口权限验证，使用HTTP头发送|i.e  Authorization : Bearer + token值
access-token | string |  否 | 接口权限验证，使用get的方式进行验证，方便测试的调试，正式版不支持| i.e: xxx?access-token=123

### 二、获取角色列表

- 请求方式 GET
- 请求地址 : admin/role
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---
page | integer | 否 | 获取请求所在的分页  i.e: xxx?page=4
perPage | integer | 否 | 每页显示的数量,默认是20条 e.g : xxx?perPage=20

AuthItemSearch[name] | string | 否 | 角色名
AuthItemSearch[ruleName] | string | 否 | 规则名称
AuthItemSearch[description] | string | 否 | 描述
    
- 响应的参数如下：

名称 | 类型 | 示例值 | 描述
---|---|---|---
type| integer | 1 | 角色标识
name| string | role_a | 角色名


- 响应事例如下:

```json
{
    "items": [
        {
            "type": "1",
            "name": "role_a",
            "description": null,
            "ruleName": null,
            "data": null,
            "createdAt": "1532078033",
            "updatedAt": "1532078033"
        }
    ],
    "_links": {
        "self": {
            "href": "http://backendapi.wenjy.top/admin/role/index?access-token=eyJ0eXAiOiJKV1QiLCJhbGciOiJTSEEyNTYifQ.eyJpc3MiOiJodHRwOlwvXC9iYWNrZW5kYXBpLndlbmp5LnRvcCIsImV4cCI6MTUzMjYyNDI1NCwiaWF0IjoxNTMyNjE3MDU0LCJ1aWQiOjIsImp0aSI6IiJ9.b1eb937ca7edb3f1b5d21f239952375ad0e00edb5d82eb83c579fc114fe914fe&page=1"
        }
    },
    "_meta": {
        "totalCount": 1,
        "pageCount": 1,
        "currentPage": 1,
        "perPage": 20
    }
}

```

### 三、创建角色

- 请求方式 POST
- 请求地址 : admin/role/create
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---
AuthItem[name] | string | 是 | role_a
AuthItem[ruleName] | string | 否 | rule_a
AuthItem[description] | string | 否 | 
AuthItem[data] | string | 否 | {"aaa":111}

    
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

### 四、分配权限、角色

- 请求方式 POST
- 请求地址 : admin/role/assign?id=role_a
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---
items[] | array | 是 | '/*'

    
- 响应的参数如下：

名称 | 类型 | 示例值 | 描述
---|---|---|---
available| object |  | 未分配的
assigned| object |  | 已分配的
success| integer |  | 1/分配成功


- 响应事例如下:

```json
{
    "available": {
        "role_b": "role",
        "/test/testa": "route"
    },
    "assigned": {
        "/*": "route"
    },
    "success": 1
}

```

### 四、移除权限、角色

- 请求方式 POST
- 请求地址 : admin/role/remove?id=role_a
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---
items[] | array | 是 | '/*'

    
- 响应的参数如下：

名称 | 类型 | 示例值 | 描述
---|---|---|---
available| object |  | 未分配的
assigned| object |  | 已分配的
success| integer |  | 1/移除成功


- 响应事例如下:

```json
{
    "available": {
        "role_b": "role",
        "/*": "route",
        "/test/testa": "route"
    },
    "assigned": [],
    "success": 1
}

```

### 六、更新角色

- 请求方式 PUT
- 请求地址 : admin/role
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---
AuthItem[name] | string | 是 | role_a
AuthItem[ruleName] | string | 否 | rule_a
AuthItem[description] | string | 否 | 
AuthItem[data] | string | 否 | {"aaa":111}

    
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

### 七、角色详情

- 请求方式 PUT
- 请求地址 : admin/role/view/{name}
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---

    
- 响应的参数如下：

名称 | 类型 | 示例值 | 描述
---|---|---|---
type| integer | 1 | 角色标识
name| string | role_a | 角色名


- 响应事例如下:

```json
{
    "name": "role_b",
    "type": "1",
    "description": "qqqqq",
    "ruleName": null,
    "data": null
}

```

### 八、删除权限、角色

- 请求方式 DELETE
- 请求地址 : admin/role/role_a
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---
    
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


