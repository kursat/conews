<?php

use app\models\PostSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;
/* @var $this View */
/* @var $searchModel PostSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Post'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'image',
//            'content:ntext',
            // 'status',
             'created_at:datetime',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view} {delete}', 
                'dropdown' => true,
                'dropdownOptions' => ['class' => 'pull-right'],
                'buttons' => [
                ]
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
