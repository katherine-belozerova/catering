<?php

use yii\db\Migration;

/**
 * Class m200123_065948_change_employee_table
 */
class m200123_065948_change_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('employee', 'fathername', $this->string(64)->null());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200123_065948_change_employee_table cannot be reverted.\n";

        return false;
    }
    */
}
