<?php

return [
    [
        'class'      => 'yii\rest\UrlRule',
        'controller' => [
            'admin/user',
            'admin/route',
            'admin/rule',
            'admin/role',
            'admin/permission',
            'admin/admin',
            'admin/menu',
        ],
        // 重写路由匹配正则，使参数能匹配字母数字下划线
        'extraPatterns' => [
            'PUT,PATCH <id:[_A-Za-z0-9]+>' => 'update',
            'GET view/<id:[_A-Za-z0-9]+>' => 'view',
            'DELETE <id:[_A-Za-z0-9]+>' => 'delete',
        ],
        'pluralize' => false,
    ],
];
