<?php

namespace app\modules\user\controllers;

use Yii;
use app\modules\user\forms\LoginForm;
use app\modules\user\traits\AjaxValidation;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\modules\user\Module;

class SecurityController extends \yii\web\Controller
{
    use AjaxValidation;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['login'], 'roles' => ['?']],
                    ['allow' => true, 'actions' => ['logout'], 'roles' => ['@']],
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->goHome();
                }
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        $model = new LoginForm();

        $this->ajaxValidate($model);

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash('success', 'Logged');

            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
