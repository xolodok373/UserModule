<?php

namespace app\modules\user\forms;

use Yii;
use yii\base\Model;
use app\modules\user\Module;
use app\modules\user\models\User;
use app\modules\user\models\Profile;

class RegistrationForm extends Model
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
     * @var string Password confirm
     */
    public $passwordConfirm;

    /**
     * @var User
     */
    private $_user;

    /**
     * @var Profile
     */
    private $_profile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            [['email', 'password', 'passwordConfirm'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::className()],
            ['password', 'string', 'min' => 6, 'max' => 72],
            ['passwordConfirm', 'compare', 'compareAttribute' => 'password', 'message' => Module::t('user', 'Passwords do not match')],
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
            'passwordConfirm' => Module::t('user', 'Password Confirmation'),
        ];
    }

    /**
     * Register user
     *
     * @return bool
     */
    public function register()
    {
        if($this->validate()) {
            $user = new User();
            $user->setAttributes($this->attributes, false);
            $user->password = $this->password;

            if($user->save()) {
                $this->_user = $user;
                if($this->_profile === null) {
                    $this->_profile = new Profile();
                }

                $user->link('profile', $this->_profile);

                Yii::$app->authManager->assign(Yii::$app->authManager->getRole('client'), $user->id);

                return true;
            }
        }

        return false;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * Set profile
     *
     * @param Profile
     * @return void
     */
    public function setProfile(Profile $profile)
    {
        $this->_profile = $profile;
    }
}