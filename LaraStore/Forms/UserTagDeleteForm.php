<?php

namespace LaraStore\Forms;

use App\Http\Controllers\Api\ApiController as Api;
use App\User;
use Auth;
use App\Models\Tag;
use App\Models\Goods;

class UserTagDeleteForm extends Form{

	public $api;
	/*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则
    |
    |-------------------------------------------------------------------------------
    */
    protected $rules = [
        
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则提示信息
    |
    |-------------------------------------------------------------------------------
    */
    protected $messages = [
       	
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Api $api){
       $this->api       = $api;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  验证用户是否登录
    |
    |-------------------------------------------------------------------------------
    */
    public function auth(){

    	return (Auth::check('user'))? true:false;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  验证数据
    |
    |-------------------------------------------------------------------------------
    */
    public function isEmpty(){

        $tag            =  Tag::find($this->id);
        return empty($tag)? true :false;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  验证数据
    |
    |-------------------------------------------------------------------------------
    */
    public function isValid(){

        return ($this->auth() && (!$this->isEmpty())) ?  true : false;
    }




    /*
    |-------------------------------------------------------------------------------
    |
    |  成功后返回
    |
    |-------------------------------------------------------------------------------
    */
    public function successRespond(){

        $this->save();
    	$tag 		= 'success';
    	$info 		= 'success';
        $user       = Auth::user('user');
        $tag_list   = $user->tag()->get();
        $goods_list = Goods::take(1000)->get();
    	return $this->api->respond(['data'=>compact('tag','info','tag_list','goods_list')]);
    	
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  验证未通过返回错误信息
    |
    |-------------------------------------------------------------------------------
    */
    public function errorRespond(){

    	if(!$this->auth()){
            $info               = '用户未登录';
    		return $this->api->respondCommonError($info);
    	}

        if($this->isEmpty()){
            $info               = '标签不存在';
            return $this->api->respondCommonError($info);
        }
    	
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 存储注册表单中的数据到数据库
    |
    |-------------------------------------------------------------------------------
    */
    public function persist()
    {
         $tag       = Tag::find($this->id);
         $tag->delete();
    }
}