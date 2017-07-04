<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/17
 * Time: 9:13
 */
namespace backend\models;

use yii\base\Model;
use yii\helpers\ArrayHelper;

class UserRoleForm extends Model{

   public $role;

   public function rules()
   {
       return [
         ['role','safe']
       ];
   }

   public function attributeLabels()
   {
       return [
         'role'=>'角色'
       ];
   }

    //获取角色
    public static function getRoleOptions(){
        $authManager = \Yii::$app->authManager;
        $roles = $authManager->getRoles();
        return ArrayHelper::map($roles,'name','description');
    }

    //给用户关联角色
    public function addUser($id){
        $authManager = \Yii::$app->authManager;
        //关联角色之前先删除之前的角色
        //获取当前用户关联的角色
//            $authManager->getRolesByUser($id);
            //如果关联之前用户关联的有角色，就删除所有角色重新关联
        $this->getErrors();
        if($id != null){
                $authManager->revokeAll($id);
                foreach ($this->role as $roleName){
//                $this->getErrors();exit;
                    $role = $authManager->getRole($roleName);
                    $authManager->assign($role,$id);
                }
            }
        return true;
    }
}