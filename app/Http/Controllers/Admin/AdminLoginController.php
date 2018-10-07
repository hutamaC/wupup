<?php namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\ArticleCat;
use Phpstore\Crud\Crud;
use Phpstore\Crud\TemplateForm;
use Html;
use Phpstore\Crud\FormToModel;
use Phpstore\Base\Sysinfo;
use Validator;
use Input;
use Request;
use File;
use App\User;
use App\Admin;
use Phpstore\Base\Base;
use URL;
use Cache;
use DB;
use Artisan;
use Auth;
class AdminLoginController extends BaseController{



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
    public $admin_login_url;

    function __construct(){

    	parent::__construct();

        $this->crud                 = new Crud();
        $this->form_to_model        = new FormToModel();

        $this->sysinfo              = new Sysinfo();

        $this->sysinfo->put('page','');
        $this->sysinfo->put('tag','');

        $this->title                = '后台登陆';
        $this->admin_login_url      = env('ADMIN_LOGIN_URL');
    }


    /*
    |------------------------------------------------------------------
    |
    |  显示所有管理员列表
    |
    |------------------------------------------------------------------
    */

    public function login(){

        if(auth()->guard('admin')->check()){

            return redirect('admin/index');
        }

        $view                       = $this->view('login');
        $view->title                = $this->title;
        $view->admin_login_url      = $this->admin_login_url;
// 
        return $view;
    }


   


    /*
    |---------------------------------------------------------------------
    |
    |  登陆验证
    |
    |---------------------------------------------------------------------
    */
    public function login_post(){
        return true;
    } 


    /*
    |---------------------------------------------------------------------
    |
    |  退出登陆
    |
    |---------------------------------------------------------------------
    */
    public function logout(){

        if (auth()->guard('admin')->check()) {

            auth()->guard('admin')->logout();
            return redirect($this->admin_login_url);
        }
    }


    /*
    |---------------------------------------------------------------------
    |
    |  清除缓存
    |
    |---------------------------------------------------------------------
    */
    public function cache_clear(){

        Cache::flush();
        return redirect('admin/index');
    }
}
