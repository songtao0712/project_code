<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/12
 * Time: 14:55
 */
use yii\web\JsExpression;
use xj\uploadify\Uploadify;


$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($goods,'name');//商品名字
//echo $form->field($goods,'sn');//编号
echo $form->field($goods,'goods_category_id')->dropDownList([\backend\models\Goods::getGoodsCategoryOptions()]);
echo '<ul id="treeDemo" class="ztree"></ul>';

//--------------------------------上传LOGO----------------------------------------------------------------------
echo $form->field($goods,'logo')->hiddenInput(['id'=>'goods-logo']);
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
        $("#goods-logo").val(data.fileUrl);
    }
}
EOF
        ),
    ]
]);

if($goods->logo){
    echo \yii\helpers\Html::img($goods->logo);
}else{
    echo \yii\helpers\Html::img('',['style'=>'display:none','id'=>'img_logo','height'=>'50']);
}
//-----------------------------------------------------------------------------------------------------------




echo $form->field($goods,'sort');//排序
echo $form->field($goods,'brand_id')->dropDownList([\backend\models\Goods::getBrandOptions()]);//品牌
echo $form->field($goods,'status')->radioList([0=>'回收',1=>'显示']);//状态
echo $form->field($goods,'is_on_sale')->radioList([0=>'下架',1=>'在售']);//在售状态
echo $form->field($goods,'market_price');
echo $form->field($goods,'shop_price');
echo $form->field($goods,'stock');
echo $form->field($intro, 'intro')->widget(\crazyfd\ueditor\Ueditor::className(),[]);//百度编辑器插件
echo \yii\bootstrap\Html::submitInput('提交数据',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
//-------------------------------------------------------------------------------------------------------------
/*$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
$zNodes = \yii\helpers\Json::encode($categories);
$js = new \yii\web\JsExpression(
    <<<JS
var zTreeObj;
    // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
    var setting = {
        data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "parent_id",
                rootPId: 0
            }
        },
        callback: {
		    onClick: function(event, treeId, treeNode) {
                //console.log(treeNode.id);
                //将选中节点的id赋值给表单parent_id
                $("#good").val(treeNode.id);
                console.debug($("#good").val(treeNode.id))
            }
	    }
    };
    // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
    var zNodes = {$zNodes};

    zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
    zTreeObj.expandAll(true);//展开所有节点
    //获取当前节点的父节点（根据id查找）
    var node = zTreeObj.getNodeByParam("id", $("#good").val(), null);
    zTreeObj.selectNode(node);//选中当前节点的父节点
JS

);
$this->registerJs($js);*/