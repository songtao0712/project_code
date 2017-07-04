<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/8
 * Time: 15:53
 */
use yii\web\JsExpression;
use xj\uploadify\Uploadify;

$from = \yii\bootstrap\ActiveForm::begin();#表单开始

echo $from->field($model,'name');
echo $from->field($model,'intro')->textarea(['style'=>['resize'=>'none','height'=>'500px']]);
echo $from->field($model,'logo')->hiddenInput();
echo \yii\bootstrap\Html::fileInput('test',null,['id'=>'test']);
echo Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 40,
        'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data.fileUrl);
        //将上传成功后的图片地址(data.fileUrl)写入img标签
        $("#img_logo").attr("src",data.fileUrl).show();
        //将上传成功后的图片地址(data.fileUrl)写入logo字段
        $("#brand-logo").val(data.fileUrl);
    }
}
EOF
        ),
    ]
]);

if($model->logo){
    echo \yii\helpers\Html::img('@web'.$model->logo);
}else{
    echo \yii\helpers\Html::img('',['style'=>'display:none','id'=>'img_logo','height'=>'50']);
}
echo $from->field($model,'sort');
echo $from->field($model,'status')->radioList(['-1'=>'下线',0=>'隐藏',1=>'正常']);
echo \yii\bootstrap\Html::submitInput('提交数据',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();#表单结束