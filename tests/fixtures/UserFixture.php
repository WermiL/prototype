<?php
namespace tests\fixtures;


use yii\test\ActiveFixture;


class UserFixture extends ActiveFixture
{
    public $modelClass = \frontend\modules\user\models\User::class;
}