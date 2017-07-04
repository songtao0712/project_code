<?php

use yii\db\Migration;

class m170619_062203_create_table_members extends Migration
{
    public function up()
    {
        $this->createTable('members',[
            'id'=>$this->primaryKey()->comment('ID主键'),
            'username'=>$this->string(24)->comment('用户名'),
            'auth_key'=>$this->string(32),
            'password_hash'=>$this->string(255)->comment('密码'),
            'email'=>$this->string()->comment('邮箱'),
            'tel'=>$this->string('12')->comment('电话号码'),
            'last_login_time'=>$this->integer()->comment('最后登录时间'),
            'last_login_ip'=>$this->string(18)->comment('最后登录IP'),
            'status'=>$this->integer(2)->comment('状态'),
            'create_at'=>$this->integer()->comment('注册时间'),
            'update_at'=>$this->integer()->comment('修改时间')
        ]);
    }

    public function down()
    {
        echo "m170619_062203_create_table_members cannot be reverted.\n";

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
