<?php
namespace backend\tests\api;
use backend\tests\ApiTester;
use common\fixtures\UserFixture;

class RouteCest
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

    // tests
    public function indexTest(ApiTester $I)
    {
        $I->sendGET('/admin/route?access-token='.$I->generateJwt());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'available' => 'array',
            'assigned' => 'array',
        ]);
    }

    public function createTest(ApiTester $I)
    {
        $I->sendPOST('/admin/route?access-token='.$I->generateJwt(), ['route' => 'test/*']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'available' => 'array',
            'assigned' => 'array',
        ]);
    }

    public function assignTest(ApiTester $I)
    {
        $I->sendPOST('/admin/route/assign?access-token='.$I->generateJwt(), ['routes' => ['/*']]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'available' => 'array',
            'assigned' => 'array',
        ]);
    }

    public function removeTest(ApiTester $I)
    {
        $I->sendPOST('/admin/route/remove?access-token='.$I->generateJwt(), ['routes' => ['test/*']]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'available' => 'array',
            'assigned' => 'array',
        ]);
    }

    public function refreshTest(ApiTester $I)
    {
        $I->sendGET('/admin/route/refresh?access-token='.$I->generateJwt());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'available' => 'array',
            'assigned' => 'array',
        ]);
    }

}
