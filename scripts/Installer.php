<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Installer
 *
 * @author kursat
 */

namespace scripts;

use Composer\Script\Event;
use Exception;
use yii\console\Controller;
use yii\helpers\Console;
use const PHP_EOL;

class Installer extends Controller {

    public static function postInstall(Event $event) {

        echo "Creating web/user_images directory..." . PHP_EOL;

        try {
            if (mkdir('web/user_images', '0777', true)) {
                echo "done." . PHP_EOL . PHP_EOL;
            };
        } catch (Exception $e) {
            echo $e->getMessage() . PHP_EOL . PHP_EOL;
        }

        echo "\033[36mMigrate database with 'php yii migrate' command.\033[0m" . PHP_EOL;
        echo "\033[36mSeed database with 'php yii seed-database' command.\033[0m" . PHP_EOL . PHP_EOL;
    }

    public static function postUpdate(Event $event) {
        $composer = $event->getComposer();
    }

    public static function postPackageUpdate(Event $event) {
        $packageName = $event->getOperation()
                ->getPackage()
                ->getName();
        echo "$packageName\n";
        // do stuff
    }

    public static function warmCache(Event $event) {
        // make cache toasty
    }

}
