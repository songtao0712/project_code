<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/10
 * Time: 8:58
 */

namespace backend\models;


use yii\db\ActiveRecord;
use yii\widgets\ActiveForm;

class Article_detail extends ActiveRecord{


    //获取文章附表得内容
    public function content(){
        return article_detail::find()->all();
    }

    //字段规则
    public function rules()
    {
        return [
            [['content'],'required']
        ];
    }

    public function attributeLabels()
    {
        return [
          'content'=>'内容'
        ];
    }
}