<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m170406_030303_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('菜单名称'),
            'parent_id'=>$this->integer(11)->comment('上级菜单'),
            'url'=>$this->string(50)->comment('路由'),
            'intro'=>$this->string(255)->notNull()->comment('简介'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menu');
    }
}
