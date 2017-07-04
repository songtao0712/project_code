<?php

use yii\db\Migration;

class m170623_104817_create_table_cart extends Migration
{
    public function up()
    {
        $this->createTable('cart',[
            'id'=>$this->primaryKey()->comment('主键'),
            'goods_id'=>$this->integer()->comment('商品ID'),
            'amount'=>$this->integer()->comment('商品数量'),
            'member_id'=>$this->integer()->comment('用户ID')
        ]);
    }

    public function down()
    {
        echo "m170623_104817_create_table_cart cannot be reverted.\n";

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
