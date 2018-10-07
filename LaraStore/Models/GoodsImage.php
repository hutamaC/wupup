<?php

namespace LaraStore\Models;
use App\Models\Goods;
use LaraStore\Models\CommonTrait;

class GoodsImage{
  

  use CommonTrait;
  protected $goods;

  /*
  |-------------------------------------------------------------------------------
  |
  |  构造函数
  |
  |-------------------------------------------------------------------------------
  */
  public function __construct(Goods $goods){

  	  $this->goods 			= $goods;
  }


  /*
  |-------------------------------------------------------------------------------
  |
  |  获取商品的缩略图
  |
  |-------------------------------------------------------------------------------
  */
  public function thumb(){

  	  return $this->src(optional($this->goods->gallery()->first())->thumb);
  }



  /*
  |-------------------------------------------------------------------------------
  |
  |  获取商品的详情页面图片
  |
  |-------------------------------------------------------------------------------
  */
  public function img(){
  	 return $this->src(optional($this->goods->gallery()->first())->img());
  }


  /*
  |-------------------------------------------------------------------------------
  |
  |  获取商品的原始上传图片
  |
  |-------------------------------------------------------------------------------
  */
  public function originalImg(){
  	return $this->src(optional($this->goods->gallery()->first())->original);
  }

  /*
  |-------------------------------------------------------------------------------
  |
  |  魔术方法获取 把属性绑定到对象
  |
  |-------------------------------------------------------------------------------
  */
  public function __get($field){

    return (in_array($field,['thumb','img','originalImg']))?  call_user_func([$this,$field]) : false;
  }


}