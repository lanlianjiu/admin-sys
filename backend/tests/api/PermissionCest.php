<?php
/**
 * @author: jiangyi
 * @date: 下午11:27 2018/7/26
 */

namespace backend\tests\api;

use backend\tests\ApiTester;
use common\fixtures\UserFixture;

class PermissionCest
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
        $I->sendPOST('/admin/permission?access-token='.$I->generateJwt(), [
            'AuthItem[name]' => 'permission_a',
            'AuthItem[ruleName]' => '',
            'AuthItem[description]' => 'aaaa',
            'AuthItem[data]' => '{"aaaa":123}',
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
        $I->sendGET('/admin/permission?access-token='.$I->generateJwt());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'items' => 'array',
        ]);
    }

    public function assignTest(ApiTester $I)
    {
        $I->sendPOST('/admin/permission/assign?access-token='.$I->generateJwt().'&id=permission_a', ['items' => ['/*']]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'available' => 'array',
            'assigned' => 'array',
            'success' => 'integer',
        ]);
    }

    public function removeTest(ApiTester $I)
    {
        $I->sendPOST('/admin/permission/remove?access-token='.$I->generateJwt().'&id=permission_a', ['items' => ['/*']]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'available' => 'array',
            'assigned' => 'array',
            'success' => 'integer',
        ]);
    }

    public function viewTest(ApiTester $I)
    {
        $I->sendGET('/admin/permission/view/permission_a?access-token='.$I->generateJwt());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'name' => 'string',
            'type' => 'string',
        ]);
    }

    public function updateTest(ApiTester $I)
    {
        $I->sendPUT('/admin/permission/permission_a?access-token='.$I->generateJwt(), ['AuthItem[description]' => 'aaaavvvv']);
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
        $I->sendDELETE('/admin/permission/permission_a?access-token='.$I->generateJwt());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'status' => 'boolean',
            'code' => 'integer',
            'message' => 'string',
            'meta' => 'array',
        ]);
    }

}
