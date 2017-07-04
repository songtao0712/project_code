<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/19
 * Time: 11:12
 */
namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class CartAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        'style/base.css',
        'style/global.css',
        'style/header.css',
//        'style/login.css',
        'style/footer.css',
        'style/bottomnav.css',
//        'style/list.css',
        'style/order.css',
        'style/jqzoom.css',
//        'style/user.css',
//        'style/index.css',
        'style/goods.css',
//        'style/address.css',
//        'style/home.css',
        'style/cart.css',
        'style/success.css',
        'style/fillin.css',
        'style/common.css',


    ];
    public $js = [
//        'js/list.js',
        'js/goods.js',
//        'js/home.js',
//        'js/index.js',
//        'js/jqzoom-core.js',
        'js/header.js',
        'js/cart1.js',
        'js/cart2.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}

