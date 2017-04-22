<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $name
 * @property string $provice_name
 * @property string $city_name
 * @property string $area_name
 * @property string $detail_address
 * @property string $tel
 * @property integer $delivery_id
 * @property string $delivery_name
 * @property string $delivery_price
 * @property integer $pay_type_id
 * @property string $pay_type_name
 * @property string $price
 * @property integer $status
 * @property string $trade_no
 * @property integer $create_time
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'delivery_id', 'pay_type_id', 'status', 'create_time'], 'integer'],
            [['name'], 'required'],
            [['delivery_price', 'price'], 'number'],
            [['name'], 'string', 'max' => 20],
            [['provice_name', 'city_name', 'area_name', 'delivery_name', 'pay_type_name', 'trade_no'], 'string', 'max' => 30],
            [['detail_address'], 'string', 'max' => 40],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '会员ID',
            'name' => '收货人',
            'provice_name' => '省份',
            'city_name' => '城市',
            'area_name' => '区县',
            'detail_address' => '详细地址',
            'tel' => '手机号',
            'delivery_id' => '配送方式的ID',
            'delivery_name' => '配送方式的名字',
            'delivery_price' => '运费',
            'pay_type_id' => '支付方式',
            'pay_type_name' => '支付方式名字',
            'price' => '商品金额',
            'status' => '订单状态',
            'trade_no' => '第三方支付的交易号',
            'create_time' => '添加时间',
        ];
    }

    //快递方式
    public static $deliveries=[
        1=>['顺丰快递','20','速度非常快,服务好'],
        2=>['申通快递','21','速度非常快,服务好'],
        3=>['圆通快递','22','速度非常快,服务好'],
        4=>['EMS快递','23','速度非常快,服务好'],
    ];

    //支付方式
    public static $payments=[
        1=>['货到付款','送货上门后再收款，支持现金、POS机刷卡、支票支付'],
        2=>['在线支付','即时到帐，支持绝大数银行借记卡及部分银行信用卡'],
        3=>['上门自提','自提时付款，支持现金、POS刷卡、支票支付'],
        4=>['邮局汇款','通过快钱平台收款 汇款后1-3个工作日到账'],
    ];
}
