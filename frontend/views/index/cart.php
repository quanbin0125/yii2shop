<?php foreach ($goods as $good):?>
    <tr data-goods-id=<?=$good['id']?>>
        <td class="col1"><a href=""><img src="<?='http://admin.yiishop.com'.$good['logo']?>" alt="" /></a>  <strong><a href=""><?=$good['name']?></a></strong></td>
        <td class="col3">￥<span><?=$good['shop_price']?></span></td>
        <td class="col4">
            <a href="javascript:;" class="reduce_num"></a>
            <input type="text" name="amount" value="<?=$good['amount']?>" class="amount"/>
            <a href="javascript:;" class="add_num"></a>
        </td>
        <td class="col5">￥<span><?=($good['shop_price'])*($good['amount'])?></span></td>
        <td class="col6"><a href="javascript:;" class="btn_del">删除</a></td>
    </tr>
<?php endforeach;?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="6">购物金额总计： <strong>￥ <span id="total"></span></strong></td>
    </tr>
    </tfoot>

<?php
$this->registerJs('totalPrice();');
