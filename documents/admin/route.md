### 接口说明
路由
### 一、请求参数

请求地址环境	| HTTP请求地址  | 请求方式
---|--- | ---
本地测试地址 | http://backendapi.wenjy.top/admin/route |  GET  POST  PUT/PATCH DELETE
正式环境	| http://api.wenjy.top/admin/route |  GET  POST  PUT/PATCH DELETE

公共的请求参数

名称 | 类型 | 是否必须 | 描述| 示例
---|---|---|---|---
Authorization | string | 是 |  接口权限验证，使用HTTP头发送|i.e  Authorization : Bearer + token值
access-token | string |  否 | 接口权限验证，使用get的方式进行验证，方便测试的调试，正式版不支持| i.e: xxx?access-token=123

### 二、获取路由列表

- 请求方式 GET
- 请求地址 : admin/route
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---
page | integer | 否 | 获取请求所在的分页  i.e: xxx?page=4
perPage | integer | 否 | 每页显示的数量,默认是20条 e.g : xxx?perPage=20

    
- 响应的参数如下：

名称 | 类型 | 示例值 | 描述
---|---|---|---
available| array |  | 未分配的路由
assigned| array |  | 已分配的路由


- 响应事例如下:

```json
{
    "routes": {
        "available": [
            "/admin/default/index",
            "/admin/default/*",
            "/admin/route/index",
            "/admin/route/view",
            "/admin/route/create",
            "/admin/route/update",
            "/admin/route/delete",
            "/admin/route/options"
        ],
        "assigned": [
            "/gii/default/index",
            "/gii/default/view"        
        ]
    }
}

```

### 三、分配路由

- 请求方式 POST
- 请求地址 : admin/route/assign
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---
routes | array | 是 | ["/gii/default/index","/gii/default/view"]

    
- 响应的参数如下：

名称 | 类型 | 示例值 | 描述
---|---|---|---
available| array |  | 未分配的路由
assigned| array |  | 已分配的路由


- 响应事例如下:

```json
{
    "routes": {
        "available": [
            "/admin/default/index",
            "/admin/default/*",
            "/admin/route/options"
        ],
        "assigned": [
            "/gii/default/index",
            "/gii/default/view"        
        ]
    }
}

```

### 三、创建路由

- 请求方式 POST
- 请求地址 : admin/route/create
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---
route | string | 是 | "/gii/default/index"

    
- 响应的参数如下：

名称 | 类型 | 示例值 | 描述
---|---|---|---
available| array |  | 未分配的路由
assigned| array |  | 已分配的路由


- 响应事例如下:

```json
{
    "routes": {
        "available": [
            "/admin/default/index",
            "/admin/default/*",
            "/admin/route/options"
        ],
        "assigned": [
            "/gii/default/index",
            "/gii/default/view"        
        ]
    }
}

```

### 四、移除路由

- 请求方式 POST
- 请求地址 : admin/route/remove
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---
route | string | 是 | "/gii/default/index"

    
- 响应的参数如下：

名称 | 类型 | 示例值 | 描述
---|---|---|---
available| array |  | 未分配的路由
assigned| array |  | 已分配的路由


- 响应事例如下:

```json
{
    "routes": {
        "available": [
            "/admin/default/index",
            "/admin/default/*"
        ],
        "assigned": [
            "/gii/default/index",
            "/gii/default/view"        
        ]
    }
}

```

### 五、刷新路由

- 请求方式 GET
- 请求地址 : admin/route/refresh
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---

    
- 响应的参数如下：

名称 | 类型 | 示例值 | 描述
---|---|---|---
available| array |  | 未分配的路由
assigned| array |  | 已分配的路由


- 响应事例如下:

```json
{
    "routes": {
        "available": [
            "/admin/default/index",
            "/admin/default/*"
        ],
        "assigned": [
            "/gii/default/index",
            "/gii/default/view"        
        ]
    }
}

```
