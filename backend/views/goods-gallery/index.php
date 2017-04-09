<?php
/* @var $this yii\web\View */
?>
<h1>相册列表</h1>

<table>
    <tr>
        <th>ID</th>
        <th>商品名称</th>
        <th>相片</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->Goods->name?></td>
            <td><?=$model->img_file?></td>
            <td></td>
        </tr>
    <?php endforeach;?>
</table>


