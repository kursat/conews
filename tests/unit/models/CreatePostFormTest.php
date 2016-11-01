<?php

namespace models;

use app\models\CreatePostForm;
use app\models\LoginForm;
use Codeception\Test\Unit;
use Faker\Factory;
use UnitTester;
use Yii;
use yii\web\UploadedFile;
use function expect_that;

class CreatePostFormTest extends Unit {

    /**
     * @var UnitTester
     */
    protected $tester;
    private $user;
    private $faker;

    protected function _before() {
        $this->faker = Factory::create('en-US');

        $this->user = new LoginForm([
            'email' => 'kursat.yigitoglu@gmail.com',
            'password' => '123456',
        ]);
        
        $this->user->login();
    }

    protected function _after() {
        Yii::$app->user->logout();
    }

    // tests
    public function testCreatePost() {
        $form = new CreatePostForm();
        
        $form->content = $this->faker->text();
        $form->title = $this->faker->text(255);
        
        $form->validate();
        
        expect($form->getErrors())->hasntKey('content');
        expect($form->getErrors())->hasntKey('title');
        expect($form->getErrors())->hasKey('imageFile');

        expect_not($form->save());
    }

}
