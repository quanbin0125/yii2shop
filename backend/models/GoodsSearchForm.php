<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/4/4
 * Time: 21:49
 */

namespace backend\models;


use yii\base\Model;
use yii\db\ActiveQuery;

class GoodsSearchForm extends Model
{
    public $name;
    public $sn;
    public $maxPrice;
    public $minPrice;
    //搜索功能字段规则
    public function rules()
    {
        return [
            ['name','string','max'=>50],
            ['sn','string'],
            ['minPrice','double'],
            ['maxPrice','double'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => '商品名称',
            'sn' => '货号',
            'minPrice'=>'最低价格',
            'maxPrice'=>'最高价格',
        ];
    }

    public function search(ActiveQuery $query){
        if($this->name){
            $query->andWhere(['like','name',$this->name]);
        }
        if($this->sn){
            $query->andWhere(['like','sn',$this->sn]);
        }
        if($this->minPrice){
            $query->andWhere(['>=','shop_price',$this->minPrice]);
        }
        if($this->maxPrice){
            $query->andWhere(['<=','shop_price',$this->maxPrice]);
        }
    }
}