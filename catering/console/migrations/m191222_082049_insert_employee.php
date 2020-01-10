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
                        'passport_series' => 1234,
                        'passport_number' => 123456,
                        'birth_date' => '00.00.00',
                        'date_of_employment' => '00.00.00',
                        'passport_issued_by' => 'Information isn`t an important',
                        'date_of_issue_of_passport' => '00.00.00',
                        'email' => '123@gmail.com',
                        'telephone' => '1234567890',
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
