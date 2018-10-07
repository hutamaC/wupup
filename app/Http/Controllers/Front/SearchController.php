<?php
/*
|-------------------------------------------------------------------------------
|
|  搜索控制器
|
|-------------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Front;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Session;
use Phpstore\Base\Common;
use App\Models\ArticleCat;
use App\Models\Goods;
use App\Models\Search;
use Request;
use App\Models\Slider;



class SearchController extends BaseController
{



    public $common;
    /*
    |-------------------------------------------------------------------------------
    |
    |  构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct()
    {

        parent::__construct();
        
        $this->common       = new Common();

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  处理搜索post请求
    |
    |-------------------------------------------------------------------------------
    */
    public function search(){


        $keywords               = Request::input('keywords'); 

        $view                   = $this->view('search');
        $view->breadcrumb       = $this->common->get_breadcrumb(trans('front.search'));
        $view->goods_list       = $this->common->get_search_goods_list($keywords);
         $this->view->slider         = Slider::getList();
        $this->view->keywords             =$keywords ;
        // dd($this->view->data);

        return $view;
    }


    public function getdata(){
        $search = new Search;
        return $search->getGoods('');
    }

}