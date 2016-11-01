<?php

namespace app\commands;

use app\models\AuthItem;
use app\models\Post;
use app\models\User;
use Faker\Factory;
use ReflectionClass;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use const PHP_EOL;

/**
 * This command seeds database tables for testing environment.
 */
class SeedDatabaseController extends Controller {

    public $defaultAction = 'all';

    /**
     * Seeds every table with random values.
     */
    public function actionAll() {

        echo "\033[36mCreating roles...\033[0m" . PHP_EOL;
        $this->createRoles();

        echo "\033[36mCreating admin users...\033[0m" . PHP_EOL;
        $this->createAdminUsers();

        echo "\033[36mCreating random users...\033[0m" . PHP_EOL;
        $this->createUsers();

        echo "\033[36mCreating random posts...\033[0m" . PHP_EOL;
        $this->createPosts();
    }

    /**
     * Creates roles.
     */
    public function actionRoles() {
        $this->createRoles();
    }

    /**
     * Creates random users.
     * 
     * @param type $count
     */
    public function actionUsers($count = null) {
        $this->createUsers($count);
    }

    /**
     * Creates random posts.
     * 
     * @param type $count
     */
    public function actionPosts($count = null) {
        $this->createPosts($count);
    }

    /**
     * Creates random users.
     * 
     * @param type $count
     */
    public function actionAdminUsers() {
        $this->createAdminUsers();
    }

    private function createPosts($count = null) {
        
        if (!$count) {
            echo "How many posts you want to create[0]: ";
            $handle = fopen("php://stdin", "r");
            $line = fgets($handle);

            $count = intval($line);

            fclose($handle);
        }

        $faker = Factory::create('en_GB');
        $users = User::find()->all();

        for ($index = 0; $index < $count; $index++) {

            $post = new Post();

            $post->title = $faker->text(rand(20, 30));
            $post->content = $faker->text(rand(1000, 1500));
            $post->image = $faker->image(Yii::getAlias('@user_images'), 480, 320, null, false);
            $post->status = Post::STATUS_ACTIVE;
            
            $random_key = array_rand($users);
            $post->link('user', $users[$random_key]);
            
            if ($post->save()) {
                echo $post->title . ': post has been created.' . PHP_EOL;
            } else {
                echo json_encode($post->getErrors()) . PHP_EOL;
                echo $post->title . ': post cannot be created.' . PHP_EOL;
            }
        }
    }

    private function createUsers($count = null) {

        if (!$count) {
            echo "How many users you want to create[0]: ";
            $handle = fopen("php://stdin", "r");
            $line = fgets($handle);

            $count = intval($line);

            fclose($handle);
        }

        $faker = Factory::create('en_GB');
        $roles = Yii::$app->authManager->getRoles();

        for ($index = 0; $index < $count; $index++) {

            $user = new User();

            $user->firstname = $faker->firstName;
            $user->lastname = $faker->lastName;
            $user->email = strtolower($faker->email);
            $user->setPassword($faker->password);
            $user->generateAuthKey();
            $user->status = User::STATUS_ACTIVE;

            if ($user->save()) {

                $random_key = array_rand($roles);

                Yii::$app->authManager->assign($roles[$random_key], $user->id);

                echo $user->email . ' user has been created.' . PHP_EOL;
            } else {
                echo $user->email . ' user cannot be created.' . PHP_EOL;
            }
        }
    }

    private function createAdminUsers($count = null) {

        $user = new User();

        $user->firstname = 'Kürşat';
        $user->lastname = 'Yiğitoğlu';
        $user->email = 'kursat.yigitoglu@gmail.com';
        $user->setPassword('123456');
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;

        if ($user->save()) {
            $role = Yii::$app->authManager->getRole(AuthItem::ROLE_DEVELOPER);
            Yii::$app->authManager->assign($role, $user->id);
            $role = Yii::$app->authManager->getRole(AuthItem::ROLE_CONFIRMED);
            Yii::$app->authManager->assign($role, $user->id);
        }
    }
    
    private function createRoles() {


        $role_names = $this->getConstants(AuthItem::className(), 'ROLE_');

        foreach ($role_names as $role_name) {

            if (!Yii::$app->authManager->getRole($role_name)) {
                $role = Yii::$app->authManager->createRole($role_name);
                Yii::$app->authManager->add($role);
                echo $role_name . ' role has been created.' . PHP_EOL;
            } else {
                echo $role_name . ' role exists.' . PHP_EOL;
            }
        }
    }

    protected function getConstants($class_name, $starts_with) {

        $reflection_class = new ReflectionClass($class_name);
        $constants = $reflection_class->getConstants();

        $keys = preg_filter('/(' . $starts_with . '.*)/', '$1', array_keys($constants));

        $values = array_map(function($x) use ($constants) {
            return $constants[$x];
        }, $keys);

        return array_combine($keys, $values);
    }

}
