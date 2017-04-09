<?php
use yii\web\JsExpression;
use yii\bootstrap\Html;
use xj\uploadify\Uploadify;

$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name');//商品名称
echo $form->field($model,'logo')->hiddenInput();//商品LOGO
echo \yii\bootstrap\Html::img($model->logo,['id'=>'img','width'=>'100px']);
echo '<br>';
echo '<br>';
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

        $("#goods-logo").val(data.fileUrl);
        $("#img").attr("src",data.fileUrl);

    }
}
EOF
        ),
    ]
]);

echo $model->logo?\yii\bootstrap\Html::img('@web/'.$model->logo,['height'=>'40px','width'=>'40px']) :' ';
echo $form->field($model,'goods_category_id')->hiddenInput();//商品分类
echo '<div>
    <ul id="treeDemo" class="ztree"></ul>
</div>';
echo $form->field($model,'brand_id')->dropDownList(\backend\models\Goods::getBrandOptions());//品牌
echo $form->field($model,'market_price');//市场价格
echo $form->field($model,'shop_price');//本店价格
echo $form->field($model,'stock');//库存
echo $form->field($model,'is_on_sale',['inline'=>true])->radioList(\backend\models\Goods::$is_on_sale_options);//是否上架
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\Goods::$status_options);//状态
echo $form->field($model,'sort');//排序
//echo $form->field($intro,'content')->textarea();
echo $form->field($intro,'content')->widget('common\widgets\ueditor\Ueditor',[
    'options'=>[
        'initialFrameWidth' => 850,
        'initialFrameHeight' => 200,
    ]
]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);

\yii\bootstrap\ActiveForm::end();



//给当前视图注册JS文件
// \yii\web\JqueryAsset::className() 当前的JS文件需要依赖jquery(在它后面加载)
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',
    ['depends'=>\yii\web\JqueryAsset::className()]);

//注册JS代码
$js=<<<EOT
var zTreeObj;
    // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
    var setting = {
        data:{
            simpleData:{
                enable:true,
                idKey:"id",
                pIdKey:"parent_id",
                rootPId:0
            }
        },
        callback:{
        onClick:function(event,treeId,treeNode){
                $("#goods-goods_category_id").val(treeNode.id);
                }
        }
    };
    // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
    var zNodes ={$models};

        zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        zTreeObj.expandAll(true);
        zTreeObj.selectNode(zTreeObj.getNodeByParam("id","{$model->goods_category_id}",null));//选中所在节点

EOT;

$this->registerJs($js);
?>

<link rel="stylesheet" href="/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">