<?php

namespace app\modules\user;

use Yii;
use yii\base\Component;
use app\modules\user\models\User;
use app\modules\user\models\Token;

class Mailer extends Component
{
    public $viewPath = '@app/modules/user/views/mail';

    protected $_sender;

    public function sendConfirmation(User $user, Token $token)
    {
        $this->send(
            $user->email,
            Module::t('user', 'Confirmation'),
            'confirmation',
            ['user' => $user, 'token' => $token]
        );
    }

    protected function send($to, $subject, $view, $params)
    {
        Yii::$app->mailer->viewPath = $this->viewPath;

        return Yii::$app->mailer->compose(['html' => $view, 'text' => 'text/' . $view], $params)
            ->setTo($to)
            ->setFrom($this->sender)
            ->setSubject($subject)
            ->send();
    }

    public function getSender()
    {
        if($this->_sender === null) {
            $this->_sender = isset(Yii::$app->params['adminEmail']) ?
                Yii::$app->params['adminEmail']
                : 'no-reply@example.com';
        }

        return $this->_sender;
    }
}