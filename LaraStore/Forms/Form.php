<?php

namespace LaraStore\Forms;

use Illuminate\Http\Request;
use Validator;

abstract class Form
{
    

    /*
    |-------------------------------------------------------------------------------
    |
    | 验证规则 和验证提示信息
    |
    |-------------------------------------------------------------------------------
    */
    protected $rules        = [];
    protected $messages     = [];


    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct()
    {
        
    }

    
    /*
    |-------------------------------------------------------------------------------
    |
    | 数据库操作
    |
    |-------------------------------------------------------------------------------
    */
    public function save()
    {

        if($this->isValid()){
            $this->persist();
            return true;
        }
        return false;
    }

    

    /*
    |-------------------------------------------------------------------------------
    |
    | 返回表单所有字段
    |
    |-------------------------------------------------------------------------------
    */
    public function fields()
    {
        return request()->all();
    }

    

    /*
    |-------------------------------------------------------------------------------
    |
    | 抽象函数定义
    |
    |-------------------------------------------------------------------------------
    */
    abstract public function persist();

    


    /*
    |-------------------------------------------------------------------------------
    |
    | 表单验证
    |
    |-------------------------------------------------------------------------------
    */
    public function isValid()
    {
        $validator      = $this->validator();
        return ($validator->fails())? false :true;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取验证错误信息
    |
    |-------------------------------------------------------------------------------
    */
    public function validator(){

        return Validator::make($this->fields(),$this->rules,$this->messages);
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 获取错误提示信息
    |
    |-------------------------------------------------------------------------------
    */
    public function errors(){
        $validator          = $this->validator();
        $str                = '';
        foreach($validator->messages()->all() as $error){
            $str           .= '<p><i="fa fa-times"></i>'.$error.'</p>';
        }
        return $str;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 魔术方法 把表单的字段绑定到form类的属性上
    |
    |-------------------------------------------------------------------------------
    */
    public function __get($property)
    {
       
        return request()->input($property);
    }
}
