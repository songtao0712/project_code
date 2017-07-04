<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/11
 * Time: 21:30
 */

namespace backend\controllers;

use backend\components\RbacFilter;
use backend\models\GoodsCategory;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class GoodsCategoryController extends Controller{

    //使用过滤器
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className()
            ],
        ];
    }

    //展示页面
    public function actionIndex(){
        $models = GoodsCategory::find()->orderBy(['tree'=>SORT_ASC,'lft'=>SORT_ASC])->all();
//        var_dump($models);
        return $this->render('list',['models'=>$models]);
    }

    //添加分类
    public function actionAdd(){
        $model = new GoodsCategory();
        if($model->load(\yii::$app->request->post()) && $model->validate()){
            //判断是否是添加的一级分类
            if($model->parent_id){
                $parent = GoodsCategory::findOne(['id'=>$model->parent_id]);
                $model->prependTo($parent);
            }else{
                //添加一级分类
                $model->makeRoot();
            }
            //提示
            \yii::$app->session->setFlash('success','添加成功');
        }
        $categories = ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],GoodsCategory::find()->asArray()->all());

        return $this->render('add',['model'=>$model,'categories'=>$categories]);
    }

    //编辑分类
    public function actionEdit($id){
        $model = GoodsCategory::findOne(['id'=>$id]);
        if($model->load(\yii::$app->request->post()) && $model->validate()){
            //判断是否是添加的一级分类
            if($model->parent_id){
                $parent = GoodsCategory::findOne(['id'=>$model->parent_id]);
                $model->prependTo($parent);
            }else{
                //添加一级分类
                $model->makeRoot();
            }
            //提示
            \yii::$app->session->setFlash('success','添加成功');
        }
        $categories = ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],GoodsCategory::find()->asArray()->all());

        return $this->render('add',['model'=>$model,'categories'=>$categories]);
    }

    //删除提示，实际上不能删除分类数据
    public function actionDel(){
        \Yii::$app->session->setFlash('warning','商品分类均不能删除，删除按钮只是为了满足我这种强迫症！！');
        return $this->redirect(['index']);
    }

    public function actionZtree()
    {
        $categories = GoodsCategory::find()->asArray()->all();

        return $this->renderPartial('ztree',['categories'=>$categories]);//不加载布局文件
    }
}