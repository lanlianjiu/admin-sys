<?php
/**
 * @author: jiangyi
 * @date: 下午11:27 2018/7/26
 */

namespace backend\tests\api;

use backend\tests\ApiTester;
use common\fixtures\UserFixture;

class AdminCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    public function _request()
    {

    }

    public function _loadPage()
    {

    }

    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ];
    }

    public function createTest(ApiTester $I)
    {
        $I->sendPOST('/admin/admin?access-token='.$I->generateJwt(), [
            'Admin[username]' => 'admin_a',
            'Admin[password]' => 123456,
            'Admin[email]' => '1234@qq.com',
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'status' => 'boolean',
            'code' => 'integer',
            'message' => 'string',
            'meta' => 'array',
        ]);
    }

    // tests
    public function indexTest(ApiTester $I)
    {
        $I->sendGET('/admin/admin?access-token='.$I->generateJwt());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'items' => 'array',
        ]);
    }

}
