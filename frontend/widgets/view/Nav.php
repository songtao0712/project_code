<!-- 顶部导航 start -->
<div class="topnav">
    <div class="topnav_bd w990 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <ul>
                <li><?php if($user->isGuest){
                        echo '[您好，请'.\yii\helpers\Html::a('登录',['user/login']).']';
                    }else{
                        echo \yii\helpers\Html::a('注销',['user/logout']);
                    };?></li>
                <li class="line">|</li>
                <li>我的订单</li>
                <li class="line">|</li>
                <li>客户服务</li>

            </ul>
        </div>
    </div>
</div>
<!-- 顶部导航 end -->