<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= Yii::t('app', 'Welcome to Conews!') ?></h1>

        <p class="lead"><?= Yii::t('app', 'Conews is a news portal where you can report or read news.') ?></p>

        <p><a class="btn btn-lg btn-success" href="/site/signup">Get started with Conews!</a></p>
    </div>

    <div class="body-content">

        <?php if (!count($posts)) { ?>
            <div class="row">
                Nobody posted any news yet. 
            </div>
        <?php } ?>

        <div class="row">
            <?php foreach ($posts as $key => $post) { ?>
                <?php if ($key % 3 == 0) { ?>
                    </div>
                    <div class="row">
                <?php } ?>
            
                <div class="col-lg-4">
                    <h2><?= $post->title ?></h2>

                    <p><?= $post->image ?></p>
                    <p><?= yii\helpers\StringHelper::truncateWords($post->content, 50) ?></p>

                    <p>
                        <?= Html::a(Yii::t('app', 'More &raquo;'), ['post/view', 'id' => $post->id], ['class' => 'btn btn-default']) ?>
                    </p>
                </div>
            <?php } ?>
        </div>

    </div>
</div>
