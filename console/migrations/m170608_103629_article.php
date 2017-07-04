<?php

use yii\db\Migration;

class m170608_103629_article extends Migration
{
    public function up()
    {
        $this->createTable('article',[
            'id'=>$this->primaryKey(),
            'name'=>$this->string(20),
            'intro'=>$this->text(),
            'category_id'=>$this->integer(3),
            'sort'=>$this->integer(11),
            'status'=>$this->string(2),
            'create_time'=>$this->integer(11)
        ]);
    }

    public function down()
    {
        echo "m170608_103629_article cannot be reverted.\n";

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
