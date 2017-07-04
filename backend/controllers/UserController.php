<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/14
 * Time: 12:51
 */
namespace backend\controllers;

use backend\components\RbacFilter;
use backend\models\LoginForm;
use backend\models\User;
//use backend\models\UserForm;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;

class UserController extends Controller{
////使用过滤器
//    public function behaviors()
//    {
//        return [
//            'rbac'=>[
//                'class'=>RbacFilter::className()
//            ],
//        ];
//    }

    public function actionUser(){
        //实例化user组件
        $user = \yii::$app->user;

        //假设ADMin登录成功
        $admin = User::findOne(['id'=>1]);

        //将登录信息保存到SESSION中
        $res = $user->login($admin);
        var_dump($res);
    }

    public function actionLogin(){
        $model = new LoginForm();
        //实例化组件
        $request = \yii::$app->request;
        //验证是否是post提交
        if($request->isPost){
            //加载数据
            $model->load($request->post());
            //验证提价数据
            if($model->validate()){
                //验证用户名是否存在
                $user = User::findOne(['username'=>$model->username]);
//                var_dump($user);exit;
                if($user){
                    //如果用户名存在就验证密码
                    if(md5($model->password) == $user->password_hash){
                        //密码正确就登录成功，并且记录登录信息到SESSION
                        $duration = $model->remember ? 7*24*3600:0; //如果选中了记住密码就设置时间
//                        var_dump($duration);exit;
                            \yii::$app->user->login($user,$duration);//将用户信息保存进cookie并设置过期时间
                        \yii::$app->session->setFlash('success','登录成功');
//                        var_dump($model->getErrors());exit;
                        $user->last_login_ip = $request->userIP;//保存最后登录的IP地址
                        $user->last_login_time = time();//保存最后登录的时间
                        $user->save(false);//修改
                        return $this->redirect(['index/index']);
                    }else{

                        \yii::$app->session->setFlash('warning','密码错误');
                    }
                }else{
                    \yii::$app->session->setFlash('success','用户名不存在或密码错误');
//                    return $this->redirect(['user/login']);
                }
            }
        }
        return $this->render('login',['model'=>$model]);
    }

    //注册用户功能
    public function actionReg(){
//        $model = new UserForm();
        $model = new User();

        //加载数据
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
                if($model->newpassword != $model->repassword){
                    \Yii::$app->session->setFlash('warning','两次输入的面不一致');
                }else{
                    $model->password_hash = md5($model->newpassword);
                    $model->created_at = time();
                    $model->status = 1;
                    $model->auth_key = \yii::$app->security->generateRandomString();
                    $model->save();//新增
                    \yii::$app->session->setFlash('success','注册成功');
                    return $this->redirect(['user/login']);
                }
        }
        return $this->render('reg',['model'=>$model]);
    }

    //注销功能
    public function actionLogout(){
       $logout = \yii::$app->user;
       $logout->logout();
        \yii::$app->session->setFlash('success','注销成功');
        return $this->redirect(['user/login']);
    }

    public function actions(){
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength'=>4,
                'maxLength'=>4,
            ],
        ];
    }

    public function actionIndex(){
        $model = User::find();
        $total = $model->count();
        $page = new Pagination(
            [
                'totalCount'=>$total,//总条数
                'defaultPageSize'=>10,//每页显示多少条数据
            ]
        );

        $user = $model->offset($page->offset)->limit($page->limit)->all();
        return $this->render('index',['user'=>$user,'page'=>$page]);
    }


    //完成修改功能
    public function actionEdit($id){
//        $model = new UserForm();
        $model = User::findone(['id'=>$id]);
        $request = new Request();

        //加载数据
        if($request->isPost){
            $model->load($request->post());
            //验证数据
            if($model->validate()){
                //所有调用save方法的都要执行
                if($model->newpassword != $model->repassword){
                    \yii::$app->session->setFlash('success','两次输入的密码不一致');
                }else{//修改密码的操作
                    $model->password_hash = md5($this->newpassword);
                }
//                $model->reg_time = time();
                $model->updated_at = time();
//                $model->status = 1;
                $model->auth_key = \yii::$app->security->generateRandomString();
                $model->save();
                \yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['user/login']);
            }
        }
        return $this->render('reg',['model'=>$model]);
    }

    //删除用户
    public function actionDel($id){
        $model = User::findOne(['id'=>$id]);
        $model->delete();
        \yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['index']);

    }

}