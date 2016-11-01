<?php

namespace models;

use app\models\ContactForm;
use app\models\PasswordResetRequestForm;
use app\models\User;
use Codeception\Test\Unit;
use UnitTester;
use Yii;
use function expect;
use function expect_not;
use function expect_that;

class PasswordResetRequestFormTest extends Unit {

    private $model;

    /**
     * @var UnitTester
     */
    protected $tester;

    protected function _before() {
        
    }

    protected function _after() {
        
    }

    // tests
    public function testEmailIsSentOnRequestResetPassword() {
        /** @var ContactForm $model */
        $this->model = $this->getMockBuilder('app\models\PasswordResetRequestForm')
                ->setMethods(['validate'])
                ->getMock();

        $this->model->attributes = [
            'email' => 'kursat.yigitoglu@gmail.com',
        ];

        $this->model->expects($this->once())
                ->method('validate')
                ->will($this->returnValue(true));

        expect_that($this->model->sendEmail());

        $this->tester->seeEmailIsSent();

        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey('kursat.yigitoglu@gmail.com');
        expect($emailMessage->getSubject())->equals('Password reset for ' . Yii::$app->name);

        expect_that($user = User::findOne(1));

        expect($emailMessage->toString())->contains($user->password_reset_token);
    }

    public function testEmailIsReal() {
        $form = new PasswordResetRequestForm();

        $form->email = 'notanemail';
        expect_not($form->validate(['email']));

        $form->email = 'kursat.yigitoglu@gmail.com';
        expect_that($form->validate(['email']));
    }

    public function testEmailIsExists() {
        $form = new PasswordResetRequestForm();
        $form->email = 'an@actual.email';
        expect_not($form->validate('email'));

        $form = new PasswordResetRequestForm();
        $form->email = 'kursat.yigitoglu@gmail.com';
        expect_that($form->validate('email'));
    }
}
