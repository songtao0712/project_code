<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/29
 * Time: 14:08
 */
namespace backend\controllers;

use backend\models\Article;
use backend\models\Category;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\LoginForm;
use frontend\models\Address;
use frontend\models\Members;
use yii\captcha\Captcha;
use yii\captcha\CaptchaAction;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class ApiController extends Controller{

    public $enableCsrfValidation = false;


    public function init()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        parent::init();
    }
    //会员注册
    public function actionRegApi(){
        $request = \Yii::$app->request;
        if($request->post()){
            $model = new Members();
            $model->username = $request->post('username');
            $model->password_hash = $request->post('password');
            $model->email = $request->post('email');
            $model->tel = $request->post('tel');
            $model->auth_key = \Yii::$app->security->generateRandomString();
            $model->create_at = time();
            if($model->validate()){
                $model->save();
                return ['status'=>1,'msg'=>'注册成功','data'=>$model->toArray()];
            }else{
                return ['status'=>0,'msg'=>$model->getErrors()];
            }

        }else{
            return ['status'=>-1,'msg'=>'请使用post请求'];
        }
    }

    //用户登录
    public function actionLoginApi(){
        $request = \Yii::$app->request;
        if($request->post()){
//            $model = new Members();
            if($model = Members::findOne(['username'=>$request->post('username')])){

                if(\Yii::$app->security->validatePassword($request->post('password'),$model->password_hash)){
                    \Yii::$app->user->login($model);
                    return ['status'=>1,'msg'=>'登录成功'];
                }else{
                    return ['status'=>0,'msg'=>'密码错误'];
                }
            }else{
                return ['status'=>0,'msg'=>'用户不存在'];
            }
        }else{
            return ['status'=>-1,'msg'=>'请使用post请求'];
        }
    }

    //修改密码
    public function actionEditApi(){
        if(!\Yii::$app->user->isGuest){
            $request = \Yii::$app->request;
            if($request->post()){
                $model = Members::findOne(['id'=>\Yii::$app->user->getId()]);
                if($request->post('password') == $request->post('re_password')){
                    $model->password_hash = $request->post('password');
                    $model->save();
                    return ['status'=>1,'msg'=>'密码修改成功'];
                }
            }else{
                return ['status'=>-1,'msg'=>'请使用post请求'];
            }

        }else{
            return ['status'=>0,'msg'=>'请登录'];
        }
    }

    //获取当前登录的用户信息
    public function actionUserApi(){
        $model = Members::findOne(['id'=>21]);
        if($model == null){
            return ['status'=>0 , 'msg'=>'当前无用户登录'];
        }else{
            return ['status'=>1 , 'msg'=>'' , 'data'=>$model->toArray()];
        }
    }

    //添加收货地址
    public function actionAddAddressApi(){
        $request = \Yii::$app->request;
        if($request->post()){
            $model = new Address();
            $model->province = $request->post('province');
            $model->city = $request->post('city');
            $model->area = $request->post('area');
            $model->address = $request->post('address');
            $model->username = $request->post('username');
            $model->member_id = \Yii::$app->user->getId();
            $model->tel = $request->post('tel');
            $model->create_at = time();
            $model->status = 0;
            if($model->validate()){
                $model->save();
                return ['status'=>1,'msg'=>'添加成功','data'=>$model->toArray()];
            }
        }else{
            return ['status','msg'=>'请使用POST请求'];
        }
    }

    //修改收货地址
    public function actionEditAddressApi($id){
        $request = \Yii::$app->request;
        if($request->post()){
            $model = Address::findOne(['id'=>$id,'member_id'=>\Yii::$app->user->getId()]);
            $model->province = $request->post('province');
            $model->city = $request->post('city');
            $model->area = $request->post('area');
            $model->address = $request->post('address');
            $model->username = $request->post('username');
            $model->tel = $request->post('tel');
            $model->create_at = time();
            $model->status = 0;
            if($model->validate()){
                $model->save();
                return ['status'=>1,'msg'=>'修改成功','data'=>$model->toArray()];
            }
        }else{
            return ['status','msg'=>'请使用POST请求'];
        }
    }

    //删除收货地址
    public function actionDelAddressApi($id){
        $model = Address::findOne(['id'=>$id,'member_id'=>\Yii::$app->user->getId()]);
        $res = $model->delete();
        return ['status'=>1,'msg'=>'删除成功','data'=>$res];
    }

    //获取收货地址
    public function actionListAddressApi(){
        $model = Address::find()->where(['member_id'=>21])->asArray()->all();
        return ['status'=>1,'msg'=>'','data'=>$model];
    }

    //获取所有分类
    public function actionCateApi(){
        $model = GoodsCategory::find()->orderBy(['tree'=>SORT_ASC,'lft'=>SORT_ASC])->all();

        return ['status'=>1,'msg'=>'','data'=>$model];
    }

    //获取当前分类下面的所有子分类
    public function actionGetChildrenApi($id){
        $model = GoodsCategory::find()->where(['parent_id'=>$id])->all();
        return ['status'=>1,'msg'=>'','data'=>$model];
    }

    //获取某分类的父分类
    public function actionGetParentApi(){

    }

    //获取某分类下面的所有商品（不考虑分页）
    public function actionGetGoodsApi($id){
        $model = Goods::find()->where(['goods_category_id'=>$id])->all();
        return ['status'=>1,'msg'=>'','data'=>$model];
    }

    //获取某品牌下面的所有商品（不考虑分页）
    public function actionBrandGoodsApi($id){
        $model = Goods::find()->where(['brand_id'=>$id])->all();
        return ['status'=>1,'msg'=>'','data'=>$model];
    }

    //获取文章分类
    public function actionCategoryApi(){
        $model = Category::find()->all();
//        var_dump($model);
        return ['status'=>1,'msg'=>'','data'=>$model];
    }

    //获取某分类下面的所有文章
    public function actionCateArticleApi($id){
        $model = Article::find()->where(['category_id'=>$id])->all();
        return ['status'=>1,'msg'=>'','data'=>$model];
    }

    //获取某文章所属分类
    public function actionCateByArticleApi($id = 19){
        $model = Article::findOne(['id'=>$id]);
        $cate = Category::find()->where(['id'=>$model->category_id])->all();
//        var_dump($cate);exit;
        return ['status'=>1,'msg'=>'','data'=>$cate];
    }

    //验证码
    public function actions()
    {
        return[
          'captcha'=>[
              'class'=>CaptchaAction::className(),
              'fixedVerifyCode'=>YII_ENV_TEST?'testme':null,
              'minLength'=>4,
              'maxLength'=>4,
              'fontFile' => '@yii/captcha/SpicyRice.ttf',
              'foreColor'=>'3232546'
          ]
        ];
    }

    //文件上传
    public function actionUploadApi(){
        $img = UploadedFile::getInstanceByName('img');
        if($img){
            $imageName = '/upload/'.uniqid().'.'.$img->extension;
            $res = $img->saveAs(\Yii::getAlias('@webroot').$imageName,0);
            if ($res){
                return ['status'=>1,'msg'=>'文件上传成功','data'=>$imageName];
            }
        }else{
            return ['status'=>0,'msg'=>'文件上传失败'];
        }
    }

    //分页读取数据
    public function actionPageApi(){
        //每页显示多少条
        $per_page = \Yii::$app->request->get('per_page',2);
        //当前第几页
        $page = \Yii::$app->request->get('page',1);
        //搜索
        $keyWords = \Yii::$app->request->get('keywords');
        //总条数
        $query = Goods::find();
        $total = $query->count();
        if($keyWords){
            $query->andWhere(['like','name',$keyWords]);
        }
        //获取当前分页数据
        $goods = $query->offset($per_page * ($page - 1))->limit($per_page)->asArray()->all();
        return ['status'=>1,'msg'=>'','data'=>[
           'per_page'=>$per_page,
           'page'=>$page,
            'total'=>$total,
            'goods'=>$goods
        ]];
    }

    //发送短信验证码
    public function actionSmsApi(){
        $tel =\Yii::$app->request->post('tel');
        if(!preg_match('/^1[34785]\d{9}$/',$tel)){
            return ['status'=>0,'msg'=>'电话号码格式错误'];
        }
        //检查上次发送的时间是否超过一分钟
        $val = \Yii::$app->cache->get('time_tel'.$tel);
        $time = time()-$val;
        if($time < 60){
            return['status'=>0,'msg'=>'请'.(60-$time).'秒后再试'];
        }
        $code = rand(1000,9999);
        $res = \Yii::$app->sms->setNum($tel)->setParam(['code'=>$code])->send();
        if($res){
            //设置缓存
            \Yii::$app->cache->set('tel_'.$tel,$code,5*60);
            \Yii::$app->cache->set('time_tel'.$tel,time(),5*60);
            return ['status'=>1,'msg'=>'发送成功'];
        }else{
            return ['status'=>1,'msg'=>'发送失败'];
        }
    }
}