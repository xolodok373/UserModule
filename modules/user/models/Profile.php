<?php

namespace app\modules\user\models;

use app\modules\user\Module;
use Yii;

/**
 * This is the model class for table "profiles".
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $skype
 *
 * @property Users $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'skype'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
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
            'first_name' => Module::t('user', 'First Name'),
            'last_name' => Module::t('user', 'Last Name'),
            'phone' => Module::t('user', 'Phone'),
            'skype' => Module::t('user', 'Skype'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
