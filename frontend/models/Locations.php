<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/20
 * Time: 16:03
 */

namespace frontend\models;

use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Locations extends ActiveRecord {
    public $province;
    public $city;
    public $district;

    public static function getLocationOption($parent_id=0){
        $result = static::findAll(['parent_id'=>$parent_id]);
        return ArrayHelper::map($result,'id','name');
    }

    public function rules()
    {
        return [
          [['province','city','district'],'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'province'=>'province',
            'city'=>'city',
            'district'=>'district'
        ];
    }

}