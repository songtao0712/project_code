<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sn
 * @property string $logo
 * @property integer $goods_category_id
 * @property integer $brand_id
 * @property string $market_price
 * @property string $shop_price
 * @property integer $stock
 * @property integer $is_on_sale
 * @property integer $status
 * @property integer $sort
 * @property integer $create_time
 */
class Goods extends \yii\db\ActiveRecord
{
    public function getBrand(){
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['sn','safe'],
            [['goods_category_id', 'brand_id', 'stock', 'is_on_sale', 'status', 'sort', 'create_time'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name', 'logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'sn' => '商品编号',
            'logo' => '商品LOGO',
            'goods_category_id' => '分类',
            'brand_id' => '品牌ID',
            'market_price' => '市场价格',
            'shop_price' => '商品价格',
            'stock' => '库存',
            'is_on_sale' => '是否在售',
            'status' => '状态',
            'sort' => '排序',
            'create_time' => '添加时间',
        ];
    }

    public static function getBrandOptions(){
        return ArrayHelper::map(Brand::find()->asArray()->all(),'id','name');
    }
    //获取相册的数据
    public function getGoodsPhotoOption(){
        return ArrayHelper::map(GoodsPhoto::find()->asArray()->all(),'goods_id','goods_photo');
    }

    //获取所有的分类数据
    public static function getGoodsCategoryOptions(){
        return ArrayHelper::map(GoodsCategory::find()->orderBy(['tree'=>'DESC','lft'=>'ASC'])->asArray()->all(),'id','name');
    }
    //设置一对一的关系
    public function getGalleries(){
        return $this->hasMany(GoodsPhoto::className(), ['goods_id' =>'id']);
    }
}
