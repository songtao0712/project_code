<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/25
 * Time: 9:17
 */

namespace frontend\controllers;

use backend\models\Goods;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Members;
use frontend\models\Order;
use yii\db\Query;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;

class CartController extends Controller{

    public $layout = 'cart';

    //购物车功能
    public function actionCart(){
        $user = \Yii::$app->user;
        //如果是未登录的状态使用购物车
        if($user->isGuest){
            //取出cookie中的商品ID和数量
            $cookies = \Yii::$app->request->cookies;
            $cookie = $cookies->get('cart');
            if($cookie == null){
                $cart = [];
            }else{
                $cart = unserialize($cookie->value);
            }

            //将序列化商品遍历展示
            $models = [];
//            $data = unserialize($cart);
//            var_dump($cart);exit;
            foreach ($cart as $good_id => $amount) {
                $goods = Goods::findOne(['id' => $good_id])->attributes;
                $goods['amount'] = $amount;
                $models[] = $goods;
            }
            return $this->render('cart',['models'=>$models]);
        }else{
            $member_id= \Yii::$app->user->getId();
            //如果cookie有数据， 就同步到数据库
            $cookies = \Yii::$app->response->cookies;
            $cookie = $cookies->get('cart');
            if($cookie == null){
                $cart = [];
            }else{
                $cart = unserialize($cookie->value);
                $model = new Cart();
                $model->goods_id = $cart['goods_id'];
                $model->amount = $cart['amount'];
                $model->save();
            }

            //将数据展示
            $carts = Cart::find()->where(['member_id'=>$member_id])->all();

            return $this->render('cart',['carts'=>$carts]);
        }

    }


    //---------------------------------------------------------------------------


    //将商品添加进购物车
    public function actionAdd(){
        //接收数据
        $goods_id = \Yii::$app->request->post('goods_id');
        $amount = \Yii::$app->request->post('amount');
        $goods = Goods::findOne(['id'=>$goods_id]);
        if($goods == null){
            throw new NotFoundHttpException('商品不存在');
        }
        $user = \Yii::$app->user;
        //如果是未登录的状态下,将商品保存进cookie
        if($user->isGuest){
            //先获取cookie里面的数据
            $cookies = \Yii::$app->request->cookies;
            $cookie = $cookies->get('cart');
            if($cookie == null){
                $cart = [];
            }else{
                $cart = unserialize($cookie->value);
            }
            //将商品id和数量存到cookie
            $cookies = \Yii::$app->response->cookies;
            //检查购物车中是否有该商品，如果有就累加
//            var_dump($cart);exit;
            $cart = [];
            if(key_exists($goods->id,$cart)){

                $cart[$goods_id] += $amount;
            }else{
                $cart[$goods_id] = $amount;
            }

            $cookie = new Cookie(['name'=>'cart','value'=>serialize($cart)]);
            $cookies->add($cookie);
//            var_dump($cookie);
        }else{
            //已登录的状态下，操作数据库
            $member_id= \Yii::$app->user->getId();
            $model = Cart::find()->where(['member_id'=>$member_id])->andWhere(['goods_id'=>$goods_id])->one();
            if($model){
                //累加
                $model->amount += $amount;
                $model->save();
            }else{
                $model = new Cart();
                $model->goods_id = $goods_id;
                $model->amount = $amount;
                $model->member_id = $member_id;
                $model->save();
            }
        }
        return $this->redirect(['cart']);
    }

    //更新购物车
    public function actionUpdate(){
        //接收数据
        $amount = \Yii::$app->request->post('amount');
        $goods_id = \Yii::$app->request->post('goods_id');
        $goods = Goods::findOne(['id'=>$goods_id]);
        if($goods == null){
            throw new NotFoundHttpException('商品不存在');
        }
        $user = \Yii::$app->user;
        //如果是未登录的状态下,将商品保存进cookie
        if($user->isGuest){
            //先获取cookie里面的数据
            $cookies = \Yii::$app->request->cookies;
            $cookie = $cookies->get('cart');
            if($cookie == null){
                $cart = [];
            }else{
                $cart = serialize($cookie->value);
            }
            //将商品id和数量存到cookie
            $cookies = \Yii::$app->response->cookies;
            //检查购物车中是否有该商品，如果有就累加
            if(key_exists($goods->id,$cart)){
                $cart[$goods_id] += $amount;
            }else{
                $cart[$goods_id] = $amount;
            }
            $cookie = new Cookie(['name'=>'cart','value'=>serialize($cart)]);
            $cookies->add($cookie);
        }else{
            //已登录的状态下，操作数据库
            $member_id= \Yii::$app->user->getId();
            $model = Cart::find()->where(['member_id'=>$member_id])->andWhere(['goods_id'=>$goods_id])->one();
            if($model){
                $model->amount += $amount;
                $model->save();
                if ($amount == 0){
                    $model->delete();
                }
            }else{
                if ($amount == 0){
                    $model->delete();
                }
                $model = new Cart();
                $model->goods_id = $goods_id;
                $model->amount = $amount;
                $model->member_id = $member_id;
                $model->save();
            }
        }
        return $this->redirect(['cart']);
    }

    //计算购物车总金额
    public function actionCount(){
        //接收POST请求
        $count = \Yii::$app->request->post('count');
        $user = \Yii::$app->user->getId();


    }

    //创建订单
    public function actionOrder(){
        $user = \Yii::$app->user;
        if($user->isGuest){
            echo '您当前是游客身份，请登录后下单';
            exit;
        }
        //获取用户的购物车信息
        $cart = Cart::find()->where(['member_id'=>$user->getId()])->all();
//        var_dump($cart);exit;

        return $this->render('order',['cart'=>$cart]);
    }

    public function actionTest(){
        $model = new Order();
        //接收POST请求
        $address_id = \Yii::$app->request->post('address_id');//收货地址
        $delivery_id = \Yii::$app->request->post('delivery_id');//配送方式
        $payment_id = \Yii::$app->request->post('payment_id');//支付方式
        $price = \Yii::$app->request->post('price');
            $address = Address::findOne(['id'=>$address_id,'member_id'=>\Yii::$app->user->id]);
//        var_dump($address);
            if($address == null){
                throw new NotFoundHttpException('地址不存在');
            }
        $model->member_id = \Yii::$app->user->getId(); //用户ID
        $model->province = $address->province;// 收货地址省
        $model->city = $address->city; //收货地址市
        $model->area = $address->area;//收货地址区县
        $model->address = $address->address;//详细收货地址
        $model->tel = $address->tel;//联系电话
        $model->name = $address->name;//收货人
        $model->delivery_id = Order::$delivery[$delivery_id];//配送方式id
        $model->delivery_name = Order::$delivery[$delivery_id]['name'];//配送方式
        $model->delivery_name = Order::$delivery[$delivery_id]['price'];//配送方式价格
        $model->payment_id = $payment_id;//支付方式id
        $model->payment_name = Order::$payment[$payment_id]['name'];//支付方式



    }

}