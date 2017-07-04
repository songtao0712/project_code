<style>
    th,td{
        text-align: center;
    }
    th{
        background: lightsteelblue;
    }
</style>
<table class="table table-responsive table-bordered">
    <thead>
    <tr>
        <th>ID值</th>
        <th>菜单名称</th>
        <th>菜单路由</th>
        <th>所属菜单</th>
        <th>菜单类型</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($model as $row):?>
    <tr>
        <td><?=$row->id;?></td>
        <td><?=$row->lable;?></td>
        <td><?php if($row->url){echo $row->url;}else{echo '一级菜单无路由';}?></td>
        <td><?=$row->parent_id;?></td>
        <td>
            <?php if($row->parent_id == 0){
                echo '一级菜单';
            }else{
                echo '二级菜单';
            }?>
        </td>
        <td>
            <?=\yii\bootstrap\Html::a('修改',['menu/edit-url','id'=>$row->id],['class'=>'btn-sm btn-info'])?>
        </td>
    </tr>
    <?php endforeach;?>
    </tbody>

</table>
<?php
$this->registerCssFile('//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
$this->registerJsFile('//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJs('$(".table").DataTable({
});');
