<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m170414_103722_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'member_id'=>$this->integer(11)->notNull()->comment('会员ID'),
            'name'=>$this->string(20)->notNull()->comment('收货人'),
            'provice_name'=>$this->string(30)->notNull()->comment('省份'),
            'city_name'=>$this->string(30)->notNull()->comment('城市'),
            'area_name'=>$this->string(30)->notNull()->comment('区县'),
            'detail_address'=>$this->string(40)->notNull()->comment('详细地址'),
            'tel'=>$this->char(11)->notNull()->comment('手机号'),
            'delivery_id'=>$this->integer(3)->notNull()->comment('配送方式的ID'),
            'delivery_name'=>$this->string(30)->notNull()->comment('配送方式的名字'),
            'delivery_price'=>$this->decimal(7,2)->notNull()->comment('运费'),
            'pay_type_id'=>$this->integer(3)->notNull()->comment('支付方式'),
            'pay_type_name'=>$this->string(30)->notNull()->comment('支付方式名字'),
            'price'=>$this->decimal(10,2)->notNull()->comment('商品金额'),
            'status'=>$this->integer(4)->notNull()->comment('订单状态'),
            //0 已取消   1待付款  2待发货  3 待收货  4  完成
            'trade_no'=>$this->char(30)->notNull()->comment('第三方支付的交易号'),
            'create_time'=>$this->integer(10)->notNull()->comment('添加时间'),

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order');
    }
}
