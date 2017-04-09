<?php


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */



$form=\yii\bootstrap\ActiveForm::begin(['id' => 'form-add']);

echo $form->field($admin,'username');
echo $form->field($admin,'password_hash')->passwordInput();
echo $form->field($admin,'email');
//给用户添加角色
echo $form->field($admin,'roles')->checkboxList(\backend\models\Admin::getRoleOptions());
echo \yii\bootstrap\Html::submitButton('添加', ['class' => 'btn btn-primary', 'name' => 'signup-button']);

\yii\bootstrap\ActiveForm::end();

