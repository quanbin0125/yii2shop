<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m170402_014830_create_admin_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('admin', [
            'id' => $this->primaryKey(),
            'username'=>$this->string(50)->notNull()->comment('用户名'),
            'password'=>$this->char(32)->notNull()->comment('密码'),
            'salt'=>$this->char(6)->notNull()->comment('盐'),
            'email'=>$this->string(30)->notNull()->comment('邮箱'),
            'token'=>$this->string(32)->notNull()->comment('自动登录令牌'),
            'token_create_time'=>$this->integer(10)->comment('令牌创建时间'),
            'add_time'=>$this->integer(11)->notNull()->comment('注册时间'),
            'last_login_time'=>$this->integer(11)->notNull()->comment('最后登录时间'),
            'last_login_ip'=>$this->string(15)->comment('最后登录IP'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('admin');
    }
}
