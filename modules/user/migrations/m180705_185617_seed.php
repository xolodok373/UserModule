<?php

use yii\db\Migration;

/**
 * Class m180705_185617_seed
 */
class m180705_185617_seed extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';
        $auth->add($admin);

        $manager = $auth->createRole('manager');
        $manager->description = 'Менеджер';
        $auth->add($manager);

        $client = $auth->createRole('client');
        $client->description = 'Клиент';
        $auth->add($client);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
    }
}
