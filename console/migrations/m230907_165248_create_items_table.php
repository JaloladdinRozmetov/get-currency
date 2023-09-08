<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%items}}`.
 */
class m230907_165248_create_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%items}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'category' => $this->integer()->notNull(),
            'price' => $this->decimal(10, 2)->notNull(),
            'currency' => $this->string(3)->notNull(),
        ]);
        $this->createIndex('idx-items-category', 'items', 'category');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%items}}');
    }
}
