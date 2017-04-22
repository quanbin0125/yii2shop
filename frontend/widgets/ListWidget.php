<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/4/12
 * Time: 19:03
 */

namespace frontend\widgets;


use backend\models\GoodsCategory;
use yii\base\Widget;
use yii\helpers\Html;

class ListWidget extends Widget
{

    public function run()
    {
        $id=$_GET['id'];
        $html = '';
        $categories = GoodsCategory::findOne(['id'=>$id]);//获取该级分类
        //var_dump($categories);exit;
        $one=GoodsCategory::findOne(['tree'=>$categories->tree,'depth'=>0]);
        $title='<h2>'.$one->name.'</h2>';
            foreach($one->children as $k=>$two){
                $html .= '<div class="child">
                    <h3 class="'.($k==0?'on':'none').'"><b></b>'.Html::a($two->name,['index/list','id'=>$two->id]).'</h3>
                    <ul>';
                //遍历三级分类
                foreach($two->children as $three)
                    $html .= '<li>'.Html::a($three->name,['index/list','id'=>$three->id]).'</li>';

                $html .= '</ul>
                        </div>';
            }


        $html = <<<EOT
        <div class="list_left fl mt10">
			<!-- 分类列表 start -->
			<div class="catlist">
			    {$title}
			    <div class="catlist_wrap">
                    {$html}
			    </div>
				<div style="clear:both; height:1px;"></div>
			</div>
			<!-- 分类列表 end -->


EOT;
        return $html;
    }

}

