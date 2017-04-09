<?php

/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/3/30
 * Time: 14:07
 */

namespace backend\components;

use creocoder\nestedsets\NestedSetsQueryBehavior;
use yii\db\ActiveQuery;

class GoodsCategoryQuery extends ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }


}