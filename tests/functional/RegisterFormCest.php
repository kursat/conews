<?php

class RegisterFormCest {

    public function _before(FunctionalTester $I) {
        $I->amOnRoute('site/register');
    }

    public function _after(FunctionalTester $I) {
        
    }

    public function submitFormWithEmptyEmail(FunctionalTester $I) {
        $I->submitForm('#form-register', []);
        $I->expectTo('see validations errors');
        $I->see('Email cannot be blank.');
    }

    public function submitFormWithTakenEmail(FunctionalTester $I) {
        $I->submitForm('#form-register', [
            'RegisterForm[email]' => 'kursat.yigitoglu@gmail.com',
        ]);
        $I->expectTo('see validations errors');
        $I->see('This email address has already been taken.');
    }

    public function registerSuccessfully(FunctionalTester $I) {
        $I->see('Register', 'h1');

        $I->submitForm('#form-register', [
            'RegisterForm[email]' => 'an@actual.email',
        ]);

        $I->see('An email sent to your email address. Check your email for further instructions. ');
    }

}
