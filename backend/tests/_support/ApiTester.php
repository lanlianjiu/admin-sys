<?php
namespace backend\tests;

use common\JWT;
use common\models\User;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class ApiTester extends \Codeception\Actor
{
    use _generated\ApiTesterActions;

   protected $jwt;

   public function generateJwt()
   {
       if ($this->jwt === null) {
           $time = time();
           $payload = [
               'iss' => 'test',
               'exp' => $time + 7200,
               'iat' => $time,
               'uid' => 1,
               'jti' => '',
           ];
           $this->jwt = JWT::encode($payload, User::getJwtSecretKey());
       }
       return $this->jwt;
   }
}
