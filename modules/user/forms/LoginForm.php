<?php

namespace app\modules\user\forms;

use Yii;
use yii\base\Model;
use app\modules\user\Module;
use app\modules\user\models\User;

class LoginForm extends Model
{
    /**
     * @var string Email
     */
    public $email;

    /**
     * @var string Password
     */
    public $password;

    /**
     * @var bool Is remember user after login
     */
    public $rememberMe = false;

    /**
     * @var User
     */
    private $user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'validatePassword'],
            ['email', 'validateUser'],
            ['rememberMe', 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => Module::t('user', 'Email'),
            'password' => Module::t('user', 'Password'),
        ];
    }

    /**
     * Validate correct user password
     *
     * @param string
     * @return void
     */
    public function validatePassword($attribute, $params)
    {
        if ($this->user === null || !$this->user->validatePassword($this->password)) {
            $this->addError($attribute, Module::t('user', 'Invalid login or password'));
        }
    }

    /**
     * Validate correct user
     *
     * @param string
     * @return void
     */
    public function validateUser($attribute, $params)
    {
        if ($this->user !== null && !$this->hasErrors() && !$this->user->confirmed) {
            $this->addError($attribute, Module::t('user', 'You need to confirm your email address'));
        }
    }

    /**
     * Login user
     *
     * @return bool
     */
    public function login()
    {
        if($this->validate()) {
            return Yii::$app->getUser()->login($this->user, $this->rememberMe ? $this->module->rememberFor : 0);
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->user = User::findByEmail($this->email);

            return true;
        }

        return false;
    }
}