<?php
/* @var $this yii\web\View */

?>
<h1>回收站</h1>
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
            <td><?=\yii\bootstrap\Html::img('@web/'.$model->logo,['height'=>'40px','width'=>'40px'])?></td>
            <td><?=\backend\models\Brand::$status_options[$model->status]?></td>
            <td>
                <?=\yii\bootstrap\Html::a('还原',['brand/edit','id'=>$model->id],['class'=>'btn btn-success'])?>
                <?=\yii\bootstrap\Html::a('彻底删除',['brand/deletes','id'=>$model->id],['class'=>'btn btn-danger'])?>
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