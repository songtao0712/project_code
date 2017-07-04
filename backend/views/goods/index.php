<style>
    th,td{
        text-align: center;
    }
    h1{
        font-family: 微软雅黑;
    }
</style>
<h1 class="text-center">所有商品</h1>
<?php
$form = \yii\bootstrap\ActiveForm::begin([
    'method' => 'get',
    //get方式提交,需要显式指定action
    'action'=>\yii\helpers\Url::to(['goods/index']),
    'options'=>['class'=>'form-inline']
]);
echo $form->field($search,'name')->textInput(['placeholder'=>'商品名'])->label(false);
echo $form->field($search,'sn')->textInput(['placeholder'=>'货号'])->label(false);
echo $form->field($search,'minPrice')->textInput(['placeholder'=>'￥'])->label(false);
echo $form->field($search,'maxPrice')->textInput(['placeholder'=>'￥'])->label('——');
echo \yii\bootstrap\Html::submitInput('搜索',['class'=>'btn-sm btn-info']);
\yii\bootstrap\ActiveForm::end();
?>
<table class="table table-bordered table-responsive table-hover">
    <tr style="background: lightsteelblue">
        <th>商品名称</th>
        <th>编号</th>
        <th>LOGO</th>
        <th>所属分类</th>
        <th>品牌</th>
        <th>市场售价</th>
        <th>本店售价</th>
        <th>剩余库存</th>
        <th>是否上架</th>
        <th>状态</th>
        <th>排序</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    <?php foreach ($model as $row):?>
    <tr>
        <td><?=$row->name;?></td>
        <td><?=$row->sn;?></td>
        <td><img src="<?=$row->logo;?>" height="40px"/></td>
        <?php $cate = \backend\models\GoodsCategory::findone(['id'=>$row->goods_category_id])?>
        <td><?=$cate->name;?></td>
        <?php $brand = \backend\models\Brand::findone(['id'=>$row->brand_id])?>
        <td><?=$brand->name;?></td>
        <td><?=$row->market_price;?></td>
        <td><?=$row->shop_price;?></td>
        <td><?=$row->stock;?></td>
        <td>
            <?php
            if($row->is_on_sale){
                echo '上架';
            }else{
                echo '下架';
            }
            ?>
        </td>
        <td>
            <?php
            if($row->status){
                echo '正常';
            }
            ?>
        </td>
        <td><?=$row->sort;?></td>
        <td><?=date('Y/m/d H:i:s',$row->create_time);?></td>
        <td width="15%">
            <?=\yii\bootstrap\Html::a('删除',['goods/del','id'=>$row->id],['class'=>'btn-xs btn-danger'])?>
            <?=\yii\bootstrap\Html::a('查看',['goods/check','id'=>$row->id],['class'=>'btn-xs btn-info'])?>
            <?=\yii\bootstrap\Html::a('修改',['goods/edit','id'=>$row->id],['class'=>'btn-xs btn-primary'])?>
            <?=\yii\bootstrap\Html::a('相册',['goods/photo','id'=>$row->id],['class'=>'btn-xs btn-primary'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>

<?php
//分页工具条
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页'

])
?>
<?=yii\bootstrap\Html::a('添加商品',['goods/add'],['class'=>'btn btn-default'])?>

<?php
//$this->registerCssFile('//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
//$this->registerJsFile('//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
//$this->registerJs('$(".table").DataTable({
//});');
