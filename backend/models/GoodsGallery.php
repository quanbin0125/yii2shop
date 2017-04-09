<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_gallery".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property string $path
 */
class GoodsGallery extends \yii\db\ActiveRecord
{
    public $getImgs;//保存文件上传对象
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_gallery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path'], 'required'],
            [['path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品ID',
            'path' => '商品图片地址',
        ];
    }
}
