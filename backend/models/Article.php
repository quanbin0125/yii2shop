<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $name
 * @property integer $article_category_id
 * @property string $intro
 * @property integer $status
 * @property integer $sort
 * @property integer $inputtime
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $content;//文章内容
    public static $status_options=['0'=>'否','1'=>'是'];

    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'article_category_id','content','intro'], 'required'],
            [['article_category_id', 'status', 'sort', 'inputtime'], 'integer'],
            [['intro','content'], 'string'],
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
            'name' => '文章名称',
            'article_category_id' => '文章所属分类',
            'intro' => '简介',
            'content'=>'文章内容',
            'status' => '状态',
            'sort' => '排序',
            'inputtime' => '录入时间',
        ];
    }

    //关联分类
    public function getArticleCategory()
    {

        /**
         * hasOne参数 1. 关联对象的类名
         * 参数2 [key=>value] key 表示关联对象的主键  value 表示关联对象在当前对象的字段
         */
        return $this->hasOne(ArticleCategory::className(),['id'=>'article_category_id']);
    }

    //定义分类
    public static function getArticleCategoryOptions()
    {
        //第一种找到分类id和分类name
        $articleCategorys = ArticleCategory::find()->asArray()->all();


        return  ArrayHelper::map($articleCategorys,'id','name');
    }


    //关联文章内容
    public function getArticleDetail(){
        return $this->hasOne(ArticleDetail::className(),['article_id'=>'id']);
    }
}
