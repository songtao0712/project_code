<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/19
 * Time: 19:57
 */
namespace frontend\controllers;

use chenkby\region\Region;
use chenkby\region\RegionAction;
use frontend\models\Address;

use frontend\models\Locations;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AddressController extends Controller{
    public $layout = 'head';

    public function actionAddress(){
        $model = new Address();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->remember){
                $models = Address::find()->where(['member_id'=>\Yii::$app->user->getId()])->all();
//        var_dump($model)
                foreach ($models as $row){
                    $row->status = 0;
                    $row->save();
                }
                $model->status = 1;
            }else{
                $model->status = 0;
            }
            $model->member_id = \Yii::$app->user->getId();
            $model->create_at = time();
//            var_dump($model);exit;
            $model->save();
            return $this->redirect('address');
        }
        return $this->render('index',['model'=>$model]);
    }

    //删除收货地址
    public function actionDel($id){

        if(empty($id) || $id==null){
            echo '数据不存在';
            exit;
        }
        $model = Address::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect('address');
    }

    //修改地址
    public function actionEdit($id){
        $model = Address::findOne(['id'=>$id]);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->remember){
                $model->status = 1;
            }else{
                $model->status = 0;
            }
            $model->member_id = \Yii::$app->user->getId();
            $model->create_at = time();
            $model->save();
            \Yii::$app->session->setFlash('success','修改成功');
            return $this->redirect('address');
        }

        return $this->render('index',['model'=>$model]);
    }

    //设置为当前地址为默认地址
    public function actionSet($id){
        if(empty($id) || $id==null){
            exit;
        }
        $models = Address::find()->where(['member_id'=>\Yii::$app->user->getId()])->all();
//        var_dump($model)
        foreach ($models as $row){
            $row->status = 0;
            $row->save();
        }
        $model = Address::findOne(['id'=>$id]);
        $model->status = 1;
        $model->save();
        return $this->redirect('address');
    }
    public function actionIndex(){

        return $this->render('test');
    }

    public function actionSite($pid, $typeid = 0)
    {
        $model = new Address();
        $model = $model->getCityList($pid);

        if($typeid == 1){
            $aa="--请选择市--";
            echo Html::tag('option',$aa, ['value'=>'empty']) ;

        }else if($typeid == 2 && $model){
            $aa="--请选择区--";
            echo Html::tag('option',$aa, ['value'=>'empty']) ;
        }

        foreach($model as $value=>$name)
        {
            echo Html::tag('option',Html::encode($name),array('value'=>$value));
        }
    }

//    public function actions()
//    {
//        $actions=parent::actions();
//        $actions['get-region']=[
//            'class'=>RegionAction::className(),
//            'model'=>Region::className(),
//        ];
//        return $actions;
//    }


}