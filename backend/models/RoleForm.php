<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/16
 * Time: 15:34
 */
namespace backend\models;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\rbac\Permission;
use yii\rbac\Role;

class RoleForm extends Model{
    public $name;//角色名称
    public $description;//角色描述
    public $permissions=[];//角色权限

    public function rules()
    {
        return [
          [['name','description'],'required'],
            ['permissions','safe']
        ];

    }

    public function attributeLabels()
    {
        return [
          'name'=>'角色名称',
            'description'=>'角色描述',
            'permission'=>'角色权限'
        ];
    }

    //显示所有的权限
    public static function getPermissionOption(){
        $authManager = \Yii::$app->authManager;
        return ArrayHelper::map($authManager->getPermissions(),'name','description');
    }

    //添加角色
    public function addRole(){
        $authManager = \Yii::$app->authManager;
        //判断接收的数据在数据表中是否存在
        if($authManager->getRole($this->name)){
            return $this->addError('角色名已存在不能重复添加');
        }
        //赋值
        $role = $authManager->createRole($this->name);
        $role->description = $this->description;
        if($authManager->add($role)){
            //循环保存权限，关联角色
            foreach ($this->permissions as $permissionName){
                $permission = $authManager->getPermission($permissionName);
                if($permission) $authManager->addChild($role,$permission);
            }
        }
        return true;
    }

    //给角色赋值
    public function loadData(Role $role){
        $this->name = $role->name;//角色赋值
        $this->description = $role->description;//描述赋值
        /**
         * 权限关联
         */
        //获取关联的权限
        $permissions = \Yii::$app->authManager->getPermissionsByRole($role->name);
        //遍历出权限
        foreach ($permissions as $permission){
            $this->permissions[]=$permission->name;
        }

    }

    //修改角色
    public function editRole($name){
        $authManager = \Yii::$app->authManager;
        $role = $authManager->getRole($name);
        //先给角色赋值
        $role->name = $this->name;
        $role->description = $this->description;
        //如果角色名被修改，检查该名字是否在数据库存在
        if($authManager->getRole($this->name) && $name != $this->name){
            return $this->addError('角色名已存在,请重新修改');
        }else{
            //保存之前去掉角色关联的所有权限
            if($authManager->update($name,$role)){
                $authManager->removeChildren($role);
                //重新给该角色权限赋值
                foreach ($this->permissions as $permissionName){
                    $permission = $authManager->getPermission($permissionName);
                    //关联权限
                    if($permission) $authManager->addChild($role,$permission);
                }
            }
        }
        return true;
    }


}