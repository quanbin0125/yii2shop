<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/4/14
 * Time: 8:45
 */

namespace frontend\widgets;


use backend\models\Goods;
use yii\base\Widget;
use yii\helpers\Html;

class GoodsListWidget extends Widget{

    public function run(){
        $html='';
        $goodses=Goods::find()->all();
        foreach($goodses as $goods){
            $html.='<li>
                        <dl>
                            <dt><a href="">'.Html::img(\Yii::$app->params['adminImgUrl'].$goods->logo).'</dt>
                            <dd>'.Html::a($goods->name,['index/goods','id'=>$goods->id]).'</dd>
                            <dd><strong>'.$goods->shop_price.'</strong></dd>
                            <dd><a href=""><em>已有10人评价</em></a></dd>
                        </dl>
                    </li>';

        }


       $html=<<<EOT
               <!-- 商品列表 start-->
        <div class="goodslist mt10">
            <ul>
                {$html}
            </ul>
        </div>
        <!-- 商品列表 end-->

EOT;
        return $html;
    }

}