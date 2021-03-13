<?php

namespace frontend\modules\user\models\forms;

use frontend\modules\user\models\query\UserQuery;
use frontend\modules\user\models\UserIdentity;
use Yii;
use yii\base\Model;

/**
 * Login form
 *
 * @property string $email
 * @property string $password
 * @property bool $rememberMe
 * @property UserQuery|null $_user
 */
class LoginForm extends Model
{
    public string $email;
    public string $password;
    public bool $rememberMe = true;

    private ?UserQuery $_user;


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['email', 'password'], 'required'],

            ['rememberMe', 'boolean'],

            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword(string $attribute,array $params): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect email or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided email and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login(): bool
    {
        if ($this->validate()) {
            $userIdentity = $this->getUserIdentity();
            return Yii::$app->user->login($userIdentity, $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    /**
     * Finds user by [[email]]
     *
     * @return UserQuery|null
     */
    protected function getUser(): ?UserQuery
    {
        if ($this->_user === null) {
            $this->_user = UserQuery::findByEmail($this->email);
        }

        return $this->_user;
    }

    /**
     * get User Identity
     *
     * @return UserIdentity
     */
    protected function getUserIdentity(): UserIdentity
    {
        $this->getUser();
        $userIdentity = new UserIdentity();
        if ($this->_user !== null) {
            $userIdentity->attributes = $this->_user->attributes;
        }
        return $userIdentity;
    }
}
