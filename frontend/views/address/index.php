<style>
</style>
<!-- 页面主体 start -->
<div class="main w1210 bc mt10">
    <div class="crumb w1210">
        <h2><strong>我的XX </strong><span>> 我的订单</span></h2>
    </div>

    <!-- 左侧导航菜单 start -->
    <div class="menu fl">
        <h3>我的XX</h3>
        <div class="menu_wrap">
            <dl>
                <dt>订单中心 <b></b></dt>
                <dd><b>.</b><a href="">我的订单</a></dd>
                <dd><b>.</b><a href="">我的关注</a></dd>
                <dd><b>.</b><a href="">浏览历史</a></dd>
                <dd><b>.</b><a href="">我的团购</a></dd>
            </dl>

            <dl>
                <dt>账户中心 <b></b></dt>
                <dd class="cur"><b>.</b><a href="">账户信息</a></dd>
                <dd><b>.</b><a href="">账户余额</a></dd>
                <dd><b>.</b><a href="">消费记录</a></dd>
                <dd><b>.</b><a href="">我的积分</a></dd>
                <dd><b>.</b><a href="">收货地址</a></dd>
            </dl>

            <dl>
                <dt>订单中心 <b></b></dt>
                <dd><b>.</b><a href="">返修/退换货</a></dd>
                <dd><b>.</b><a href="">取消订单记录</a></dd>
                <dd><b>.</b><a href="">我的投诉</a></dd>
            </dl>
        </div>
    </div>
    <!-- 左侧导航菜单 end -->

    <!-- 右侧内容区域 start -->
    <div class="content fl ml10">
        <div class="address_hd">
            <h3>收货地址薄</h3>
            <?php foreach (\frontend\models\Address::getAddressOption() as $row):?>
            <dl>
                    <?php
                    $province = \frontend\models\Locations::findOne(['id'=>$row->province]);
                    $city = \frontend\models\Locations::findOne(['id'=>$row->city]);
                    $area = \frontend\models\Locations::findOne(['id'=>$row->area]);
                    ?>
                <dt><?='联系人：'.$row->username.'&nbsp;&nbsp;&nbsp;收货地址：'.$province->name.$city->name.$area->name.$row->address.'&nbsp;&nbsp;&nbsp;联系电话：'.$row->tel?> </dt>
                <dd>
                    <?=\yii\helpers\Html::a('删除',['address/del','id'=>$row->id])?>
                    <?=\yii\helpers\Html::a('修改',['address/edit','id'=>$row->id])?>
                    <?php
                    if($row->status){
                       echo '<b>默认地址</b>';
                    }else{
                       echo \yii\helpers\Html::a('设为默认地址',['address/set','id'=>$row->id]);
                    }
                    ?>

                </dd>
            </dl>
            <?php endforeach;?>
        </div>

        <div class="address_bd mt10">
            <h4>新增收货地址</h4>
            <?php $form = \yii\widgets\ActiveForm::begin(['fieldConfig'=>['options'=>['tag'=>'li',], 'errorOptions'=>['tag'=>'i']]]);?>
            <?='<ul>'?>
            <?=$form->field($model,'username')->textInput(['class'=>'txt'])?>
            <?= $form->field($model,'province')->dropDownList($model->getCityList(0),
                [
                    'prompt'=>'--请选择省--',
                    'onchange'=>'
            $.post("'.yii::$app->urlManager->createUrl('address/site').'?typeid=1&pid="+$(this).val(),function(data){
                $("select#address-city").html(data);
            });',
                ]) ?>

            <?= $form->field($model, 'city')->dropDownList($model->getCityList($model->province),
                [
                    'prompt'=>'--请选择市--',
                    'onchange'=>'
            $.post("'.yii::$app->urlManager->createUrl('address/site').'?typeid=2&pid="+$(this).val(),function(data){
                $("select#address-area").html(data);
            });',
                ]) ?>
            <?= $form->field($model, 'area')->dropDownList($model->getCityList($model->city),['prompt'=>'--请选择区--',]) ?>
            <?=$form->field($model,'address')->textInput(['class'=>'txt'])?>

            <?=$form->field($model,'tel')->textInput(['class'=>'txt'])?>
            <?=$form->field($model,'remember')->checkbox()?>
            <?=\yii\helpers\Html::submitButton('保存')?>
            <?='</ul>'?>
            <?php \yii\widgets\ActiveForm::end()?>
        </div>

    </div>
    <!-- 右侧内容区域 end -->
</div>
<!-- 页面主体 end-->
<div style="clear:both;"></div>