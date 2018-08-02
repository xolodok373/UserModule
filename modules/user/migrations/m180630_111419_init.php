<?php

use yii\db\Migration;

/**
 * Class m180630_111419_init
 */
class m180630_111419_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'email' => $this->string(100)->unique()->notNull(),
            'password_hash' => $this->string(60),
            'auth_key' => $this->string(32),
            'confirmed' => $this->boolean()->defaultValue(false),
            'date_created' => $this->dateTime(),
            'date_updated' => $this->dateTime(),
        ], $this->tableOptions);

        $this->createTable('profiles', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->unique()->notNull(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'phone' => $this->string(20),
            'skype' => $this->string(),
        ], $this->tableOptions);

        $this->createTable('tokens', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'code' => $this->string()->notNull(),
            'type' => $this->integer()->notNull(),
            'date_created' => $this->dateTime(),
        ], $this->tableOptions);

        $this->createIndex(
            'idx-users_email',
            'users',
            'email'
        );

        $this->createIndex(
            'idx-tokens_code',
            'tokens',
            'code'
        );

        $this->addForeignKey(
            'fk-profiles_user_id',
            'profiles',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-tokens_user_id',
            'tokens',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('profiles');
        $this->dropTable('tokens');
        $this->dropTable('users');

        $this->dropForeignKey(
            'fk-profiles_user_id',
            'profiles'
        );

        $this->dropForeignKey(
            'fk-tokens_user_id',
            'tokens'
        );
    }

    public function getTableOptions()
    {
        switch ($this->db->driverName) {
            case 'mysql':
                $options = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
                break;
            default:
                $options = null;
        }

        return $options;
    }
}
