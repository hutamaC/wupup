<?php

namespace App\Http\Controllers\Api;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Search;
use LaraStore\Forms\Category\ShowForm;
use LaraStore\Forms\Category\GridForm;

class CatController extends ApiController
{
    protected $tag;
    protected $info;


    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(){

        $this->tag          = 'success';
        $this->info         = 'success';
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取列表
    |
    |-------------------------------------------------------------------------------
    */
    public function index($id){
        $search = Request::input('search'); //9.12 新加
        // dd(request()->brid);
        $form           = new ShowForm($this,$id,$search);
        if($id==29 && !request()->brid ){
            return ($form->isValid())? $form->successBrandRespond() : $form->errorRespond();
        }else{
            return ($form->isValid())? $form->successRespond() : $form->errorRespond();
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | grid 获取数据
    |
    |-------------------------------------------------------------------------------
    */
    public function grid(){
        $form            = new GridForm($this);
        return ($form->isValid())? $form->successRespond() : $form->errorRespond();
    }



    public function getdata(){
       $k='';
        $current_page = 1;
        if(request()->param){
           $arr = json_decode(request()->param,true);
           $current_page = $arr['current_page'];
        }
        if(request()->keywords){
             $k = request()->keywords;
        }
        $search = new Search;
        // dd($k);
        return $search->getGoods($k,$current_page);
    }
}
