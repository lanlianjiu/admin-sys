<?php
/**
 * @author: jiangyi
 * @date: 下午11:27 2018/7/26
 */

namespace backend\tests\api;

use backend\tests\ApiTester;
use backend\tests\fixtures\MenuFixture;
use common\fixtures\UserFixture;

class MenuCest
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
            ],
            'menu' => [
                'class' => MenuFixture::class,
                'dataFile' => codecept_data_dir() . 'menu_data.php'
            ]
        ];
    }

    public function createTest(ApiTester $I)
    {
        $I->sendPOST('/admin/menu?access-token='.$I->generateJwt(), [
            'Menu[parent]' => '',
            'Menu[name]' => '权限管理',
            'Menu[parent_name]' => '',
            'Menu[route]' => '',
            'Menu[order]' => 11,
            'Menu[data]' => '132',
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

    public function createChildTest(ApiTester $I)
    {
        $I->sendPOST('/admin/menu?access-token='.$I->generateJwt(), [
            'Menu[parent]' => 10,
            'Menu[name]' => '用户管理',
            'Menu[parent_name]' => '测试',
            'Menu[route]' => '',
            'Menu[order]' => 1,
            'Menu[data]' => '132',
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
        $I->sendGET('/admin/menu?access-token='.$I->generateJwt());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'items' => 'array',
        ]);
    }

    public function viewTest(ApiTester $I)
    {
        $I->sendGET('/admin/menu/view/10?access-token='.$I->generateJwt());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
        ]);
    }

    public function updateTest(ApiTester $I)
    {
        $I->sendPUT('/admin/menu/10?access-token='.$I->generateJwt(), ['Menu[data]' => '123123']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'status' => 'boolean',
            'code' => 'integer',
            'message' => 'string',
            'meta' => 'array',
        ]);
    }

    public function deleteTest(ApiTester $I)
    {
        $I->sendDELETE('/admin/menu/10?access-token='.$I->generateJwt());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'status' => 'boolean',
            'code' => 'integer',
            'message' => 'string',
            'meta' => 'array',
        ]);
    }

    public function assignedMenuTest(ApiTester $I)
    {
        $I->sendGET('/admin/menu/assigned-menu?access-token='.$I->generateJwt());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
    }
}
