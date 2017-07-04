<div class="cat_bd">
    <?php foreach ($cate as $row):?>
        <div class="cat item1">
            <h3><?=\yii\helpers\Html::a($row->name,['list/list','id'=>$row->id])?> <b></b></h3>
            <div class="cat_detail">
                <?php foreach ($row->children as $info):?>
                    <dl class="dl_1st">
                        <dt><?=\yii\helpers\Html::a($info->name,['list/list','id'=>$info->id])?></dt>
                        <?php foreach ($info->children as $re):?>
                            <dd>
                                <?=\yii\helpers\Html::a($re->name,['list/list','id'=>$re->id])?>
                            </dd>
                        <?php endforeach;?>
                    </dl>
                <?php endforeach;?>
            </div>
        </div>
    <?php endforeach;?>
</div>
