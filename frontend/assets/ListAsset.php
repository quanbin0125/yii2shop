<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/4/12
 * Time: 18:57
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class ListAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/list.css',
        'style/common.css',
        'style/bottomnav.css',
        'style/footer.css',
    ];
    public $js = [
        'js/header.js',
        'js/list.js',
    ];
    public $depends = [

        'yii\web\JqueryAsset',
    ];

}
