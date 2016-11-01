<?php

/* @var $this yii\web\View */
/* @var $user app\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm-email', 'token' => $user->password_reset_token]);
?>
Hello,

Follow the link below to confirm your email and set your new password:

<?= $confirmLink ?>
