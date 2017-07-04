<style>
    th,td{
        text-align: center;
    }
</style>
<table class="table table-hover table table-bordered table-responsive">
    <tr>
        <th>用户ID</th>
        <th>用户名</th>
        <th>所属角色</th>
        <th>注册时间</th>
        <th>最后登录时间</th>
        <th>最后登录IP</th>
        <th>操作</th>
    </tr>
    <?php foreach ($user as $row):?>
        <tr>
            <td><?=$row->id;?></td>
            <td><?=$row->username;?></td>
            <td>
                <?php
                foreach (Yii::$app->authManager->getRolesByUser($row->id) as $role){
                    echo "<span style='color: red'>$role->name</span>-";
                }
                ?>
            </td>
            <td><?=date('Y/m/d H:i:s',$row->created_at);?></td>
            <td><?=date('Y/m/d H:i:s',$row->last_login_time);?></td>
            <td><?=$row->last_login_ip;?></td>
            <td>
                <?=\yii\bootstrap\Html::a('删除',['user/del','id'=>$row->id],['class'=>'btn-sm btn-danger'])?>
                <?=\yii\bootstrap\Html::a('修改',['user/reg','id'=>$row->id],['class'=>'btn-sm btn-primary'])?>
                <?=\yii\bootstrap\Html::a('添加角色',['rbac/add-user','id'=>$row->id],['class'=>'btn-sm btn-info'])?>
            </td>
        </tr>
    <?php endforeach;;?>
</table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页'

])
?>
<?=yii\bootstrap\Html::a('注册新用户',['user/reg'],['class'=>'btn btn-default'])?>
<?php
$this->registerCssFile('//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
$this->registerJsFile('//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJs('$(".table").DataTable({
});');

