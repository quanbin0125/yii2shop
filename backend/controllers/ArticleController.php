<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleDetail;
use yii\data\Pagination;
use yii\web\Request;

class ArticleController extends \yii\web\Controller
{
    public function actionIndex(){
        //调用模型的静态方法,查询出所有的文章信息
        $query=Article::find();
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

    //添加文章功能
    public function actionAdd(){
        //实例化模型
        $model=new Article();
        //实例化request,获取请求方式
        $request=new Request();
        //判断请求方式
        if($request->isPost){//是POST方式
            //通过POST方式,加载数据到模型
            $model->load($request->post());
            $detail=new ArticleDetail();
            $detail->content=$model->content;
            //验证字段是否符合字段规则
            if($model->validate() && $detail->validate()){
                //添加当前时间
                $model->inputtime=time();
                //保存数据
                $model->save();
                //实例化文章内容模型
                //将添加的内容和ID赋值给文章内容
                $detail->article_id=$model->id;


                    $detail->save();

                //通过session给用户一个执行"添加"操作成功后的提示信息
                \Yii::$app->session->setFlash('success','恭喜恭喜,添加文章成功');
                //如果保存数据成功,就跳转到列表页面
                return $this->redirect(['article/index']);
            }
        }
        //把数据传递到视图
        return $this->render('add',['model'=>$model]);
    }


    //修改文章功能
    public function actionEdit($id){
        //实例化模型
        $model=Article::findOne(['id'=>$id]);
        $model->content=$model->articleDetail->content;
        //实例化request,获取请求方式
        $request=new Request();
        //判断请求方式
        if($request->isPost){//是POST方式
            //通过POST方式,加载数据到模型
            $model->load($request->post());
            //根据ID查询文章内容中对应的数据
            $detail=ArticleDetail::findOne(['article_id'=>$id]);
            $detail->content=$model->content;

            //验证字段是否符合字段规则
            if($model->validate() && $detail->validate()){
                //保存数据
                $model->save();
                $detail->save();

                //通过session给用户一个执行"添加"操作成功后的提示信息
                \Yii::$app->session->setFlash('success','恭喜恭喜,修改文章成功');
                //如果保存数据成功,就跳转到列表页面
                return $this->redirect(['article/index']);
            }
        }
        //把数据传递到视图
        return $this->render('add',['model'=>$model]);
    }

        //删除文章
    public function actionDelete($id){
        //实例化模型
        $model=Article::findOne(['id'=>$id]);
        $detail=ArticleDetail::findOne(['article_id'=>$id]);
        $model->delete();
        $detail->delete();
        //跳转页面
        return $this->redirect(['article/index']);
    }
}
