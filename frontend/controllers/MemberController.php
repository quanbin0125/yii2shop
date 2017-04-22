<?php

namespace frontend\controllers;

use frontend\models\LoginForm;
use frontend\models\Member;



class MemberController extends \yii\web\Controller{
    public $layout='login';//指定布局文件
    public $enableCsrfValidation=false;
    //public $layout='';//指定布局文件
    //用户列表
    public function actionIndex(){
        $models=Member::find()->all();
        return $this->render('index',['models'=>$models]);
    }
    //用户注册功能
    public function actionRegister(){
        //实例化模型
        $model=new Member();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //实现数据入库操作
            $model->add_time=time();
            $model->last_login_time=time();
            $model->last_login_ip=ip2long($_SERVER['REMOTE_ADDR']);
            $model->password_hash =\Yii::$app->security->generatePasswordHash($model->password_hash);
            $model->auth_key=\Yii::$app->security->generateRandomString();
            $model->save(false);
            //var_dump($model->errors);exit;
            \Yii::$app->session->setFlash('success', '注册成功');
            //保存数据之后自动登录
            \Yii::$app->user->login($model);
            //跳转页面
            return $this->redirect(['member/index']);
        }
        //var_dump($model->errors);exit;
        //把数据传递给视图
        return $this->render('register',['model'=>$model]);
    }

    //用户登录功能
    public function actionLogin(){
        //实例化模型
        $model=new LoginForm();
        if($model->load(\Yii::$app->request->post())) {
            //如果通过验证,证实输入的用户信息正确,就从数据库中查询出该用户信息
            if ($model->login()) {
                $id = \Yii::$app->user->id;
                $member = Member::findOne(['id' => $id]);
                //var_dump($member);exit;
                $member->last_login_time = time();
                $member->last_login_ip = ip2long($_SERVER['REMOTE_ADDR']);
                $member->save(false);
                //var_dump($member);exit;
                \Yii::$app->session->setFlash('success', '登录成功');
                return $this->redirect(['member/index']);
            }
        }
        //把数据传递给视图
        return $this->render('login',['model'=>$model]);

    }

    //手机短信验证功能
    public function actionSms(){
        //生成短信验证码
        $telephone=\Yii::$app->request->post('telephone');
        //随机生成短信验证码
        $code=rand(1000,9999);
        //把手机号码和对应的验证码保存在SESSION中
        \Yii::$app->session->set('telephone_'.$telephone,$code);
        Member::getTest();

        return [
            'err_code'=>0,
            'msg'=>'短信发送成功'
        ];
    }


}
