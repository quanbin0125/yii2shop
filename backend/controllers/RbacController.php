<?php

namespace backend\controllers;

use backend\models\PermissionForm;
use backend\models\RoleForm;

class RbacController extends \yii\web\Controller
{
    //一丶权限列表
    public function actionPermissionIndex()
    {
        //实例化组件
        $auth = \Yii::$app->authManager;
        //获取所有的权限
        $permissions = $auth->getPermissions();
        // var_dump($permissions);exit;
        return $this->render('permissionIndex', ['permissions' => $permissions]);
    }

    //添加权限功能
    public function actionAddPermission()
    {
        //实例化表单模型
        $model = new PermissionForm();
        //加载数据和验证字段
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            //实例化组件
            $auth = \Yii::$app->authManager;
            //创建权限
            $permission = $auth->createPermission($model->name);
            //描述
            $permission->description = $model->description;
            //保存到数据表
            if ($auth->add($permission)) {
                //给用户一个添加成功的提示信息
                \Yii::$app->session->setFlash('success', $permission->description . '权限添加成功!');
                return $this->redirect(['rbac/permission-index']);
            };
        }
        //把数据传递给视图
        return $this->render('addPermission', ['model' => $model]);
    }

    //删除权限功能
    public function actionDeletePermission($name)
    {
        //实例化组件
        $auth = \Yii::$app->authManager;
        //根据权限名称查询出一条数据
        $permission = $auth->getPermission($name);
        //删除权限
        $auth->remove($permission);//删除方法中必须传一个对象进去,所有直接用权限名称来删除是不能的
        //给用户一个添加成功的提示信息
        \Yii::$app->session->setFlash('success', $permission->description . '权限删除成功!');
        return $this->redirect(['rbac/permission-index']);
    }


    //二丶角色列表
    public function actionRoleIndex()
    {
        //实例化组件
        $auth = \Yii::$app->authManager;
        //获取所有的角色
        $roles = $auth->getRoles();
        //把数据传递给视图
        return $this->render('roleIndex', ['roles' => $roles]);
    }
    //添加角色功能
    public function actionAddRole(){
        //实例化表单模型
        $model=new RoleForm();
        //指定场景
        $model->scenario=RoleForm::SCENARIO_ADD;
        //加载数据和验证字段
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            //实例化组件
            $auth = \Yii::$app->authManager;
            //创建角色
            $role = $auth->createRole($model->name);
            //描述
            $role->description = $model->description;
            //保存角色信息
            $auth->add($role);
            //给该角色保存权限
            foreach($model->permissions as $permission){
                //addChild中第二个参数是对象,所有使用getPermission()方法通过权限名称来获取对象
                $auth->addChild($role,$auth->getPermission($permission));
            }
            //给用户一个添加成功的提示信息
            \Yii::$app->session->setFlash('success', $role->description . '角色添加成功!');
            return $this->redirect(['rbac/role-index']);
        }
        //把数据传递给视图
        return $this->render('addRole',['model'=>$model]);
    }

    //修改角色功能
    public function actionEditRole($name){
        //实例化表单模型
        $model=new RoleForm();
        //实例化组件
        $auth=\Yii::$app->authManager;
        //获取需要修改的角色
        $role=$auth->getRole($name);
        //回显角色名称和描述
        $model->name=$role->name;
        $model->description=$role->description;
        //根据角色名称获取它有具有的权限
        $permissions=$auth->getPermissionsByRole($role->name);
        //直接获取数据的键名array_keys
        $model->permissions=array_keys($permissions);
        //var_dump($model->permissions);exit;
        //加载数据和验证字段
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            //实例化组件
            $auth = \Yii::$app->authManager;
            //描述
            $role->description = $model->description;
            //更新角色信息
            $auth->update($role->name,$role);
            //清空之前角色已经具有的权限
            $auth->removeChildren($role);
            //给该角色保存权限
            foreach($model->permissions as $permission){
                //addChild中第二个参数是对象,所有使用getPermission()方法通过权限名称来获取对象
                $auth->addChild($role,$auth->getPermission($permission));
            }
            //给用户一个添加成功的提示信息
            \Yii::$app->session->setFlash('success', $role->description . '角色修改成功!');
            return $this->redirect(['rbac/role-index']);
        }
        //把数据传递给视图
        return $this->render('addRole',['model'=>$model]);
    }

    //删除角色
    public function actionDeleteRole($name){
        //根据传过来的角色名称
        $role=\Yii::$app->authManager->getRole($name);
        \Yii::$app->authManager->remove($role);
        //给用户一个添加成功的提示信息
        \Yii::$app->session->setFlash('success', $role->description . '角色删除成功!');
        return $this->redirect(['rbac/role-index']);
    }



}
