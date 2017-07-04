<style>
    th,td{
        text-align: center;
    }
</style>
<h1 class="text-center">文章列表</h1>
<table class="table table-bordered table-hover">
    <tr style="background: lightsteelblue">
        <th>标题</th>
        <th>简介</th>
        <th>分类</th>
        <th>排序</th>
        <th>状态</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    <?php foreach ($article as $rows):?>
        <tr>
            <td><?=$rows->name;?></td>
            <td><?=$rows->intro;?></td>
            <td><?=$rows->category_id;?></td>
            <td><?=$rows->sort;?></td>
            <td><?=$rows->status;?></td>
            <td><?=date('Y/m/d H:i:s',$rows->create_time);?></td>
            <td>
                <?=\yii\bootstrap\Html::a('查看内容',['article/check','id'=>$rows->id],['class'=>'btn btn-info'])?>
                <?=\yii\bootstrap\Html::a('编辑',['article/edit','id'=>$rows->id],['class'=>'btn btn-primary'])?>
                <?=\yii\bootstrap\Html::a('删除',['article/del','id'=>$rows->id],['class'=>'btn btn-danger'])?>
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
<?=yii\bootstrap\Html::a('添加文章',['article/add'],['class'=>'btn btn-default'])?>

<?php
$this->registerCssFile('//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
$this->registerJsFile('//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJs('$(".table").DataTable({
});');
