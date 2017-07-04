<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/12
 * Time: 14:46
 */

namespace backend\controllers;

use backend\components\RbacFilter;
use backend\models\Brand;
use backend\models\Goods;
use backend\models\GoodsDayCount;
use backend\models\GoodsIntro;
use backend\models\GoodsPhoto;
use backend\models\GoodsSearchForm;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use xj\uploadify\UploadAction;
use yii\helpers\ArrayHelper;
use backend\models\GoodsCategory;

class GoodsController extends Controller{
    //使用过滤器
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
                'only'=>['add,index,edit,check,photo,gallery,del']
            ],
        ];
    }

    //完成商品的添加功能
    public function actionAdd(){
        $goods = new Goods();
        $intro = new GoodsIntro();
//        $brand = Brand::find()->where('name')->all();
//        var_dump($brand);exit;
        $request = new Request();
        //接收数据
        if($request->isPost){
            $goods->load($request->post()) && $intro->load($request->post());
            //验证
            if($goods->validate() && $intro->validate()){
                $day = date('Y-m-d');
                $goodscount = GoodsDayCount::findOne(['day'=>$day]);//将数据库day字段的值设置为当天的日期
                if($goodscount == null){ //如果当天的时间为空不存在，就设置日期
                    $count = new GoodsDayCount();
                    $count->day = $day;
                    $count->count = 0;
                    $count->save();
                }
//                $str = substr('000'.($goodscount->count+1),-4,4);
                $goods->sn = date('Ymd').substr('000'.($goodscount->count+1),-4,4);
//                var_dump($goods->sn);exit;
                $goods->create_time = time();
//                var_dump($goods);exit;
                $goods->save();
                $intro->goods_id = $goods->id;
//                var_dump($intro);exit;
                $intro->save();
                GoodsDayCount::updateAllCounters(['count'=>1],['day'=>$day]);
                //提示
                \yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['goods/index']);//跳转
            }
            //将分类数据分配到页面
        }
        //分配数据
        $categories = ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],GoodsCategory::find()->asArray()->all());
//        var_dump($categories);exit;
        return $this->render('add',['goods'=>$goods,'intro'=>$intro,'categories'=>$categories]);
    }



    //展示所有商品数据
    public function actionIndex(){
        $search = new GoodsSearchForm();
        $model = Goods::find()->where(['status'=>1]);
//        var_dump($model);exit;
        $search->search($model);//接收表单提交的参数
        $total = $model->count();
        $page = new Pagination(
            [
                'totalCount'=>$total,//总条数
                'defaultPageSize'=>10,//每页显示多少条数据
            ]
        );

        $model = $model->offset($page->offset)->limit($page->limit)->all();
        return $this->render('index',['model'=>$model,'page'=>$page,'search'=>$search]);
    }

    //完成商品修改功能
    public function actionEdit($id){
        $goods = Goods::findOne(['id'=>$id]);
        $intro = GoodsIntro::findOne(['goods_id'=>$id]);
//        $brand = Brand::find()->where('name')->all();
//        var_dump($brand);exit;
        $request = new Request();
        //接收数据
        if($request->isPost){
            $goods->load($request->post()) && $intro->load($request->post());
            //验证
            if($goods->validate() && $intro->validate()){
//                $goods->sn = date('YmdHis',time()).mt_rand(1,9);
//                $goods->create_time = time();
//                var_dump($goods);exit;
                $goods->save();
//                $intro->goods_id = $goods->id;
//                var_dump($intro);exit;
                $intro->save();
                //提示
                \yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['goods/index']);//跳转
            }
            //将分类数据分配到页面
        }
        //分配数据
        $categories = ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],GoodsCategory::find()->asArray()->all());
//        var_dump($categories);exit;
        return $this->render('add',['goods'=>$goods,'intro'=>$intro,'categories'=>$categories]);
    }

    //完成查看功能
    public function actionCheck($id){
        //根据ID获取对应的数据
        $goods = Goods::findone(['id'=>$id]);
        $intro = GoodsIntro::findone(['goods_id'=>$id]);
//        var_dump($model);exit;
        //分配数据
        return $this->render('check',['intro'=>$intro,'goods'=>$goods]);
    }

    public function actionTest(){
       $test = date('YmdHis').mt_rand(1,9);
       echo $test;
    }

    //查看商品相册
    public function actionPhoto($id)
    {
        $goods = Goods::findOne(['id'=>$id]);
        if($goods == null){
            throw new NotFoundHttpException('商品不存在');
        }
//        var_dump($goods);exit;
        return $this->render('photo',['goods'=>$goods]);
    }

    //假删除
    public function actionDel($id){
        $model = Goods::findOne(['id'=>$id]);
        $model->status = 0;
        $model->save();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['index']);
    }

    //AJAX删除图片
    public function actionDelGallery(){
        $id = \Yii::$app->request->post('id');
        $model = GoodsPhoto::findOne(['goods_id'=>$id]);
        if($model && $model->delete()){
            return 'success';
        }else{
            return 'fail';
        }
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
                //'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
//                'format' => function (UploadAction $action) {
//                    $fileext = $action->uploadfile->getExtension();
//                    $filename = sha1_file($action->uploadfile->tempName);
//                    return "{$filename}.{$fileext}";
//                },
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
                    //图片上传成功后，将图片和商品关联起来
                    $model = new GoodsPhoto();
                    $model->goods_id = \yii::$app->request->post('goods_id');
                    $model->path = $action->getWebUrl();
                    $model->create_time = time();
                    $model->save();

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
            //百度编辑器
            'ueditor' => [
                'class' => 'crazyfd\ueditor\Upload',
                'config'=>[
                    'uploadDir'=>date('Y/m/d')
                ]
            ]
        ];

    }

}