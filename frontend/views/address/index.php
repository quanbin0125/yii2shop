<?php
?>
<!-- 页面主体 start -->
<div class="main w1210 bc mt10">
    <div class="crumb w1210">
        <h2><strong>我的XX </strong><span>> 我的订单</span></h2>
    </div>

    <!-- 左侧导航菜单 start -->
    <div class="menu fl">
        <h3>我的XX</h3>
        <div class="menu_wrap">
            <dl>
                <dt>订单中心 <b></b></dt>
                <dd><b>.</b><a href="">我的订单</a></dd>
                <dd><b>.</b><a href="">我的关注</a></dd>
                <dd><b>.</b><a href="">浏览历史</a></dd>
                <dd><b>.</b><a href="">我的团购</a></dd>
            </dl>

            <dl>
                <dt>账户中心 <b></b></dt>
                <dd class="cur"><b>.</b><a href="">账户信息</a></dd>
                <dd><b>.</b><a href="">账户余额</a></dd>
                <dd><b>.</b><a href="">消费记录</a></dd>
                <dd><b>.</b><a href="">我的积分</a></dd>
                <dd><b>.</b><a href="">收货地址</a></dd>
            </dl>

            <dl>
                <dt>订单中心 <b></b></dt>
                <dd><b>.</b><a href="">返修/退换货</a></dd>
                <dd><b>.</b><a href="">取消订单记录</a></dd>
                <dd><b>.</b><a href="">我的投诉</a></dd>
            </dl>
        </div>
    </div>
    <!-- 左侧导航菜单 end -->

    <!-- 右侧内容区域 start -->
    <div class="content fl ml10">
        <div class="address_hd">
            <h3>收货地址薄</h3>
            <?php foreach($address as $addres):?>
                <dl>
                    <dt><?=$addres->id.'.'.$addres->name.' '.$addres->provice.' '.$addres->city.' '.$addres->district.' '.$addres->detail.' '.$addres->telephone?></dt>
                    <dd>
                        <?=\yii\helpers\Html::a('修改',['address/add','id'=>$addres->id])?>
                        <?=\yii\helpers\Html::a('删除',['address/delete','id'=>$addres->id])?>
                        <?=\yii\helpers\Html::a('设为默认地址',['address/edit','id'=>$addres->id])?>
                    </dd>
                </dl>
            <?php endforeach;?>
        </div>

        <div class="address_bd mt10">
            <h4>新增收货地址</h4>
               <?php
               $form=\yii\widgets\ActiveForm::begin();
               echo '<ul>';
               $options=[
                   'options'=>['tag'=>'li'],//包裹整个输入框的标签
                   'errorOptions'=>['tag'=>'p'],//错误信息的标签
               ];
               //收货人
               echo $form->field($model,'name',$options)->textInput(['class'=>'txt']);
               //所在地区
               echo '<label for=""><span>*</span>所在地：</label>
								<select name="provice" id="cmbProvince">
								</select>
                               <select name="city" id="cmbCity">
								</select>
								<select name="district" id="cmbArea">
								</select>';

               //详细地址
               echo $form->field($model,'detail',$options)->textInput(['class'=>'txt']);
               //电话号码
               echo $form->field($model,'telephone',$options)->textInput(['class'=>'txt']);

               echo '<li><label for="">&nbsp;</label>'. $form->field($model,'status')->checkbox(['class'=>'check']).'</li>';
                echo '<br>';
               echo '<li><label for="">&nbsp;</label>'. \yii\helpers\Html::submitButton('保存',['class'=>'login_btn']).'</li>';

               echo '</ul>';
               \yii\widgets\ActiveForm::end();
               ?>
        </div>

    </div>
    <!-- 右侧内容区域 end -->
</div>
<!-- 页面主体 end-->

<script type="text/javascript">
    addressInit('cmbProvince', 'cmbCity', 'cmbArea', '四川', '成都市', '武侯区');
</script>