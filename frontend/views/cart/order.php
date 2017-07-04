
<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="index.html"><?=\yii\helpers\Html::img('@web/images/logo.png')?></a></h2>
        <div class="flow fr">
            <ul>
                <li>1.我的购物车</li>
                <li>2.填写核对订单信息</li>
                <li class="cur">3.成功提交订单</li>
            </ul>
        </div>
    </div>
</div>
<!-- 页面头部 end -->
<!-- 主体部分 start -->
<form action="<?=\yii\helpers\Url::to(['cart/commit-order'])?>" method="post">
<div class="fillin w990 bc mt15">
    <div class="fillin_hd">
        <h2>填写并核对订单信息</h2>
    </div>

    <div class="fillin_bd">
        <!-- 收货人信息  start-->
        <div class="address">
            <h3>收货人信息</h3>
            <div class="address_info">
                <?php foreach (\frontend\models\Address::getAddressOption() as $item):?>
                    <?php
                    $province = \frontend\models\Locations::findOne(['id'=>$item->province]);
                    $city = \frontend\models\Locations::findOne(['id'=>$item->city]);
                    $area = \frontend\models\Locations::findOne(['id'=>$item->area]);
                    ?>
                    <?php $location = \frontend\models\Locations::findOne(['id'=>$item->province])?>
                <p>
                    <input type="radio" value="<?=$item->id?>" name="address_id" <?php if($item->status == 1){echo 'checked';}?>/>
                    <input name="_csrf-frontend" type="hidden" id="_csrf-frontend" value="<?= Yii::$app->request->csrfToken ?>">
                    <?=$item->username.'&nbsp;&nbsp;&nbsp;'.$item->tel.'&nbsp;&nbsp;&nbsp;'.$province->name.$city->name.$area->name.$item->address?>
                </p>
                <?php endforeach;?>
            </div>


        </div>
        <!-- 收货人信息  end-->

        <!-- 配送方式 start -->
        <div class="delivery">
            <h3>送货方式 </h3>


            <div class="delivery_select">
                <table id="table">
                    <thead>
                    <tr>
                        <th class="col1">送货方式</th>
                        <th class="col2">运费</th>
                        <th class="col3">运费标准</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (\frontend\models\Order::$delivery as $k=>$row):?>
                    <tr class="cur">
                        <td>
                            <input type="radio" name="delivery_id" value="<?=$k?>"/><?=$row['name'];?>

                        </td>
                        <td>￥<span id="price"><?=$row['price'];?></span></td>
                        <td><?=$row['info'];?></td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>

            </div>
        </div>
        <!-- 配送方式 end -->

        <!-- 支付方式  start-->
        <div class="pay">
            <h3>支付方式 </h3>


            <div class="pay_select">
                <table id="pay_select">
                    <?php foreach (\frontend\models\Order::$payment as $k=>$info):?>
                    <tr class="cur">
                        <td class="col1"><input type="radio" name="payment_id" value="<?=$k?>" /><?=$info['name']?></td>
                        <td class="col2"><?=$info['info']?></td>
                    </tr>
                    <?php endforeach;?>
                </table>

            </div>
        </div>
        <!-- 支付方式  end-->

        <!-- 商品清单 start -->
        <div class="goods">
            <h3>商品清单</h3>
            <table id="goods_list">
                <thead>
                <tr>
                    <th class="col1">商品</th>
                    <th class="col3">价格</th>
                    <th class="col4">数量</th>
                    <th class="col5">小计</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($cart as $item):?>
                <tr>
                    <td class="col1"><a href=""><?=\yii\helpers\Html::img($item->goodsinfo->logo)?></a>  <strong><a href=""><?=$item->goodsinfo->name?></a></strong></td>
                    <td class="col3"><?=$item->goodsinfo->shop_price;?></td>
                    <td class="col4"><?=$item->amount;?></td>
                    <td class="col5"><span><?=$item->goodsinfo->shop_price * $item->amount;?></span></td>
                </tr>
                <?php endforeach;?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <ul>
                            <li>

                                <span><?=count($cart)?>件商品，总商品金额：</span>
                                <?php $sum = 0;
                                    foreach ($cart as $value){
                                        $sum += $value->goodsinfo->shop_price * $value->amount;
                                    }
                                ?>
                                <em id="sum"><?=$sum?></em>
                            </li>
                            <li>
                                <span>运费：</span>
                                <em><span id="value"></span></em>
                            </li>

                        </ul>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- 商品清单 end -->

    </div>

    <div class="fillin_ft">
<!--        <a href="javascript:void(0)" id="btn"><span>提交订单</span></a>-->
        <p>应付总额：<strong><span id="yy"></span></strong></p>
        <input type="submit" value="提交订单"/>

    </div>
</div>
</form>
<!-- 主体部分 end -->

<?php
$url = \yii\helpers\Url::to(['cart/test']);
$token = Yii::$app->request->csrfToken;
$this->registerJs(new \yii\web\JsExpression(

        <<<JS
    var sum = $('#sum').text();
    var data = $('#value');
    var span = $('#yy');
    var check = $('#table').find($("input[type='radio']"));
    check.click(function() {
      var tr = $(this).closest('tr');
      //获取运费
     var value = tr.find('#price').text();
     //将运费赋值到结算金额
     var price = data.text(value);
     //结算总额
     var yunfei = parseFloat(value);
     var zonge = parseFloat(sum);
     span.text(yunfei + zonge);
       
    });

    //-------------------AJAX请求后台部分------------------------

    var price = parseFloat(span.text());
    $('body').on('click',function() {
      $.post('/cart/test',{'price':price,'_csrf-frontend':'$token'},function(data) {
        console.debug(data)
      })
    })

JS

))


?>