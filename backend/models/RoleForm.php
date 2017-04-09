<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/4/5
 * Time: 14:11
 */

namespace backend\models;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class RoleForm extends Model
{
    //定义对象
    public $name;//角色名称
    public $description;//角色的描述
    public $permissions=[];//权限

    //定义添加时才用到的场景
    const SCENARIO_ADD='add';

    //定义字段规则
    public function rules()
    {
        return [
            [['name','description'],'required'],
            [['name'],'validateName','on'=>self::SCENARIO_ADD],
            [['permissions'],'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name'=>'角色名称',
            'description'=>'角色描述',
            'permissions'=>'权限',
        ];
    }

    //自定义验证权限字段的规则
    public function validateName($attribute,$params){
    //判断输入的权限是够已经存在于数据库中
        //实例化组件
        $auth=\Yii::$app->authManager;
        //$auth->getPermissions($this->$attribute);//权限名称
        if($auth->getRole($this->$attribute)){//输入的权限已经存在
            $this->addError($attribute,'您添加的角色已经存在,请重新输入!');
        }
    }

    //获取所有权限选项
    public static function getPermissionOptions(){
        //获取所有的权限
        $permissions=\Yii::$app->authManager->getPermissions();
        return ArrayHelper::map($permissions,'name','description');
    }


    //获取所有权限选项
    public static function getPermission($name){
        //获取所有的权限
        $auth=\Yii::$app->authManager;
        $permission=[];
        foreach($auth->getPermissionsByRole($name) as $permissions){
            $permission[]=$permissions->description;
        };
        foreach($permission as $description){
            echo $description,'&nbsp';
        };
    }
}