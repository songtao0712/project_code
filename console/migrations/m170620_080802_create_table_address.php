<?php

use yii\db\Migration;

class m170620_080802_create_table_address extends Migration
{
    public function up()
    {
        $this->createTable('address',[
           'id'=>$this->primaryKey()->comment('主键'),
            'member_id'=>$this->integer()->comment('用户ID'),
            'address'=>$this->string()->comment('收货地址'),
            'tel'=>$this->string()->comment('联系电话'),
            'create_at'=>$this->integer()->comment('创建时间'),
            'update_at'=>$this->integer()->comment('修改时间')
        ]);
    }

    public function down()
    {
        echo "m170620_080802_create_table_address cannot be reverted.\n";

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
