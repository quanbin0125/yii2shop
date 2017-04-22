<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/4/11
 * Time: 11:07
 */

namespace frontend\controllers;

use backend\models\Goods;
use frontend\models\Cart;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Cookie;


class IndexController extends Controller
{
    public $enableCsrfValidation=false;
    public $layout='index';

    //前台首页
    public function actionIndex(){

        return $this->render('index');
    }

    //商品分类列表
    public function actionList(){
        $this->layout='list';
        $id=$_GET['id'];
        //得到所有商品
        $goodses=Goods::find()->all();
        return $this->render('list',['id'=>$id,'goodses'=>$goodses]);
    }

    //商品列表
    public function actionGoods(){
        $this->layout='goods';
        $id=$_GET['id'];
        $goodss=Goods::findOne(['id'=>$id]);
        return $this->render('goods',['id'=>$id,'goodss'=>$goodss]);
    }

    //提示功能
    public function actionNotice(){
        $goods_id=\Yii::$app->request->post('goods_id');
        $amount=\Yii::$app->request->post('amount');
        if(\Yii::$app->user->isGuest){  //未登录用户
            //将购物车cookie取出
            $cookies = \Yii::$app->request->cookies;
            $cookie = $cookies->get('cart');
            if($cookie == null){//购物车cookie不存在
                $cart = [];
            }else{  //购物车cookie存在
                $cart = unserialize($cookie);
            }
            //将商品保存到购物车cookie
            if(key_exists($goods_id,$cart)){// 购物车中有商品
                $cart[$goods_id] += $amount;
            }else{//购物车中没有商品
                $cart[$goods_id] = $amount;
            }
            $cookies = \Yii::$app->response->cookies;
            $cookie = new Cookie([
                'name'=>'cart',
                'value'=>serialize($cart)
            ]);
            $cookies->add($cookie);
        }else{  //已登录用户
            $model = new Cart();
            $one = $model->findOne(['goods_id'=>$goods_id]);
            //判断新添加的商品在cart表里是否有数据
            if(isset($one)){
                $one->amount += $amount;
                $one->save();
            }else{
                $model->goods_id = $goods_id;
            $model->amount = $amount;
            $model->member_id = \Yii::$app->user->id;
            if($model->validate()){
                $model->save();
            }
        }
        }
        return $this->redirect(['index/cart']);
    }

        //购物车页面
    public function actionCart()
    {
        $this->layout = 'cart';
        //未登录的时候
        if (\Yii::$app->user->isGuest) {
            $cookies = \Yii::$app->request->cookies;
            $cookie = $cookies->get('cart');
            if ($cookie == null) {
                $cart = [];
            } else {
                $cart = unserialize($cookie->value);
            }
            $goods = [];
            foreach ($cart as $id => $num) {
                $good = Goods::find()->where(['id' => $id])->asArray()->one();
                $good['amount'] = $num;
                $goods[] = $good;
            }
             }else{//登录时
                $cart = Cart::find()->where(['member_id' => \Yii::$app->user->id])->asArray()->all();

                $goods = [];

                foreach ($cart as $id => $num) {
                    $good = Goods::find()->where(['id' => $num['goods_id']])->asArray()->one();
                    $good['amount'] = $num['amount'];
                    $goods[] = $good;
                }
                //var_dump($goods);exit;


        }
        return $this->render('cart', ['goods' => $goods]);
    }

    /*
     * 修改购物车商品数量
     * $filter = modify   del
     */
    public function actionAjax($filter)
    {
        switch ($filter){
            case 'modify':
                //修改商品数量 goods_id  num
                $goods_id = \Yii::$app->request->post('goods_id');
                $num = \Yii::$app->request->post('num');

                if(\Yii::$app->user->isGuest){

                    \Yii::$app->cartCookie->updateCart($goods_id,$num)->save();
                }
                return 'success';
                break;

            case 'del':
                //删除商品
                $goods_id = \Yii::$app->request->post('goods_id');

                if(\Yii::$app->user->isGuest){

                    \Yii::$app->cartCookie->delCart($goods_id)->save();
                    return 'success';
                }
                break;
        }


    }

}