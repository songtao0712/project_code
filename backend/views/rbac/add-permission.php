<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/16
 * Time: 10:59
 */



$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'description')->textarea();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
echo '<hr/>';