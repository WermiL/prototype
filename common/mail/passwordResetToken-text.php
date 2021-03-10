<?php

/* @var $this yii\web\View */
/* @var $user frontend\modules\user\models\records\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>

Follow the link below to reset your password:

<?= $resetLink ?>
