<head>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.15/css/jquery.dataTables.css">

    <!-- jQuery -->
    <script type="text/javascript" charset="utf8" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

    <!-- DataTables -->
    <script type="text/javascript" charset="utf8" src="http://cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>
</head>
<style>
    th,td{
        text-align: center;
    }
    th{
        background: lightsteelblue;
    }

</style>
<table class="table table-hover table table-bordered table-responsive display" id="table_id_example">
    <thead>
    <tr>
        <th>权限名称</th>
        <th>权限描述</th>
        <th>创建时间</th>
        <th>更新时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($models as $row):?>
        <tr>
            <td><?="<strong>{$row->name}</strong>";?></td>
            <td><?="<strong>{$row->description}</strong>";?></td>
            <td><?=date('Y/m/d H:i:s',$row->createdAt);?></td>
            <td><?=date('Y/m/d H:i:s',$row->updatedAt);?></td>
            <td>
                <?=\yii\helpers\Html::a('删除',['rbac/del-permission','name'=>$row->name],['class'=>'btn-sm btn-danger'])?>
                <?=\yii\helpers\Html::a('修改',['rbac/edit-permission','name'=>$row->name],['class'=>'btn-sm btn-info'])?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
<?=\yii\bootstrap\Html::a('添加权限',['rbac/add-permission'],['class'=>'btn btn-default'])?>
<?php
$this->registerCssFile('//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
$this->registerJsFile('//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJs('$(".table").DataTable({
});');
