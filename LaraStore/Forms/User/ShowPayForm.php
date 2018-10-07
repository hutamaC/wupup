<?php

namespace LaraStore\Forms\User;

use Auth;
use App\User;
use App\Models\Payment;
use LaraStore\Forms\Form;
use App\Models\Order;
use App\Http\Controllers\Front\BaseController;

class ShowPayForm extends Form{

	public $api;
    public $title   = '使用账户余额支付';
	/*
    |-------------------------------------------------------------------------------
    |
    | 表单验证规则
    |
    |-------------------------------------------------------------------------------
    */
    protected $rules = [
        
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 表单验证规则提示信息
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
    public function __construct(BaseController $api,$order_id){
       $this->api           = $api;
       $this->order_id      = $order_id;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  品牌模型是否为空
    |
    |-------------------------------------------------------------------------------
    */
    public function isEmpty(){

        return (empty(Order::find($this->order_id)))? true :false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  是否登录
    |
    |-------------------------------------------------------------------------------
    */
    public function auth(){

        return  (Auth::check('user'))? true :false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  返回订单
    |
    |-------------------------------------------------------------------------------
    */
    public function  order(){

        return Order::find($this->order_id);
    }

    

    /*
    |-------------------------------------------------------------------------------
    |
    |  成功后返回
    |
    |-------------------------------------------------------------------------------
    */
    public function successRespond(){

        $view               = $this->api->view('user.payment.account_btn');
        $view->order        = $this->order();
        $view->user         = Auth::user('user');
        return $view;
    	
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  isValid
    |
    |-------------------------------------------------------------------------------
    */
    public function isValid(){

       return ((!$this->isEmpty()) && ($this->auth()))? true: false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  验证未通过返回错误信息
    |
    |-------------------------------------------------------------------------------
    */
    public function errorRespond(){

        $view                 = $this->api->view('user.payment.info');
        $view->back_url       = url('auth/order');
        $view->info           = $this->getErrorInfo();

        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取错误信息
    |
    |-------------------------------------------------------------------------------
    */
    public function getErrorInfo(){

        if($this->isEmpty()){

            return '订单号不存在';
        }
        
        if(!$this->auth()){

            return '登录后才可以支付';
        }
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 处理数据库相关操作
    |
    |-------------------------------------------------------------------------------
    */
    public function persist()
    {
         return true;
    }
}