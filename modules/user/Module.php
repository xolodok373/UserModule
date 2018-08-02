<?php

namespace app\modules\user;

/**
 * user module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\user\controllers';

    /**
     * @var bool Enable email confirmation
     */
    public $enableConfirmation = true;

    /**
     * @var bool Enable run background processes
     */
    public $enableJobs = false;

    /**
     * @var bool Enable flash messages
     */
    public $enableFlashMessages = true;

    /**
     * @var int Remeber user time
     */
    public $rememberFor = 2592000;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $this->registerTranslations();
    }

    /**
     * {@inheritdoc}
     */
    public function registerTranslations()
    {
        \Yii::$app->i18n->translations['app/modules/user/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/modules/user/messages',
            'fileMap' => [
                'app/modules/user/user' => 'default.php',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        return \Yii::t('app/modules/user/' . $category, $message, $params, $language);
    }
}
