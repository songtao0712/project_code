<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/18
 * Time: 22:54
 */
namespace backend\components;



use yii\base\ActionFilter;
use yii\web\HttpException;

class RbacFilter extends ActionFilter {

    public function beforeAction($action)
    {
        //实例化user组件
        $user = \Yii::$app->user;
        if(!$user->can($action->uniqueId)){
            if($user->isGuest){
                return $action->controller->redirect(['user/login']);
            }
            throw new HttpException(403,'您没有权限操作此功能，请联系管理员');
        }
        return parent::beforeAction($action);
    }
}