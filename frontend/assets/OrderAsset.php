<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/4/14
 * Time: 19:11
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class OrderAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/fillin.css',
        'style/footer.css',
    ];
    public $js = [
        'js/cart2.js',

    ];
    public $depends = [

        'yii\web\JqueryAsset',
    ];


}