<?php

namespace frontend\models;

use Yii;
use yii\web\IdentityInterface;

use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $email
 * @property string $tel
 * @property integer $status
 * @property integer $add_time
 * @property integer $last_login_time
 * @property integer $last_login_ip
 */
class Member extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $password;//明文密码
    public $code;//验证码
    public $smscode;//短信验证码
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','password_hash', 'email', 'telephone','code','smscode'], 'required'],
            [['status', 'add_time', 'last_login_time', 'last_login_ip'], 'integer'],
            [['username', 'password_hash', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['telephone'], 'string', 'max' => 11],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['email'], 'email'],
            ['code','captcha'],
            //验证短信验证码
            ['smscode','validateSmscode'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名：',
            'auth_key' => 'Auth Key',
            'password_hash' => '密码：',
            'email' => '邮箱：',
            'telephone' => '手机号码：',
            //'status' => '状态',

            'add_time' => 'Add Time',
            'last_login_time' => 'Last Login Time',
            'last_login_ip' => 'Last Login Ip',
            'smscode' => '短信验证码：',
            'code'=>'验证码',

        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id'=>$id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key===$authKey;
    }


    public function validateSmscode()
    {
        //根据电话号码从session获取短信验证码
        $code = Yii::$app->session->get('telephone_'.$this->telephone);
        //和表单提交的短信验证码对比
        if($code != $this->smscode){
            $this->addError('smscode','验证码不正确');
        }
    }

    public static function getTest()
    {
        // 配置信息
        $config = [
            'app_key' => '23746798',
            'app_secret' => '2c718f8d2b2b6d3ceb87360fdea8ce09',
            // 'sandbox'    => true,  // 是否为沙箱环境，默认false
        ];
        // 使用方法一
        $client = new Client(new App($config));
        $req = new AlibabaAliqinFcSmsNumSend;

        $req->setRecNum('18583778627')
            ->setSmsParam([
                'code' => rand(1000, 9999),
                'name'=>'陈奕迅'
            ])
            ->setSmsFreeSignName('全彬')
            ->setSmsTemplateCode('SMS_60845091');
        $resp = $client->execute($req);
    }
}
