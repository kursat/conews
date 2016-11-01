<?php

namespace models;

use app\models\Post;
use app\models\User;
use Codeception\Test\Unit;
use Faker\Factory;
use UnitTester;
use function expect_not;
use function expect_that;

class PostTest extends Unit {

    /**
     * @var UnitTester
     */
    protected $tester;
    private $faker;

    protected function _before() {
        $this->faker = Factory::create('en-US');
    }

    protected function _after() {
        
    }

    public function testPostShouldHaveUser() {
        $post = Post::findOne(1);
        expect_not($post->unlink('user', $post->user));
    }

    public function testValidateTitleLength() {
        $post = new Post();
        $long_text = '';
        while (strlen($long_text) < 256) {
            $long_text .= 'c';
        }
        
        $post->title = substr($long_text, 0, 255);
        expect_that($post->validate(['title']));
        
        $post->title = $long_text;
        expect_not($post->validate(['title']));
    }
    
    public function testCreatePost() {
        $post = new Post();
        $post->image = 'dummyimagelink.png';
        $post->content = $this->faker->text;
        $post->title = $this->faker->text(255);
        expect_not($post->save());
        
        $post->link('user', User::findOne(1));
        expect_that($post->save());
    }
    
    public function testDeletePost() {
        $post = Post::findOne(1);
        expect_that($post->delete());
        expect_not(Post::findOne(1));
    }

}
