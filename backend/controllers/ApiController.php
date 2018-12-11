<?php
/**
 * @author: jiangyi
 * @date: 上午10:21 2018/7/11
 */

namespace backend\controllers;

use common\Auth;
use yii\rest\ActiveController;

class ApiController extends ActiveController
{
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = Auth::authentication(parent::behaviors());

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete'], $actions['view']);
        // 指定index数据提供器
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function formatResponse($status = true, $code = 0, $message = '', $meta = [])
    {
        return [
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'meta' => $meta
        ];
    }

}
