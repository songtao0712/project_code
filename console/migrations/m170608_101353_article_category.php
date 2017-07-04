<?php

use yii\db\Migration;

class m170608_101353_article_Category extends Migration
{
    public function up()
    {
        $this->createTable('article',[
           'id'=>$this->primaryKey(),
            'name'=>$this->string(20),
            'intro'=>$this->text(),
            'sort'=>$this->integer(2),
            'status'=>$this->string(2),
            'is_help'=>$this->string(10)
        ]);
    }

    public function down()
    {
        echo "m170608_101353_article cannot be reverted.\n";

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
