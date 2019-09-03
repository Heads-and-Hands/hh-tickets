<?php

use yii\db\Migration;

/**
 * Class m190830_071436_user
 */
class m190830_071436_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(){
        $tableOptions = null;
        if ($this->db->driverName === 'psql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' =>$this->string(100)->notNull(),
            'login' => $this->string(100)->notNull(),
            'roles' => $this->string(100)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'isAdmin' => $this->boolean()->defaultValue(false),
            'verification_token' => $this->string()->defaultValue(null),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(){
        $this->dropTable('{{%user}}');
    }
}
