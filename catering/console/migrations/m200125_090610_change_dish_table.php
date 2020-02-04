<?php

use yii\db\Migration;

/**
 * Class m200125_090610_change_dish_table
 */
class m200125_090610_change_dish_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('dishes', 'cost', $this->integer()->notNull());
        $this->alterColumn('dishes', 'weight', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200125_090610_change_dish_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200125_090610_change_dish_table cannot be reverted.\n";

        return false;
    }
    */
}
