<style>
    th,td{
        text-align: center;
    }
    th{
        background: lightsteelblue;
    }
</style>
<table class="table table-bordered table-responsive">
    <tr>
        <th>ID</th>
        <th>分类名</th>
        <th>父级ID</th>
        <th>分类介绍</th>
        <th>操作</th>
    </tr>
    <?Php foreach ($models as $row):?>
        <tr>
            <td><?=$row->id?></td>
            <td style="text-align: left"><?=str_repeat('———',$row->depth).$row->name?></td>
            <td><?=$row->parent_id?></td>
            <td><?=$row->intro?></td>
            <td>
                <?=\yii\bootstrap\Html::a('编辑',['goods-category/edit','id'=>$row->id],['class'=>'btn-sm btn-info']);?>
                <?=\yii\bootstrap\Html::a('删除',['goods-category/del','id'=>$row->id],['class'=>'btn-sm btn-danger']);?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php
//$this->registerCssFile('//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
//$this->registerJsFile('//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
//$this->registerJs('$(".table").DataTable({
//});');
