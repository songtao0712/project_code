<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/9
 * Time: 19:34
 */
namespace backend\models;

use yii\db\ActiveRecord;

class Article extends ActiveRecord{

    //获取所有分类数据
    public function cate(){
        return Category::find()->all();
    }

    public function rules()
    {
        return [
            [['name','intro','category_id','sort','status'],'required'],

        ];
    }

    public function attributeLabels()
    {
        return [
          'name'=>'标题',
            'intro'=>'简介',
            'category_id'=>'分类',
            'sort'=>'排序',
            'status'=>'状态',
//            'content'=>'内容'
        ];
    }
}