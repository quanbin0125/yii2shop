<?php


namespace backend\models;
use yii\base\Model;
use backend\models;
class LoginForm extends Model
{
    public $username;//用户名
    public $password_hash;//密码
    public $rememberMe = true;

    public function rules()
    {
        return [
            [['username','password_hash'],'required'],
            ['rememberMe', 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password_hash'=>'密码',

        ];
    }


    //登录
    public function login()
    {
        if($this->validate()){
            //先根据用户名查找用户
            $admin = Admin::findOne(['username'=>$this->username]);
            //找到用户过后再比对密码
            if($admin){
                //对比密码
                if(\Yii::$app->security->validatePassword($this->password_hash,$admin->password_hash)){
                    //保存用户信息到session
                    \Yii::$app->user->login($admin, $this->rememberMe ? 3600 * 24 * 7 : 0);
                    return true;
                }else{
                    //密码错误
                    $this->addError('password_hash','密码错误');
                }
            }else{
                //用户名不存在
                $this->addError('username','用户名不存在');
            }
        }
        return false;
    }

}


