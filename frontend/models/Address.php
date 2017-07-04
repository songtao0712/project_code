<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $address
 * @property string $tel
 * @property integer $create_at
 * @property integer $update_at
 */
class Address extends \yii\db\ActiveRecord
{
//    public $district;
//    public $province;
//    public $city;
//    public $area;
    public $remember;

    public function setHasMany(){
        return $this->hasMany(Members::className(),['id'=>'member_id']);
    }

    //获取对应ID的收货地址
    public static function getAddressOption(){
        $data = self::findAll(['member_id'=>Yii::$app->user->getId()]);
        return $data;
    }

    public function getCityList($pid)
    {
        $model = Locations::findAll(array('parent_id'=>$pid));
        return ArrayHelper::map($model, 'id', 'name');
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','tel','address','province','city','area'],'required'],
            [['member_id', 'create_at', 'update_at'], 'integer'],
            [['address', 'tel'], 'string', 'max' => 255],
            [['remember'],'safe'],
            [['status'],'safe']
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'province'=>'省份',
            'city'=>'城市',
            'area'=>'区/县',
            'status'=>'状态',
            'remember'=>'默认地址',
            'district'=>'收货地址',
            'id' => '主键',
            'member_id' => '用户ID',
            'username'=>'收货人',
            'address' => '详细地址',
            'tel' => '联系电话',
            'create_at' => '创建时间',
            'update_at' => '修改时间',
        ];
    }
}
