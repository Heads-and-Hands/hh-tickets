<?php

use yii\db\Migration;

/**
 * Class m190902_144710_foreign_key_status
 */
class m190902_144710_foreign_key_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk-orders_status', 'order', 'status_id', 'status', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190902_144710_foreign_key_status cannot be reverted.\n";

        return false;
    }
}
