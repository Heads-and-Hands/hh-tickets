<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m190902_144157_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'name' =>$this->string(100)->notNull(),
            'description' => $this->string(100)->notNull(),
            'status_id' => $this->tinyInteger()->notNull(),
            'created_at' => $this->string(100),
            'updated_at' => $this->string(100),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }
}
