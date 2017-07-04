<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/19
 * Time: 11:31
 */

namespace frontend\controllers;

use frontend\models\Address;
use frontend\models\loginForm;
use frontend\models\Members;
use yii\helpers\Url;
use yii\web\Controller;
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;
use yii\web\NotFoundHttpException;

class UserController extends Controller{


    public function actionReg(){
        $model = new Members();

        if($model->load(\Yii::$app->request->post()) && $model->validate()){

            //------------------------短信验证部分----------------------------
            if($this->actionSms()){
                $model->save(false);
            }else{
                throw new NotFoundHttpException('短信验证码错误');
            }
            //----------------------------------------------------------------

            $model->save(false);
        }
        return $this->render('reg',['model'=>$model]);
    }

    public function actionLogin(){
        $model = new loginForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->login()){
                $user = new Members();
                //登录成功保存IP和时间
                $user->last_login_time = time();
                $user->last_login_ip = \Yii::$app->request->userIP;
                $user->save(false);
                \Yii::$app->session->setFlash('success','登录成功');
                return $this->redirect(['index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }

        return $this->render('login',['model'=>$model]);
    }

    //p
    public function actionIndex(){
        var_dump(\Yii::$app->user->isGuest);
//        var_dump(\Yii::$app->user->getId());
        echo date('Y/m/d H:i:s',1497871094);


        $data = Address::findAll(['member_id'=>\Yii::$app->user->getId()]);
        var_dump($data);
    }

    //注销
    public function actionLogout(){
        $res = \Yii::$app->user->logout();
        var_dump($res);

    }

    public function actionTest(){
        $code = rand(1000,9999);
        $res = \Yii::$app->sms->setNum(18224416499)->setParam(['code'=>$code])->send();
        if($res){
            echo $code.'成功';
        }else{
            echo '失败';
        }

    }

    //验证短信
    public function actionSms(){
        $tel =\Yii::$app->request->post('tel');
        if(!preg_match('/^1[34785]\d{9}$/',$tel)){
            echo '电话号码不正确';
        }
        $code = rand(1000,9999);
        $res = \Yii::$app->sms->setNum($tel)->setParam(['code'=>$code])->send();
        if($res){
            echo 'success'.$code;
        }else{
            echo '发送失败';
        }
    }

}