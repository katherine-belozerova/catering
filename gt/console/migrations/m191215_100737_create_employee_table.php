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
            'pas_ser' => $this->integer(4)->notNull(),
            'pas_num' => $this->integer(6)->notNull(),
            'dob' => $this->string(10)->notNull(),
            'e_date' => $this->string(10)->notNull(),
            'by_whom' => $this->string(128)->notNull(),
            'when' => $this->string(10)->notNull(),
            'email' => $this->string(128)->notNull(),
            'tel' => $this->string(10)->notNull(),
            'status' => $this->integer(1)->defaultValue(1),
            'pass' => $this->string(64),
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
