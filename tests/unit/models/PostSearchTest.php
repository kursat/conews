<?php

namespace models;

use app\models\AuthItem;
use app\models\PostSearch;
use app\models\User;
use Codeception\Test\Unit;
use UnitTester;
use Yii;
use function expect;

class PostSearchTest extends Unit {

    /**
     * @var UnitTester
     */
    protected $tester;

    protected function _before() {
        
    }

    protected function _after() {
        
    }

    // tests
    public function testGuestsCantListPosts() {
        $search = new PostSearch();
        $dataProvider = $search->search([]);
        
        expect($dataProvider->totalCount)->equals(0);
    }
    
    public function testRegisteredUsersCantListPosts() {
        $user_ids = Yii::$app->authManager->getUserIdsByRole(AuthItem::ROLE_REGISTERED);
        $confirmed_user = User::findOne($user_ids[0]);
        
        $search = new PostSearch();
        $search->user_id = $confirmed_user->id;
        $dataProvider = $search->search([]);
        
        expect($dataProvider->totalCount)->equals(0);
        
    }
    
    public function testConfirmedUsersCanListPosts() {
        $user_ids = Yii::$app->authManager->getUserIdsByRole(AuthItem::ROLE_CONFIRMED);
        $confirmed_user = User::findOne($user_ids[0]);
        
        $search = new PostSearch();
        $search->user_id = $confirmed_user->id;
        $dataProvider = $search->search([]);
        
        expect($dataProvider->totalCount)->notEquals(0);
    }

}
