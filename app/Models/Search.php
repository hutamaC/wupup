<?php

namespace App\Models;

use App\models\goods;
use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\GoodsArticleRepository;
use Phpstore\Grid\Page;

class Search extends Model

{

    protected $xs;

    //模糊搜索
    protected $fuzzy;

    //同义词搜索
    protected $synonyms;

    public function __construct($configFile = 'goods',$fuzzy = true,$synonyms = true){
        $this->page             = new Page();


        define ('XS_APP_ROOT', '/home/vagrant/xunsearch/sdk/php/app');

        $this->xs = new \XS($configFile);
        $this->fuzzy = $fuzzy;
        $this->synonyms = $synonyms;

        //获取搜索对象
        $this->search = $this->xs->search;

    }

    public function getGoods($searchname,$current_page){

        $goods = new Goods();

        $res = $this->doSearch($searchname);

        $Arr = array_column($res,'id');


        $this->model = $goods->whereIn('id',$Arr)->orWhere('goods_name','like','%'.$searchname.'%');

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

    /**
     * doSearch 使用xunsearch进行搜索
     * @param  string $keyword 搜索词语 用户从表单填写的要搜索的内容
     * @return array           搜索结果
     */
    public function doSearch($keyword)
    {

        $this->search
        ->setFuzzy($this->fuzzy);

        //设置搜索语句
        // $this->search->setQuery($keyword);

        //执行搜索，将搜索结果文档保存在 $docs 数组中
        $docs =  $this->search->search($keyword);

        if(count($docs) == 0){

          // 没有找到搜索结果
          return array();
        }

        //将结果一一取出
        foreach($docs as $k => $doc){
            if(!empty($doc)){

                //取出搜索结果
                $searchRes[] = $doc->getFields();

                //获取每个词的权重
                $searchRes[$k]['weight'] = $doc->weight();

            }
        }

       return $searchRes;

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
