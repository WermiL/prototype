<?php

namespace frontend\modules\user\models\forms;

use frontend\modules\user\models\query\UserQuery;
use yii\base\InvalidArgumentException;
use yii\base\Model;

/**
 * Password reset form
 *
 * @property UserQuery|null $_user
 * @property string|null $password
 */
class ResetPasswordForm extends Model
{
    public $password;
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string|null $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }
        $this->_user = UserQuery::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidArgumentException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 8],
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
