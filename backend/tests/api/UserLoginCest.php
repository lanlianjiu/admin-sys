<?php
namespace backend\tests\api;
use backend\tests\ApiTester;
use common\fixtures\UserFixture;

class UserLoginCest
{
    public function _before(ApiTester $I)
    {
        //$I->sendOPTIONS('/admin/user/login');
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

    // tests
    public function tryToTest(ApiTester $I)
    {
        $I->amHttpAuthenticated('erau', 'password_0');
        $I->sendPOST('/admin/user/login');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'name' => 'string',
            'message' => 'string',
            'code' => 'integer',
            'status' => 'integer',
            'Authorization' => 'string',
            'username' => 'string',
        ]);
    }

    public function usernameOrPasswordNotMatchTest(ApiTester $I)
    {
        $I->amHttpAuthenticated('wen', '1234567');
        $I->sendPOST('/admin/user/login');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED); // 400
    }
}
