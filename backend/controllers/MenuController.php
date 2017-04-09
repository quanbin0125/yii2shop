<?php

namespace backend\controllers;

use backend\models\Menu;

class MenuController extends \yii\web\Controller
{
    public function actionIndex(){
        $models=Menu::find()->where(['parent_id'=>0])->all();
        //var_dump($models);exit;
        return $this->render('index',['models'=>$models]);
    }

    //添加菜单功能
    public function actionAdd(){
        //实例化模型
        $model=new Menu();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
                $model->save();
                \Yii::$app->session->setFlash('success','恭喜你,添加菜单成功!');
                return $this->redirect(['menu/index']);
        }
        //把数据传递给视图
        return $this->render('add',['model'=>$model]);
    }

}
