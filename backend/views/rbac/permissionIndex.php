<?php

echo \yii\bootstrap\Html::a('添加权限',['rbac/add-permission'],['class'=>'btn btn-info']);
?>
<h1>权限列表</h1>
<table class="table table-hover table-bordered">
    <tr>
        <th>权限名称</th>
        <th>权限描述</th>
        <th>操作</th>
    </tr>
    <?php foreach($permissions as $permission):?>
        <tr>
            <td><?=$permission->name?></td>
            <td><?=$permission->description?></td>
            <td><?=\yii\bootstrap\Html::a('删除',['rbac/delete-permission','name'=>$permission->name],['class'=>'btn btn-danger'])?></td>
        </tr>
    <?php endforeach;?>
</table>
