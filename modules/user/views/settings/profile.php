<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\modules\user\Module;

/* @var $this yii\web\View */

$this->title = Module::t('user', 'Profile');
?>

<div class="card-panel">
    <h4><?= $this->title ?></h4>
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'first_name') ?>

    <?= $form->field($model, 'last_name') ?>

    <?= $form->field($model, 'skype') ?>

    <?= $form->field($model, 'phone')->widget('yii\widgets\MaskedInput', [
        'mask' => '+38(999)-999-9999',
    ]) ?>

    <?= Html::submitButton(Module::t('user', 'Save'), ['class' => 'btn btn-success']) ?>

    <?php ActiveForm::end() ?>
</div>