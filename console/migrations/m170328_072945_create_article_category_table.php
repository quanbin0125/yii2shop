<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_category`.
 */
class m170328_072945_create_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('文章名称'),
            'intro'=>$this->text()->comment('简介'),
            'status'=>$this->integer(1)->defaultValue(1)->comment('状态'),
            'sort'=>$this->integer()->defaultValue(20)->comment('排序'),
            'is_help'=>$this->integer()->defaultValue(1)->comment('是否帮助相关的分类'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_category');
    }
}
