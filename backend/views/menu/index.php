
+
+<?php
/* @var $this yii\web\View */
echo \yii\bootstrap\Html::a('添加菜单',['menu/add'],['class'=>'btn btn-info']);
?>
<h1>菜单列表</h1>
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>菜单名称</th>
        <th>路由</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->name?></td>
            <td><?=$model->url?></td>
            <td>编辑 删除</td>
        </tr>
        <?php foreach($model->children as $son):?>
            <tr>
                <td><?=$son->id?></td>
                <td>----<?=$model->name?></td>
                <td><?=$son->url?></td>
                <td>编辑 删除</td>
            </tr>
            <?php endforeach;?>
    <?php endforeach;?>
</table>