<?php
/* @var $this yii\web\View */
echo \yii\bootstrap\Html::a('添加品牌',['brand/add'],['class'=>'btn btn-info']);
echo ' ';
echo \yii\bootstrap\Html::a('回收站',['brand/garbage'],['class'=>'btn btn-danger']);
?>
<h1>品牌列表</h1>
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>LOGO</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->name?></td>
            <td><?=\yii\bootstrap\Html::img('@web'.$model->logo,['height'=>'40px','width'=>'40px'])?></td>
            <td><?=\backend\models\Brand::$status_options[$model->status]?></td>
            <td>
                <?=\yii\bootstrap\Html::a('编辑',['brand/edit','id'=>$model->id],['class'=>'btn btn-success'])?>
                <?=\yii\bootstrap\Html::a('删除',['brand/delete','id'=>$model->id],['class'=>'btn btn-danger'])?>
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