<?php
/**
 * @author: jiangyi
 * @date: 下午3:01 2018/7/20
 */

namespace backend\modules\admin\controllers;

use yii\rbac\Item;

class RoleController extends ItemController
{
    /**
     * @inheritdoc
     */
    public function labels()
    {
        return[
            'Item' => 'Role',
            'Items' => 'Roles',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return Item::TYPE_ROLE;
    }
}
