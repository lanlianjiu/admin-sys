<?php
/**
 * @author: jiangyi
 * @date: 下午3:01 2018/7/20
 */

namespace backend\modules\admin\controllers;

use backend\controllers\ApiController;
use backend\modules\admin\models\BizRule;
use backend\modules\admin\models\searches\BizRuleSearch;
use mdm\admin\components\Configs;
use mdm\admin\components\Helper;
use Yii;
use yii\web\NotFoundHttpException;

class RuleController extends ApiController
{
    /**
     * @var string
     */
    public $modelClass = 'backend\modules\admin\models\BizRule';

    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET'],
            'create' => ['POST'],
            'refresh' => ['POST'],
            'delete' => ['DELETE'],
        ];
    }

    public function prepareDataProvider()
    {
        $searchModel = new BizRuleSearch();
        return $searchModel->search(Yii::$app->request->getQueryParams());
    }

    public function actionView($id)
    {
        return $this->findModel($id);
    }

    public function actionCreate()
    {
        $model = new BizRule(null);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Helper::invalidate();

            return $this->formatResponse();
        } else {
            $errors = $model->getFirstErrors();
            return $this->formatResponse(false, 1001, array_shift($errors));
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Helper::invalidate();

            return $this->formatResponse();
        }

        $errors = $model->getFirstErrors();
        return $this->formatResponse(false, 1001, array_shift($errors));
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        Configs::authManager()->remove($model->item);
        Helper::invalidate();

        return $this->formatResponse();
    }

    protected function findModel($id)
    {
        $item = Configs::authManager()->getRule($id);
        if ($item) {
            return new BizRule($item);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
