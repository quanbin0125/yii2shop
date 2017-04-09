<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\data\Pagination;
use yii\web\Request;
use yii\web\UploadedFile;
use xj\uploadify\UploadAction;


class BrandController extends \yii\web\Controller
{
    //首页品牌列表
    public function actionIndex(){
        //查询出状态值为0 .1 的数据
        $query=Brand::find()->where(['status'=>['0','1']]);
        //实例化分页工具类,指定总条数,每页显示的条数
        $pager=new Pagination([
            'totalCount'=>$query->count(),
            'pageSize'=>3,
        ]);
        //设置limit参数,获取当页数据
        $models=$query->limit($pager->limit)->offset($pager->offset)->all();
        //把数据传递到视图
        return $this->render('index',['models'=>$models,'pager'=>$pager]);
    }

    //添加品牌功能
    public function actionAdd(){
        //实例化表单模型
        $model=new Brand();
        //实例化request,获取请求方式
        $request=new Request(); //或者$request=\Yii::$app->request;
        //判断请求方式
        if($request->isPost){//是POST方式
            //通过POST方式 加载数据到模型
            $model->load($request->post());
            //处理图片
          //  $model->logo_file=UploadedFile::getInstance($model,'logo_file');
            //验证字段规则
            if($model->validate()){
                //判断是否上传图片
//                if($model->logo_file){
//                    //定义临时文件路径
//                    $fileName='upload/brand'.uniqid().'.'.$model->logo_file->extension;
//                    //判断是否上传成功,  第二个参数false表示不删除临时文件
//                    if($model->logo_file->saveAs($fileName,false)){
//                        $model->logo=$fileName;
//                    }
//                }
                //通过session给用户一个'添加'操作成功后的提示信息
                \Yii::$app->session->setFlash('success','恭喜恭喜,添加品牌成功!');
                //保存数据到数据库
                $model->save();
                //跳转页面
                return $this->redirect(['brand/index']);
            }

        }

        //把数据传递给视图
        return $this->render('add',['model'=>$model]);
    }


    //修改品牌功能
    public function actionEdit($id){
        //实例化表单模型
        $model=Brand::findOne(['id'=>$id]);
        //实例化request,获取请求方式
        $request=new Request(); //或者$request=\Yii::$app->request;
        //判断请求方式
        if($request->isPost){//是POST方式
            //通过POST方式 加载数据到模型
            $model->load($request->post());
            //处理图片
            $model->logo_file=UploadedFile::getInstance($model,'logo_file');
            //验证字段规则
            if($model->validate()){
                //判断是否上传图片
                if($model->logo_file){
                    //定义临时文件路径
                    $fileName='upload/brand'.uniqid().'.'.$model->logo_file->extension;
                    //判断是否上传成功,  第二个参数false表示不删除临时文件
                    if($model->logo_file->saveAs($fileName,false)){
                        $model->logo=$fileName;
                    }
                }
                //通过session给用户一个'修改'操作成功后的提示信息
                \Yii::$app->session->setFlash('success','恭喜恭喜,修改品牌成功!');
                //保存数据到数据库
                $model->save();
                //跳转页面
                return $this->redirect(['brand/index']);
            }

        }

        //把数据传递给视图
        return $this->render('add',['model'=>$model]);
    }

    //删除(数据库中还有数据,只是把状态值改为-1)品牌功能
    public function actionDelete($id){
        //根据ID查询品牌信息
        $model=Brand::findOne(['id'=>$id]);
        //调用模型上的方法删除
        $model->status='-1';
        //跳转页面
        $model->save();
        return $this->redirect(['brand/index']);
    }

    //回收站功能(接收状态值为 -1  的品牌)
    public function actionGarbage(){
        //查询出状态值为0 .1 的数据
        $query=Brand::find()->where(['status'=>'-1']);
        //实例化分页工具类,指定总条数,每页显示的条数
        $pager=new Pagination([
            'totalCount'=>$query->count(),
            'pageSize'=>3,
        ]);
        //设置limit参数,获取当页数据
        $models=$query->limit($pager->limit)->offset($pager->offset)->all();
        //把数据传递到视图
        return $this->render('garbage',['models'=>$models,'pager'=>$pager]);
    }

    //彻底删除品牌功能
    public function actionDeletes($id){

        //根据ID查询品牌信息
        $model=Brand::findOne(['id'=>$id]);
        //调用模型上的方法删除
        $model->delete();
        //跳转页面
        return $this->redirect(['brand/garbage']);
    }


    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload/brand',
                'baseUrl' => '@web/upload/brand',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                //'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
//                'format' => function (UploadAction $action) {
//                    $fileext = $action->uploadfile->getExtension();
//                    $filename = sha1_file($action->uploadfile->tempName);
//                    return "{$filename}.{$fileext}";
//                },
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png','gif'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    $action->output['fileUrl'] = $action->getWebUrl();
                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"

                },

            ],
        ];
    }




}
