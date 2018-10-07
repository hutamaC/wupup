<?php

namespace LaraStore\Forms;
use App\Http\Controllers\Api\ApiController as Api;
use Sms;
use App\User;
use Auth;

class RegisterForm extends Form{

	protected $api;
	/*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则
    |
    |-------------------------------------------------------------------------------
    */
    protected $rules = [
        'username'  => 'required|min:5',
        'phone'     => 'required|digits:11|unique:users,phone',
        'email'     => 'required|email|unique:users,email',
        'password'  => 'required|min:6',
        'code'      => 'required|sms',
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则提示信息
    |
    |-------------------------------------------------------------------------------
    */
    protected $messages = [
        'username.unique'=>'用户名已存在', 
       	'phone.digits' =>'手机为11位数字',
        'phone.unique' =>'手机号已存在',
        'email.email'  =>'电子邮件格式错误',
        'email.unique' =>'电子邮件已存在',
        'password.min' =>'密码至少6位',
        'code.required'=>'验证码必须',
        'code.sms'     =>'验证码错误',
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
    | 表单格式验证错误
    |
    |-------------------------------------------------------------------------------
    */
    public function errorRespond(){

    	if(!$this->isValid()){
            $info               = $this->errors();
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
        $this->persist();
    	$tag 			= 'success';
    	$info 			= 'success';
    	return $this->api->respond(['data'=>compact('tag','info')]);
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
        $data 	= [
        	'username'	=>$this->username,
        	'phone'		=>$this->phone,
        	'email'		=>$this->email,
        	'password'	=> \Hash::make($this->password),
        	'ip'		=> request()->ip(),
        	'reg_from'	=> '手机短信验证码注册',
            'add_time'  => time(),
        ];
        $user           = User::create($data);
        Auth::login($user);
        //销毁会话中的验证码
        Sms::put('phone',$this->phone)->destroy();
    }
}