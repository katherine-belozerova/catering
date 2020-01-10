<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%employee}}`.
 */
class m191215_100737_create_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%employee}}', [
            'id' => $this->primaryKey(4),
            'role' => $this->string(16)->notNull(),
            'surname' => $this->string(64)->notNull(),
            'name' => $this->string(64)->notNull(),
            'fathername' => $this->string(64)->notNull(),
            'login' => $this->string(16),
            'passport_series' => $this->integer(4)->notNull(),
            'passport_number' => $this->integer(6)->notNull(),
            'birth_date' => $this->string(10)->notNull(),
            'date_of_employment' => $this->string(10)->notNull(),
            'passport_issued_by' => $this->string(128)->notNull(),
            'date_of_issue_of_passport' => $this->string(10)->notNull(),
            'email' => $this->string(128)->notNull(),
            'telephone' => $this->string(10)->notNull(),
            'status' => $this->integer(1)->defaultValue(1),
            'pass' => $this->string(64),
            'deals' => $this->integer(11)->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%employee}}');
    }
}
