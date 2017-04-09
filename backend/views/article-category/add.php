<?php

$form=\yii\bootstrap\ActiveForm::begin();


echo $form->field($model,'name');//文章分类名称
echo $form->field($model,'intro')->textarea();//简介
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\ArticleCategory::$status_options);//文章分类的状态
echo $form->field($model,'sort');//排序
echo $form->field($model,'is_help',['inline'=>true])->radioList(\backend\models\ArticleCategory::$is_help_options);//是否帮助相关的分类
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);


\yii\bootstrap\ActiveForm::end();

