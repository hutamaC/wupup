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
use Phpstore\Base\Goodslib;
use Phpstore\Supplier\CommonHelper;
use App\Supplier;


/*
|----------------------------------------------------------------------------------------
|
| 路由类型         路由                        对应处理函数             路由名称
|
| route get      admin/category              function index()       admin.category.index
| route get      admin/category/create       function create()      admin.category.create
| route post     admin/category              function store()       admin.category.store
| route get      admin/category/{id}/edit    function edit()        admin.category.edit
| route put      admin/category/{id}         function update()      admin.category.update
|---------------------------------------------------------------------------------------
| route get      admin/category/del/{id}     function destroy()     admin.category.destroy
| route post     admin/category/batch        function batch()       admin.category.batch
| route post     admin/category/grid         function grid()        admin.category.grid
|---------------------------------------------------------------------------------------
*/
class SupplierController extends BaseController{



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
    public $list_name;
    public $add_name;
    public $edit_name;

    function __construct(){

    	parent::__construct();
        $this->page                 = 'supplier';
        $this->tag                  = 'admin.supplier.index';
        $this->crud                 = new Crud();
        $this->form_to_model        = new FormToModel();

        //定义商品的常用操作链接
        $this->list_url             = 'admin/supplier';
        $this->edit_url             = 'admin/supplier/edit';
        $this->add_url              = 'admin/supplier/create';
        $this->update_url           = 'admin/supplier/update';
        $this->del_url              = 'admin/supplier/delete/';
        $this->batch_url            = 'admin/supplier/batch';
        $this->preview_url          = '';
        $this->ajax_url             = 'admin/supplier/grid';

        //名称
        $this->list_name            = trans('admin.supplier_list');
        $this->add_name             = trans('admin.add_supplier');
        $this->edit_name            = trans('admin.edit_supplier'); 


        //初始化帮助对象
        $this->help                 = new CommonHelper();

        //其他设置
        $this->sysinfo              = new Sysinfo();
        $this->sysinfo->put('url',url($this->list_url));
        $this->sysinfo->put('page',$this->page);
        $this->sysinfo->put('tag',$this->tag);

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  显示所有商品列表信息
    |  路由：admin/cateogry
    |  路由名称：admin.goods.index
    |
    |-------------------------------------------------------------------------------
    |
    |  列表页使用通用模板  crud/gird.blade.php
    |  grid模板页面需要的dom元素包括
    |  1.page 和 tag 标签 用于指定左侧菜单的当前一级菜单和当前二级菜单
    |  2.path_url  显示面包屑导航菜单
    |  3.action_name  显示当前操作名称
    |  4.add_btn    显示添加新商品的按钮
    |  5.系统搜索表单  用crud的form类生成
    |  6.grid页面的ajax函数为  ps.ui.grid(ajax_url,_token,json)
    |    这里指定ajax_url 同时生成json格式的搜索条件参数
    |  7 生成列表页的所有记录显示table  同时包含一个portlet box  可以自定义颜色
    |  8 把初始化好的grid对象实例赋值给模板
    |  9 模板 通过 $grid->portlet() 获取带style的响应式表格
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){

        $view                       = $this->view('crud.grid');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $current_url                = HTML::link($this->list_url,$this->list_name);
        $view->path_url             = $this->get_path_url($current_url);
        $view->action_name          = $this->list_name;

        //生成添加按钮
        $view->add_btn              = Common::get_add_btn($this->add_url,$this->add_name);

        //生成搜索表单
        $this->crud->put('row',$this->help->searchData());
        $this->crud->put('url',url($this->list_url));
        $view->search               = $this->crud->render();

        //生成ps.ui.grid(ajax_url,_token,json)
        //指定ajax_url, json格式的搜索参数
        $view->ajax_url             = url($this->ajax_url);
        $view->searchInfo           = $this->help->searchInfo();

        //设置grid
        $tableData                  = $this->help->tableDataInit();
        $grid                       = new Grid($tableData);


        //指定portlet的颜色和配置文件
        //生成带配置文件的protletbox 响应式table
        //$grid->portlet()
        $grid->put('color','blue');
        $grid->put('action_name',$this->list_name);
        $view->grid                 = $grid;

        //设置批量删除操作的batch_url
        $view->batch_url            = $this->batch_url;
        //批量删除按钮
        $view->batch_btn            = Common::batch_del_btn();

        //返回视图模板
        return $view;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   执行ajax grid操作
    |   输出json格式的商品列表数据 phpstore.grid.js组件根据json格式 重新生成table 并刷新列表
    |   对应路由  admin/goods/grid
    |   路由名称  admin.goods.grid
    |
    |-------------------------------------------------------------------------------
    */
    public function grid(){

        $info           = Request::input('info');
        $info           = json_decode($info);
        $tableData      = $this->help->getTableData($info);
        $grid           = new Grid($tableData);

        echo $grid->render();

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   执行添加商品的操作
    |   调用crud通用模板 crud/crud.blade.php
    |   对应路由  admin/goods/create
    |   路由名称  admin.goods.create
    |
    |-------------------------------------------------------------------------------
    */
    public function create(){

        $view               = $this->view('crud_add');
        $view->page         = $this->page;
        $view->tag          = $this->tag;
        $current_url        = HTML::link($this->add_url,$this->add_name);
        $view->path_url     = $this->get_path_url($current_url);

        $view->action_name  = $this->add_name;

        //设置参数 通过crud组件生成输入界面表单
        $this->crud->put('row',$this->help->FormData());
        $this->crud->put('url',url($this->list_url));
        $view->form         = $this->crud->render();

        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行添加商品的操作 post
    |   路由名称：admin.category.store
    |   对应路由  admin/category
    |
    |-------------------------------------------------------------------------------
    */
    public function store(){

         $rules         = [

                                'username'              =>'required|unique:supplier,username',
                                'password'              =>'required|confirmed',
                                'password_confirmation' =>'required',
                                'email'                 =>'required|email|unique:supplier,email',

                          ];

         $validator     = Validator::make(Request::all(),$rules);

         if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            return $this->sysinfo->error();
         }

         $model             = new Supplier();
         $this->form_to_model->put('model',$model);
         $this->form_to_model->put('row',$this->help->FormData());

         if($this->form_to_model->insert()){

              return redirect($this->list_url);
         }
         else{

            return $this->sysinfo->fails();
         }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行添加商品的操作 get
    |   对应路由  admin/{id}/edit
    |   路由名称：admin.goods.edit
    |
    |-------------------------------------------------------------------------------
    */
    public function edit($id){

        $model                     = Supplier::find($id);

         if(empty($model)){

            return $this->sysinfo->forbidden();
         }

        $view                       = $this->view('crud_add');
        $view->action_name          = $this->edit_name;
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $current_url                = HTML::link($this->edit_url.$id,$this->edit_name);
        $view->path_url             = $this->get_path_url($current_url);

        //设置参数 通过crud组件生成输入界面表单
        $this->crud->put('row',$this->help->EditData($model));
        $this->crud->put('url',url($this->list_url.'/'.$id));
        $view->form                 = $this->crud->form();

        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行更新商品操作 put 这里需要伪装路由为 put
    |   路由名称：admin.category.update
    |   对应路由  admin/category/{id}
    |
    |-------------------------------------------------------------------------------
    */
    public function update(){


        $id             = Request::input('id');
        $id             = intval($id);

        $model          = Supplier::find($id);

        if(empty($model)){

           return $this->sysinfo->forbidden();
        }

         $rules         = [

                                'username'              =>'required|unique:supplier,username,'.$id,
                                'email'                 =>'required|email|unique:supplier,email,'.$id,

                          ];


        $validator      = Validator::make(Input::all(),$rules);

        if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            return $this->sysinfo->error();
        }


        $this->form_to_model->put('model',$model);
        $this->form_to_model->put('row',$this->help->EditData($model));



        if($this->form_to_model->insert()){

           return redirect($this->list_url);
        }
        else{

           return $this->sysinfo->fails();
        }

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行删除商品操作 delete
    |   对应路由  admin/goods/{id}
    |   路由名称  admin.goods.destroy
    |
    |-------------------------------------------------------------------------------
    */
    public function delete($id){

        $model          = Supplier::find($id);

        if(empty($model)){

            return $this->sysinfo->forbidden();
        }


        if($model->delete()){

            return redirect($this->list_url);
        }

        return $this->sysinfo->fails();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行批量操作 post
    |   对应路由  admin/category/batch
    |   路由名称为 admin.category.batch
    |
    |-------------------------------------------------------------------------------
    */
    public function batch(){

        $del_type           = Request::input('del_type');
        $ids                = Request::input('ids');

        if(empty($ids)){

            return $this->sysinfo->batchEmpty();
        }

        foreach($ids as $id){

            $model          = Supplier::find($id);

            if($model){

                $model->delete();
            }
        }

        return redirect($this->list_url);
    }

}
