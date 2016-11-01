<?php

namespace models;

use app\models\RegisterForm;
use app\models\User;
use Codeception\Test\Unit;
use Faker\Factory;
use UnitTester;
use Yii;
use function expect;
use function expect_not;
use function expect_that;

class RegisterFormTest extends Unit {

    /**
     * @var UnitTester
     */
    protected $tester;
    private $model;
    private $faker;

    protected function _before() {
        $this->faker = Factory::create('en-US');
    }

    protected function _after() {
        
    }

    // tests
    public function testRegisterNewUser() {
        /** @var RegisterForm $model */
        $this->model = $this->getMockBuilder('app\models\RegisterForm')
                ->setMethods(['validate'])
                ->getMock();

        $this->model->attributes = [
            'email' => 'tester@example.com',
        ];

        $this->model->expects($this->once())
                ->method('validate')
                ->will($this->returnValue(true));

        expect_that($this->model->register());

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        $form = User::findByEmail('tester@example.com');

        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey('tester@example.com');
        expect($emailMessage->getSubject())->equals('Welcome to ' . Yii::$app->name);
        expect($emailMessage->toString())->contains($form->password_reset_token);
    }

    public function testEmailIsReal() {
        $form = new RegisterForm();

        $form->email = 'notanemail';
        expect_not($form->validate(['email']));

        $form->email = 'an@actual.email';
        expect_that($form->validate(['email']));
    }

    public function testEmailIsExists() {
        $form = new RegisterForm();
        $form->email = 'an@actual.email';
        expect_that($form->validate('email'));
        
        $form->register();

        $form = new RegisterForm();
        $form->email = 'an@actual.email';
        expect_not($form->validate('email'));
    }

    public function testEmailLengthValidate() {
        $form = new RegisterForm();

        $form->email = 'not5';
        expect_not($form->validate(['email']));

        $form->email = 'a@a.a';
        expect_that($form->validate(['email']));

        $long_email = 'long@email.long';

        while (strlen($long_email) < 255) {
            $long_email .= 'c';
        }

        $form->email = $long_email;
        expect_not($form->validate(['email']));

        $form->email = substr($long_email, 0, 254);
        expect_that($form->validate(['email']));
    }

}
