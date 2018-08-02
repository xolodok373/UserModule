<?php

namespace app\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use app\modules\user\models\Profile;
use app\modules\user\traits\AjaxValidation;

class SettingsController extends \yii\web\Controller
{
    use AjaxValidation;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['profile'], 'roles' => ['@']],
                ],
            ],
        ];
    }

    public function actionProfile()
    {
        $model = Yii::$app->user->identity->profile;

        $this->ajaxValidate($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Your profile has been updated');
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }
}
