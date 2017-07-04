<style>
    span{
        font-size: 20px;
        font-family: 微软雅黑;
    }
</style>
<h1 style="margin-bottom: 100px">品牌详情</h1>

<p><span>品牌ID:</span><br/><?=$model->id;?></p>
    <hr/>
    <p><span>品牌:</span><br/><?=$model->name;?></p>
    <hr/>
<p><span>LOGO:</span><br/><?php if($model->logo){
        echo "<img src='$model->logo' width='200px' class='img-thumbnail'>";
    }else{
        echo '无';
        }?></p>
    <hr/>
    <p><span>当前状态:<span<br/><?=$model->status?></p>
    <hr/>
    <p><span>品牌简介:</span><br/><?=$model->intro?></p>

