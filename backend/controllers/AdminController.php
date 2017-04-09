<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\LoginForm;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\AccessFilter;


class AdminController extends \yii\web\Controller
{
    public function actionIndex(){
        //调用模型的静态方法,查询出所有的文章信息
        $query=Admin::find();
        //实例化分页工具条
        $pager=new Pagination([
            'totalCount'=>$query->count(),
            'pageSize'=>3,
        ]);
        //设置limit参数获取当前分页数据
        $models=$query->limit($pager->limit)->offset($pager->offset)->all();
        //把数据传递给视图
        return $this->render('index',['models'=>$models,'pager'=>$pager]);
    }

    //添加新管理员
    public function actionAdd(){
        $admin = new Admin();
        if ($admin->load(\Yii::$app->request->post())) {
            if ($admin->validate()) {
                // 实现数据入库操作
                $admin->created_at =time();
                $admin->password_hash = \Yii::$app->security->generatePasswordHash($admin->password_hash);
                $admin->auth_key=\Yii::$app->security->generateRandomString();
                $admin->save();
            //给用户添加角色
                $auth=\Yii::$app->authManager;
                foreach($admin->roles as $role){
                    $auth->assign($auth->getRole($role),$admin->id);
                }
                \Yii::$app->session->setFlash('success', '添加管理员成功');
                \Yii::$app->user->login($admin);
                //跳转页面
                return $this->redirect(['admin/index']);
            }
        }
        // 渲染添加新用户的表单
        return $this->render('add', ['admin' => $admin]);
    }

    //修改管理员
    public function actionEdit($id){
        $admin =Admin::findOne(['id'=>$id]);
        //获取用户的角色
        $auth=\Yii::$app->authManager;
        $role=$auth->getRolesByUser($id);
        $admin->roles=array_keys($role);
        if ($admin->load(\Yii::$app->request->post())) {
            if ($admin->validate()) {
                // 实现数据入库操作
                $admin->save();
                //给用户添加角色
                $auth=\Yii::$app->authManager;
                $auth->revokeAll($id);
                foreach($admin->roles as $role){
                    $auth->assign($auth->getRole($role),$admin->id);
                }
                \Yii::$app->session->setFlash('success', '修改管理员成功');
                //跳转页面
                return $this->redirect(['admin/index']);
            }
        }
        // 渲染添加新用户的表单
        return $this->render('add', ['admin' => $admin]);
    }

    //删除管理员
    public function actionDelete($id){
            $admin=Admin::findOne(['id'=>$id]);
            $auth=\Yii::$app->authManager;
            $auth->revokeAll($id);
            $admin->delete();
        \Yii::$app->session->setFlash('success', '删除管理员成功');
        //跳转页面
        return $this->redirect(['admin/index']);
    }

    //用户登录
    public function actionLogin()
    {
       $model=new LoginForm();

        if($model->load(\Yii::$app->request->post())){
            //验证输入的字段是否满足规则
            if($model->login()){
                //通过验证
                //从数据库中查询该用户的信息
                $id=\Yii::$app->user->id;
                $admin=Admin::findOne(['id'=>$id]);
                $admin->last_login_ip=$_SERVER['REMOTE_ADDR'];//保存当前IP
                $admin->last_login_time=time();
                $admin->save();
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('login',['model'=>$model]);
    }

    //用户注销
    public function actionLogout(){
        \Yii::$app->user->logout();
        \Yii::$app->session->setFlash('success','注销成功');
        return $this->redirect(['admin/login']);
    }
    //ACF
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessFilter::className(),
                'only' => ['logout', 'index','add'],

            ],
        ];
    }


}
