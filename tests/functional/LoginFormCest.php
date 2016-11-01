<?php

class LoginFormCest {

    public function _before(\FunctionalTester $I) {
        $I->amOnRoute('site/login');
    }

    public function openLoginPage(\FunctionalTester $I) {
        $I->see('Login', 'h1');
    }

    public function internalLoginById(\FunctionalTester $I) {
        $I->amLoggedInAs(1);
        $I->amOnPage('/');
        $I->see('Logout (kursat.yigitoglu@gmail.com)');
    }

    public function internalLoginByInstance(\FunctionalTester $I) {
        $I->amLoggedInAs(\app\models\User::findByEmail('kursat.yigitoglu@gmail.com'));
        $I->amOnPage('/');
        $I->see('Logout (kursat.yigitoglu@gmail.com)');
    }

    public function loginWithEmptyCredentials(\FunctionalTester $I) {
        $I->submitForm('#login-form', []);
        $I->expectTo('see validations errors');
        $I->see('Email cannot be blank.');
        $I->see('Password cannot be blank.');
    }

    public function loginWithWrongCredentials(\FunctionalTester $I) {
        $I->submitForm('#login-form', [
            'LoginForm[email]' => 'admin',
            'LoginForm[password]' => 'wrong',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Incorrect email or password.');
    }

    public function loginSuccessfully(\FunctionalTester $I) {
        $I->submitForm('#login-form', [
            'LoginForm[email]' => 'kursat.yigitoglu@gmail.com',
            'LoginForm[password]' => '123456',
        ]);
        $I->see('Logout (kursat.yigitoglu@gmail.com)');
        $I->dontSeeElement('form#login-form');
    }

}
