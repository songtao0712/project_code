<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/8
 * Time: 15:48
 */

namespace backend\controllers;

use backend\components\Qiniuyun;
use backend\components\RbacFilter;
use backend\models\Brand;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;
use xj\uploadify\UploadAction;
use crazyfd\qiniu\Qiniu;

class BrandController extends Controller{

//使用过滤器
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
                'only'=>['index','del','add','check','off'],
            ],
        ];
    }

    //完成品牌展示功能
    public function actionIndex(){
        $model = Brand::find()->where(['status'=>1]);
        $total = $model->count();
        $page = new Pagination(
            [
                'totalCount'=>$total,//总条数
                'defaultPageSize'=>10,//每页显示多少条数据
            ]
        );

        $brand = $model->offset($page->offset)->limit($page->limit)->all();
        return $this->render('index',['brand'=>$brand,'page'=>$page]);
    }

    //完成品牌添加功能
    public function actionAdd(){
        //实例化表单
        $model = new Brand();
        $request = new Request();
        //接收数据
        if($request->isPost){
            $model->load($request->post());
//            var_dump($request->post());exit;
            //验证数据
            if($model->validate()){

                $model->save();
                //跳转
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['brand/index']);
            }else{
                var_dump($model->getErrors());exit;
            }

        }
        return $this->render('add',['model'=>$model]);
    }

    //显示品牌的详情
    public function actionCheck($id){
        $model = Brand::findOne($id);
        return $this->render('check',['model'=>$model]);
    }

    //完成品牌的修改功能
    public function actionEdit($id){
        //实例化表单
        $model = Brand::findOne($id);
        $request = new Request();
        //接收数据
        if($request->isPost){
            $model->load($request->post());
            //验证数据
            if($model->validate()){
                $model->save();
                //跳转
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['brand/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>($model)]);
    }

    //完成品牌下线功能
    public function actionOff($id){
        //获取到对应id的数据
        $model = Brand::findOne($id);
        //将status字段设置为‘-1’,-1表示下线
        $model->status = '-1';
        //保存
        $model->save();
        var_dump($model);

    }

    //将下线的品牌放在单独的页面
    public function actionDel($id){
        $model = Brand::findOne(['id'=>$id]);
        $model->status = '0';
        $model->save();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['index']);
    }

    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                $imgUrl = $action->getWebUrl();
                $action ->output['fileUrl'] = $action->getWebUrl();
                //调用七牛云组件，将图片上传到七牛云
                    $qiniu = \Yii::$app->qiniuyun;
                    $qiniu->uploadFile(\Yii::getAlias('@webroot').$imgUrl,$imgUrl);
                    //获取该图片在七牛云的地址
                    $url = $qiniu->getLink($imgUrl);
                    $action->output['fileUrl'] = $url;
                },
            ],
        ];
    }

}