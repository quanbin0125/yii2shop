<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/4/12
 * Time: 10:43
 */

namespace frontend\widgets;




use backend\models\Goods;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class GoodsWidget extends Widget{

    public function run(){
        $id=$_GET['id'];
        $html='';
        $models=Goods::findOne(['id'=>$id]);
        $title='<h3><strong>'.$models->name.'</strong></h3>';
        $imgs='<a href="">'.Html::img(\Yii::$app->params['adminImgUrl'].$models->logo);
        $url=Url::to(['index/notice']);
        $html.='<ul>
					<li><span>商品编号： </span>'.$models->sn.'</li>
                    <li class="market_price"><span>定价：</span><em>￥'.$models->market_price.'</em></li>
                    <li class="shop_price"><span>本店价：</span> <strong>￥'.$models->shop_price.'</strong> <a href="">(降价通知)</a></li>
                    <li><span>上架时间：</span>'.date('Y-m-d',$models->inputtime).'</li>
                    <li class="star"><span>商品评分：</span> <strong></strong><a href="">(已有21人评价)</a></li>
					</ul>';

        $html=<<<EOT
            <!-- 商品信息内容 start -->
		<div class="goods_content fl mt10 ml10">
			<!-- 商品概要信息 start -->
			<div class="summary">
                    {$title}
				<!-- 图片预览区域 start -->
				<div class="preview fl">
					<div class="midpic">
						{$imgs}  <!-- 第一幅图片的大图 class 和 rel属性不能更改 -->
							<img src="<?=Yii::getAlias('@web')?>/images/preview_m1.jpg" alt="" />               <!-- 第一幅图片的中图 -->
						</a>
					</div>

					<!--使用说明：此处的预览图效果有三种类型的图片，大图，中图，和小图，取得图片之后，分配到模板的时候，把第一幅图片分配到 上面的midpic 中，其中大图分配到 a 标签的href属性，中图分配到 img 的src上。 下面的smallpic 则表示小图区域，格式固定，在 a 标签的 rel属性中，分别指定了中图（smallimage）和大图（largeimage），img标签则显示小图，按此格式循环生成即可，但在第一个li上，要加上cur类，同时在第一个li 的a标签中，添加类 zoomThumbActive  -->

					<div class="smallpic">
						<a href="javascript:;" id="backward" class="off"></a>
						<a href="javascript:;" id="forward" class="on"></a>
						<div class="smallpic_wrap">
							<ul>
								<li class="cur">
									<a class="zoomThumbActive" href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '<?=Yii::getAlias('@web')?>/images/preview_m1.jpg',largeimage: '<?=Yii::getAlias('@web')?>/images/preview_l1.jpg'}"><img src="<?=Yii::getAlias('@web')?>/images/preview_s1.jpg"></a>
								</li>
								<li>
									<a href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '<?=Yii::getAlias('@web')?>/images/preview_m2.jpg',largeimage: '<?=Yii::getAlias('@web')?>/images/preview_l2.jpg'}"><img src="<?=Yii::getAlias('@web')?>/images/preview_s2.jpg"></a>
								</li>
								<li>
									<a href="javascript:void(0);"
									rel="{gallery: 'gal1', smallimage: '<?=Yii::getAlias('@web')?>/images/preview_m3.jpg',largeimage: '<?=Yii::getAlias('@web')?>/images/preview_l3.jpg'}">
	    							<img src="<?=Yii::getAlias('@web')?>/images/preview_s3.jpg"></a>
								</li>
								<li>
									<a href="javascript:void(0);"
									rel="{gallery: 'gal1', smallimage: '<?=Yii::getAlias('@web')?>/images/preview_m4.jpg',largeimage: '<?=Yii::getAlias('@web')?>/images/preview_l4.jpg'}">
	    							<img src="<?=Yii::getAlias('@web')?>/images/preview_s4.jpg"></a>
								</li>
								<li>
									<a href="javascript:void(0);"
									rel="{gallery: 'gal1', smallimage: '<?=Yii::getAlias('@web')?>/images/preview_m5.jpg',largeimage: '<?=Yii::getAlias('@web')?>/images/preview_l5.jpg'}">
	    							<img src="<?=Yii::getAlias('@web')?>/images/preview_s5.jpg"></a>
								</li>
								<li>
									<a href="javascript:void(0);"
									rel="{gallery: 'gal1', smallimage: '<?=Yii::getAlias('@web')?>/images/preview_m6.jpg',largeimage: '<?=Yii::getAlias('@web')?>/images/preview_l6.jpg'}">
	    							<img src="<?=Yii::getAlias('@web')?>/images/preview_s6.jpg"></a>
								</li>
								<li>
									<a href="javascript:void(0);"
									rel="{gallery: 'gal1', smallimage: '<?=Yii::getAlias('@web')?>/images/preview_m7.jpg',largeimage: '<?=Yii::getAlias('@web')?>/images/preview_l7.jpg'}">
	    							<img src="<?=Yii::getAlias('@web')?>/images/preview_s7.jpg"></a>
								</li>
								<li>
									<a href="javascript:void(0);"
									rel="{gallery: 'gal1', smallimage: '<?=Yii::getAlias('@web')?>/images/preview_m8.jpg',largeimage: '<?=Yii::getAlias('@web')?>/images/preview_l8.jpg'}">
	    							<img src="<?=Yii::getAlias('@web')?>/images/preview_s8.jpg"></a>
								</li>
								<li>
									<a href="javascript:void(0);"
									rel="{gallery: 'gal1', smallimage: '<?=Yii::getAlias('@web')?>/images/preview_m9.jpg',largeimage: '<?=Yii::getAlias('@web')?>/images/preview_l9.jpg'}">
	    							<img src="<?=Yii::getAlias('@web')?>/images/preview_s9.jpg"></a>
								</li>
							</ul>
						</div>

					</div>
				</div>
				<!-- 图片预览区域 end -->

				<!-- 商品基本信息区域 start -->
				<div class="goodsinfo fl ml10">

					{$html}

					<form action="{$url}" method="post" class="choose">
					<input type="hidden"  name="goods_id" value="$models->id"/>
						<ul>

							<li>
								<dl>
									<dt>购买数量：</dt>
									<dd>
										<a href="javascript:;" id="reduce_num"></a>
										<input type="text" name="amount" value="1" class="amount"/>
										<a href="javascript:;" id="add_num"></a>
									</dd>
								</dl>
							</li>

							<li>
								<dl>
									<dt>&nbsp;</dt>
									<dd>
										<input type="submit" value="" class="add_btn" />
									</dd>
								</dl>
							</li>

						</ul>
					</form>
				</div>
				<!-- 商品基本信息区域 end -->
			</div>
			<!-- 商品概要信息 end -->

			<div style="clear:both;"></div>

			<!-- 商品详情 start -->
			<div class="detail">
				<div class="detail_hd">
					<ul>
						<li class="first"><span>商品介绍</span></li>
						<li class="on"><span>商品评价</span></li>
						<li><span>售后保障</span></li>
					</ul>
				</div>
				<div class="detail_bd">
					<!-- 商品介绍 start -->
					<div class="introduce detail_div none">
						<div class="attr mt15">
							<ul>
								<li><span>商品名称：</span>ThinkPadX230(2306 3T4）</li>
								<li><span>商品编号：</span>979631</li>
								<li><span>品牌：</span>联想（Thinkpad）</li>
								<li><span>上架时间：</span>2013-09-18 17:58:12</li>
								<li><span>商品毛重：</span>2.47kg</li>
								<li><span>商品产地：</span>中国大陆</li>
								<li><span>显卡：</span>集成显卡</li>
								<li><span>触控：</span>非触控</li>
								<li><span>厚度：</span>正常厚度（>25mm）</li>
								<li><span>处理器：</span>Intel i5</li>
								<li><span>尺寸：</span>12英寸</li>
							</ul>
						</div>

						<div class="desc mt10">
							<!-- 此处的内容 一般是通过在线编辑器添加保存到数据库，然后直接从数据库中读出 -->
							<img src="<?=Yii::getAlias('@web')?>/images/desc1.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="<?=Yii::getAlias('@web')?>/images/desc2.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="<?=Yii::getAlias('@web')?>/images/desc3.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="<?=Yii::getAlias('@web')?>/images/desc4.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="<?=Yii::getAlias('@web')?>/images/desc5.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="<?=Yii::getAlias('@web')?>/images/desc6.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="<?=Yii::getAlias('@web')?>/images/desc7.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="<?=Yii::getAlias('@web')?>/images/desc8.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="<?=Yii::getAlias('@web')?>/images/desc9.jpg" alt="" />
						</div>
					</div>
					<!-- 商品介绍 end -->

					<!-- 商品评论 start -->
					<div class="comment detail_div mt10">
						<div class="comment_summary">
							<div class="rate fl">
								<strong><em>90</em>%</strong> <br />
								<span>好评度</span>
							</div>
							<div class="percent fl">
								<dl>
									<dt>好评（90%）</dt>
									<dd><div style="width:90px;"></div></dd>
								</dl>
								<dl>
									<dt>中评（5%）</dt>
									<dd><div style="width:5px;"></div></dd>
								</dl>
								<dl>
									<dt>差评（5%）</dt>
									<dd><div style="width:5px;" ></div></dd>
								</dl>
							</div>
							<div class="buyer fl">
								<dl>
									<dt>买家印象：</dt>
									<dd><span>屏幕大</span><em>(1953)</em></dd>
									<dd><span>外观漂亮</span><em>(786)</em></dd>
									<dd><span>系统流畅</span><em>(1091)</em></dd>
									<dd><span>功能齐全</span><em>(1109)</em></dd>
									<dd><span>反应快</span><em>(659)</em></dd>
									<dd><span>分辨率高</span><em>(824)</em></dd>
								</dl>
							</div>
						</div>

						<div class="comment_items mt10">
							<div class="user_pic">
								<dl>
									<dt><a href=""><img src="<?=Yii::getAlias('@web')?>/images/user1.gif" alt="" /></a></dt>
									<dd><a href="">乖乖</a></dd>
								</dl>
							</div>
							<div class="item">
								<div class="title">
									<span>2013-03-11 22:18</span>
									<strong class="star star5"></strong> <!-- star5表示5星级 start4表示4星级，以此类推 -->
								</div>
								<div class="comment_content">
									<dl>
										<dt>心得：</dt>
										<dd>东西挺好，挺满意的！</dd>
									</dl>
									<dl>
										<dt>优点：</dt>
										<dd>反应速度开，散热性能好</dd>
									</dl>
									<dl>
										<dt>不足：</dt>
										<dd>暂时还没发现缺点哦！</dd>
									</dl>
									<dl>
										<dt>购买日期：</dt>
										<dd>2013-11-24</dd>
									</dl>
								</div>
								<div class="btns">
									<a href="" class="reply">回复(0)</a>
									<a href="" class="useful">有用(0)</a>
								</div>
							</div>
							<div class="cornor"></div>
						</div>

						<div class="comment_items mt10">
							<div class="user_pic">
								<dl>
									<dt><a href=""><img src="<?=Yii::getAlias('@web')?>/images/user2.jpg" alt="" /></a></dt>
									<dd><a href="">小宝贝</a></dd>
								</dl>
							</div>
							<div class="item">
								<div class="title">
									<span>2013-10-01 14:10</span>
									<strong class="star star4"></strong> <!-- star5表示5星级 start4表示4星级，以此类推 -->
								</div>
								<div class="comment_content">
									<dl>
										<dt>心得：</dt>
										<dd>外观漂亮同，还在使用过程中。</dd>
									</dl>
									<dl>
										<dt>型号：</dt>
										<dd>i5 8G内存版</dd>
									</dl>
									<dl>
										<dt>购买日期：</dt>
										<dd>2013-11-20</dd>
									</dl>
								</div>
								<div class="btns">
									<a href="" class="reply">回复(0)</a>
									<a href="" class="useful">有用(0)</a>
								</div>
							</div>
							<div class="cornor"></div>
						</div>

						<div class="comment_items mt10">
							<div class="user_pic">
								<dl>
									<dt><a href=""><img src="<?=Yii::getAlias('@web')?>/images/user3.jpg" alt="" /></a></dt>
									<dd><a href="">天使</a></dd>
								</dl>
							</div>
							<div class="item">
								<div class="title">
									<span>2013-03-11 22:18</span>
									<strong class="star star5"></strong> <!-- star5表示5星级 start4表示4星级，以此类推 -->
								</div>
								<div class="comment_content">
									<dl>
										<dt>心得：</dt>
										<dd>挺好的，物超所值，速度挺好，WIN8用起来也不错。</dd>
									</dl>
									<dl>
										<dt>优点：</dt>
										<dd>散热很好，配置不错</dd>
									</dl>
									<dl>
										<dt>不足：</dt>
										<dd>暂时还没发现缺点哦！</dd>
									</dl>
									<dl>
										<dt>购买日期：</dt>
										<dd>2013-11-24</dd>
									</dl>
								</div>
								<div class="btns">
									<a href="" class="reply">回复(0)</a>
									<a href="" class="useful">有用(0)</a>
								</div>
							</div>
							<div class="cornor"></div>
						</div>

						<!-- 分页信息 start -->
						<div class="page mt20">
							<a href="">首页</a>
							<a href="">上一页</a>
							<a href="">1</a>
							<a href="">2</a>
							<a href="" class="cur">3</a>
							<a href="">4</a>
							<a href="">5</a>
							<a href="">下一页</a>
							<a href="">尾页</a>
						</div>
						<!-- 分页信息 end -->

						<!--  评论表单 start-->
						<div class="comment_form mt20">
							<form action="">
								<ul>
									<li>
										<label for=""> 评分：</label>
										<input type="radio" name="grade"/> <strong class="star star5"></strong>
										<input type="radio" name="grade"/> <strong class="star star4"></strong>
										<input type="radio" name="grade"/> <strong class="star star3"></strong>
										<input type="radio" name="grade"/> <strong class="star star2"></strong>
										<input type="radio" name="grade"/> <strong class="star star1"></strong>
									</li>

									<li>
										<label for="">评价内容：</label>
										<textarea name="" id="" cols="" rows=""></textarea>
									</li>
									<li>
										<label for="">&nbsp;</label>
										<input type="submit" value="提交评论"  class="comment_btn"/>
									</li>
								</ul>
							</form>
						</div>
						<!--  评论表单 end-->

					</div>
					<!-- 商品评论 end -->



EOT;
        return $html;
    }

}