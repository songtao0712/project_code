<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/16
 * Time: 10:00
 */
namespace backend\models;

use yii\base\Model;
use yii\rbac\Permission;

class PermissionForm extends Model{
    public $name;//权限名称
    public $description;//权限描述

    public function rules()
    {
        return[
            [['name','description'],'required']
        ];
    }

    public function attributeLabels()
    {
        return[
          'name'=>'权限名称',
            'description'=>'权限描述'
        ];
    }

    //添加权限
    public function addPermission(){
        //实例化组件
        $authManager = \Yii::$app->authManager;
        //判断接收的数据是否存在
        if($authManager->getPermission($this->name)){
            return $this->addError('name','权限名称已存在');
        }else{
            $permission = $authManager->createPermission($this->name);
            $permission->description = $this->description;//接收数据
//            $authManager->add($this->description);
            return $authManager->add($permission);//保存进数据表
        }
        return false;
    }

    //加载数据
    public function loadDate(Permission $permission){
        $this->name = $permission->name;
        $this->description = $permission->description;
    }

    //修改权限
    public function updatePermission($name){
        $authManager = \Yii::$app->authManager;
        //获取到要修改的对象
        $permission = $authManager->getPermission($name);
        //判断，如果传过来的数据存在，并且传过来的数据不等于旧数据，就不能继续执行
        if($authManager->getPermission($this->name) && $this->name != $name){
            return $this->addError('name','权限名已存在');
        }else{
            //给新的数据赋值
            $permission->name = $this->name;
            $permission->description = $this->description;
//            var_dump($permission);exit;
            //以前条件全部满足就更新数据
            return $authManager->update($name,$permission);
        }
        return false;
    }

}