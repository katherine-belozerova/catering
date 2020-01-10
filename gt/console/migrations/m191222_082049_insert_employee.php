<?php

use yii\db\Migration;

/**
 * Class m191222_082049_insert_employee
 */
class m191222_082049_insert_employee extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
                $this->insert('{{%employee}}', [
                        'id' => 1,
                        'role' => 'Администратор',
                        'surname' => 'Админ',
                        'name' => 'Админ',
                        'fathername' => 'Админ',
                        'login' => 'admin',
                        'pas_ser' => 1234,
                        'pas_num' => 123456,
                        'dob' => '00.00.00',
                        'e_date' => '00.00.00',
                        'by_whom' => 'Information isn`t an important',
                        'when' => '00.00.00',
                        'email' => '123@gmail.com',
                        'tel' => '1234567890',
                        'status' => '5',
                        'pass' => Yii::$app->security->generatePasswordHash('dj5ghg67'),
                    ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%employee}}', ['id' => 1]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191222_082049_insert_employee cannot be reverted.\n";

        return false;
    }
    */
}
