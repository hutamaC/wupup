<?php namespace Phpstore\Brand;

use Phpstore\Grid\TableData;
use Phpstore\Grid\Grid;
use Phpstore\Grid\Page;
use Phpstore\Grid\Common;
use Phpstore\Base\Goodslib;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Goods;
/*
|-------------------------------------------------------------------------------
|
|   商品控制器里面的grid相应操作函数
|
|-------------------------------------------------------------------------------
|
|   tableDataInit  	    --------------- 初始化tableData实例 并赋值给grid实例
|   setTableDataCol		--------------- 设置tabledata实例需要显示的数据库字段
|   getData 		    --------------- 根据指定的字段 获取表格所需要显示的所有数据
|   getTableData($info) --------------- 根据返回的json格式数据 初始化新的tableData实例
|   searchData          --------------- grid模板页面 需要的搜索表单配置数组
|   searchInfo 			--------------- grid模板页面 ajax操作函数 需要的json格式参数
|                                       ps.ui.grid(ajax_url,_token ,json)
|   FormData            --------------- 生成添加商品时候的表单数据信息
|   EditData            --------------- 编辑商品时候生成表单的数组信息
|   get_cat_name        --------------- 通过分类id 获取分类名称
|   get_brand_name      --------------- 通过品牌id 获取品牌名称
|
|
|-------------------------------------------------------------------------------
*/
class CommonHelper{

	protected $data;



	/*
	|----------------------------------------------------------------------------
	|
	|  构造函数
	|
	|----------------------------------------------------------------------------
	*/
	function __construct(){

		//定义商品的常用操作链接
        $this->list_url             = 'admin/brand';
        $this->edit_url             = 'admin/brand/edit/';
        $this->add_url              = 'admin/brand/add';
        $this->update_url           = 'admin/brand/update';
        $this->del_url              = 'admin/brand/del/';
        $this->batch_url            = 'admin/brand/batch';
        $this->preview_url          = 'brand/preview/';
        $this->ajax_url             = 'admin/brand/grid';



	}


	/*
    |-------------------------------------------------------------------------------
    |
    |  初始化tableData 输出初始的商品列表dom元素
    |  设置 数据表   					table ---- goods
    |  设置排序方式  					orderBy('id','desc')
    |  设置等于搜索
    |
    |  brand_id  					品牌
    |  is_new    					新品
    |  is_best   					精品
    |  is_hot    					热卖
    |  is_on_sale 					上架
    |
    |  设置关键字搜索  				商品名称 goods_name
    |  where('goods_name','like',''.$goods_name.'')
    |
    |  设置whereIn操作
    |  whereIn('cat_id',[1,2,3,4,5])
    |  系统会根据以上条件拼接sql查询 把最终结果返回给grid类来处理
    |
    |-------------------------------------------------------------------------------
    */
    public function tableDataInit(){


        $tableData                  = new TableData();

        //设置参数
        $tableData->put('table','brand');
        $tableData->put('sort_name','id');
        $tableData->put('sort_value','desc');

        //设置等于搜索数组
        //无等于搜索

        //设置搜索关键字
        $tableData->keywords('brand_name','');

        //设置whereIn搜索



        //设置数据表格每列显示的字段名称
        $tableData              = $this->setTableDataCol($tableData);

         //给page设置参数
         $current_page           = 1;
         $per_page               = 20;
         $total                  = intval($tableData->total());
         $last_page              = ceil($total / $per_page);
         $tableData->page('current_page',$current_page);
         $tableData->page('per_page',$per_page);
         $tableData->page('total',$total);
         $tableData->page('last_page',$last_page);

         //获取个性化后的数据
         $data                   = $this->getData($tableData->toArray());
         $tableData->put('data',$data);

        return $tableData;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   设置数据表中需要显示的所有数据字段 并根据需求格式化数据内容
    |
    |-------------------------------------------------------------------------------
    */
    public function setTableDataCol(TableData $tableData){

        //设置数据表格每列显示的字段名称
        $tableData->addCol('id','id','编号','50px');
        $tableData->addCol('brand_name','brand_name','品牌名称','200px');
        $tableData->addCol('brand_url','brand_url','品牌网址','');
        $tableData->addCol('brand_logo','brand_logo_str','品牌logo','');
        $tableData->addCol('sort_order','sort_order','品牌排序','');
        $tableData->addCol('is_show','is_show_str','是否显示','');
        $tableData->addCol('diy_url','diy_url','自定义链接','');


        return $tableData;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  把获取的数据 再进一步格式化
    |
    |-------------------------------------------------------------------------------
    */
    public function getData($data){

        if(empty($data)){

            return '';
        }

        foreach($data as $key=>$value){

            $brand                                 = Brand::find($value['id']);
            //alias赋值
            $data[$key]['brand_logo_str']          = $brand->presenter()->logoHtml();
            $data[$key]['is_show_str']             = Common::get_tag_status($value['is_show']);


            //操作链接
            $data[$key]['edit_url']                 = Common::get_resource_edit_url($this->list_url,$value['id']);
            $data[$key]['del_url']                  = Common::get_del_url($this->del_url,$value['id']);
            $data[$key]['preview_url']= Common::get_preview_url($this->preview_url,$value['id'],'brand');
        }

        return $data;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  根据返回的json格式的数据  格式化相关数据
    |
    |-------------------------------------------------------------------------------
    */
    public function getTableData($info){


        $tableData                  = new TableData();

        $sort_name                  = $info->sort_name;
        $sort_value                 = $info->sort_value;
        $current_page               = $info->page;
        $per_page                   = $info->per_page;

        $fieldRow                   = $info->fieldRow;
        $keywords                   = $info->keywords;
        //$whereIn                    = $info->whereIn;


        //设置参数
        $tableData->put('table','brand');
        $tableData->put('sort_name',$sort_name);
        $tableData->put('sort_value',$sort_value);

        //设置关键词
        if($keywords){

            foreach($keywords as $key=>$value){

                $tableData->keywords($key , $value);
            }
        }

        /*
        //设置fieldRow 等于搜索
        if($fieldRow){

            foreach($fieldRow as $key=>$value){

                $tableData->addField($key , $value);
            }
        }

        //设置whereIn搜索
        if($whereIn){

             $in_field              = $whereIn->in_field;
             $in_value              = $whereIn->in_value;

             //这里为商品分类  获取该分类下所有子类
             $row                   = Common::get_child_row($in_value);

             $tableData->whereIn($in_field,$row);
        }

        */

        //设置数据表格每列显示的字段名称
        $tableData              = $this->setTableDataCol($tableData);

         //设置分页参数信息
         $total                  = intval($tableData->total());
         $last_page              = ceil($total / $per_page);
         $tableData->page('current_page',$current_page);
         $tableData->page('per_page',$per_page);
         $tableData->page('total',$total);
         $tableData->page('last_page',$last_page);

         //获取个性化后的数据
         $data                   = $this->getData($tableData->toArray());
         $tableData->put('data',$data);

         return $tableData;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 生成grid页面 搜索表单的配置数组
    |
    |-------------------------------------------------------------------------------
    */
    public function searchData(){

        return [

                    [
                        'type'          => 'select',
                        'field'         => 'per_page',
                        'name'          => '分页大小',
                        'option_list'   => Common::get_per_page_option_list(),
                        'selected_name' => '5个/页',
                        'selected_value'=> 5,
                        'id'            => 'per_page',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'brand_name',
                        'name'          => '品牌名称',
                        'value'         => '',
                        'id'            => 'brand_name',
                    ],


                    [
                        'type'          => 'button',
                        'name'          => '搜索',
                        'id'            => 'search-btn',
												'back_url' 			=> url($this->list_url),
                    ],
        ];

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  把执行ajax的搜索参数 用json格式化后 传递给grid页面
    |
    |-------------------------------------------------------------------------------
    */
    public function searchInfo(){

        $row    = [

                    'keywords'=>[
                                    ['field'=>'brand_name','value'=>'']
                    ],
        ];


        return  json_encode($row,JSON_UNESCAPED_UNICODE);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 添加商品 生成form表单的配置参数
    |
    |-------------------------------------------------------------------------------
    */
    public function FormData(){

        return [

                    [
                        'type'          => 'text',
                        'field'         => 'brand_name',
                        'name'          => '品牌名称',
                        'value'         => '',
                        'id'            => 'brand_name',
                    ],


                    [
                        'type'          => 'text',
                        'field'         => 'brand_en_name',
                        'name'          => '英文名称',
                        'value'         => '',
                        'id'            => 'brand_name',
                    ],


                    [
                        'type'          => 'text',
                        'field'         => 'brand_country',
                        'name'          => '品牌国家',
                        'value'         => '',
                        'id'            => 'brand_name',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'brand_url',
                        'name'          => '品牌网址',
                        'value'         => '',
                        'id'            => 'brand_url',
                    ],

                    [
                        'type'          => 'file',
                        'field'         => 'brand_logo',
                        'name'          => '品牌logo',
                        'value'         => '',
                        'file_info'     => '',
                        'upload_img'    =>'',
                        'id'            => 'brand_logo',
                    ],


                    [
                        'type'          => 'radio',
                        'field'         => 'is_show',
                        'name'          => '是否显示',
                        'radio_row'     => Common::get_radio_show_list(),
                        'checked'       => 1,
                        'id'            => 'is_show',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'sort_order',
                        'name'          => '品牌排序',
                        'value'         => '',
                        'id'            => 'sort_order',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'diy_url',
                        'name'          => '自定义链接',
                        'value'         => '',
                        'id'            => 'diy_url',
                    ],

                    [
                        'type'          => 'ueditor',
                        'field'         => 'brand_desc',
                        'name'          => '品牌描述',
                        'value'         => '',
                        'id'            => 'editor',
                    ],



                    [
                        'type'          => 'submit',
                        'value'         => '确认添加',
                        'id'            => 'cat-submit',
                        'back_url'      => url($this->list_url),
                    ],
        ];

    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 编辑商品 生成form表单的配置参数
    |
    |-------------------------------------------------------------------------------
    */
    public function EditData($model){

        return [

                    [
                        'type'          => 'text',
                        'field'         => 'brand_name',
                        'name'          => '品牌名称',
                        'value'         => $model->brand_name,
                        'id'            => 'brand_name',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'brand_en_name',
                        'name'          => '英文名称',
                        'value'         => $model->brand_en_name,
                        'id'            => 'brand_name',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'brand_country',
                        'name'          => '品牌国家',
                        'value'         => $model->brand_country,
                        'id'            => 'brand_name',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'brand_url',
                        'name'          => '品牌网址',
                        'value'         => $model->brand_url,
                        'id'            => 'brand_url',
                    ],

                    [
                        'type'          => 'file',
                        'field'         => 'brand_logo',
                        'name'          => '品牌logo',
                        'value'         => $model->brand_logo,
                        'file_info'     => '',
                        'upload_img'    =>$model->presenter()->logo(),
                        'id'            => 'brand_logo',
                    ],


                    [
                        'type'          => 'radio',
                        'field'         => 'is_show',
                        'name'          => '是否显示',
                        'radio_row'     => Common::get_radio_show_list(),
                        'checked'       => $model->is_show,
                        'id'            => 'is_show',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'sort_order',
                        'name'          => '品牌排序',
                        'value'         => $model->sort_order,
                        'id'            => 'sort_order',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'diy_url',
                        'name'          => '自定义链接',
                        'value'         => $model->diy_url,
                        'id'            => 'diy_url',
                    ],

                    [
                        'type'          => 'ueditor',
                        'field'         => 'brand_desc',
                        'name'          => '品牌描述',
                        'value'         => $model->brand_desc,
                        'id'            => 'editor',
                    ],

                    [
                        'type'          =>'hidden',
                        'field'         =>'id',
                        'value'         =>$model->id,
                        'id'            =>'id',
                    ],

										[
                        'type'          => 'hidden',
                        'field'         => '_method',
                        'name'          => '表单递交方法',
                        'value'         => 'PUT',
                        'id'            => 'method',
                    ],

                    [
                        'type'          => 'submit',
                        'value'         => '确认添加',
                        'id'            => 'cat-submit',
                        'back_url'      => url($this->list_url),
                    ],
        ];

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取商品名称
    |
    |-------------------------------------------------------------------------------
    */
    public function get_cat_name($cat_id){

    	$cat 				= Category::find($cat_id);

    	if(empty($cat)){

    		return '';
    	}

    	return $cat->cat_name;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取品牌名称
    |
    |-------------------------------------------------------------------------------
    */
    public function get_brand_name($brand_id){

    	$brand 				= Brand::find($brand_id);

    	if(empty($brand)){

    		return '';
    	}

    	return $brand->brand_name;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 删除品牌logo
    |
    |-------------------------------------------------------------------------------
    */
    public function delete_brand_image($id){

        $model              = Brand::find($id);

        if(empty($model)){

            return ;
        }

        $img                = $model->brand_logo;

        if($img){

            @unlink(public_path().'/'.$img);
        }


    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  生成批量删除 和 批量回收站按钮
    |
    |-------------------------------------------------------------------------------
    */
    public function batch_all_btn(){

        $str    = '<div class="form-group">'
                 .'<span class="btn del-btn btn-danger" data-value="softdel">'
                 .'<i class="fa fa-refresh"></i>批量回收站'
                 .'</span>'
                 .'<span class="btn del-btn btn-success" data-value="delete"><i class="fa fa-times"></i>批量删除</span>'
                 .'</div>';

        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  生成批量删除按钮
    |
    |-------------------------------------------------------------------------------
    */
    public function batch_del_btn(){

        $str    = '<div class="form-group">'
                 .'<span class="btn del-btn btn-danger" data-value="delete"><i class="fa fa-times"></i>批量删除</span>'
                 .'</div>';

        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 批量回收站操作
    |
    |-------------------------------------------------------------------------------
    */
    public function softdelAction($ids){

        foreach($ids as $id){

            $model                  = Goods::find($id);
            $model->is_delete       = 1;
            $model->save();
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 批量删除操作
    |
    |-------------------------------------------------------------------------------
    */
    public function deleteAction($ids){

        foreach($ids as $id){

            $model                  = Brand::find($id);
            $this->delete_brand_image($id);
            $model->delete();
        }
    }


}
