<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/21
 * Time: 11:29
 */
namespace frontend\controllers;

use backend\models\Goods;
use backend\models\GoodsSearchForm;
use frontend\components\SphinxClient;
use frontend\models\GoodsCategory;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class GoodsController extends Controller{
    public $layout = 'index';
    //展示页面
    public function actionIndex(){
//        $models = \frontend\models\GoodsCategory::find()->where(['parent_id'=>0])->asArray()->all();
//        var_dump($models);
        return $this->render('index');
    }


    public function actionTest(){
        $cl = new SphinxClient();
        $cl->SetServer ( '127.0.0.1', 9312);
        $cl->SetConnectTimeout ( 10 );
        $cl->SetArrayResult ( true );
// $cl->SetMatchMode ( SPH_MATCH_ANY);
        $cl->SetMatchMode ( SPH_MATCH_ALL);
        $cl->SetLimits(0, 1000);
        $info = '华为手机';
        $res = $cl->Query($info, 'goods');//shopstore_search
//print_r($cl);
        var_dump($res);

    }




}