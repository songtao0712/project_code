<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/19
 * Time: 15:49
 */
namespace frontend\models;

use yii\base\Model;
use yii\web\NotFoundHttpException;

class loginForm extends Model{
    public $username;
    public $password;
    public $code;
    public $remember;

    public function rules()
    {
        return
        [
            [['username','password','code'],'required']
        ];
    }

    public function attributeLabels()
    {
        return[
          'username'=>'用户名',
            'password'=>'密码',
            'code'=>'验证码',
            'remember'=>'记住密码'
        ];
    }

    //
    public function login(){
        //首先验证用户名是否存在
        $info = Members::findOne(['username'=>$this->username]);
        if($info){
            if(\Yii::$app->security->validatePassword($this->password,$info->password_hash)){
                    //如果选中了记住密码，就记录一周的时间戳写进cookie
                    $duration = $this->remember ? 3600*24*7:0;
                    \Yii::$app->user->login($info,$duration);
                return true;
            }else{
                $this->addError('密码错误');
            }
        }else{
            $this->addError('用户名不存在');
            return false;
        }

    }
}