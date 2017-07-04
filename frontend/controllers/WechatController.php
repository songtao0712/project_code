<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/7/3
 * Time: 15:46
 */
namespace frontend\controllers;


use backend\models\Goods;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\News;
use frontend\models\Address;
use frontend\models\Members;
use frontend\models\Order;
use yii\helpers\Url;
use yii\web\Controller;

class WechatController extends Controller{
    //微信开发依赖的插件  easyWechat
    //关闭csrf验证
    public $enableCsrfValidation = false;
    //url 就是用于接受微信服务器发送的请求
    public function actionIndex()
    {

        $app = new Application(\Yii::$app->params['wechat']);
        $app->server->setMessageHandler(function ($message) {
            switch ($message->MsgType){
                case 'text':
                    //文本消息
                    switch ($message->Content){
                        case '帮助':
                            return '您可以发送、优惠、解除绑定';
                            break;
                        case '注册':
                            $url = Url::to(['user/reg'],true);
                            return '点此注册'.$url;
                            break;
                        case '商城':
                            //多图文信息
                            $news1 = new News([
                                'title'       => '商城首页',
                                'description' => '点击进入商城首页...',
                                'url'         => 'http://www.shopping.cn/',
                                'image'       => 'http://pic27.nipic.com/20130131/1773545_150401640000_2.jpg',
                            ]);
                            return $news1;
                            break;
                    }
                    return '收到你的消息:'.$message->Content;
                    break;
                case 'event'://事件
                    //事件的类型   $message->Event
                    //事件的key值  $message->EventKey
                    if($message->Event == 'CLICK'){//菜单点击事件
                        if($message->EventKey == 'zxhd'){
                            $news1 = new News([
                                'title'       => '促销活动',
                                'description' => '双十一全场五折...',
                                'url'         => 'http://www.esont.cn/frontend/web/wechat/hot-goods',
                                'image'       => 'https://img10.360buyimg.com/da/jfs/t4324/317/860219935/78514/96c6e177/58ba3360N7d709700.jpg',
                            ]);
                            return $news1;
                        }
                    }
                    return '接受到了'.$message->Event.'类型事件'.'key:'.$message->EventKey;
                    break;
            }
        });
        $response = $app->server->serve();
// 将响应输出
        $response->send(); // Laravel 里请使用：return $response;
    }

    //设置菜单
    public function actionSetMenu()
    {
        $app = new Application(\Yii::$app->params['wechat']);
        $menu = $app->menu;
        $buttons = [
            [
                "type" => "click",
                "name" => "促销商品",
                "key"  => "zxhd"
            ],
            [
                "type" => "click",
                "name" => "在线商城",
                "key"  => "zxsc"
            ],
            [
                "name"       => "个人中心",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "绑定账户",
                        "url"  => Url::to(['wechat/login'],true)
                    ],
                    [
                        "type" => "view",
                        "name" => "我的订单",
                        "url"  => Url::to(['wechat/order'],true)
                    ],
                    [
                        "type" => "view",
                        "name" => "收货地址",
                        "url" => Url::to(['wechat/address'],true)
                    ],
                    [
                        "type" => "view",
                        "name" => "修改密码",
                        "url" => Url::to(['wechat/edit-pwd'],true)
                    ],
                ],
            ],
        ];
        $menu->add($buttons);
        //获取已设置的菜单（查询菜单）
        $menus = $menu->all();
        var_dump($menus);
    }
    //我的订单
    public function actionOrder()
    {
        //openid
        $openid = \Yii::$app->session->get('openid');
        if($openid == null){
            //获取用户的基本信息（openid），需要通过微信网页授权
            \Yii::$app->session->set('redirect',\Yii::$app->controller->action->uniqueId);
            //echo 'wechat-user';
            $app = new Application(\Yii::$app->params['wechat']);
            //发起网页授权
            $response = $app->oauth->scopes(['snsapi_base'])
                ->redirect();
            $response->send();
        }
        //var_dump($openid);
        //通过openid获取账号
        $member = Members::findOne(['openid'=>$openid]);
        if($member == null){
            //该openid没有绑定任何账户
            //引导用户绑定账户
            return $this->redirect(['wechat/login']);
        }else{
            //已绑定账户
            $orders = Order::findAll(['member_id'=>$member->id]);
//            var_dump($orders);
        }
        return $this->renderFile('login');
    }
    //个人中心
    public function actionUser()
    {
        $openid = \Yii::$app->session->get('openid');
        if($openid == null){
            //获取用户的基本信息（openid），需要通过微信网页授权
            \Yii::$app->session->set('redirect',\Yii::$app->controller->action->uniqueId);
            //echo 'wechat-user';
            $app = new Application(\Yii::$app->params['wechat']);
            //发起网页授权
            $response = $app->oauth->scopes(['snsapi_base'])
                ->redirect();
            $response->send();
        }
    }
    //授权回调页
    public function actionCallback()
    {
        $app = new Application(\Yii::$app->params['wechat']);
        $user = $app->oauth->user();
        //将openid放入session
        \Yii::$app->session->set('openid',$user->getId());
        return $this->redirect([\Yii::$app->session->get('redirect')]);
    }


    public function actionTest()
    {
        \Yii::$app->session->removeAll();
    }
    //绑定用户账号   将openid和用户账号绑定
    public function actionLogin()
    {
        $openid = \Yii::$app->session->get('openid');
        if($openid == null){
            //获取用户的基本信息（openid），需要通过微信网页授权
            \Yii::$app->session->set('redirect',\Yii::$app->controller->action->uniqueId);
            //echo 'wechat-user';
            $app = new Application(\Yii::$app->params['wechat']);
            //发起网页授权
            $response = $app->oauth->scopes(['snsapi_base'])
                ->redirect();
            $response->send();
        }

        //让用户登录，如果登录成功，将openid写入当前登录账户
        $request = \Yii::$app->request;
        if(\Yii::$app->request->isPost){
            $user = Members::findOne(['username'=>$request->post('username')]);
            if($user && \Yii::$app->security->validatePassword($request->post('password'),$user->password_hash)){
                \Yii::$app->user->login($user);
                //如果登录成功，将openid写入当前登录账户
                Members::updateAll(['openid'=>$openid],'id='.$user->id);
                if(\Yii::$app->session->get('redirect')) return $this->redirect([\Yii::$app->session->get('redirect')]);
                echo '绑定成功';exit;
            }else{
                echo '登录失败';exit;
            }
        }
        return $this->renderPartial('login');
    }

    //修改密码
    public function actionEditPwd(){

    }

    //收货地址
    public function actionAddress(){
        //判断是否绑定账号

        $user = Members::findOne(['id'=>\Yii::$app->user->getId()]);
        if($user->openid == null){
            return $this->redirect(['wechat/login']);
        }
        $model = Address::find()->where(['member_id'=>\Yii::$app->user->getId()])->all();

        return $this->renderPartial('address',['model'=>$model]);
    }

    //促销商品
    public function actionHotGoods(){
        $models = Goods::find()->limit(5)->all();
//        var_dump($models);exit;
        return $this->renderPartial('hot',['models'=>$models]);
    }

}