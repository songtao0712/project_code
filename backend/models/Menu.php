<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $lable
 * @property integer $sort
 * @property integer $parent_id
 * @property string $url
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lable','sort'],'required'],
            [['parent_id','url'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID主键',
            'lable' => '路由名称',
            'sort' => '排序',
            'parent_id' => '上级菜单',
            'url' => '路由|地址',
        ];
    }
    //获取所有一级菜单
    public static function getParentMenuOption(){
        return ArrayHelper::map(self::find()->where(['parent_id'=>0])->all(),'id','lable');
    }

    //一对多
    public function getChildren()
    {
        return $this->hasMany(self::className(),['parent_id'=>'id']);
    }
}
