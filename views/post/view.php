<?php

use app\models\Post;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Post */

$this->title = $model->title;
?>
<div class="post-view">

    <div class="row">
        <div class="col-md-8 col-md-offset-4">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <img src="/user_images/<?= $model->image ?>" class="img-responsive"/>
        </div>
        <div class="col-md-8">
            <p class="text-justify">
                <?= $model->content ?>
            </p>
            <p class="pull-right text-muted">
                Published at 
                <b><?= \Yii::$app->formatter->asDatetime($model->created_at) ?></b>
                by 
                <b><?= $model->user->email ?></b>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-4">
            <?php if (Yii::$app->controller->getRoute() == 'post/view') { ?>
                <?= Html::a(Yii::t('app', 'View Pdf'), ['post/view-pdf', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Download Pdf'), ['post/view-pdf', 'id' => $model->id, 'destination' => 'download'], ['class' => 'btn btn-primary']) ?> 
            <?php } ?>
        </div>
    </div>

</div>
