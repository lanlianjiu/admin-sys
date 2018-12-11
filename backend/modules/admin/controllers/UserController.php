<?php

namespace backend\modules\admin\controllers;

use common\models\User;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\rest\Controller;
use yii\web\Response;

/**
 * Class UserController
 * @package frontend\modules\v1\controllers
 * @author wumahoo
 */
class UserController extends ActiveController
{
    /**
     * @var string
     */
    public $modelClass = 'common\models\User';

    /**
     * 使用HttpBasicAuth进行登陆验证,注意每次跨域请求前均带有options的请求
     *
     * @return array
     * @author: wumahoo
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        //跨域请求
        $behaviors = ArrayHelper::merge([
            [
                'class' => Cors::class,
                'cors' => [
                    //允许的跨域请求源
                    'Origin' => Yii::$app->params['CorsOrigin'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    //'Access-Control-Request-Headers' => ['Origin, X-Requested-With, Content-Type, Accept, Authorization'],
                    'Access-Control-Request-Headers' => ['*'],
                    //'Access-Control-Max-Age' => 3600,
                ],
            ],
        ], $behaviors);

        //使用HttpBasicAuth验证用户登陆
        if (!Yii::$app->request->isOptions) {
            $_SERVER['PHP_AUTH_USER'] = $_SERVER['PHP_AUTH_USER'] ?? '';
            $_SERVER['PHP_AUTH_PW'] = $_SERVER['PHP_AUTH_PW'] ?? '';
            $behaviors['authenticator'] = [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    [
                        'class' => HttpBasicAuth::class,
                        'auth' => function ($username, $password) {
                            $request = Yii::$app->request;
                            $username = $username ?: $request->post('username');
                            $password = $password ?: $request->post('password');
                            if (!$user = User::findByUsername($username)) {
                                return null;
                            }
                            if (!$user->validatePassword($password)) {
                                return null;
                            }
                            if ($user->login()) {
                                return $user;
                            }
                            return null;
                        }
                    ],
                    HttpBearerAuth::class,
                    QueryParamAuth::class,
                ]
            ];
        }

        //设置输入的格式
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;

        return $behaviors;
    }

    /**
     * 返回登陆成功的access_token值
     *
     * @return array | null | boolean
     * @author: wumahoo
     */
    public function actionLogin()
    {
        $username = '';
        if (Yii::$app->user->id) {
            $message = '登陆成功';
            $code = 1;
            $identity = Yii::$app->user->identity;
            $authorization = isset($identity->access_token) ? $identity->access_token : '';
            $username = isset($identity->username) ? $identity->username : '';
        } else {
            $message = '用户名或者密码有误';
            $code = 0;
            $authorization = '';
        }
        return [
            'name' => 'access-token',
            'message' => $message,
            'code' => $code,
            'status' => 200,
            'Authorization' => $authorization,
            'username' => $username,
        ];
    }

}
