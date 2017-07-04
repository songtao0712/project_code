<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/16
 * Time: 10:09
 */
namespace backend\controllers;

use backend\components\RbacFilter;
use backend\models\PermissionForm;
use backend\models\RoleForm;
use backend\models\User;
use backend\models\UserRoleForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RbacController extends Controller{

    //使用过滤器
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className()
            ],
        ];
    }

    /**
     * 权限的增删改查
     */
    //权限添加
    public function actionAddPermission(){
        $model = new PermissionForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->addPermission()){
                \Yii::$app->session->setFlash('success','添加权限成功');
                return $this->redirect(['index-permission']);
            }
        }
        return $this->render('add-permission',['model'=>$model]);
    }
    //权限修改
    public function actionEditPermission($name){
        //接收到对应name的数据
        $authManager = \Yii::$app->authManager;
        $permission = $authManager->getPermission($name);
//        var_dump($permission);exit;
        //判断该数据是否存在
        if($permission == null){
            throw new NotFoundHttpException('此权限不存在');
        }
            $model = new PermissionForm();
            //给表单模型赋值
            $model->loadDate($permission);
//            var_dump($model);exit;
            //加载数据实现数据回显
            if($model->load(\Yii::$app->request->post()) && $model->validate()){
                if($model->updatePermission($name)){
                    \Yii::$app->session->setFlash('success','修改权限成功');
                    return $this->redirect(['index-permission']);
                }
            }
        return $this->render('add-permission',['model'=>$model]);
    }
    //权限列表
    public function actionIndexPermission(){
        $models = \Yii::$app->authManager->getPermissions();
//        var_dump($models);exit;
        return $this->render('index-permission',['models'=>$models]);
    }
    //权限删除
    public function actionDelPermission($name){
        $model = \Yii::$app->authManager->getPermission($name);
        if($model == null){
            \Yii::$app->session->setFlash('success','此权限不存在');
            return $this->redirect(['index-permission']);

        }else{
            \Yii::$app->authManager->remove($model);
            \Yii::$app->session->setFlash('success','删除权限成功');
            return $this->redirect(['index-permission']);
        }
    }

    /**
     * 角色的增删改查---------------------------------------------------------------------------
     */
    //添加角色
    public function actionAddRole(){
        $model = new RoleForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->addRole()){
                \Yii::$app->session->setFlash('success','角色添加成功');
                return $this->redirect(['index-role']);
            }
        }
        return $this->render('add-role',['model'=>$model]);
    }
    //显示角色
    public function actionIndexRole(){
        $models = \Yii::$app->authManager->getRoles();
//        var_dump($models);exit;
        return $this->render('index-role',['models'=>$models]);
    }
    //修改角色
    public function actionEditRole($name){
        $authManager = \Yii::$app->authManager;
        $role = $authManager->getRole($name);
        $model = new RoleForm();
        $model->loadData($role);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->editRole($name)){
                \Yii::$app->session->setFlash('success','角色修改成功');
                return $this->redirect(['index-role']);
            }
        }
        return $this->render('add-role',['model'=>$model]);
    }

    //删除角色
    public function actionDelRole($name){
        $authManager = \Yii::$app->authManager;
        $role = $authManager->getRole($name);
        if($role == null){
            throw new NotFoundHttpException('角色不存在');
        }else{
            //删除对应数据
            $authManager->remove($role);
            \Yii::$app->session->setFlash('success','角色删除成功');
            return $this->redirect(['index-role']);
        }
    }

    /**
     * 用户关联角色-------------------------------------------------------------------------------
     */
    public function actionAddUser($id){
        $model = new UserRoleForm();

        //判断id是否为空
        if($id == false){
            throw new NotFoundHttpException('用户不存在，请返回重新操作');
        }

        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->addUser($id)){
                \Yii::$app->session->setFlash('success','添加角色成功');
                return $this->redirect(['user/index']);
            }
        }
        return $this->render('add-user',['model'=>$model]);
    }

    //显示关联角色的所有用户
    public function actionIndexUser(){

    }
}