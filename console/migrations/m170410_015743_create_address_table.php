<?php

use yii\db\Migration;

/**
 * Handles the creation of table `address`.
 */
class m170410_015743_create_address_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('收货人'),
            'member_id'=>$this->integer(11)->notNull()->comment('用户名'),
            'provice'=>$this->string(255)->notNull()->comment('省份'),
            'city'=>$this->string(255)->notNull()->comment('城市'),
            'district'=>$this->string(255)->notNull()->comment('区/县'),
            'detail'=>$this->string(255)->notNull()->comment('详细地址'),
            'telephone'=>$this->integer(11)->notNull()->comment('联系号码'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('address');
    }
}
