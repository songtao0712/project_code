<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/14
 * Time: 16:41
 */

$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username');
echo $form->field($model,'email');
echo $form->field($model,'newpassword')->passwordInput();
echo $form->field($model,'repassword')->passwordInput();
echo $form->field($model,'code')->widget(\yii\captcha\Captcha::className(),[
    'captchaAction'=>'user/captcha',
    'template'=>'<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-1">{image}</div></div>']);
echo \yii\bootstrap\Html::submitInput('点击注册',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();