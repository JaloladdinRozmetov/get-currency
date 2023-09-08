<?php

use yii\db\Migration;

/**
 * Class m230907_171105_populate_items_table
 */
class m230907_171105_populate_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $items = [];
        $faker = \Faker\Factory::create();

        for ($i = 1; $i <= 400000; $i++) {
            $items[] = [
                'name' => $faker->text(rand(10, 30)),
                'category' => rand(1, 10),
                'price' => rand(1, 10000),
                'currency' => $faker->randomElement(['EUR', 'USD']),
            ];
        }

        $this->batchInsert('items', ['name', 'category', 'price', 'currency'], $items);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230907_171105_populate_items_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230907_171105_populate_items_table cannot be reverted.\n";

        return false;
    }
    */
}
