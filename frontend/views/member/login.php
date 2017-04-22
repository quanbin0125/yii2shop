<?php
?>
<!-- 登录主体部分start -->
<div class="login w990 bc mt10">
    <div class="login_hd">
        <h2>用户登录</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <?php
            $form=\yii\widgets\ActiveForm::begin();
            echo '<ul>';

            $button =  '<input type="button" onclick="bindPhoneNum(this)" id="get_captcha" value="获取验证码" style="height: 25px;padding:3px 8px">';

            $options=[
                'options'=>['tag'=>'li'],//包裹整个输入框的标签
                'errorOptions'=>['tag'=>'p'],//错误信息的标签
            ];

            //用户名
            echo $form->field($model,'username', $options)->textInput(['class'=>'txt']);

            //密码
            echo $form->field($model,'password_hash',$options)->passwordInput(['class'=>'txt']);

            //验证码
            echo $form->field($model,'code',$options)->widget(\yii\captcha\Captcha::className());
            echo '<br>';
            //保存登录信息
            echo $form->field($model,'rememberMe')->checkbox();
            echo '<br>';
            echo '<li><label for="">&nbsp;</label>'. \yii\helpers\Html::submitButton('',['class'=>'login_btn']).'</li>';
            echo '<li><label for="">&nbsp;</label>'. \yii\helpers\Html::a('还未注册?点我带你去注册！',['member/register'],['class'=>'btn btn-info']).'</li>';

            echo '</ul>';
            \yii\widgets\ActiveForm::end();
            ?>


            <div class="coagent mt15">
                <dl>
                    <dt>使用合作网站登录商城：</dt>
                    <dd class="qq"><a href=""><span></span>QQ</a></dd>
                    <dd class="weibo"><a href=""><span></span>新浪微博</a></dd>
                    <dd class="yi"><a href=""><span></span>网易</a></dd>
                    <dd class="renren"><a href=""><span></span>人人</a></dd>
                    <dd class="qihu"><a href=""><span></span>奇虎360</a></dd>
                    <dd class=""><a href=""><span></span>百度</a></dd>
                    <dd class="douban"><a href=""><span></span>豆瓣</a></dd>
                </dl>
            </div>
        </div>

        <div class="guide fl">
            <h3>还不是商城用户</h3>
            <p>现在免费注册成为商城用户，便能立刻享受便宜又放心的购物乐趣，心动不如行动，赶紧加入吧!</p>

            <a href="regist.html" class="reg_btn">免费注册 >></a>
        </div>

    </div>
</div>
<!-- 登录主体部分end -->

