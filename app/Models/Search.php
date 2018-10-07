<?php

namespace App\Models;

use App\models\goods;
use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\GoodsArticleRepository;
use Phpstore\Grid\Page;

class Search extends Model

{

    public function __construct(){
        $this->page             = new Page();

    }

    public function getGoods($searchname,$current_page){

        $goods = new Goods();


        $this->model = $goods->where('goods_name','like','%'.$searchname.'%');

        $tag                = 'success';
        $info               = 'success';
        // dd(request()->toArray());

        

        $total              = $this->total = $this->model->get()->count();


        $this->current_page = $current_page;

        $this->skip          =  ($current_page-1)*20;
        $per_page           = $this->per_page = 20;
        $last_page          = $this->last_page = ceil($this->total / $this->per_page);
        $this->page->put('total',$this->total)
                   ->put('per_page',$this->per_page)
                   ->put('current_page',$this->current_page)
                   ->put('last_page',$this->last_page);
        $number             = $this->page->number();

        $goods_list          = $this->toArray(); 


        return $arr = ['data'=>compact($this->field())];



    }


     /*
    |-------------------------------------------------------------------------------
    |
    |  返回品牌数据字段数组
    |
    |-------------------------------------------------------------------------------
    */


    public function field(){
        return [ 
                                            
                'tag',//执行结果
                'info',//弹出信息
                'goods_list',
                'page',
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
    |  进一步格式化商品列表数据
    |
    |-------------------------------------------------------------------------------
    */
    public function toArray(){
        $arr        = [];
        foreach($this->model->skip($this->skip)->take(20)->get() as $goods){
            $arr[]  =[
                'id'                =>$goods->id,
                'goods_name'        =>$goods->goods_name,
                'short_goods_name'  =>str_limit($goods->goods_name,25,'..'),
                'cat_id'            =>$goods->cat_id,
                'brand_id'          =>$goods->brand_id,
                'shop_price'        =>$goods->shop_price,
                'goods_sn'          =>$goods->goods_sn,
                'goods_weight'      =>$goods->goods_weight,
                'thumb'             =>$goods->thumb(),
                'url'               =>$goods->url(),
                'goods_number'      =>$goods->goods_number,
            ];
        }

        return $arr;
    }

}
