<?php

use app\models\User;

class CreatePostFormCest {

    public function _before(FunctionalTester $I) {
        
    }

    public function _after(FunctionalTester $I) {
        
    }

    public function loadPageAsGuest(FunctionalTester $I) {
        $I->amOnRoute('post/create');
        $I->dontSee('Posts');
        $I->see('Login', 'h1');
    }

    public function loadPageAsConfirmedUser(FunctionalTester $I) {
        $I->amLoggedInAs(1);
        $I->amOnRoute('post/create');
        $I->see('Posts');
        $I->dontSee('Login', 'h1');
    }

    public function submitFormWithInvalidData(FunctionalTester $I) {
        $I->amLoggedInAs(1);
        $I->amOnRoute('post/create');
        $I->see('Posts');
        $I->dontSee('Login', 'h1');

        /**
         * TODO: Test with valid input file.
         * 
         * $I->attachFile('input[name="CreatePostForm[imageFile]"]', 'testimage.jpg');
         */
        $I->submitForm('#create-post-form', [
            'CreatePostForm[title]' => 'title',
            'CreatePostForm[content]' => 'content',
        ]);

        $I->expectTo('see validations errors');
        $I->see('Please upload a file.');
    }

}
