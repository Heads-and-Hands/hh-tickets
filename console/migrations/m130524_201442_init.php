<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'psql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' =>$this->string(100)->notNull(),
            'login' => $this->string(100)->notNull(),
            'role' => $this->integer()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'verification_token' => $this->string()->defaultValue(null),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp(),
        ], $tableOptions);

        $this->createTable('{{%session}}', [
            'token' => $this->string(64)->notNull(),
            'user_id' => $this->integer()->notNull()->unsigned(),
            'created_at' => $this->timestamp()->notNull()->defaultValue('1999-01-01 00:00:00'),
        ], $tableOptions);

        $this->addPrimaryKey('session-pk', '{{%session}}', 'token');
        $this->createIndex('session-user-index', '{{%session}}', 'user_id');
        $this->addForeignKey('session-user-fk', '{{%session}}', 'user_id',
            '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('auth', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'redmine_id' => $this->integer()->unsigned()->notNull(),
            'token' => $this->string()->unsigned()->notNull(),
        ]);

        $this->addForeignKey('fk-auth-user_id-user-id', '{{%auth}}', 'user_id',
            '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'name' =>$this->string(100)->notNull(),
            'description' => $this->string(100)->notNull(),
            'status_id' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
        ]);

        $this->createTable('{{%status}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' =>$this->string(100)->notNull(),
        ]);

        $this->addForeignKey('fk-orders_status', '{{%order}}', 'status_id',
            '{{%status}}', 'id', 'CASCADE', 'CASCADE');

        Yii::$app->db->createCommand()->batchInsert('{{%status}}', ['name'], [
            ['Новая'],
            ['В работе'],
            ['Отклонена'],
            ['Сделана'],
        ])->execute();
    }

    public function down()
    {
        $this->dropTable('{{%session}}');
        $this->dropTable('{{%order}}');
        $this->dropTable('{{%status}}');
        $this->dropTable('{{%auth}}');
        $this->dropTable('{{%user}}');
    }
}
