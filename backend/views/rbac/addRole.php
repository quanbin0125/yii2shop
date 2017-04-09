<?php


$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name');//角色名称
echo $form->field($model,'description');//角色的描述
//角色具有的权限
echo $form->field($model,'permissions')->checkboxList(\backend\models\RoleForm::getPermissionOptions());
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();
