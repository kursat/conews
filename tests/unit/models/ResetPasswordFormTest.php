<?php

namespace models;

use app\models\ContactForm;
use app\models\ResetPasswordForm;
use app\models\User;
use Codeception\Test\Unit;
use UnitTester;
use function expect_not;
use function expect_that;

class ResetPasswordFormTest extends Unit {

    private $model;

    /**
     * @var UnitTester
     */
    protected $tester;
    private $user;

    protected function _before() {
        $this->user = User::findOne(1);
        $this->user->generatePasswordResetToken();
        $this->user->save();
    }

    protected function _after() {
        
    }

    // tests
    public function testResetPassword() {
        
        /** @var ContactForm $model */
        $this->model = $this->getMockBuilder('app\models\ResetPasswordForm')
                ->setConstructorArgs(array($this->user->password_reset_token))
                ->setMethods(['validate'])
                ->getMock();

        $this->model->attributes = [
            'password' => '123456',
        ];

        $this->model->expects($this->once())
                ->method('validate')
                ->will($this->returnValue(true));

        expect_that($this->model->resetPassword());

        expect_that($this->user = User::findOne(1));
        expect_not($this->user->password_reset_token);
    }

    public function testValidatePasswordLength() {
        $form = new ResetPasswordForm($this->user->password_reset_token);

        $form->password = '12345';
        expect_not($form->validate(['password']));

        $form->password = '123456';
        expect_that($form->validate(['password']));
    }

}
