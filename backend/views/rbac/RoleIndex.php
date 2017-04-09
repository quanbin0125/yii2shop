<?php

echo \yii\bootstrap\Html::a('添加角色',['rbac/add-role'],['class'=>'btn btn-info']);
?>
<h1>角色列表</h1>
<table class="table table-hover table-bordered">
    <tr>
        <th>角色名称</th>
        <th>角色描述</th>
        <th>角色具有的权限</th>
        <th>操作</th>
    </tr>
    <?php foreach($roles as $role):?>
        <tr>
            <td><?=$role->name?></td>
            <td><?=$role->description?></td>
            <td><?=\backend\models\RoleForm::getPermission($role->name)?></td>
            <td>
                <?=\yii\bootstrap\Html::a('修改',['rbac/edit-role','name'=>$role->name],['class'=>'btn btn-success'])?>
                <?=\yii\bootstrap\Html::a('删除',['rbac/delete-role','name'=>$role->name],['class'=>'btn btn-danger'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
