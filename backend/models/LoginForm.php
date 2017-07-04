<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/14
 * Time: 15:23
 */
namespace backend\models;

use yii\base\Model;

class LoginForm extends Model{

    public $username;
    public $password;
    public $remember;
    public $code;


    public function rules()
    {
        return [
          [['username','password','code'],'required'],
            ['remember','safe']

        ];
    }

    public function attributeLabels()
    {
        return [
          'username'=>'用户名',
            'password'=>'密码',
            'remember'=>'记住密码',
            'code'=>'验证码'
        ];
    }
}