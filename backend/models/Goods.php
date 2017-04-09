<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property string $sn
 * @property string $logo
 * @property integer $goods-category_id
 * @property integer $brand_id
 * @property string $market_price
 * @property string $shop_price
 * @property integer $stock
 * @property integer $is_on-sale
 * @property integer $status
 * @property integer $sort
 * @property integer $inputtime
 */
class Goods extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public $logo_file;//定义上传文件对象
    public static $status_options=['1'=>'正常','0'=>'回收站'];//定义商品状态对象
    public static $is_on_sale_options=['1'=>'是','0'=>'否'];//定义商品上架

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
            [['name','logo', 'goods_category_id', 'brand_id', 'market_price', 'shop_price', 'stock', 'is_on_sale', 'status', 'sort'], 'required'],
            [['goods_category_id', 'brand_id', 'stock', 'is_on_sale', 'status', 'sort'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['logo'], 'string', 'max' => 255],
            [['logo_file'], 'file','extensions'=>['jpg','png','gif']],
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
            //'sn' => '货号',
            //'logo' => '商品LOGO',
            'goods_category_id' => '商品分类',
            'brand_id' => '品牌',
            'market_price' => '市场价格',
            'shop_price' => '本店价格',
            'stock' => '库存',
            'is_on_sale' => '是否上架',
            'status' => '状态',
            'sort' => '排序',
            'inputtime' => '录入时间',
            'content'=>'商品描述',
        ];
    }

    //关联品牌分类
    public function getBrand()
    {

        /**
         * hasOne参数 1. 关联对象的类名
         * 参数2 [key=>value] key 表示关联对象的主键  value 表示关联对象在当前对象的字段
         */
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    }

    //定义分类
    public static function getBrandOptions()
    {
        //第一种找到分类id和分类name
        $brands = Brand::find()->asArray()->all();


        return  ArrayHelper::map($brands,'id','name');
    }


    //关联商品分类
    public function getGoodsCategory()
    {

        /**
         * hasOne参数 1. 关联对象的类名
         * 参数2 [key=>value] key 表示关联对象的主键  value 表示关联对象在当前对象的字段
         */
        return $this->hasOne(GoodsCategory::className(),['id'=>'goods_category_id']);
    }

    //定义分类
    public static function getGoodsCategoryOptions()
    {
        //第一种找到分类id和分类name
        $goodsCategory=GoodsCategory::find()->asArray()->all();


        return  ArrayHelper::map($goodsCategory,'id','name');
    }


    /*
     * 商品和相册关系 1对多
     */
    public function getGallerys()
    {
        return $this->hasMany(GoodsGallery::className(),['goods_id'=>'id']);
    }

}
