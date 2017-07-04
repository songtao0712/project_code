<style>
    th,td{
        text-align: center;
    }
</style>
<h1 class="text-center">分类列表</h1>

<table class="table table-bordered table-hover">
    <tr style="background: lightsteelblue">
        <th>分类ID</th>
        <th>分类名</th>
        <th>分类说明</th>
        <th>排序</th>
        <th>状态</th>
        <th>类型</th>
        <th>操作</th>
    </tr>
    <?php foreach($cate as $rows):?>
        <tr>
            <td><?=$rows->id;?></td>
            <td><?=$rows->name;?></td>
            <td><?=$rows->intro;?></td>
            <td><?=$rows->sort;?></td>
            <td>
                <?php if ($rows->status >= 0){
                    if($rows->status){
                        echo '正常';
                    }else{
                        echo '隐藏';
                    }
                }?>
            </td>
            <td><?=$rows->is_help;?></td>
            <td><?=yii\bootstrap\Html::a('编辑',['category/edit','id'=>$rows->id],['class'=>'btn btn-info']);?>
                <?=yii\bootstrap\Html::a('删除',['category/del','id'=>$rows->id],['class'=>'btn btn-danger']);?>
            </td>
        </tr>

    <?php endforeach;?>
</table>
<?=yii\bootstrap\Html::a('添加新分类',['category/add'],['class'=>'btn btn-default'])?>

<?php
//分页工具条
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页'

])
?>

<?php
$this->registerCssFile('//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
$this->registerJsFile('//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJs('$(".table").DataTable({
});');
