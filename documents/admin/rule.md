### 接口说明
规则
### 一、请求参数

请求地址环境	| HTTP请求地址  | 请求方式
---|--- | ---
本地测试地址 | http://backendapi.wenjy.top/admin/rule |  GET  POST  PUT/PATCH DELETE
正式环境	| http://api.wenjy.top/admin/rule |  GET  POST  PUT/PATCH DELETE

公共的请求参数

名称 | 类型 | 是否必须 | 描述| 示例
---|---|---|---|---
Authorization | string | 是 |  接口权限验证，使用HTTP头发送|i.e  Authorization : Bearer + token值
access-token | string |  否 | 接口权限验证，使用get的方式进行验证，方便测试的调试，正式版不支持| i.e: xxx?access-token=123

### 二、添加规则

- 请求方式 POST
- 请求地址 : admin/rule/create
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---
BizRule[name] | string | 是 | 规则名称
BizRule[className] | string | 是 | 规则类名（带命名空间）

    
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

### 三、修改规则

- 请求方式 PUT x-www-form-urlencoded
- 请求地址 : admin/rule/update/{name}
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---
BizRule[className] | string | 是 | 规则类名（带命名空间）
    
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

### 四、获取规则列表

- 请求方式 GET
- 请求地址 : admin/rule
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---
page | integer | 否 | 获取请求所在的分页  i.e: xxx?page=4
perPage | integer | 否 | 每页显示的数量,默认是20条 e.g : xxx?perPage=20
BizRuleSearch[name] | string |  否 | 规则名称

    
- 响应的参数如下：

名称 | 类型 | 示例值 | 描述
---|---|---|---
available| array |  | 未分配的路由
assigned| array |  | 已分配的路由


- 响应事例如下:

```json
{
    "items": [
        {
            "name": "AuthorRule",
            "createdAt": null,
            "updatedAt": null,
            "className": "backend\\modules\\admin\\rules\\AuthorRule"
        }
    ],
    "_links": {
        "self": {
            "href": "http://backendapi.wenjy.top/admin/rule?access-token=8b24f9fd71630b89aa8191efaa95cc5d&page=1"
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

### 五、规则详情

- 请求方式 GET
- 请求地址 : admin/rule/view/{name}
- 请求参数：

名称 | 类型 | 是否必须 | 描述
---|---|---|---
    
- 响应的参数如下：

名称 | 类型 | 示例值 | 描述
---|---|---|---
name| string | AuthorRule | 规则名称
createdAt| string |  |
createdAt| string |  |
className| string |  | 类


- 响应事例如下:

```json
{
    "name": "AuthorRule",
    "createdAt": null,
    "createdAt": null,
    "className": "backend\\modules\\admin\\rules\\AuthorRule"
}

```

### 六、删除规则

- 请求方式 DELETE
- 请求地址 : admin/rule/delete/{name}
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
