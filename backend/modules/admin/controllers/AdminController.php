<?php
/**
 * @author: jiangyi
 * @date: 下午10:01 2018/7/28
 */

namespace backend\modules\admin\controllers;

use backend\controllers\ApiController;
use backend\modules\admin\models\Admin;
use backend\modules\admin\models\searches\AdminSearch;
use Yii;

class AdminController extends ApiController
{
    /**
     * @var string
     */
    public $modelClass = 'backend\modules\admin\models\Admin';

    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'refresh' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'assign' => ['POST'],
            'remove' => ['POST'],
        ];
    }

    public function prepareDataProvider()
    {
        $searchModel = new AdminSearch();
        return $searchModel->search(Yii::$app->request->queryParams);
    }

    public function actionCreate()
    {
        $model = new Admin();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->create()) {
                return $this->formatResponse();
            }
        }
        $errors = $model->getFirstErrors();
        return $this->formatResponse(false, 1003, array_shift($errors));
    }
}
