<?php

class PasswordResetRequestFormCest {

    public function _before(FunctionalTester $I) {
        $I->amOnRoute('site/request-password-reset');
    }

    public function _after(FunctionalTester $I) {
        
    }

    public function submitFormWithEmptyEmail(FunctionalTester $I) {
        $I->submitForm('#request-password-reset-form', []);
        $I->expectTo('see validations errors');
        $I->see('Email cannot be blank.');
    }

    public function submitFormWithWrongEmail(FunctionalTester $I) {
        $I->submitForm('#request-password-reset-form', [
            'PasswordResetRequestForm[email]' => 'not.an@actual.email',
        ]);
        $I->expectTo('see validations errors');
        $I->see('There is no user with such email.');
    }

    public function resetPasswordSuccessfully(FunctionalTester $I) {
        $I->see('Request password reset', 'h1');

        $I->fillField('PasswordResetRequestForm[email]', 'kursat.yigitoglu@gmail.com');

        $I->submitForm('#request-password-reset-form', [
            'PasswordResetRequestForm[email]' => 'kursat.yigitoglu@gmail.com',
        ]);

        $I->see('Check your email for further instructions.');
    }

}
