<?php

use yii\db\Migration;

/**
 * Class m180604_051721_init_rbac
 */
class m180604_051721_init_rbac extends Migration
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
        echo "m180604_051721_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180604_051721_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
