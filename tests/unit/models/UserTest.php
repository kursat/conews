<?php

namespace tests\models;

use app\models\User;
use Codeception\Test\Unit;
use Faker\Factory;
use UnitTester;
use function expect;
use function expect_not;
use function expect_that;

class UserTest extends Unit {

    /**
     * @var UnitTester
     */
    protected $tester;
    private $faker;

    protected function _before() {
        $this->faker = Factory::create('en-US');
    }

    protected function _after() {
        
    }

    public function testFindUserById() {
        expect_that($user = User::findIdentity(1));
        expect($user->email)->equals('kursat.yigitoglu@gmail.com');

        expect_not(User::findIdentity(999));
    }

    public function testFindUserByEmail() {
        expect_that($user = User::findByEmail('kursat.yigitoglu@gmail.com'));
        expect_not(User::findByEmail('not-exist'));
    }

    public function testFindByPasswordResetToken() {
        expect_that($user_by_email = User::findByEmail('kursat.yigitoglu@gmail.com'));
        $user_by_email->generatePasswordResetToken();
        $user_by_email->save();

        expect($user_by_token = User::findByPasswordResetToken($user_by_email->password_reset_token));

        expect($user_by_email->email)->equals($user_by_token->email);
    }

    /**
     * @depends testFindUserByEmail
     */
    public function testFindUserByAccessToken() {
        expect_that($user_by_email = User::findByEmail('kursat.yigitoglu@gmail.com'));

        expect_that($user_by_auth_key = User::findIdentityByAccessToken($user_by_email->auth_key));
        expect($user_by_auth_key->email)->equals('kursat.yigitoglu@gmail.com');

        expect_not(User::findIdentityByAccessToken('non-existing'));
    }

    /**
     * @depends testFindUserByEmail
     */
    public function testValidateUser() {
        $user = User::findByEmail('kursat.yigitoglu@gmail.com');
        expect_that($user->validateAuthKey($user->auth_key));
        expect_not($user->validateAuthKey(uniqid()));

        expect_that($user->validatePassword('123456'));
        expect_not($user->validatePassword(uniqid()));
    }

    /**
     * @depends testFindUserByEmail
     */
    public function testGenerateAndValidatePasswordResetToken() {
        expect_that($user = User::findByEmail('kursat.yigitoglu@gmail.com'));

        $token_before = $user->password_reset_token;
        $user->generatePasswordResetToken();
        $token = $user->password_reset_token;
        expect_that($token != $token_before);

        expect_that($user->isPasswordResetTokenValid($token));
        expect_not($user->isPasswordResetTokenValid(uniqid()));
    }

    /**
     * @depends testFindUserByEmail
     */
    public function testPasswordResetTokenValid() {
        expect_that($user = User::findByEmail('kursat.yigitoglu@gmail.com'));

        $user->generatePasswordResetToken();

        $user->removePasswordResetToken();
        expect_not($user->isPasswordResetTokenValid($user->password_reset_token));

        $user->generatePasswordResetToken();
        expect_that($user->isPasswordResetTokenValid($user->password_reset_token));
    }

    public function testGetFullname() {
        $user = new User();
        $user->firstname = 'Oscar';
        $user->lastname = 'Kilo';

        expect($user->fullname)->equals('Oscar Kilo');

        $user->lastname = null;

        expect($user->fullname)->equals('Oscar');
    }

    public function testEmailIsReal() {
        $user = new User();

        $user->email = 'notanemail';
        expect_not($user->validate(['email']));

        $user->email = 'an@actual.email';
        expect_that($user->validate(['email']));
    }

    public function testEmailIsUnique() {
        $user = new User();
        $user->email = 'an@actual.email';
        $user->setPassword($this->faker->password());
        $user->generateAuthKey();
        expect_that($user->save());

        $user = new User();
        $user->email = 'an@actual.email';
        $user->setPassword($this->faker->password());
        $user->generateAuthKey();
        expect_not($user->save());
    }

    public function testEmailLengthValidate() {
        $user = new User();

        $user->email = 'not5';
        expect_not($user->validate(['email']));

        $user->email = 'a@a.a';
        expect_that($user->validate(['email']));

        $long_email = 'long@email.long';

        while (strlen($long_email) < 255) {
            $long_email .= 'c';
        }

        $user->email = $long_email;
        expect_not($user->validate(['email']));

        $user->email = substr($long_email, 0, 254);
        expect_that($user->validate(['email']));
    }

    public function testSavingUser() {
        $user = new User();
        $user->email = 'an@actual.email';
        $user->setPassword($this->faker->password());
        $user->generateAuthKey();

        expect_that($user->save());

        $user = new User();
        $user->email = 'an@actual.email';
        $user->setPassword($this->faker->password());

        expect_not($user->save());

        $user = new User();
        $user->email = 'an@actual.email';
        $user->generateAuthKey();

        expect_not($user->save());
    }
    
    public function testAssignRevokeRole() {
        $user = new User();
        $user->email = 'an@actual.email';
        $user->setPassword($this->faker->password());
        $user->generateAuthKey();

        $user->save();
        
        $role = \Yii::$app->authManager->getRole('Confirmed');
        
        expect_that(\Yii::$app->authManager->assign($role, $user->id));
        
        expect_that($user->getAuthItems()->where('name=:name', ['name' => $role->name])->all());
        expect_not($user->getAuthItems()->where('name=:name', ['name' => 'Registered'])->all());
        
        expect_that(\Yii::$app->authManager->revokeAll($user->id));
        expect_not($user->getAuthItems()->all());
    }

}
