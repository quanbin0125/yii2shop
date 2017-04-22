<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/4/9
 * Time: 15:26
 */

namespace frontend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $username;//登录用户名
    public $password_hash;//登录密码
    public $rememberMe = true;//是否保存信息
    public $code;//验证码

    //定义字段规则
    public function rules()
    {
        return [
            [['username', 'password_hash', 'code'], 'required'],
            ['rememberMe', 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名：',
            'password_hash' => '密码：',
            'code' => '验证码：',
            'rememberMe' => '保存登录信息',
        ];
    }

    //登录功能
    public function login()
    {
        //判断字段规则
        if ($this->validate()) {
            //通过之后.根据输入的用户名去数据库中查找用户
            $member = Member::findOne(['username' => $this->username]);
            //var_dump($member);exit;
            //如果有用户名相同的用户,就对比密码是否一致
            if ($member) {
                //var_dump($model);exit;
                if (\Yii::$app->security->validatePassword($this->password_hash, $member->password_hash)) {
                    //如果密码也一致,就保存用户信息到SESSION中
                    \Yii::$app->user->login($member,$this->rememberMe ? 3600 * 27 * 3 : 0);
                    return true;
                } else {
                    //密码错误
                    $this->addError('password_hash', '密码错误');
                }
            } else {
                //用户名错误
                $this->addError('username', '用户名错误');
            }
        }
        return false;
    }
}