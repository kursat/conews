<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */

$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= Yii::t('app', 'Welcome to Conews!') ?></h1>

        <p class="lead"><?= Yii::t('app', 'Conews is a news portal where you can report or read news.') ?></p>

        <p><a class="btn btn-lg btn-success" href="<?= Url::toRoute('site/register')?>">Get started with Conews!</a></p>
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
            
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <img src="/user_images/<?= $post->image ?>">
                        <div class="caption">
                            <h3><?= $post->title ?></h3>
                            <p><?= StringHelper::truncateWords($post->content, 50) ?></p>
                            <p>
                                <?= Html::a(Yii::t('app', 'More &raquo;'), ['post/view', 'id' => $post->id], ['class' => 'btn btn-default']) ?>
                            </p>
                            <p class="card-text">
                                <small class="text-muted">Published <?= Yii::$app->formatter->asDuration(time() - $post->created_at) ?> ago</small>
                            </p>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
</div>
