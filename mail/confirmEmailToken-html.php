<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm-email', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Hello,</p>

    <p>Follow the link below to confirm your email and set your new password:</p>

    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
</div>
