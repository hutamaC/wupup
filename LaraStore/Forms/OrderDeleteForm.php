<?php

namespace LaraStore\Forms;

use App\Http\Controllers\Api\ApiController as Api;
use App\User;
use Auth;
use App\Models\Order;
use App\Models\Goods;

class OrderDeleteForm extends Form{

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

        $model            =  Order::find($this->id);
        return empty($model)? true :false;
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

        $this->save();//删除操作在这里执行了
    	$tag 		= 'success';
    	$info 		= 'success';
        $user       = Auth::user('user');
        $order_list = $user->order()->get();
    	return $this->api->respond(['data'=>compact('tag','info','order_list')]);
    	
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
         $model       = Order::find($this->id);
         // $model->order_goods->each(function($item,$key){
         //    $item->update(['goods_number'=>1]);
         // });

         // dd();

         $goods       = Goods::whereIn('id',$model->order_goods->pluck('goods_id'));

         // dd($model->order_goods->pluck('goods_id'));


         $goods->each(function($item,$key){
            $item->update(['goods_number'=>$item->goods_number+1]);
         });

         //删除订单产品
         $model->order_goods()->delete();
         //删除订单
         $model->delete();
    }
}