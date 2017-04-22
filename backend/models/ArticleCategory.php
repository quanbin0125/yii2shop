<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $status
 * @property integer $sort
 * @property integer $is_help
 */
class ArticleCategory extends \yii\db\ActiveRecord
{

    public static $status_options=['0'=>'否','1'=>'是'];//定义一个文章分类状态对象
    public static $is_help_options=['0'=>'不帮助','1'=>'帮助'];//定义是否帮助相关的分类
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','intro','status','sort'], 'required'],
            [['intro'], 'string'],
            [['name'],'unique'],
            [['status', 'sort', 'is_help'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章分类名称',
            'intro' => '简介',
            'status' => '状态',
            'sort' => '排序',
            'is_help' => '是否帮助相关的分类',
        ];
    }


    //关联文章
    public function getArticles()

    {
        /*
         * hasMany 表示1对多关系
         * 参数1 表示关联对象的类名
         * 参数2 [key=>value] key 关联对象在当前对象的关联字段名  value 当前对象的主键
         */
        return $this->hasMany(Article::className(),['article_category_id'=>'id']);
    }

    public static function ArticleCategorys(){
       return self::find()->all();
    }
}
