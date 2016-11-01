<?php

use app\models\User;

class ResetPasswordFormCest {

    private $user;

    public function _before(FunctionalTester $I) {
        $this->user = User::findOne(1);
        $this->user->generatePasswordResetToken();
        $this->user->save();
    }

    public function _after(FunctionalTester $I) {
        
    }

    public function loadPageWithWrongToken(FunctionalTester $I) {
        $I->amOnRoute('site/reset-password', [
            'token' => 'wrong_token'
        ]);
        $I->expectTo('see errors');
        $I->see('Wrong password reset token.');
    }

    public function submitFormWithEmptyPassword(FunctionalTester $I) {
        $I->amOnRoute('site/reset-password', [
            'token' => $this->user->password_reset_token
        ]);

        $I->submitForm('#reset-password-form', [
            'ResetPasswordForm[password]' => null
        ]);
        $I->expectTo('see validations errors');
        $I->see('Password cannot be blank.');
    }

    public function submitFormWithInvalidPassword(FunctionalTester $I) {
        $I->amOnRoute('site/reset-password', [
            'token' => $this->user->password_reset_token
        ]);

        $I->see('Reset password', 'h1');

        $I->submitForm('#reset-password-form', [
            'ResetPasswordForm[password]' => '1'
        ]);

        $I->see('Password should contain at least 6 characters.');
    }

    public function resetPasswordSuccessfully(FunctionalTester $I) {
        $I->amOnRoute('site/reset-password', [
            'token' => $this->user->password_reset_token
        ]);

        $I->see('Reset password', 'h1');

        $I->submitForm('#reset-password-form', [
            'ResetPasswordForm[password]' => '123456'
        ]);

        $I->see('New password was saved. ');
    }

}
