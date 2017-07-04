<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/8
 * Time: 18:53
 */

$from = \yii\bootstrap\ActiveForm::begin();#表单开始
echo $from->field($model,'name');
echo $from->field($model,'intro')->textarea(['style'=>['resize'=>'none','height'=>'200px']]);
echo $from->field($model,'sort');
echo $from->field($model,'status')->radioList(['-1'=>'下线',0=>'隐藏',1=>'正常']);
echo $from->field($model,'is_help');
echo \yii\bootstrap\Html::submitInput('提交数据',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();#表单结束