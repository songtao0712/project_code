<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/8
 * Time: 18:43
 */

namespace backend\models;

use yii\db\ActiveRecord;


/**
 * This is the model class for table "article_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $sort
 * @property string $status
 * @property string $is_help
 */
class Category extends ActiveRecord{

    public function rules()
    {
        return [
            [['name','intro','sort','status','is_help'],'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '分类名',
            'intro' => '分类简介',
            'sort' => '排序',
            'status' => '状态',
            'is_help' => '类型',
        ];
    }

}