<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/18
 * Time: 12:17
 */
namespace backend\controllers;

use backend\components\RbacFilter;
use backend\models\Menu;
use yii\web\Controller;

class MenuController extends Controller{

    /**
     * 路由的曾删该查
     */

    //使用过滤器
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className()
            ],
        ];
    }

    public function actionAddUrl(){
        $model = new Menu();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //如果没有选择一级菜单，则默认执行添加一级菜单操作
            if(empty($model->parent_id)){
                $model->parent_id = 0;
            }
            $model->save();
            \Yii::$app->session->setFlash('success','添加路由成功');
            return $this->redirect(['index-url']);
        }
//        var_dump($model);exit;
        return $this->render('add-url',['model'=>$model]);
    }

    //展示所有路由
    public function actionIndexUrl(){
        $model = Menu::find()->all();
//        var_dump($model);exit;
        return $this->render('index-url',['model'=>$model]);
    }

    //修改菜单
    public function actionEditUrl($id){
        $model = Menu::findOne(['id'=>$id]);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //如果没有选择一级菜单，则默认执行添加一级菜单操作
            if(empty($model->parent_id)){
                $model->parent_id = 0;
            }
            $model->save();
            \Yii::$app->session->setFlash('success','添加路由成功');
            return $this->redirect(['index-url']);
        }
//        var_dump($model);exit;
        return $this->render('add-url',['model'=>$model]);
    }


}