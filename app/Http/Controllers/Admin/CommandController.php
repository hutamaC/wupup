<?php namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\ArticleCat;
use Phpstore\Crud\Crud;
use Phpstore\Crud\TemplateForm;
use HTML;
use Phpstore\Crud\FormToModel;
use Phpstore\Base\Sysinfo;
use Phpstore\Base\Lang;
use Validator;
use Input;
use Request;
use File;
use App\User;
use App\Models\Role;
use Phpstore\Grid\Grid;
use Phpstore\Grid\TableData;
use Phpstore\Grid\Page;
use Phpstore\Grid\Common;
use App\Models\Goods;
use App\Models\Category;
use App\Models\Brand;
use App\Models\GoodsGallery;
use Phpstore\Base\Goodslib;
use Phpstore\Base\Base;
use Image;
use Session;
use DB;
use Phpstore\Crud\ImageLib;
use Excel;


/*
|----------------------------------------------------------------------------------------
|
|  Excel导入导出商品数据信息 
|
|---------------------------------------------------------------------------------------
*/
class CommandController extends BaseController{



    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public $page;
    public $tag;
    public $view;
    public $layout;
    public $form;
    public $crud;
    public $row;
    public $form_to_model;

    function __construct(){

    	parent::__construct();
        $this->page                 = 'goods';
        $this->tag                  = 'admin.command.index';
        $this->crud                 = new Crud();
        $this->form_to_model        = new FormToModel();

        //定义商品的常用操作链接
        $this->list_url             = 'admin/command';
        
        

        //其他设置
        $this->sysinfo              = new Sysinfo();
        $this->sysinfo->put('url',url($this->list_url));
        $this->sysinfo->put('page',$this->page);
        $this->sysinfo->put('tag',$this->tag);  
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 显示命令行添加商品数据信息
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){

        $view                   = $this->view('command');
        $view->page             = $this->page;
        $view->tag              = $this->tag;
        $current_url            = HTML::link($this->list_url,trans('admin.command_insert'));
        $view->path_url         = $this->get_path_url($current_url);
        $view->action_name      = trans('admin.command_insert');

        return $view;
    }


}
