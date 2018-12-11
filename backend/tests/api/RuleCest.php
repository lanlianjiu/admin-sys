<?php
namespace backend\tests\api;
use backend\tests\ApiTester;
use common\fixtures\UserFixture;

class RuleCest
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
        $I->sendGET('/admin/rule?access-token='.$I->generateJwt());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'items' => 'array',
        ]);
    }

    public function createTest(ApiTester $I)
    {
        $I->sendPOST('/admin/rule?access-token='.$I->generateJwt(), ['BizRule[name]' => 'AuthorRule', 'BizRule[className]' => 'backend\modules\admin\rules\AuthorRule']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'status' => 'boolean',
            'code' => 'integer',
            'message' => 'string',
            'meta' => 'array',
        ]);
    }

    public function viewTest(ApiTester $I)
    {
        $I->sendGET('/admin/rule/view/AuthorRule?access-token='.$I->generateJwt());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'name' => 'string',
            'createdAt' => 'null',
            'updatedAt' => 'null',
            'className' => 'string',
        ]);
    }

    public function updateTest(ApiTester $I)
    {
        $I->sendPUT('/admin/rule/AuthorRule?access-token='.$I->generateJwt(), ['BizRule[className]' => 'backend\modules\admin\rules\AuthorRule']);
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
        $I->sendDELETE('/admin/rule/AuthorRule?access-token='.$I->generateJwt());
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
