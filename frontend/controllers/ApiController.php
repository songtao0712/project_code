<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/29
 * Time: 11:31
 */

namespace frontend\controllers;


use backend\models\Goods;
use frontend\models\Members;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;

class ApiController extends  Controller{

    public $enableCsrfValidation = false;


    public function init()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        parent::init();
    }

    public function actionTestApi(){

        $goods = Goods::find()->asArray()->all();
        if($goods){
            return ['status'=>1,'msg'=>'','data'=>$goods];
        }else{
            return ['status'=>0,'msg'=>'错误'];
        }
    }


}