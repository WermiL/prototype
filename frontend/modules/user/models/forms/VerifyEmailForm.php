<?php

namespace frontend\modules\user\models\forms;

use frontend\modules\user\models\query\UserQuery;
use frontend\modules\user\models\records\User;
use yii\base\InvalidArgumentException;
use yii\base\Model;
/**
 * Verify Email Form
 *
 * @property string|null $token
 * @property UserQuery|null $_user
 */
class VerifyEmailForm extends Model
{
    public ?string $token;
    private ?UserQuery $_user;


    /**
     * Creates a form model with given token.
     *
     * @param string|null $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct(?string $token, array $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Verify email token cannot be blank.');
        }
        $this->_user = UserQuery::findByVerificationToken($token);
        if (!$this->_user) {
            throw new InvalidArgumentException('Wrong verify email token.');
        }
        parent::__construct($config);
    }

    /**
     * Verify email
     *
     * @return UserQuery|null the saved model or null if saving fails
     */
    public function verifyEmail(): ?UserQuery
    {
        $user = $this->_user;
        $user->status = User::STATUS_ACTIVE;
        return $user->save(false) ? $user : null;
    }
}
