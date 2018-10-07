<?php

namespace LaraStore\Helpers\Category;
use App\Models\Category;
use DB;

class CatList{

	protected $category;
	/*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Category $category,$search=''){
    	$this->category 		= $category;
        $this->search           = $search;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  获取分类下的品牌列表函数
    |
    |-------------------------------------------------------------------------------
    */
    public function handle(){

    	return $this->toArray();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  基础查询
    |
    |-------------------------------------------------------------------------------
    */
    public function baseQuery(){
        if(!$this->search){
            return  Category::where('parent_id',$this->category->id);
        }else{
            return  Category::where('parent_id',$this->category->id)->where('cat_name','like','%'.$this->search.'%');    
        }
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  拼接查询
    |
    |-------------------------------------------------------------------------------
    */
    public function query(){

    	return  $this->baseQuery();
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  wherein查询
    |
    |-------------------------------------------------------------------------------
    */
    public function whereInQuery(){
    	return $this->baseQuery()->whereIn('g.cat_id',$this->category->ids());
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  where查询
    |
    |-------------------------------------------------------------------------------
    */
    public function whereQuery(){

    	return $this->baseQuery()->where('g.cat_id',$this->category->id);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  进一步格式化商品列表数据
    |
    |-------------------------------------------------------------------------------
    */
    public function toArray(){
        $arr        = [];
        foreach($this->baseQuery()->get() as $cat){
            $arr[]  =[
                'id'                =>$cat->id,
                'cat_name'        =>$cat->cat_name,
                'cat_img'           =>url($cat->cat_img),
                'url'               =>url('category/'.$cat->id),
            ];
        }

        return $arr;
    }


}