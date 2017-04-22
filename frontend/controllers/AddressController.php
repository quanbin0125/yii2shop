<?php

namespace frontend\controllers;

use frontend\models\Address;

class AddressController extends \yii\web\Controller
{
    public $layout='address';
    public $enableCsrfValidation=false;
    //添加新地址
    public function actionAdd()
    {
        $model = new Address();
        $address = Address::find()->all();
        if ($model->load(\Yii::$app->request->post())) {
            //var_dump($model->getErrors());exit;
            $model->provice = $_POST['provice'];
            $model->city = $_POST['city'];
            $model->district = $_POST['district'];
            //$model->save();
            //var_dump($model);exit;
            if ($model->validate()) {
                if ($model->status) {
                    $status = Address::findOne(['status' => 1]);
                    $status->status = 0;
                    $model->status = 1;
                }
            }
            $model->member_id = \Yii::$app->user->id;
            //var_dump($model);exit;
            $model->save();
            //var_dump($model->telephone);exit;
            \Yii::$app->session->setFlash('success', '添加地址成功');
            return $this->refresh();
        }
        //var_dump($model);exit;
        return $this->render('index', ['model' => $model, 'address' => $address]);
    }

    //修改地址
    public function actionEdit($id){
        $model=Address::findOne(['id'=>$id]);
        $address=Address::find()->all();
        if($model->load(\Yii::$app->request->post())){
            //var_dump($model->getErrors());exit;
            $model->provice=$_POST['provice'];
            $model->city=$_POST['city'];
            $model->district=$_POST['district'];
            //var_dump($model);exit;
            if($model->validate()) {
                if ($model->status) {
                    $statuss = Address::find()->where(['status' => 1])->all();
                    foreach ($statuss as $status) {
                        $status->status = 0;
                        $status->update();
                    }
                    $model->status = 1;
                }
                $model->member_id = \Yii::$app->user->id;
                $model->save();
                //var_dump($model);exit;
                \Yii::$app->session->setFlash('success', '修改地址成功');
                return $this->refresh();
            }
            //var_dump($model);exit;

        }
        return $this->render('index',['model'=>$model,'address'=>$address]);
    }

}
