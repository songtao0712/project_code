<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/9
 * Time: 19:55
 */
use kartik\detail\DetailView;
$form = \yii\bootstrap\ActiveForm::begin();

//echo $form->field($model,'')->hiddenInput();
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea(['style'=>['resize'=>'none','height'=>'100px']]);
echo $form->field($model,'category_id')->dropDownList(\yii\helpers\ArrayHelper::map($cate,'id','name'));
echo $form->field($model,'sort');
echo $form->field($model,'status')->radioList([0=>'显示',1=>'隐藏']);
echo $form->field($content, 'content')->widget(\crazyfd\ueditor\Ueditor::className(),[]);
//echo $form->field($content,'content')->textarea(['style'=>['resize'=>'none','height'=>'500px']]);
echo yii\bootstrap\Html::submitInput('上传文章',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();
?>

