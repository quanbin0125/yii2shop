<?php

namespace backend\controllers;

use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use backend\models\GoodsSearchForm;
use xj\uploadify\UploadAction;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\web\UploadedFile;


class GoodsController extends \yii\web\Controller{

    //商品首页
    public function actionIndex(){
        //搜索功能
        $model=new GoodsSearchForm();
        //调用模型的静态方法,查询出所有的文章信息
        $query=Goods::find();
        $model->load(\Yii::$app->request->get());
        //接收表单提交的查询参数
        $model->search($query);

        //实例化分页工具条
        $pager=new Pagination([
            'totalCount'=>$query->count(),
            'pageSize'=>3,
        ]);
        //设置limit参数获取当前分页数据
        $models=$query->limit($pager->limit)->offset($pager->offset)->all();
        //把数据传递给视图
        return $this->render('index',['models'=>$models,'pager'=>$pager,'model'=>$model]);
    }

    //添加商品功能
    public function actionAdd()
    {
        //实例化商品模型
        $model = new Goods();
        //实例化商品简介模型
        $intro = new GoodsIntro();
        //获取商品分类的数据
        $models = GoodsCategory::find()->asArray()->all();
        $models = Json::encode($models);
        //判断请求方式
        if ($model->load(\Yii::$app->request->post()) && $intro->load(\Yii::$app->request->post())) {
            //判断选择的商品分类是否是第三级
            if (GoodsCategory::findOne(['id' => $model->goods_category_id])->depth != 2) {
                \Yii::$app->session->setFlash('warning', '商品分类选择不对,请选择第三级分类');
                return $this->refresh();
            }
            //实例化goods_day_count的模型,添加商品的时候,往它里面添加一条数据
            $dayCount = new GoodsDayCount();
            //当前日期
            $day = date("Y-m-d");
            //判断添加的数据是否是当天的第一条数据
            $result = $dayCount->findOne(['day' => $day]);
            if ($result != null) {//当天已经有数据
                $result->count++;//给商品数字段+1
                $result->save();//保存数据到goods_day_count中
                $model->sn=date("Ymd").str_pad($result->count,4,0,STR_PAD_LEFT);//拼接保存货号
//                    $input = Alien;
//                    echo str_pad($input, 10, "-=", STR_PAD_LEFT);   produces "-=-=-Alien"
            } else {//当天没有数据
                $dayCount->count = 1;
                $dayCount->day = $day;
                $dayCount->save();
                //自动生成货号
                $model->sn=date("Ymd").str_pad($dayCount->count,4,0,STR_PAD_LEFT);
                //字符串补全
                //str_pad  substr
            }


            //保存商品对象
            $model->inputtime=time();
            if ($model->validate()) {
                $model->save();
                //保存商品信息对象
                $intro->goods_id = $model->id;
                if ($intro->validate()) {
                    $intro->save();
                    //提示信息，保存数据
                    \Yii::$app->session->setFlash('success', '添加商品成功');
                    //跳转页面
                    return $this->redirect(['goods/index','id'=>$model->id]);
                }


            }

        }
        //将数据传递给视图
        return $this->render('add', ['model' => $model, 'models' => $models,'intro'=>$intro]);

    }

    //修改商品功能
    public function actionEdit($id)
    {
        //实例化商品模型
        $model = Goods::findOne(['id'=>$id]);
        //实例化商品简介模型
        $intro = GoodsIntro::findOne(['goods_id'=>$id]);
        //获取商品分类的数据
        $models = GoodsCategory::find()->asArray()->all();
        $models = Json::encode($models);
        //判断请求方式
        if ($model->load(\Yii::$app->request->post()) && $intro->load(\Yii::$app->request->post())) {
            //判断选择的商品分类是否是第三级
            if (GoodsCategory::findOne(['id' => $model->goods_category_id])->depth != 2) {
                \Yii::$app->session->setFlash('warning', '商品分类选择不对,请选择第三级分类');
                return $this->refresh();
            }
            //实例化goods_day_count的模型,添加商品的时候,往它里面添加一条数据
            $dayCount = new GoodsDayCount();
            //当前日期
            $day = date("Y-m-d");
            //判断添加的数据是否是当天的第一条数据
            $result = $dayCount->findOne(['day' => $day]);
            if ($result != null) {//当天已经有数据
                $result->count++;//给商品数字段+1
                $result->save();//保存数据到goods_day_count中
                $model->sn=date("Ymd").str_pad($result->count,4,0,STR_PAD_LEFT);//拼接保存货号

//                    $input = Alien;
//                    echo str_pad($input, 10, "-=", STR_PAD_LEFT);   produces "-=-=-Alien"
            } else {//当天没有数据
                $dayCount->count = 1;
                $dayCount->day = $day;
                $dayCount->save();
                $model->sn=date("Ymd").str_pad($dayCount->count,4,0,STR_PAD_LEFT);
            }
            //保存商品对象
            $model->inputtime=time();
            if ($model->validate()) {
                $model->save();
                //保存商品信息对象
                $intro->goods_id = $model->id;
                if ($intro->validate()) {
                    $intro->save();
                    //提示信息，保存数据
                    \Yii::$app->session->setFlash('success', '添加商品成功');
                    //跳转页面
                    return $this->redirect(['goods/index']);
                }


            }

        }
        //将数据传递给视图
        return $this->render('add', ['model' => $model, 'models' => $models,'intro'=>$intro]);

    }


    //删除商品功能(第一次删除只是将status值改成0)
    public function actionDelete($id){
        //根据ID查询出对应的所有数据
        $model=Goods::findOne(['id'=>$id]);
        //将状态值改为0
        $model->status='0';
        //保存数据
        $model->save();
        //跳转到列表页面
        return $this->redirect(['goods/index']);
    }
    //回收站功能(接收状态值为 -1  的品牌)
    public function actionGarbage(){
        //查询出状态值为0 .1 的数据
        $query=Goods::find()->where(['status'=>'0']);
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
        $model=Goods::findOne(['id'=>$id]);
        //调用模型上的方法删除
        $model->delete();
        //跳转页面
        return $this->redirect(['goods/garbage']);
    }


    public function actionGallery()
    {
        $model = new GoodsGallery();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $model->img_file = UploadedFile::getInstances($model,'img_file');//4.实例化上传文件对象
            if($model->validate()){
                // $model->validate();
                //验证码只能验证一次
                //var_dump($model->getErrors());exit;
                $model->save(false);//验证码只能验证一次,关闭save方法的自动验证
                foreach($model->img_file as $img_file){
                    //if($model->img_file){
                    $fileName = 'upload/'.uniqid().'.'.$img_file->extension;
                    $img_file->saveAs($fileName,false);//5

                    \Yii::$app->db->createCommand()->insert('img',[
                        'student_id'=>$model->id,
                        'img'=>$fileName,
                    ])->query();
                    //$model->img = $fileName;
                    //echo '上传成功';
                    //exit;
                }



                //var_dump($model->getErrors());exit;

                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['goods-gallery/index']);
            }

        }


        return $this->render('add',['model'=>$model]);
    }





    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload/goods',
                'baseUrl' => '@web/upload/goods',
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
            'ueditor'=>[
                'class' => 'common\widgets\ueditor\UeditorAction',
                'config'=>[
                    //上传图片配置
                    'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ]
            ]
        ];
    }
}
