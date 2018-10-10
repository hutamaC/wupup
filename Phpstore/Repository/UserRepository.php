<?php

namespace Phpstore\Repository;
use Config;
use File;
use Storage;
use Phpstore\Oss\ImageOss;
use App\Models\Cart;
use App\Models\Account;
use Hash;
use LaraStore\Presenters\UserPresenter;

trait UserRepository{


  	/*
  	|-------------------------------------------------------------------------------
  	|
  	| 使用trait 让模型User 拥有业务逻辑所需的方法
  	| 获取用户上传的头像
  	|
  	|-------------------------------------------------------------------------------
  	*/
  	public function icon(){
      
      	//没上传头像直接返回
  	  	if(empty($this->user_icon)){

  	  	 	 return false;

  	  	}
  	  	//获取filesystems的存储介质
  	  	$config 			= Config::get('filesystems.default');
  	  	//key:vlaue值
  	  	$arr 				= [
  	  						 	'oss' 		=> env('ALIOSS_BASEURL').$this->user_icon,
  	  						 	'local'		=> url($this->user_icon),
  	  	];
  	  	//返回相应的值
  	  	return  (in_array($config,['oss','local'])) ? $arr[$config] : false;
  	}



    /*
    |-------------------------------------------------------------------------------
    |
    | 使用trait 让模型User 拥有业务逻辑所需的方法
    | 获取用户上传的头像
    |
    |-------------------------------------------------------------------------------
    */
    public function getOssIconAttribute(){
       return $this->icon();
    }


  	/*
    |-------------------------------------------------------------------------------
    |
    | 设置密码
    |
    |-------------------------------------------------------------------------------
    */
    public function password(){

        if(request()->password){

            $this->password     = Hash::make(request()->password);
            $this->save();
        }
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  上传用户头像
    |
    |-------------------------------------------------------------------------------
    */
    public function img(){

    	 //初始化图片上传对象
    	$img 						= new ImageOss();
    	$img->put('file_name','user_icon');

    	//如果上传图片成功
    	if($upload_img  = $img->upload_image()){

    		//删除旧图片
    		$this->delete_img();
    		//更新数据库记录
        $this->user_icon  = $upload_img;
        $this->save();
    	}

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  处理上传ip地址
    |
    |-------------------------------------------------------------------------------
    */
    public function ip(){

        $this->ip     = request()->getClientIp();
        $this->save();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  删除上传头像
    |
    |-------------------------------------------------------------------------------
    */
    public function delete_img(){

    	if(Storage::exists($this->user_icon)){
    		//删除操作
    		Storage::delete($this->user_icon);
    	}

    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  获取用户注册或添加的时间
    |
    |-------------------------------------------------------------------------------
    */
    public function add_time(){

        return  ($this->add_time == 0) ? '':date('Y-m-d',$this->add_time);
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  获取用户注册或添加的时间
    |
    |-------------------------------------------------------------------------------
    */
    public function getRegisterTimeFormatAttribute(){
      return $this->add_time();
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  获取登录用户的购物车列表
    |
    |-------------------------------------------------------------------------------
    */
    public function cart_list(){

        return  $this->cart()->get();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取 ajax的购物车列表
    |
    |-------------------------------------------------------------------------------
    */
    public function ajax_cart_list(){

        $row                      = $this->cart()->get();

        foreach($row as $key=>$cart){
             $cart['thumb']       = $cart->goods->thumb();
             $cart['total']       = $cart->total();
             $cart['url']         = $cart->goods->url();
             $cart['short_goods_name'] = str_limit($cart->goods_name,25,'..');
        }

        return $row;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  获取当前登录用户购物车中商品总记录数 和总金额
    |
    |-------------------------------------------------------------------------------
    */
    public function  amount(){

        $amount         = 0;

        foreach($this->cart()->where('is_checked',1)->get() as $item){

             $amount   += $item->total();
        }
        return $amount;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取当前登录购物车中 商品总数量
    |
    |-------------------------------------------------------------------------------
    */
    public function number(){

      return ($this->cart()->where('is_checked',1)->sum('goods_number')) ? $this->cart()->where('is_checked',1)->sum('goods_number') : 0;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  获取当前登录购物车中 所有商品数量 选中和未选中的
    |
    |-------------------------------------------------------------------------------
    */
    public function allNumber(){

        return  ($value = $this->cart()->sum('goods_number'))? $value : 0;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  获取当前登录购物车中的ajax 记录 返回给js
    |
    |-------------------------------------------------------------------------------
    */
    public function cartJSON(){
    
        $row         = [ 
                          'cart_list'       => $this->ajax_cart_list(),
                          'cart_total'      => $this->amount() ,
                          'cart_number'     => $this->number(),
                          'all_number'      => $this->allNumber(),
                          'is_all_checked'  => $this->isAllChecked(),
                          'cart_amount'     => Cart::amountAll(),

                       ];

        echo json_encode($row, JSON_UNESCAPED_UNICODE);
        exit;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 购物车中 如果有商品未被选中 则直接返回 0
    |
    |-------------------------------------------------------------------------------
    */
    public function isAllChecked(){


      if(count($this->cart()->get()) == 0){

        return 0;
      }

      foreach($this->cart()->get() as $cart){

        if($cart->is_checked == 0){

          return 0;
        }
      }

      return 1;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 购物车中 所有商品被选中
    |
    |-------------------------------------------------------------------------------
    */
    public function allCartChecked(){

        foreach($this->cart()->get() as $cart){

           $cart->doChecked();
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 购物车中 所有商品被取消选中
    |
    |-------------------------------------------------------------------------------
    */
    public function allCartUnChecked(){
       foreach($this->cart()->get() as $cart){
          $cart->unChecked();
       }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取用户选择下拉表单
    |
    |-------------------------------------------------------------------------------
    */
    public static function optionList(){
       $self        = new static;
       $str         = '';
       foreach($self->all() as $user){

           $str    .= '<option value="'.$user->id.'">'.$user->username.'</option>';
       }
       return $str;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 获取登录用户 是否拥有当前的礼品卡串号
    |
    |-------------------------------------------------------------------------------
    */
    public function checkGiftCard($card_sn){

      
      $res  = $this->card()->where('card_sn',$card_sn)
                           ->where('add_time','<=',time())
                           ->where('tag',1)
                           ->where('end_time','>=',time())
                           ->first();
      return $res ? true:false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取用户的默认地址信息
    |
    |-------------------------------------------------------------------------------
    */
    public function default_address(){

        if($this->address_id == 0){
           return false;
        }
        return ($this->address)? $this->address()->where('id',$this->address_id)->first() : false;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取当前登录用户 可以使用的礼品卡
    |
    |-------------------------------------------------------------------------------
    */
    public function giftCardList(){

       return  $this->card()->where('tag',1)
                            ->where('add_time','<=',time())
                            ->where('end_time','>=',time())
                            ->get();
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 保存用户的的登录ip地址
    |
    |-------------------------------------------------------------------------------
    */
    public function loginIp(){
       $this->login_ip   = request()->getClientIp();
       $this->save();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取性别
    |
    |-------------------------------------------------------------------------------
    */
    public function sex(){

        $arr    = ['男','女','保密'];

        if(in_array($this->sex,[0,1,2])){

            return $arr[$this->sex];
        }

        return $arr[2];
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取性别
    |
    |-------------------------------------------------------------------------------
    */
    public function getSexNameAttribute(){
      return $this->sex();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取上次登录的时间
    |
    |-------------------------------------------------------------------------------
    */
    public function last_login_time(){

        if($this->last_login_time == 0){

            return '';
        }

        return date('Y-m-d H:i:s',$this->last_login_time);
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取账户所有充值记录
    |
    |-------------------------------------------------------------------------------
    */
    public function cz(){

        return Account::where('pay_tag',1)
                      ->where('type',0)
                      ->where('username',$this->username)
                      ->sum('amount');
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取账户所有提现记录
    |
    |-------------------------------------------------------------------------------
    */
    public function tx(){

        return Account::where('pay_tag',1)
                      ->where('type',1)
                      ->where('username',$this->username)
                      ->sum('amount');
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取账户余额
    |
    |-------------------------------------------------------------------------------
    */
    public function money(){

        return $this->cz() - $this->tx();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取上次登录的时间
    |
    |-------------------------------------------------------------------------------
    */
    public function getLastLoginTimeFormatAttribute(){
      return $this->last_login_time();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | presenter
    |
    |-------------------------------------------------------------------------------
    */
    public function presenter(){
        return new UserPresenter($this);
    }

}