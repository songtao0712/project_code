<?php

use yii\db\Migration;

class m170611_130913_goods_category extends Migration
{
    public function up()
    {
        $this->createTable('goods_category', [
            'id' => $this->primaryKey(),
            'tree' => $this->integer()->notNull(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'parent_id'=>$this->integer()->notNull(),
            'intro'=>$this->text()->notNull()
        ]);
    }

    public function down()
    {
        echo "m170611_130913_goods_category cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
