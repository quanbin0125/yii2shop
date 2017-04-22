<?php

?>
<!-- 登录主体部分start -->
	<div class="login w990 bc mt10 regist">
		<div class="login_hd">
			<h2>用户注册</h2>
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
                echo $form->field($model,'username', $options)->textInput(['class'=>'txt','placeholder'=>'用户名不能重复']);

				//密码
                echo $form->field($model,'password_hash',$options)->passwordInput(['class'=>'txt','placeholder'=>'密码必须为数字']);

				//邮箱
				echo $form->field($model,'email',$options)->textInput(['class'=>'txt','placeholder'=>'邮箱必须为真实邮箱']);

				//电话号码
                echo $form->field($model,'telephone',$options)->textInput(['class'=>'txt','placeholder'=>'电话号码必须为真实号码']);

				//短信验证码
                echo $form->field($model,'smscode',[
					'options'=>['tag'=>'li'],//包裹整个输入框的标签
					'errorOptions'=>['tag'=>'p'],//错误信息的标签
					'template'=>"{label}\n{input}$button\n{hint}\n{error}",//输出模板
				])->textInput(['class'=>'txt']);
				//验证码
				echo $form->field($model,'code',$options)->widget(\yii\captcha\Captcha::className());


				echo '<li><label for="">&nbsp;</label>'. \yii\helpers\Html::submitButton('',['class'=>'login_btn']).'</li>';


				echo '</ul>';
                \yii\widgets\ActiveForm::end();
                ?>


			</div>

			<div class="mobile fl">
				<h3>手机快速注册</h3>
				<p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
				<p><strong>1069099988</strong></p>
			</div>

		</div>
	</div>
	<!-- 登录主体部分end -->
<!-- 登录主体部分end -->
<script type="text/javascript">
	function bindPhoneNum(){
		//启用输入框
		$('#captcha').prop('disabled',false);

		var time=30;
		var interval = setInterval(function(){
			time--;
			if(time<=0){
				clearInterval(interval);
				var html = '获取验证码';
				$('#get_captcha').prop('disabled',false);
			} else{
				var html = time + ' 秒后再次获取';
				$('#get_captcha').prop('disabled',true);
			}

			$('#get_captcha').val(html);
		},1000);
	}
</script>

