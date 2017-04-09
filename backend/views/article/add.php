<?php

$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name');
echo $form->field($model,'article_category_id')->dropDownList(\backend\models\Article::getArticleCategoryOptions());
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\Article::$status_options);
echo $form->field($model,'sort');
echo $form->field($model,'content')->textarea();

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);

\yii\bootstrap\ActiveForm::end();


