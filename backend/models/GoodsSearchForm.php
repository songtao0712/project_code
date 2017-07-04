<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/14
 * Time: 11:18
 */
namespace backend\models;

use yii\base\Model;
use yii\db\ActiveQuery;

class GoodsSearchForm extends Model{
    public $name;
    public $sn;
    public $minPrice;
    public $maxPrice;

    public function rules()
    {
        return [
          ['name','string','max'=>50],
            ['sn','string'],
            ['minPrice','double'],
            ['maxPrice','double']
        ];
    }

    public function search(ActiveQuery $query){
        $this->load(\yii::$app->request->get());
        if($this->name){
            $query->andWhere(['like','name',$this->name]);
        }
        if($this->sn){
            $query->andWhere(['like','sn',$this->sn]);
        }
        if($this->minPrice){
            $query->andWhere(['<=','like','shop_price',$this->minPrice]);
        }
        if($this->maxPrice){
            $query->andWhere(['>=','like','shop',$this->maxPrice]);
        }
    }
}