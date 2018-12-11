### 接口说明
菜单
### 一、请求参数

请求地址环境	| HTTP请求地址  | 请求方式
---|--- | ---
本地测试地址 | http://backendapi.wenjy.top/admin/menu |  GET  POST  PUT/PATCH DELETE
正式环境	| http://api.wenjy.top/admin/menu |  GET  POST  PUT/PATCH DELETE

公共的请求参数

名称 | 类型 | 是否必须 | 描述| 示例
---|---|---|---|---
Authorization | string | 是 |  接口权限验证，使用HTTP头发送|i.e  Authorization : Bearer + token值
access-token | string |  否 | 接口权限验证，使用get的方式进行验证，方便测试的调试，正式版不支持| i.e: xxx?access-token=123

### 二、获取菜单列表

- 请求方式 GET
- 请求地址 : admin/menu
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---
page | integer | 否 | 获取请求所在的分页  i.e: xxx?page=4
perPage | integer | 否 | 每页显示的数量,默认是20条 e.g : xxx?perPage=20

MenuSearch[name] | string | 否 | 菜单名
    
- 响应的参数如下：

名称 | 类型 | 示例值 | 描述
---|---|---|---
name| string | role_a | 菜单名
parent| string | role_a | 父级菜单名
route| string | role_a | 对应权限


- 响应事例如下:

```json
{
    "items": [
        {
            "id": 1,
            "name": "权限管理",
            "parent": null,
            "route": null,
            "order": null,
            "data": null
        },
        {
            "id": 2,
            "name": "权限管理",
            "parent": null,
            "route": null,
            "order": 1,
            "data": null
        }
    ],
    "_links": {
        "self": {
            "href": "http://backendapi.wenjy.top/admin/menu?access-token=eyJ0eXAiOiJKV1QiLCJhbGciOiJTSEEyNTYifQ.eyJpc3MiOiJodHRwOlwvXC9iYWNrZW5kYXBpLndlbmp5LnRvcCIsImV4cCI6MTUzMzIyNjcxNiwiaWF0IjoxNTMzMjE5NTE2LCJ1aWQiOjIsImp0aSI6IiJ9.d9eeba07b1693a319d06efd1cb95ed09eb9a822d877a8cf12094ba38e32dffca&page=1"
        }
    },
    "_meta": {
        "totalCount": 2,
        "pageCount": 1,
        "currentPage": 1,
        "perPage": 20
    }
}

```

### 三、创建菜单

- 请求方式 POST
- 请求地址 : admin/role/create
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---
Menu[parent] | string | 否 | role_a
Menu[name] | string | 是 | rule_a
Menu[parent_name] | string | 否 | 
Menu[route] | string | 否 | 
Menu[order] | string | 否 | 
Menu[data] | string | 否 | 

    
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

### 四、更新菜单

- 请求方式 PUT
- 请求地址 : admin/menu/{id}
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---
Menu[parent] | string | 否 | role_a
Menu[name] | string | 否 | rule_a
Menu[parent_name] | string | 否 | 
Menu[route] | string | 否 | 
Menu[order] | string | 否 | 
Menu[data] | string | 否 |
    
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

### 五、菜单详情

- 请求方式 PUT
- 请求地址 : admin/menu/view/{id}
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---

    
- 响应的参数如下：

名称 | 类型 | 示例值 | 描述
---|---|---|---
name| string | role_a | 菜单名


- 响应事例如下:

```json
{
    "id": 1,
    "name": "权限管理",
    "parent": null,
    "route": null,
    "order": null,
    "data": null
}

```

### 六、删除菜单

- 请求方式 DELETE
- 请求地址 : admin/menu/id
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

### 七、获取菜单

- 请求方式 GET
- 请求地址 : admin/menu/assigned-menu
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---
    
- 响应的参数如下：

名称 | 类型 | 示例值 | 描述
---|---|---|---
label| string | true | 菜单名
url| string | # | 路由
items| array |  | 子菜单

- 响应事例如下:

```json
[
    {
        "id": "2",
        "label": "权限管理",
        "url": "#",
        "icon": "fa fa-circle-o",
        "items": [
            {
                "id": "4",
                "label": "角色列表",
                "url": "/admin/role/index",
                "icon": "fa fa-circle-o"
            },
            {
                "id": "3",
                "label": "用户列表",
                "url": "/admin/user/index",
                "visible": "aaa",
                "icon": "bbb",
                "options": {
                    "visible": "aaa",
                    "icon": "bbb"
                }
            }
        ]
    }
]

```


