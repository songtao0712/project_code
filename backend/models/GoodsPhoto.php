<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/13
 * Time: 22:30
 */
namespace backend\models;
use yii\db\ActiveRecord;

class GoodsPhoto extends ActiveRecord{

    public function rules()
    {
        return[
          [['goods_id','path'],'required'],
            ['goods_id','integer'],
            ['path','string']
        ];
    }

    public function attributeLabels()
    {
        return[
          'goods_id'=>'商品',
            'path'=>'图片地址'
        ];
    }
}