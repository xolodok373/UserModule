<?php

namespace app\modules\user\traits;

use Yii;
use yii\base\Model;
use yii\widgets\ActiveForm;
use yii\web\Response;

trait AjaxValidation
{
    protected function ajaxValidate(Model $model)
    {
        if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            Yii::$app->response->data = ActiveForm::validate($model);
            Yii::$app->response->send();
            Yii::$app->end();
        }
    }
}