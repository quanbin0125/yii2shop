<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/4/5
 * Time: 14:11
 */

namespace backend\models;
use yii\base\Model;

class PermissionForm extends Model
{
    //定义对象
    public $name;//权限名称
    public $description;//权限的描述
    //定义字段规则
    public function rules()
    {
        return [
            [['name','description'],'required'],
            [['name'],'validateName'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name'=>'权限名称(路由)',
            'description'=>'权限描述',
        ];
    }

    //自定义验证权限字段的规则
    public function validateName($attribute,$params){
    //判断输入的权限是够已经存在于数据库中
        //实例化组件
        $auth=\Yii::$app->authManager;
        //$auth->getPermissions($this->$attribute);//权限名称
        if($auth->getPermission($this->$attribute)){//输入的权限已经存在
            $this->addError($attribute,'您添加的权限已经存在,请重新输入!');
        }
    }
}