<?php

namespace app\modules\user\models;

use Yii;
use yii\helpers\Url;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "tokens".
 *
 * @property int $id
 * @property int $user_id
 * @property string $code
 * @property int $type
 * @property string $date_created
 *
 * @property Users $user
 */
class Token extends \yii\db\ActiveRecord
{
    const TYPE_CONFIRMATION = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tokens';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date_created',
                'updatedAtAttribute' => false,
                'value' => function(){ return date('Y-m-d H:i:s');},
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'code', 'type'], 'required'],
            [['user_id', 'type'], 'integer'],
            [['date_created'], 'safe'],
            [['code'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('user', 'ID'),
            'user_id' => Module::t('user', 'User ID'),
            'code' => Module::t('user', 'Code'),
            'type' => Module::t('user', 'Type'),
            'date_created' => Module::t('user', 'Date Created'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Create email confirmation token
     *
     * @param User $user
     * @return static
     */
    public static function createConfirmation(User $user)
    {
        return static::createToken($user, self::TYPE_CONFIRMATION);
    }

    /**
     * Create token
     *
     * @param User $user
     * @param string $type
     * @return static
     */
    protected function createToken(User $user, $type)
    {
        $token = new static();
        $token->setAttributes([
            'user_id' => $user->id,
            'type' => $type,
            'code' => Yii::$app->security->generateRandomString(120),
        ]);

        $token->save(false);

        return $token;
    }

    /**
     * Get absolute url
     *
     * @return string
     */
    public function getUrl()
    {
        switch ($this->type) {
            case self::TYPE_CONFIRMATION:
                $route = '/user/registration/confirm';
                break;
            case self::TYPE_RECOVERY:
                $route = '/user/recovery/reset';
                break;
        }

        return Url::to([$route, 'code' => $this->code], true);
    }
}
