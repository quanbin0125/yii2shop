<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/4/18
 * Time: 11:26
 */

namespace frontend\controllers;


use frontend\models\Member;
use yii\helpers\Json;
use yii\web\Controller;

class ApiController extends Controller
{

    //登录
    public function actionLogin(){
        $result=[
            "success"=>false,
            "errorMsg"=>"",
            "result"=>[]
        ];

        $username=\Yii::$app->request->get('username');
        $pwd=\Yii::$app->request->get('pwd');
        $member=Member::findOne(['username'=>$username]);
        //对比密码
        if($member){//用户存在
            if(\Yii::$app->security->validatePassword($pwd,$member->password_hash)){//密码也对
                //登录成功
                \Yii::$app->user->login($member);
                $result['success']=true;
                $result['result']=[
                    "id"=>$member->id,
                    "userName"=>$member->username,
                    "userIcon"=>\Yii::getAlias('@web')."/images/crazy1.jpg",
                    "waitPayCount"=>2,
                    "waitReceiveCount"=>2,
                    "userLevel"=>5
                ];
            }
        }
        $result['errorMsg']=',登录失败!用户名或者密码错误!';
        return Json::encode($result);
    }

    //首页
    public function actionBanner(){
        //adkind=1  adkind=2
        $adkind=\Yii::$app->request->get('adkind');
        $result=[
            "success"=>false,
            "errorMsg"=>"",
            "result"=>[
                "id"=>1,
                "type"=>1,
                "adUrl"=>\Yii::getAlias('@web')."/images/crazy1.jpg",
                "webUrl"=>"http://www.baidu.com",
                "adKind"=>$adkind

            ]
        ];
        return Json::encode($result);

    }
    //秒杀商品

    public function actionSeckill(){
        $result=[
            "success"=>true,
            "errorMsg"=>"",
            "result"=>[
                "total"=>3,
                "rows"=>[
                    [
                        "allPrice"=>999,
                        "pointPrice"=>998,
                        "iconUrl"=>\Yii::getAlias('@web')."/images/crazy1.jpg",
                        "timeLeft"=>30,
                        "type"=>2,
                        "productId"=>1
                    ]
                ]
            ]
        ];
        return Json::encode($result);
    }
    //猜你喜欢

    public function actionGetYourFav(){
        $result=[
            "success"=>true,
            "errorMsg"=>"",
            "result"=>[
                "total"=>3,
                "rows"=>[
                    [
                        "price"=>1988,
                        "name"=>"法拉利",
                        "iconUrl"=>\Yii::getAlias('@web')."/images/crazy2.jpg",
                        "productId"=>1
                    ]
                ]
            ]
        ];
        return Json::encode($result);
    }
}