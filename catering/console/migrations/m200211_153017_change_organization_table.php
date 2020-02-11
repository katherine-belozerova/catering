<?php

use yii\db\Migration;

/**
 * Class m200211_153017_change_organization_table
 */
class m200211_153017_change_organization_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('organization', 'inn', $this->string(12)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200211_153017_change_organization_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200211_153017_change_organization_table cannot be reverted.\n";

        return false;
    }
    */
}
