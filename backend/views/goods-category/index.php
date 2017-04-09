<?php
/* *
 * @var $this yii\web\View
 *
 */

echo \yii\bootstrap\Html::a('添加商品分类',['goods-category/add'],['class'=>'btn btn-info']);
?>
<h1>商品分类列表</h1>

<table class="table table-hover table-bordered" style="font-size: small">
    <tr>
        <th>ID</th>
        <th style="width:35%">商品分类名称</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <tbody id="goods-category">
    <?php foreach($models as $model):?>
        <tr data-lft="<?=$model->lft?>" data-rgt="<?=$model->rgt?>" data-tree="<?=$model->tree?>">
            <td><?=$model->id?></td>
            <td><?=str_repeat('－',$model->depth).$model->name?>
                <span class="glyphicon glyphicon-minus expand" style="float: right"></span></td>
            <td><?=$model->intro?></td>
            <td>
                <?=\yii\bootstrap\Html::a('编辑',['goods-category/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
                <?=\yii\bootstrap\Html::a('删除',['goods-category/delete','id'=>$model->id],['class'=>'btn btn-danger'])?>
            </td>
        </tr>

    <?php endforeach;?>
    </tbody>
</table>

<?php
//注册JS代码  expand展开
$js=<<<EOT
//    给"-" "+"添加点击事件  展开或者折叠
     $(".expand").click(function(){
        //切换"+""-"图标
        $(this).toggleClass("glyphicon glyphicon-minus");
        $(this).toggleClass("glyphicon glyphicon-plus");
        //找当前分类同一棵树下面的子分类  同一棵树左值大于当前分类的左值并且右值小于当前分类的右值
        var click_tr=$(this).closest("tr");//获取当前点击图标所在的tr
        var click_lft=parseInt(click_tr.attr("data-lft"));//获取当前左值

        var click_rgt=parseInt(click_tr.attr("data-rgt"));//获取当前右值
        var click_tree=parseInt(click_tr.attr("data-tree"));//获取当前的哪一棵树

        //循环找到符合条件的
        $("#goods-category tr").each(function(){
            var lft=parseInt($(this).attr("data-lft"));//分类的左值
            var rgt=parseInt($(this).attr("data-rgt"));//分类的右值
            var tree=parseInt($(this).attr("data-tree"));//获取当前的树的tree值
            //判断出满足条件的
            if(tree==click_tree && lft > click_lft && rgt < click_rgt){
                //当前分类的子分类隐藏或者显示
                    $(this).fadeToggle();
        }
        });

        });
EOT;

$this->registerJs($js);

?>






