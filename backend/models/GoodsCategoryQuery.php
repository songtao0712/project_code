<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/11
 * Time: 21:24
 */

namespace backend\models;

use creocoder\nestedsets\NestedSetsBehavior;
use creocoder\nestedsets\NestedSetsQueryBehavior;
use yii\db\ActiveQuery;


class GoodsCategoryQuery extends ActiveQuery {

    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className()
        ];
    }

}