<?php

namespace app\modules\user\jobs;

use app\modules\user\models\Token;
use app\modules\user\models\User;
use app\modules\user\Mailer;

/**
 * Class MailJob.
 */
class MailJob extends \yii\base\BaseObject implements \yii\queue\JobInterface
{
    /**
     * @var int User Id
     */
    public $userId;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        $user = User::findOne($this->userId);
        (new Mailer())->sendConfirmation($user, Token::createConfirmation($user));
    }
}
