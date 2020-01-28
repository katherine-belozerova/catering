<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client}}`.
 */
class m200127_112343_create_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(12)->notNull(),
            'surname' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'fathername' => $this->string(),
            'birth_date' => $this->string(10)->notNull(),
            'telephone' => $this->string()->notNull(),
            'email' => $this->string(128)->notNull(),
            'organization_id' => $this->integer(8),
            'date_added' => $this->date(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%client}}');
    }
}
