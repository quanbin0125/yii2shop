<?php
/* @var $this yii\web\View */
echo  \yii\bootstrap\Html::a('添加文章分类',['article-category/add'],['class'=>'btn btn-info']);

?>
<h1>文章分类首页</h1>

<table class="table table-hover table-bordered">
    <tr>
        <th>ID</th>
        <th>文章分类名</th>
        <th>分类简介</th>
        <th>分类状态</th>
        <th>排序</th>
        <th>是否是帮助相关的分类</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->name?></td>
            <td><?=$model->intro?></td>
            <td><?=\backend\models\ArticleCategory::$status_options[$model->status]?></td>
            <td><?=$model->sort?></td>
            <td><?=\backend\models\ArticleCategory::$is_help_options[$model->is_help]?></td>
            <td>
                <?= \yii\bootstrap\Html::a('编辑',['article-category/edit','id'=>$model->id],['class'=>'btn btn-success'])?>
                <?= \yii\bootstrap\Html::a('删除',['article-category/delete','id'=>$model->id],['class'=>'btn btn-warning'])?>

            </td>
        </tr>
    <?php endforeach;?>
</table>

<!--分页工具条-->
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pager,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',

]);
?>


