<?php

namespace common;

use mdm\admin\components\Helper;
use Yii;
use yii\base\Component;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

/**
 * 跨域身份验证及响应格式设置组件
 *
 * Class Auth
 * @package components
 */
class Auth extends Component
{

    /**
     *  跨域、用户认证
     *
     * @param array $behaviors 已有的认证方法
     *
     * @return array
     * @author: wumahoo
     */
    public static function authentication(array $behaviors)
    {
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index' => ['GET'],
                'view' => ['GET'],
                'create' => ['POST'],
                'update' => ['PUT', 'PATCH'],
                'delete' => ['DELETE'],
            ],
        ];

        $behaviors = ArrayHelper::merge([
            [
                'class' => Cors::class,
                'cors' => [
                    //允许的跨域请求源
                    'Origin' => Yii::$app->params['CorsOrigin'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    //'Access-Control-Request-Headers' => ['Origin, X-Requested-With, Content-Type, Accept, Authorization'],
                    'Access-Control-Request-Headers' => ['*'],
                    //'Access-Control-Max-Age' => 3600,   //TODO: 开发阶段先不缓存options请求
                ],
            ],
        ], $behaviors);

        //验证规则
        if (!Yii::$app->request->isOptions) {
            $behaviors['authenticator'] = [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    /*下面是三种验证access_token方式*/
                    //1.HTTP 基本认证: access token 当作用户名发送，应用在access token可安全存在API使用端的场景，例如，API使用端是运行在一台服务器上的程序。
                    HttpBasicAuth::class,
                    //2.OAuth 2: 使用者从认证服务器上获取基于OAuth2协议的access token，然后通过 HTTP Bearer Tokens 发送到API 服务器。
                    HttpBearerAuth::class,
                ],
            ];

            //调试模式下可使用access-token接收参数
            if (YII_DEBUG) {
                //3.请求参数: access token 当作API URL请求参数发送，这种方式应主要用于JSONP请求，因为它不能使用HTTP头来发送access token
                //http://localhost/user/index/index?access-token=123
                //QueryParamAuth::className(),
                array_push($behaviors['authenticator']['authMethods'], QueryParamAuth::class);
            }
        }

        //设置响应的格式
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;

        return $behaviors;
    }

    /**
     * 检查用户是否拥有权限操作的api
     *
     * @param $actionId string 所在控制器的方法
     * @param $user string 已认证的用户
     * @return bool
     * @throws ForbiddenHttpException
     * @author: wumahoo
     */
    public static function checkRoute($actionId, $user)
    {
        if (Yii::$app->request->isOptions) {
            return true;
        }
        if (Helper::checkRoute('/' . $actionId, Yii::$app->getRequest()->get(), $user)) {
            return true;
        }
        throw new ForbiddenHttpException();
    }
}
