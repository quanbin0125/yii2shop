<?php

namespace frontend\controllers;



use backend\models\Goods;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Order;
use frontend\models\OrderDetail;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\HttpException;


class OrderController extends \yii\web\Controller
{
    //权限
    public function behaviors()
    {
        return [
            'access'=>[
                'class'=>AccessControl::className(),
                'only'=>['index','add'],
                'rules'=>[
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index','add'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public $enableCsrfValidation=false;
    public $layout='order';

    //订单页面
    public function actionIndex(){
        //收货地址
        $addresss=Address::find()->where(['member_id'=>\Yii::$app->user->id])->all();
        //购物车数据
        $carts=Cart::find()->where(['member_id'=>\Yii::$app->user->id])->all();


        $data=$_POST;
        //var_dump($data);exit;
        $order=new Order();
        $orderDetail=new OrderDetail();
        //判断提交方式
        if(\Yii::$app->request->isPost){
            //获取订单用户ID
            $order->member_id=\Yii::$app->user->id;
            //var_dump($_POST);exit;

            //获取配送地址信息
            $address=Address::findOne(['id'=>\Yii::$app->request->post('address_id'),'member_id'=>$order->member_id]);
            if($address==null){
                throw new HttpException('404','地址不存在');
            }
            //将地址信息保存到订单对应的信息中
            $order->name=$address->name;
            $order->provice_name=$address->provice;
            $order->city_name=$address->city;
            $order->area_name=$address->district;
            $order->detail_address=$address->detail;
            $order->tel=$address->telephone;
            $order->delivery_id=$data['delivery_id'];
            //var_dump($order);exit;
            //验证字段
            if($order->validate()){
                $order->delivery_name=Order::$deliveries[$order->delivery_id][0];
                $order->delivery_price=Order::$deliveries[$order->delivery_id][1];
                $order->pay_type_id=$data['pay_type_id'];
                $order->pay_type_name=Order::$payments[$data['pay_type_id']][0];
                $order->price=0;
                $order->status=1;
                $order->create_time=time();
                $order->save();
                //var_dump($order->errors);exit;
                //开启事务,验证库存
                $db=\Yii::$app->db;
                $transaction=$db->beginTransaction();
                try {
                    //var_dump($order);exit;
                    $order->save();
                    //var_dump($order->errors);exit;
                    //订单详情表数据
                    //购物车数据
                    $carts = Cart::find()->where(['member_id' => \Yii::$app->user->id])->all();
                    foreach ($carts as $cart) {
                        $_orderDetail = clone $orderDetail;
                        $_orderDetail->order_info_id = $order->id;
                        $_orderDetail->goods_id = $cart->goods->id;
                        $_orderDetail->goods_name = $cart->goods->name;
                        $_orderDetail->logo = $cart->goods->logo;
                        $_orderDetail->price = $cart->goods->shop_price;
                        $_orderDetail->amount = $cart->amount;
                        if ($cart->goods->stock < $_orderDetail->amount) {
                            \Yii::$app->session->setFlash('danger', '商品库存不足,请购买其他产品');
                            throw new Exception('商品库存不足');
                        }
                        $good = Goods::findOne(['id' => $_orderDetail->goods_id]);
                        $good->stock -= $_orderDetail->amount;
                        $good->save();
                        $_orderDetail->total_price = ($_orderDetail->price) * ($_orderDetail->amount);

                        $_orderDetail->save();
                        $cart->delete();
                    }
                    $transaction->commit();//提交数据库操作
                }catch(Exception $e){
                    $transaction->rollBack();
                }
                //事务  解决库存不足,需要回滚
            }
            //var_dump($order->errors);exit;
            \Yii::$app->session->setFlash('success', '提交订单成功');
        }


        return $this->render('index',['addresss'=>$addresss,'carts'=>$carts]);
    }


}
