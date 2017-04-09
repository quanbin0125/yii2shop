<?php


$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name');//添加或者修改的权限名称
echo $form->field($model,'description');//权限的描述
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();
