<?php

namespace backend\controllers;

use backend\models\GoodsCategory;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class GoodsCategoryController extends \yii\web\Controller
{

    //商品分类列表
    public function actionIndex()
    {
        //实例化模型,查询出数据库中所有的数据
        $model=GoodsCategory::find();
        $models =$model->orderBy(['tree'=>SORT_ASC,'lft'=>SORT_ASC])->all();
        return $this->render('index', ['models' => $models]);
    }

    //添加商品分类功能
    public function actionAdd()
    {
        $model = new GoodsCategory();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->parent_id == 0) {//判断上级分类ID是否是0
                //var_dump($model);exit;
                $model->makeRoot();//创建一级分类
                \Yii::$app->session->setFlash('success', '一级分类添加成功');
                return $this->refresh();//刷新本页
            } else {
                //创建非一级分类
                //查找父级分类
                $parent_category = GoodsCategory::findOne(['id' => $model->parent_id]);
                $model->prependTo($parent_category);
                \Yii::$app->session->setFlash('success', '分类添加成功');
            }

        }
        //var_dump($model);exit;
        $models = GoodsCategory::find()->asArray()->all();
        $models[] = ['id' => 0, 'parent_id' => 0, 'name' => '全部商品分类'];
        $models = Json::encode($models);
        return $this->render('add', ['model' => $model, 'models' => $models]);


    }


    //修改商品分类功能
    public function actionEdit($id)
    {
        $model = GoodsCategory::findOne(['id' => $id]);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            try {
                if ($model->parent_id == 0) {//判断上级分类ID是否是0
                    $model->makeRoot();//创建一级分类

                } else {
                    //创建非一级分类
                    //查找父级分类
                    $parent_category = GoodsCategory::findOne(['id' => $model->parent_id]);
                    $model->prependTo($parent_category);
                    \Yii::$app->session->setFlash('success', '分类修改成功');
                    return $this->refresh();//刷新本页
                }
            }catch(Exception $e){
                \Yii::$app->session->setFlash('danger',$e->getMessage());
                $model->addError('parent_id',$e->getMessage());
            }

        }
        $models = GoodsCategory::find()->asArray()->all();
        $models[] = ['id' => 0, 'parent_id' => 0, 'name' => '全部商品分类'];
        $models = Json::encode($models);
        return $this->render('add', ['model' => $model, 'models' => $models]);
    }

    //删除商品分类功能
    public function actionDelete($id){
        //根据ID查询出一条数据
        $model=GoodsCategory::findOne(['id'=>$id]);
        $model_son=GoodsCategory::findOne(['parent_id'=>$id]);
        //判断该分类下面是否有分类
        if(isset($model_son)){
            \Yii::$app->session->setFlash('success','对不起,该分类下面还有子孙分类,不能被删除');
            return $this->redirect(['goods-category/index']);
        }
        //调用模型的删除方法
        $model->delete();
        return $this->redirect(['goods-category/index']);
    }
}