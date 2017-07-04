<style>
    th,td{
        text-align: center;
    }
    th{
        background: lightsteelblue;
    }
</style>
<table class="table table-hover table table-bordered table-responsive">
    <tr>
        <th>角色名称</th>
        <th>角色描述</th>
        <th>角色权限</th>
        <th>创建时间</th>
        <th>更新时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $row):?>
        <tr>
            <td><?=$row->name;?></td>
            <td><?=$row->description;?></td>
            <td width="30%">
                <?php
                foreach (Yii::$app->authManager->getPermissionsByRole($row->name) as $permission)
                    echo $permission->description.'|';
                ?>
            </td>
            <td><?=date('Y/m/d H:i:s',$row->createdAt);?></td>
            <td><?=date('Y/m/d H:i:s',$row->updatedAt);?></td>
            <td width="10%">
                <?=\yii\helpers\Html::a('删除',['rbac/del-role','name'=>$row->name],['class'=>'btn-sm btn-danger'])?>
                <?=\yii\helpers\Html::a('修改',['rbac/edit-role','name'=>$row->name],['class'=>'btn-sm btn-info'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?=\yii\bootstrap\Html::a('添加角色',['rbac/add-role'],['class'=>'btn btn-default'])?>
<?php
$this->registerCssFile('//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
$this->registerJsFile('//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJs('$(".table").DataTable({
});');

