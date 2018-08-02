<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\modules\user\Module;

/* @var $this yii\web\View */

$this->title = Module::t('user', 'Login');
?>

<div class="card-panel">
    <h4><?= $this->title ?></h4>
        <?php $form = ActiveForm::begin([
            'enableAjaxValidation' => true,
        ]) ?>

        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= Html::submitButton(Module::t('user', 'Sign In'), ['class' => 'btn btn-success']) ?>

        <?php ActiveForm::end() ?>
</div>