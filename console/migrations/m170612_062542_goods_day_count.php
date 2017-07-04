<?php

use yii\db\Migration;

class m170612_062542_goods_day_count extends Migration
{
    public function up()
    {
        $this->createTable('goods_day_count',[
            'day'=>$this->date(),
            'count'=>$this->integer()
        ]);
    }

    public function down()
    {
        echo "m170612_062542_goods_day_count cannot be reverted.\n";

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
