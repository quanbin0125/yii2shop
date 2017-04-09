<?php
use yii\web\JsExpression;
use yii\bootstrap\Html;
use xj\uploadify\Uploadify;

$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name');//品牌名称
echo $form->field($model,'intro')->textarea();//品牌简介
echo $form->field($model,'logo')->hiddenInput();//品牌LOGO
echo Html::img($model->logo,['id'=>'img','width'=>'100px']);
echo '<br>';
echo '<br>';
//外部TAG
echo Html::fileInput('test', NULL, ['id' => 'test']);
echo Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 100,
        'height' => 40,
        'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        //console.log(data.fileUrl);
        $("#brand-logo").val(data.fileUrl);
        $("#img").attr("src",data.fileUrl);
    }
}
EOF
        ),
    ]
]);

echo $model->logo?\yii\bootstrap\Html::img('@web/'.$model->logo,['height'=>'40px','width'=>'40px']) :' ';
echo $form->field($model,'sort');//排序
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\Brand::$status_options);
echo \yii\bootstrap\Html::submitButton('提交添加',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();