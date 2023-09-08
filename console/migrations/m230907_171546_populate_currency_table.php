<?php

use yii\db\Migration;

/**
 * Class m230907_171546_populate_currency_table
 */
class m230907_171546_populate_currency_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $startDate = strtotime('2022-01-01');
        $endDate = strtotime('2023-07-01');
        $currencies = ['EUR', 'USD'];

        foreach ($currencies as $currency) {
            $currentDate = $startDate;

            while ($currentDate <= $endDate) {
                $this->insert('currency', [
                    'date' => date('Y-m-d', $currentDate),
                    'currency' => $currency,
                    'value' => rand(10, 100),
                ]);

                $currentDate = strtotime('+1 day', $currentDate);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230907_171546_populate_currency_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230907_171546_populate_currency_table cannot be reverted.\n";

        return false;
    }
    */
}
