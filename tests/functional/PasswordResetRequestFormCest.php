<?php

class PasswordResetRequestFormCest {
    
    private $user;

    public function _before(FunctionalTester $I) {
        $this->user = app\models\User::findOne(1);
        $this->user->generatePasswordResetToken();
        $this->user->save();
    }

    public function _after(FunctionalTester $I) {
        
    }

    public function submitFormWithEmptyPassword(FunctionalTester $I) {
        $I->amOnRoute('site/reset-password', [
            'token' => $this->user->password_reset_token
        ]);
        
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
