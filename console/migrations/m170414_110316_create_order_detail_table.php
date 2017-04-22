<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_detail`.
 */
class m170414_110316_create_order_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order_detail', [
            'id' => $this->primaryKey(),
            'order_info_id'=>$this->integer(10)->notNull()->defaultValue(0)->comment('订单ID'),
            'goods_id'=>$this->integer(10)->notNull()->defaultValue(0)->comment('商品ID'),
            'goods_name'=>$this->string(32)->notNull()->comment('商品名称'),
            'logo'=>$this->string(255)->notNull()->comment('LOGO'),
            'price'=>$this->decimal(10,2)->notNull()->defaultValue(0.00)->comment('价格'),
            'amount'=>$this->integer(10)->notNull()->defaultValue(0)->comment('数量'),
            'total_price'=>$this->decimal(10,2)->notNull()->defaultValue(0.00)->comment('小计'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order_detail');
    }
}
