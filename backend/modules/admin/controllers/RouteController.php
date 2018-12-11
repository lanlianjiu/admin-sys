<?php
/**
 * @author: jiangyi
 * @date: 下午3:00 2018/7/20
 */

namespace backend\modules\admin\controllers;


use backend\controllers\ApiController;
use backend\modules\admin\models\Route;
use Yii;

class RouteController extends ApiController
{
    /**
     * @var string
     */
    public $modelClass = 'backend\modules\admin\models\Route';

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
        $model = new Route();
        return $model->getRoutes();
    }

    public function actionCreate()
    {
        $routes = Yii::$app->getRequest()->post('route', '');
        $routes = preg_split('/\s*,\s*/', trim($routes), -1, PREG_SPLIT_NO_EMPTY);
        $model = new Route();
        $model->addNew($routes);
        return $model->getRoutes();
    }

    public function actionAssign()
    {
        $routes = Yii::$app->getRequest()->post('routes', []);
        $model = new Route();
        $model->addNew($routes);
        return $model->getRoutes();
    }

    public function actionRemove()
    {
        $routes = Yii::$app->getRequest()->post('routes', []);
        $model = new Route();
        $model->remove($routes);
        return $model->getRoutes();
    }

    public function actionRefresh()
    {
        $model = new Route();
        $model->invalidate();
        return $model->getRoutes();
    }
}
