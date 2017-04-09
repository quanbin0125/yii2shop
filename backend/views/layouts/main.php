<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use backend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '首页', 'url' => ['site/index']],
//        [
//            'label' => '品牌管理',
//            'items' => [
//                ['label' => '品牌列表', 'url' => ['brand/index']],
//                ['label' => '添加品牌', 'url' => ['brand/add']],
//                ['label' => '品牌回收站', 'url' => ['brand/garbage']],
//            ],
//        ],
//        [
//            'label' => '文章分类管理',
//            'items' => [
//                ['label' => '文章分类列表', 'url' => ['article-category/index']],
//                ['label' => '添加文章分类', 'url' => ['article-category/add']],
//            ],
//        ],
//        [
//            'label' => '文章管理',
//            'items' => [
//                ['label' => '文章列表', 'url' => ['article/index']],
//                ['label' => '添加文章', 'url' => ['article/add']],
//            ],
//        ],
//        [
//            'label' => '管理员管理',
//            'items' => [
//                ['label' => '添加管理员', 'url' => ['admin/add']],
//
//            ],
//        ],
        ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
    } else {
        //获取当前登录用户的菜单
        $menuItems=\yii\helpers\ArrayHelper::merge($menuItems,Yii::$app->user->identity->getMenuItems());
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                '注销 (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

