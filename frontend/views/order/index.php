<form action="<?php echo \yii\helpers\Url::to(['order/index'])?>" method="post" name="addOrder">
<!-- 主体部分 start -->
<div class="fillin w990 bc mt15">
    <div class="fillin_hd">
        <h2>填写并核对订单信息</h2>
    </div>
    <div class="fillin_bd">
        <!-- 收货人信息  start-->
        <div class="address">
            <div class="address_info">
                <ul>
                    <?php foreach($addresss as $address):?>
                            <li class="cur">
                                <input type="radio" name="address_id" value="<?=$address->id?>" /><?=$address->name.'.'.$address->telephone.' '.$address->provice.' '.$address->city.' '.$address->district.' '.$address->detail?>
                                <a href="">设为默认地址</a>
                                <a href="">编辑</a>
                                <a href="">删除</a>
                            </li>
                    <?php endforeach;?>
                </ul>

            </div>
        </div>
        <!-- 收货人信息  end-->

        <!-- 配送方式 start -->
        <div class="delivery">
            <h3>送货方式 <a href="javascript:;" id="delivery_modify">[修改]</a></h3>
            <div class="delivery_info">
                <table>
                <thead>
                <tr>
                    <th class="col1">送货方式</th>
                    <th class="col2">运费</th>
                    <th class="col3">运费标准</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $deliveries=\frontend\models\Order::$deliveries;
                ?>
                <?php foreach($deliveries as $i=>$delivery):?>
                <tr>
                   <td><input type="radio" name="delivery_id" value="<?=$i?>"/><?=$delivery[0]?></td>
                   <td>￥<?=$delivery[1]?></td>
                   <td><?=$delivery[2]?></td>
                </tr>
                <?php endforeach;?>
                    </tbody>
                </table>

            </div>
        </div>
        <!-- 配送方式 end -->

        <!-- 支付方式  start-->
        <div class="pay">
            <h3>支付方式 <a href="javascript:;" id="pay_modify">[修改]</a></h3>
            <div class="pay_info">
                <table>
                    <?php
                    $paymentss=\frontend\models\Order::$payments;
                    ?>
                    <?php foreach($paymentss as $k=>$payments):?>
                        <tr class="'.($k==0?'cur':'').'">
                            <td class="col1"><input type="radio" name="pay_type_id" value="<?=$k?>" /><?=$payments[0]?></td>
                            <td class="col2"><?=$payments[1]?></td>
                        </tr>
                    <?php endforeach;?>
                </table>
                <a href="" class="confirm_btn"><span>确认支付方式</span></a>
            </div>
        </div>
        <!-- 支付方式  end-->


        <!-- 商品清单 start -->
        <div class="goods">
            <h3>商品清单</h3>
            <table>
                <thead>
                <tr>
                    <th class="col1">商品</th>
                    <th class="col3">价格</th>
                    <th class="col4">数量</th>
                    <th class="col5">小计</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($carts as $cart):?>
                    <tr>
                        <td class="col1"><a href=""><img src="<?=Yii::$app->params{'adminImgUrl'}.$cart->goods->logo?>" alt="" /></a>  <strong><a href=""><?=$cart->goods->name?></a></strong></td>
                        <td class="col3">￥<?=$cart->goods->shop_price?></td>
                        <td class="col4"><?=$cart->amount?></td>
                        <td class="col5"><span>￥<?php echo ($cart->amount)*($cart->goods->shop_price)?></span></td>

                    </tr>
                    <?php endforeach;?>

                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <ul>
                            <li>
                                <span>件商品，总商品金额：</span>
                                <em>￥5316.00</em>
                            </li>
                            <li>
                                <span>返现：</span>
                                <em>-￥240.00</em>
                            </li>
                            <li>
                                <span>运费：</span>
                                <em>￥10.00</em>
                            </li>
                            <li>
                                <span>应付总额：</span>
                                <em>￥5076.00</em>
                            </li>
                        </ul>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- 商品清单 end -->

    </div>

    <div class="fillin_ft">
        <a href="javascript:document.addOrder.submit()"><span>提交订单</span></a>
        <p>应付总额：<strong>￥5076.00元</strong></p>

    </div>
</div>
<!-- 主体部分 end -->
</form>