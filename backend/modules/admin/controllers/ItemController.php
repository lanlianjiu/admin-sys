<?php
/**
 * @author: jiangyi
 * @date: 下午11:02 2018/7/26
 */

namespace backend\modules\admin\controllers;


use backend\controllers\ApiController;
use backend\modules\admin\models\AuthItem;
use backend\modules\admin\models\searches\AuthItemSearch;
use mdm\admin\components\Configs;
use mdm\admin\components\Helper;
use Yii;
use yii\rbac\Item;
use yii\web\NotFoundHttpException;

class ItemController extends ApiController
{
    /**
     * @var string
     */
    public $modelClass = 'backend\modules\admin\models\AuthItem';

    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET'],
            'create' => ['POST'],
            'update' => ['PUT'],
            'assign' => ['POST'],
            'remove' => ['POST'],
            'delete' => ['DELETE'],
        ];
    }

    public function prepareDataProvider()
    {
        $searchModel = new AuthItemSearch(['type' => $this->type]);
        return $searchModel->search(Yii::$app->request->getQueryParams());
    }

    public function actionView($id)
    {
        return $this->findModel($id);
    }

    public function actionCreate()
    {
        $model = new AuthItem(null);
        $model->type = $this->type;
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->formatResponse();
        } else {
            $errors = $model->getFirstErrors();
            return $this->formatResponse(false, 1002, array_shift($errors));
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->formatResponse();
        }

        return $this->formatResponse(false, 1002, array_shift($errors));
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        Configs::authManager()->remove($model->item);
        Helper::invalidate();

        return $this->formatResponse();
    }

    public function actionAssign($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = $this->findModel($id);
        $success = $model->addChildren($items);
        Yii::$app->getResponse()->format = 'json';

        return array_merge($model->getItems(), ['success' => $success]);
    }

    public function actionRemove($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = $this->findModel($id);
        $success = $model->removeChildren($items);
        Yii::$app->getResponse()->format = 'json';

        return array_merge($model->getItems(), ['success' => $success]);
    }

    /**
     * Type of Auth Item.
     * @return integer
     */
    public function getType()
    {

    }

    protected function findModel($id)
    {
        $auth = Configs::authManager();
        $item = $this->type === Item::TYPE_ROLE ? $auth->getRole($id) : $auth->getPermission($id);
        if ($item) {
            return new AuthItem($item);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
