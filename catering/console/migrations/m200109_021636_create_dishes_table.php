<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dishes}}`.
 */
class m200109_021636_create_dishes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dishes}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'category_id' => $this->integer(2)->notNull(),
            'weight' => $this->integer(3)->notNull(),
            'cost' => $this->integer(4)->notNull(),
            'notes' => $this->string(128),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%dishes}}');
    }
}
