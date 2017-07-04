
<style>

th,td{
    text-align: center;
}

</style>

<div class="container" style="width: 80%">

    <h1 class="text-center">品牌列表</h1>
<table class="table table-bordered table-hover">
    <tr style="background: lightblue">
        <th>品牌ID</th>
        <th>品牌</th>
        <th>排序</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php foreach ($brand as $rows):?>
        <tr>
            <td><?=$rows->id;?></td>
            <td><?=$rows->name;?></td>
            <td><?=$rows->sort;?></td>
            <td><?=$rows->status;?></td>
            <td><?=yii\bootstrap\Html::a('编辑',['brand/edit','id'=>$rows->id],['class'=>'btn btn-info']);?>
                <?=yii\bootstrap\Html::a('查看',['brand/check','id'=>$rows->id],['class'=>'btn btn-primary']);?>
                <?=\yii\bootstrap\Html::a('删除',['brand/del','id'=>$rows->id],['class'=>'btn btn-danger'])?>
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
<?=yii\bootstrap\Html::a('添加新品牌',['brand/add'],['class'=>'btn btn-default'])?>

</div>

<?php
$this->registerCssFile('//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
$this->registerJsFile('//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJs('$(".table").DataTable({
});');
