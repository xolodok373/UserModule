<?php
use app\modules\user\Module;
use yii\helpers\Html;
?>
<?= Module::t('user', 'Hello') ?>,

<?= Module::t('user', 'Thank you for signing up on {0}', Yii::$app->name) ?>.
<?= Module::t('user', 'In order to complete your registration, please click the link below') ?>.

<?= Html::a(Html::encode($token->url), $token->url) ?>

<?= Module::t('user', 'If you cannot click the link, please try pasting the text into your browser') ?>.

<?= Module::t('user', 'If you did not make this request you can ignore this email') ?>.
