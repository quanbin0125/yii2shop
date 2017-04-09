<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property string $url
 * @property string $intro
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id'], 'integer'],
            [['name', 'url'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '菜单名称',
            'parent_id' => '上级菜单',
            'url' => '路由',
        ];
    }

    //一级分类和二级分类  一对多
    public function getChildren(){
        return $this->hasMany(self::className(),['parent_id'=>'id']);
    }

    public static function getMenuOptions(){
        $top=[0=>'顶级分类'];
        $menu=self::find()->where(['parent_id'=>0])->all();
        $menu=ArrayHelper::map($menu,'id','name');
        return $menu=ArrayHelper::merge($top,$menu);
    }

    //获取父类ID为0的下拉列表
//    public static function getParentMenu(){
//        $ParentMenu=['0'=>'顶级分类'];
//        foreach(Menu::find()->where(['parent_id'=>0])->all() as $parent){
//            $ParentMenu[$parent->id]=$parent->name;
//        }
//        return $ParentMenu;
//    }

    //获取所有的下拉列表
//    public static function getList(){
//        $List=[];
//        $menu=self::find()->where(['parent_id'=>0])->all();
//       // var_dump(self::findOne(['id'=>2])->children);exit;
//        foreach($menu as $model){
//            $List[]=$model;
//            //var_dump($model);exit;
//            foreach($model->children as $son){
//                $son->name='--'.$son->name;
//                $list[]=$son;
//            }
//        }
//        return $List;
//    }
}
