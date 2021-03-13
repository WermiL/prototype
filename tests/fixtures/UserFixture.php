<?php
namespace tests\fixtures;


use frontend\modules\user\models\records\User;
use yii\test\ActiveFixture;


class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
}