<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/18
 * Time: 16:26
 */
namespace backend\controllers;

use backend\components\RbacFilter;
use yii\web\Controller;

class IndexController extends Controller{
//使用过滤器
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className()
            ],
        ];
    }

    public function actionIndex(){

        return $this->render('index');
    }
}