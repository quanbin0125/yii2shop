<?php
/* @var $this yii\web\View */

echo \yii\bootstrap\Html::a('添加商品',['goods/add'],['class'=>'btn btn-info']);
echo ' ';
echo \yii\bootstrap\Html::a('回收站',['goods/garbage'],['class'=>'btn btn-success']);
echo '<br>';
echo '<br>';
$form=\yii\bootstrap\ActiveForm::begin([
    'options'=>[
        'method'=>'get',
        'class'=>'form-inline'
    ]
]);
echo $form->field($model,'name');
echo ' ';
echo $form->field($model,'sn');
echo ' ';
echo $form->field($model,'maxPrice');
echo '----';
echo ' ';
echo $form->field($model,'minPrice');
echo ' ';
echo \yii\bootstrap\Html::submitButton('搜索',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();
?>
<h1>商品列表</h1>
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>商品名称</th>
        <th>货号</th>
        <th>商品LOGO</th>
        <th>商品分类</th>
        <th>品牌</th>
        <th>市场价格</th>
        <th>本店价格</th>
        <th>库存</th>
        <th>是否上架</th>
        <th>状态</th>
        <th>排序</th>
        <th>录入时间</th>
        <th>操作</th>
    </tr>

    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->name?></td>
            <td><?=$model->sn?></td>
            <td><?=\yii\bootstrap\Html::img('@web'.$model->logo,['height'=>'40px','width'=>'40px'])?></td>
            <td><?=$model->goodsCategory->name?></td>
            <td><?=$model->brand->name?></td>
            <td><?=$model->market_price?></td>
            <td><?=$model->shop_price?></td>
            <td><?=$model->stock?></td>
            <td><?=\backend\models\Goods::$is_on_sale_options[$model->is_on_sale]?></td>
            <td><?=\backend\models\Goods::$status_options[$model->status]?></td>
            <td><?=$model->sort?></td>
            <td><?=date('Y-m-d H:i:s',$model->inputtime)?></td>
            <td>
                <?=\yii\bootstrap\Html::a('编辑',['goods/edit','id'=>$model->id],['class'=>'btn btn-success'])?>
                <?=\yii\bootstrap\Html::a('删除',['goods/delete','id'=>$model->id],['class'=>'btn btn-danger'])?>
                <?=\yii\bootstrap\Html::a('相册',['goods-gallery/add','id'=>$model->id],['class'=>'btn btn-info'])?>
            </td>
        </tr>
       <?php endforeach;?>
</table>

<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pager,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
]);

?>


