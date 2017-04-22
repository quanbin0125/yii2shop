<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cart`.
 */
class m170414_061615_create_cart_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cart', [
            'id' => $this->primaryKey(),
            'member_id'=>$this->integer(10)->notNull()->comment('用户名'),
            'goods_id'=>$this->integer(10)->notNull()->comment('商品'),
            'amount'=>$this->integer(10)->notNull()->comment('数量'),

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cart');
    }
}
