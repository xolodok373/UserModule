<?php

namespace app\modules\user\controllers;

use Yii;
use app\modules\user\traits\AjaxValidation;
use yii\filters\AccessControl;
use app\modules\user\Module;
use yii\web\BadRequestHttpException;
use app\modules\user\models\Token;
use app\modules\user\jobs\MailJob;
use app\modules\user\forms\RegistrationForm;
use app\modules\user\Mailer;

class RegistrationController extends \yii\web\Controller
{
    use AjaxValidation;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['register', 'confirm'], 'roles' => ['?']],
                ],
            ],
        ];
    }

    public function actionRegister()
    {
        $model = new RegistrationForm();

        $this->ajaxValidate($model);

        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            Yii::$app->session->setFlash('alert', Module::t('user', 'Your account has been created and a message with further instructions has been sent to your email'));

            if ($this->module->enableJobs) {
                Yii::$app->queue->push(new MailJob(['userId' => $model->user->id]));
            } else {
                (new Mailer())->sendConfirmation($model->user, Token::createConfirmation($model->user));
            }

            return $this->goHome();
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionConfirm()
    {
        $code = Yii::$app->request->get('code');

        if ($code === null) {
            throw new BadRequestHttpException();
        }

        $token = Token::findOne(['code' => $code, 'type' => Token::TYPE_CONFIRMATION]);

        if ($token === null || $token->user === null) {
            throw new BadRequestHttpException();
        }

        $token->user->confirm();
        Yii::$app->user->login($token->user, $this->module->rememberFor);
        Yii::$app->session->setFlash('alert', Module::t('user', 'Thank you, registration is now complete.'));

        return $this->goHome();
    }
}
