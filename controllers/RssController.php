<?php

namespace app\controllers;

use app\models\Post;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\Controller;
use Zelenin\Feed;
use Zelenin\yii\extensions\Rss\RssView;

class RssController extends Controller {

    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()->with(['user']),
            'pagination' => [
                'pageSize' => 10
            ],
        ]);

        $response = Yii::$app->getResponse();
        $headers = $response->getHeaders();

        $headers->set('Content-Type', 'application/rss+xml; charset=utf-8');
        
        echo RssView::widget([
            'dataProvider' => $dataProvider,
            'channel' => [
                'title' => function ($widget, Feed $feed) {
                    $feed->addChannelTitle(Yii::$app->name);
                },
                'link' => Url::toRoute('/', true),
                'description' => Yii::t('app', 'Latest 10 News'),
                'language' => function ($widget, Feed $feed) {
                    return Yii::$app->language;
                },
            ],
            'items' => [
                'title' => function ($model, $widget, Feed $feed) {
                    return $model->title;
                },
                'description' => function ($model, $widget, Feed $feed) {
                    return StringHelper::truncateWords($model->content, 50);
                },
                'link' => function ($model, $widget, Feed $feed) {
                    return Url::toRoute(['post/view', 'id' => $model->id], true);
                },
                'author' => function ($model, $widget, Feed $feed) {
                    return $model->user->email;
                },
                'guid' => function ($model, $widget, Feed $feed) {
                    $date = Yii::$app->formatter->asDatetime($model->created_at, DATE_RSS);
                    return Url::toRoute(['post/view', 'id' => $model->id], true) . ' ' . $date;
                },
                'pubDate' => function ($model, $widget, Feed $feed) {
                    return Yii::$app->formatter->asDatetime($model->created_at, DATE_RSS);
                }
            ]
        ]);
    }

}
