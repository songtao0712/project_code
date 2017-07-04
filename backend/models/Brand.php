<?php

namespace backend\models;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property string $logo
 * @property integer $sort
 * @property integer $status
 */
class Brand extends ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $brand_logo;
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['name','intro','sort','status','logo'],'required'],
//            ['brand_logo','file','extensions'=>['jpg','png','gif'],'skipOnEmpty'=>false]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'name' => '品牌名字',
            'intro' => '品牌介绍',
            'logo' => '品牌logo',
            'sort' => '排序',
            'status' => '状态',
            'brand_logo'=>'品牌LOGO'
        ];
    }
}
