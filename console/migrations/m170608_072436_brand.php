<?php

use yii\db\Migration;

class m170608_072436_brand extends Migration
{
    public function up()
    {
        $this->createTable('brand',[

            'id'=>$this->primaryKey()->comment('主键'),
            'name'=>$this->string(50)->comment('品牌名字'),
            'intro'=>$this->text()->comment('品牌介绍'),
            'logo'=>$this->string(255)->comment('品牌logo'),
            'sort'=>$this->integer(11)->comment('排序'),
            'status'=>$this->integer(2)->comment('状态')

            ]);
    }

    public function down()
    {
        echo "m170608_072436_brand cannot be reverted.\n";

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
