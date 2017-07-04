<?php
namespace backend\widgets;

use backend\models\Menu;
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Widget;
use yii\helpers\ArrayHelper;

class NavWidget extends Widget{
    public function init()
    {
        parent::init();
    }

    public function run(){
        NavBar::begin([
            'brandLabel' => '后台管理系统',
            'brandUrl' => \Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);


        if (\Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => '登录', 'url' =>\yii::$app->user->loginUrl];
        } else {
            $menuItems[] = ['label' => '注销（'.\Yii::$app->user->identity->username.'）', 'url' =>['user/logout']];
            //获取所有一级菜单
            $menus = Menu::findAll(['parent_id'=>0]);
            foreach($menus as $menu){

                $item = ['label'=>$menu->lable,'items'=>[]];

                foreach ($menu->children as $child){
                    //根据用户权限判断，该菜单是否显示
                    if(\Yii::$app->user->can($child->url)){
                        $item['items'][] = ['label'=>$child->lable,'url'=>[$child->url]];
                    }
                }
                //如果一级菜单下没有子菜单，就不在页面显示
                if(!empty($item['items'])){
                    $menuItems[] = $item;
                }
            }

        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
    }

}