<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%status}}`.
 */
class m190902_144223_create_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%status}}', [
            'id' => $this->primaryKey(),
            'name' =>$this->string(100)->notNull(),
        ]);
        $this->batchInsert('status', ['name'], [
            ['Новая'],
            ['В работе'],
            ['Отклонена'],
            ['Сделана'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%status}}');
    }
}
