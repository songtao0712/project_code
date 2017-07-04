
<div class="container">
    <h1 class="text-center">文章详情</h1>
<h3 style="color: lightsteelblue;"><?=$article->name;?></h3>
    <hr/>
    <div><?=$model->content;?></div>
    <hr/>
    <div><?=\yii\bootstrap\Html::a('返回上一页',['article/index'],['class'=>'btn btn-default'])?></div>
</div>