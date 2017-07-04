<?php

use yii\db\Migration;

class m170612_063749_goods_intro extends Migration
{
    public function up()
    {
        $this->createTable('goods_intro',[
            'goods_id'=>$this->integer()->comment('商品ID'),
            'intro'=>$this->text()->comment('详情')
        ]);
    }

    public function down()
    {
        echo "m170612_063749_goods_intro cannot be reverted.\n";

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
