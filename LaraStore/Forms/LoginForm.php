<?php

namespace LaraStore\Forms;

use App\Http\Controllers\Api\ApiController as Api;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;

class LoginForm extends Form{

	protected $api;
	/*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则
    |
    |-------------------------------------------------------------------------------
    */
    protected $rules = [
        'phone'     => 'required',
        'password'  => 'required|min:6',
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则提示信息
    |
    |-------------------------------------------------------------------------------
    */
    protected $messages = [
       	'phone.required' =>'请输入用户名或者手机号码',
        'password.min' =>'密码至少6位',
       
    ];



    /*
    |-------------------------------------------------------------------------------
    |
    | 表单格式验证错误
    |
    |-------------------------------------------------------------------------------
    */
    public function errorRespond(){

    	if(!$this->isValid()){
            $info               = $this->errors();
    		return $this->api->respondCommonError($info);
    	}
        //账号密码错误
        if(!$this->login()){
            $info               = '账号密码错误';
            return $this->api->respondCommonError($info);
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  保存成功 返回api信息
    |
    |-------------------------------------------------------------------------------
    */
    public function successRespond(){
        $this->login();
    	$tag 			= 'success';
    	$info 			= 'success';
    	return $this->api->respond(['data'=>compact('tag','info')]);
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  用户登录
    |
    |-------------------------------------------------------------------------------
    */
    public function login(){
    	
    	//验证通过后 登录
        $phone                      = $this->phone;
        $password                   = $this->password;
        $remember                   = ($this->remember == 1)? true:false;
        $user = User::where('username',$phone)->first();
        //dd(Hash::check($password, $password2));

        if($id = $this->check()){

               //登录成功 写入登录ip
               Auth::login($user,true);
               //dd(Auth::check('user'));
               $user                = Auth::user('user');
               $user->loginIp();
               return true;
         }
         return false;
    }

    public function check(){
         $user = User::where('username',$this->phone)->orWhere('phone',$this->phone)->first();
         if(!$user){
            return false;
         }
         $Userpassword = $user->password;
         if(!Hash::check($this->password, $Userpassword)){
            return false;
         }
         return $user->id;

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  用户登录
    |
    |-------------------------------------------------------------------------------
    */
    public function persist(){
    	return true;
    }


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
}