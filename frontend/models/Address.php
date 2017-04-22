<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $name
 * @property integer $member_id
 * @property string $provice
 * @property string $city
 * @property string $district
 * @property string $detail
 * @property integer $telephone
 */
class Address extends \yii\db\ActiveRecord
{

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
            [['name','provice', 'city', 'district', 'detail', 'telephone'], 'required'],
            [['telephone','member_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['provice', 'city', 'district', 'detail'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '* 收货人:',
            'provice' => '省份',
            'city' => '城市',
            'district' => '区/县',
            'detail' => '* 详细地址:',
            'telephone' => '* 联系号码:',
            'status'=>'默认地址',
            'member_id'=>'用户名'
        ];
    }
}
