<?php
namespace tests\unit\models;

use tests\fixtures\UserFixture;
use frontend\modules\user\models\forms\SignupForm;
use frontend\modules\user\models\records\User;
use yii\mail\MessageInterface;

class SignupFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \tests\UnitTester
     */
    protected $tester;


    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);
    }

    public function testCorrectSignup()
    {
        $model = new SignupForm([
            'email' => 'some_email@example.com',
            'password' => 'some_password',
        ]);

        $user = $model->signup();
        expect($user)->true();

        /** @var \frontend\modules\user\models\records\User $user */
        $user = $this->tester->grabRecord(User::class, [
            'email' => 'some_email@example.com',
            'status' => User::STATUS_INACTIVE
        ]);

        $this->tester->seeEmailIsSent();

        $mail = $this->tester->grabLastSentEmail();

        expect($mail)->isInstanceOf(MessageInterface::class);
        expect($mail->getTo())->hasKey('some_email@example.com');
        expect($mail->getFrom())->hasKey(\Yii::$app->params['supportEmail']);
        expect($mail->getSubject())->equals('Account registration at ' . \Yii::$app->name);
        expect($mail->toString())->stringContainsString($user->verification_token);
    }

    public function testNotCorrectSignup()
    {
        $model = new SignupForm([
            'email' => 'nicolas.dianna@hotmail.com',
            'password' => 'some_password',
        ]);

        expect_not($model->signup());
        expect_that($model->getErrors('email'));

        expect($model->getFirstError('email'))
            ->equals('This email address has already been taken.');
    }
}
