<?php

namespace LaraStore\Forms\Category;
use App\Models\Category;
use App\Models\Brand;
use LaraStore\Forms\Form;
use Phpstore\Grid\Page;
use LaraStore\Helpers\Category\BrandPage;
use App\Http\Controllers\Api\ApiController as Api;
use Cache;

class ShowForm extends Form{

	public $api;
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
    public function __construct(Api $api , $id,$search=''){
       $this->api           = $api;
       $this->id            = $id;
       $this->search        = $search;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   检测模型是否存在
    |
    |-------------------------------------------------------------------------------
    */
    public function isEmpty(){

    	return (empty(Category::find($this->id)))? true:false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   isValid
    |
    |-------------------------------------------------------------------------------
    */
    public function isValid(){

        return ($this->isEmpty())? false : true;
    }

    

    /*
    |-------------------------------------------------------------------------------
    |
    |  成功后返回
    |
    |-------------------------------------------------------------------------------
    */
    public function successRespond(){
        Cache::flush();

    	$tag 				= 'success';
    	$info 				= 'success';
        $model  			= Category::find($this->id);
        $price 				= $model->price();
        $brand 				= $model->brand();
        //dd($this->search);

        if(!$this->search){
            $goods_list 		= $model->goods_list();
        }else{
            $goods_list         = $model->goods_search_list($this->search);
        }
        $brand_name         = '';
        if(request()->brid){
            // dd(request()->brid);
            $brand_name = Brand::find(request()->brid)->brand_name;
        }


        $attr               = $model->attr();
        $field              = $model->field();
        $page               = $model->presenter()->page()->handle();
        $current_page       = $page['current_page'];
        $total              = $page['total'];
        $per_page           = $page['per_page'];
        $last_page          = $page['last_page'];
        $number             = $page['number'];

        $sonCat             = $model->getChildren();

        $cat_id             = $this->id;
        $cat_sign           = $model->cat_sign;
        $brand_id           = 0;
       
        $goods_attr_ids     = [];
        $goods_attrs        = [];
        $goods_field_ids    = [];
        $goods_fields       = [];
        $max                = 0;
        $min                = 0;
        $sort_name          = 'id';
        $sort_value         = 'asc';

    	return $this->api->respond(['data'=>compact($this->field())]);
    	
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  返回珠宝品牌
    |
    |-------------------------------------------------------------------------------
    */

    public function successBrandRespond(){

         // Cache::flush();

        $tag                = 'success';
        $info               = 'success';
        // dd(request()->toArray());
        $model              = Brand::where('brand_name','like','%'.'珠宝'.'%');
        if(request()->param){
            $reqArr         = request()->toArray();
            $param          = json_decode($reqArr['param'],true);
            if($param['country'] != '所有'){
                $model          = $model->where('brand_country',$param['country']);
            }
        }

        $country            = $model->pluck('brand_country');
        $goods_list          = []; 

        $total              = $model->get()->count();
        // dd($total);
        $page               = new BrandPage(new Page,$total);

        $page               = $page->handle();
        // dd($page->current_page);
        $current_page       = $page['current_page'];
       
        $per_page           = $page['per_page'];
        $last_page          = $page['last_page'];
        $number             = $page['number'];

        foreach($model->get() as $k=>$v){

            $goods_list[]  =[
                'id'                =>$v->id,
                'brand_name'        =>$v->brand_name,
                'brand_en_name'     =>$v->brand_en_name,
                'brand_logo'        =>url($v->brand_logo),
                'url'               =>url('category/'.request()->id,['brid',$v->id]),
            ];
        }



        return $this->api->respond(['data'=>compact($this->brand_field())]);
        
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  返回品牌数据字段数组
    |
    |-------------------------------------------------------------------------------
    */


    public function brand_field(){
        return [ 
                                            
                'tag',//执行结果
                'info',//弹出信息
                'goods_list',
                'page',
                'country',
                'current_page',
                'last_page',
                'per_page',
                'total',
                'number',
        ];
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  返回数据字段数组
    |
    |-------------------------------------------------------------------------------
    */
    public function field(){

        return [ 
                                            
                'tag',//执行结果
                'info',//弹出信息
                'goods_list',
                'page',
                'price',
                'brand',
                'attr',
                'field',
                'number',
                'goods_attr_ids',//被选中的商品属性值编号数组
                'goods_attrs',
                'goods_field_ids',//被选中的商品规格值编号数组
                'goods_fields',//规格值
                'max',//价格区间最大值
                'min',//价格区间最小值
                'cat_id',//分类编号
                'brand_id',//品牌编号
                'brand_name',//品牌名称
                'sort_name',
                'sort_value',
                'current_page',
                'last_page',
                'per_page',
                'total',
                'goods_cat',
                'sonCat',
                'cat_sign',
        ];
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  验证未通过返回错误信息
    |
    |-------------------------------------------------------------------------------
    */
    public function errorRespond(){

    	if($this->isEmpty()){
            $info               = '模型异常';
    		return $this->api->respondCommonError($info);
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