<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/4/17
 * Time: 23:10
 */

namespace frontend\controllers;


use backend\models\Goods;
use frontend\models\Order;
use frontend\models\OrderDetail;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class TaskController extends Controller
{


    //清理超时并且未支付的订单
    public function actionClear(){
        //设置脚本可执行最大时间
        set_time_limit(0);
        while(true){
            //1.找出超时订单ID(超时条件:1.状态是1未支付  2.下单时间超过一个小时)
            //$time=time()-create_time>=3600
            $orders=Order::find()->select('id')->where(['status'=>1])->andWhere(['<','create_time',time()-3600])->asArray()->all();
            $ids=ArrayHelper::map($orders,'id','id');
            //修改订单状态
            Order::updateAll(['status'=>0],'status=1 and create_time < '.(time()-3600));

            //返库存
            foreach($ids as $id){
                //找出订单详情表中对应的数据
                $details=OrderDetail::find()->where(['order_info_id'=>$id])->all();
                //循环找出一个订单中商品ID对应的数量
                foreach($details as $detail){
                    //根据ID返回商品表中对应商品的数量
                    Goods::updateAllCounters(['stock'=>$detail->amount],'id='.$detail->goods_id);
                }
            }
            //间隔时间
            sleep(5);
        }

    }
}