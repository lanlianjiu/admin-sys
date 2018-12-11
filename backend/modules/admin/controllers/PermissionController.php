<?php
/**
 * @author: jiangyi
 * @date: 下午3:02 2018/7/20
 */

namespace backend\modules\admin\controllers;


use yii\rbac\Item;

class PermissionController extends ItemController
{
    /**
     * @inheritdoc
     */
    public function labels()
    {
        return[
            'Item' => 'Permission',
            'Items' => 'Permissions',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return Item::TYPE_PERMISSION;
    }
}
