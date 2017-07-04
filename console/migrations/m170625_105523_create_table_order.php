<?php

use yii\db\Migration;

class m170625_105523_create_table_order extends Migration
{
    public function up()
    {
        $this->createTable('order',[
           'id'=>$this->primaryKey()->comment('主键'),
            'member_id'=>$this->integer()->comment('用户ID'),
            'name'=>$this->string()->comment('收货人'),
            'province'=>$this->string()->comment('省'),
            'city'=>$this->string()->comment('市'),
            'area'=>$this->string()->comment('区|县'),
            'address'=>$this->string()->comment('详细地址'),
            'tel'=>$this->string()->comment('电话号码'),
            'delivery_id'=>$this->integer()->comment('配送方式ID'),
            'delivery_name'=>$this->string()->comment('配送名称'),
            'delivery_price'=>$this->float()->comment('配送价格'),
            'payment_id'=>$this->integer()->comment('支付方式ID'),
            'payment_name'=>$this->string()->comment('支付方式名称'),
            'total'=>$this->decimal()->comment('订单金额'),
            'status'=>$this->integer()->comment('状态'),
            'trade_no'=>$this->string()->comment('第三方支付交易号'),
            'create_time'=>$this->integer()->comment('创建时间')
        ]);
    }

    public function down()
    {
        echo "m170625_105523_create_table_order cannot be reverted.\n";

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
