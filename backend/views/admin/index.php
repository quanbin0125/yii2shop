<?php
/* @var $this yii\web\View */

echo \yii\bootstrap\Html::a('添加用户',['admin/add'],['class'=>'btn btn-info']);
?>
    <h1>用户列表</h1>
    <table class="table table-bordered table-hover">
        <tr>
            <th>ID</th>
            <th>用户名</th>
            <th>邮箱</th>
            <th>录入时间</th>
            <th>修改时间</th>
            <th>最后时间</th>
            <th>最后登录IP</th>
            <th>操作</th>
        </tr>
        <?php foreach($models as $model):?>
            <tr>
                <td><?=$model->id?></td>
                <td><?=$model->username?></td>
                <td><?=$model->email?></td>
                <td><?=date('Y-m-d H:i:s',$model->created_at)?></td>
                <td><?=date('Y-m-d H:i:s',$model->updated_at)?></td>
                <td><?=date('Y-m-d H:i:s',$model->last_login_time)?></td>
                <td><?=date('Y-m-d H:i:s',$model->last_login_time)?></td>
                <td><?=$model->last_login_ip?></td>
                <td>
                    <?=\yii\bootstrap\Html::a('编辑',['admin/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
                    <?=\yii\bootstrap\Html::a('删除',['admin/delete','id'=>$model->id],['class'=>'btn btn-warning'])?>
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