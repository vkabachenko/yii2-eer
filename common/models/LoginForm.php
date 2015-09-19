<?php

namespace common\models;

use Yii;
use yii\base\Model;


class LoginForm  extends Model{


    /**
     * @var string $username
     */
    public $username;

    /**
     * @var string $password
     */
    public $password;

    /**
     * @var boolean rememberMe
     */
    public $rememberMe = true;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Required
            [['username', 'password'], 'required'],
            // Password
            ['password', 'validatePassword'],
            // Remember Me
            ['rememberMe', 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить'
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->$attribute)) {
                $this->addError($attribute, 'Неверный логин или пароль');
            }
        }
    }

    /**
     * Finds user by username.
     *
     * @return User|boolean User instance
     */
    protected function getUser()
    {
            $user = User::findByUsername($this->username);

        return $user;
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
    }


} 