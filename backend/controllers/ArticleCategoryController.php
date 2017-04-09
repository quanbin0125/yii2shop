<?php

namespace backend\controllers;

use backend\models\ArticleCategory;
use yii\data\Pagination;
use yii\web\Request;

class ArticleCategoryController extends \yii\web\Controller
{
    //首页文章分类列表
    public function actionIndex(){
        //通过模型查询出数据库中所有的数据
        $query=ArticleCategory::find();
//        var_dump($models);exit;
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

    //添加文章分类功能
    public function actionAdd(){
        //实例化表单模型
        $model=new ArticleCategory();
        //实例化request,获取请求方式
        $request=new Request();
        //判断请求方式
        if($request->isPost){//是POST方式
            //通过POST方式,加载数据到模型
            $model->load($request->post());
            //验证字段是否符合字段规则
            if($model->validate()){
                //保存数.据
                $model->save();
                //通过session给用户一个执行"添加"操作成功后的提示信息
                \Yii::$app->session->setFlash('success','恭喜恭喜,添加文章分类成功');
                //如果保存数据成功,就跳转到列表页面
                return $this->redirect(['article-category/index']);
            }
        }
        //把数据传递到视图
        return $this->render('add',['model'=>$model]);
    }

    //修改文章分类功能
    public function actionEdit($id){
        //实例化表单模型
        $model=ArticleCategory::findOne(['id'=>$id]);
        //实例化request,获取请求方式
        $request=new Request();
        //判断请求方式
        if($request->isPost){//是POST方式
            //通过POST方式,加载数据到模型
            $model->load($request->post());
            //验证字段是否符合字段规则
            if($model->validate()){
                //保存数.据
                $model->save();
                //通过session给用户一个执行"添加"操作成功后的提示信息
                \Yii::$app->session->setFlash('success','恭喜恭喜,修改文章分类成功');
                //如果保存数据成功,就跳转到列表页面
                return $this->redirect(['article-category/index']);
            }
        }
        //把数据传递到视图
        return $this->render('add',['model'=>$model]);
    }

    //删除文章分类功能
    public function actionDelete($id){
        //根据ID查询出一条数据
        $model=ArticleCategory::findOne(['id'=>$id]);
        //判断该分类下面是否有文章
        if($model->articles){
            \Yii::$app->session->setFlash('success','对不起,该分类下面还有文章,不能被删除');
            return $this->redirect(['article-category/index']);
        }
        //调用模型的删除方法
        $model->delete();
        return $this->redirect(['article-category/index']);
    }
}
