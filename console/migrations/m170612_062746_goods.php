<?php

use yii\db\Migration;

class m170612_062746_goods extends Migration
{
    public function up()
    {
        $this->createTable('goods',[
            'id'=>$this->primaryKey()->comment('ID'),
            'name'=>$this->string()->comment('商品名称'),
            'sn'=>$this->integer()->comment('商品编号'),
            'logo'=>$this->string()->comment('商品LOGO'),
            'goods_category_id'=>$this->integer()->comment('分类ID'),
            'brand_id'=>$this->integer()->comment('品牌ID'),
            'market_price'=>$this->decimal(10,2)->comment('市场价格'),
            'shop_price'=>$this->decimal(10,2)->comment('商品价格'),
            'stock'=>$this->integer()->comment('库存'),
            'is_on_sale'=>$this->integer(2)->comment('是否在售'),
            'status'=>$this->integer(2)->comment('状态'),
            'sort'=>$this->integer(4)->comment('排序'),
            'create_time'=>$this->integer(11)->comment('添加时间')
        ]);
    }

    public function down()
    {
        echo "m170612_062746_goods cannot be reverted.\n";

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
