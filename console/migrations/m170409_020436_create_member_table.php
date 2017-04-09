<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member`.
 */
class m170409_020436_create_member_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('member', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'tel'=>$this->char(11)->notNull()->comment('手机号码'),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'add_time' => $this->integer()->notNull(),
            'last_login_time' => $this->integer(),
            'last_login_ip' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('member');
    }
}
