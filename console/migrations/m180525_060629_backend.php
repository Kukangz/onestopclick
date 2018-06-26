<?php

use yii\db\Migration;

/**
 * Class m180525_060629_backend
 */
class m180525_060629_backend extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        // $this->createTable('product', [
        //     'id' => $this->primaryKey(),
        //     'PID' => $this->string()->notNull()->unique(),
        //     'name' => $this->string(64)->notNull(),
        //     'description' => $this->string()->notNull(),
        //     'category' => $this->integer(),
        //     'price' => $this->money(),
        //     'brand' => $this->integer(),
        //     'status' => $this->tinyinteger()->notNull()->defaultValue(0),
        //     'created_at' => $this->datetime(),
        //     'created_by' => $this->integer(),
        //     'updated_at' => $this->datetime(),
        //     'updated_by' => $this->integer(),
        // ], $tableOptions);

        // $this->createTable('category', [
        //     'id' => $this->primaryKey(),
        //     'name' => $this->string(32)->notNull(),
        //     'slug' => $this->string(32)->notNull(),
        //     'description' => $this->string()->notNull(),
        //     'status' => $this->tinyinteger()->notNull()->defaultValue(0),
        //     'created_at' => $this->datetime(),
        //     'created_by' => $this->integer(),
        //     'updated_at' => $this->datetime(),
        //     'updated_by' => $this->integer(),
        // ], $tableOptions);

        // $this->createTable('brand', [
        //     'id' => $this->primaryKey(),
        //     'name' => $this->string(32)->notNull(),
        //     'slug' => $this->string(32)->notNull(),
        //     'description' => $this->string()->notNull(),
        //     'status' => $this->tinyinteger()->notNull()->defaultValue(0),
        //     'created_at' => $this->datetime(),
        //     'created_by' => $this->integer(),
        //     'updated_at' => $this->datetime(),
        //     'updated_by' => $this->integer(),
        // ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180525_060629_backend cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180525_060629_backend cannot be reverted.\n";

        return false;
    }
    */
}
