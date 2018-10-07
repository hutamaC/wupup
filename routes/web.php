<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



   
//后台路由
Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware(['privi','log'])->group(function () {

    //excel导入导出
    //Excel导出
    Route::get('excel/export','ExcelController@export')->name('excel.export');
    //Excel导入
    Route::get('excel/import','ExcelController@import')->name('excel.import');


    //后台登陆退出
    //Route::get('login',['as'=>'admin.login.form','uses'=>'AdminLoginController@login']);
    //Route::post('login',['as'=>'admin.login.post','uses'=>'AdminLoginController@login_post']);
    Route::get('administrator/logout',['as'=>'administrator.logout','uses'=>'AdminLoginController@logout']);


    //系统后台首页
    Route::get('index',['as'=>'system.index','uses'=>'IndexController@index']);
    //后台公用省会城市地区地址三级联查ajax
    Route::post('pcd',['as'=>'pcd.ajax','uses'=>'IndexController@pcd']);


    //权限列表
    Route::resource('privi','PriviController',['only'=>['index','create','store','edit','update']]);
    Route::get('privi/del/{id}',['as'=>'privi.delete','uses'=>'PriviController@delete']);
    //新增批量添加权限
    Route::get('privi/create-batch',['as'=>'privi.batch','uses'=>'PriviController@batch']);
    Route::post('privi/batch',['as'=>'privi.batch.store','uses'=>'PriviController@batch_store']); 

    //角色管理
    Route::resource('role','RoleController',['only'=>['index','create','store','edit','update']]);
    Route::post('role/batch',['as'=>'role.batch','uses'=>'RoleController@batch']);
    Route::get('role/del/{id}',['as'=>'role.delete','uses'=>'RoleController@delete']);
    Route::post('role/grid',['as'=>'role.grid','uses'=>'RoleController@grid']);

    //管理员管理
    Route::resource('administrator','AdminController',['only'=>['index','create','store','edit','update']]);
    Route::get('administrator/del/{id}',['as'=>'administrator.delete','uses'=>'AdminController@delete']);
    Route::post('administrator/batch',['as'=>'administrator.batch','uses'=>'AdminController@batch']);
    Route::post('administrator/grid',['as'=>'administrator.grid','uses'=>'AdminController@grid']);

    //文章管理
    Route::resource('article','ArticleController',['only'=>['index','create','store','edit','update']]);
    Route::get('article/del/{id}',['as'=>'article.delete','uses'=>'ArticleController@delete']);
    Route::post('article/batch',['as'=>'article.batch','uses'=>'ArticleController@batch']);
    Route::post('article/grid',['as'=>'article.grid','uses'=>'ArticleController@grid']);

    //文章分类管理
    Route::resource('article_cat','ArticleCatController',['only'=>['index','create','store','edit','update']]);
    Route::get('article_cat/del/{id}',['as'=>'article_cat.delete','uses'=>'ArticleCatController@delete']);
    Route::post('article_cat/batch',['as'=>'article_cat.batch','uses'=>'ArticleCatController@batch']);
    Route::post('article_cat/grid',['as'=>'article_cat.grid','uses'=>'ArticleCatController@grid']);

    //日志管理
    Route::get('log',['as'=>'log.index','uses'=>'LogController@index']);
    Route::get('log/del/{id}',['as'=>'log.delete','uses'=>'LogController@delete']);
    Route::post('log/batch',['as'=>'log.batch','uses'=>'LogController@batch']);
    Route::post('log/grid',['as'=>'log.grid','uses'=>'LogController@grid']);

    //会员管理
    Route::resource('user','UserController',['only'=>['index','create','store','edit','update']]);
    Route::get('user/del/{id}',['as'=>'user.delete','uses'=>'UserController@delete']);
    Route::post('user/batch',['as'=>'user.batch','uses'=>'UserController@batch']);
    Route::post('user/grid',['as'=>'user.grid','uses'=>'UserController@grid']);

    //会员等级
    Route::resource('user_rank','UserRankController',['only'=>['index','create','store','edit','update']]);
    Route::get('user_rank/del/{id}',['as'=>'user_rank.delete','uses'=>'UserRankController@delete']);
    Route::post('user_rank/batch',['as'=>'user_rank.batch','uses'=>'UserRankController@batch']);
    Route::post('user_rank/grid',['as'=>'user_rank.grid','uses'=>'UserRankController@grid']);

    //商品管理
    Route::resource('goods','GoodsController',['only'=>['index','create','store','edit','update']]);
    Route::get('goods/del/{id}',['as'=>'goods.delete','uses'=>'GoodsController@delete']);
    Route::post('goods/batch',['as'=>'goods.batch','uses'=>'GoodsController@batch']);
    Route::post('goods/grid',['as'=>'goods.grid','uses'=>'GoodsController@grid']);
    //删除关联商品
    Route::post('goods/relation/delete/{id}',['as'=>'goods.relation.delete','uses'=>'GoodsController@relationGoodsDelete']);

    //商品回收站
    Route::get('cycle',['as'=>'cycle.index','uses'=>'CycleController@index']);
    Route::get('cycle/del/{id}',['as'=>'cycle.delete','uses'=>'CycleController@delete']);
    Route::get('cycle/softdel/{id}',['as'=>'cycle.softdel','uses'=>'CycleController@softdel']);
    Route::post('cycle/batch',['as'=>'cycle.batch','uses'=>'CycleController@batch']);

    
    //命令行导入商品数据
    Route::get('command',['as'=>'command.index','uses'=>'CommandController@index']);

    //商品图片批量处理
    Route::get('goods/image',['as'=>'goods.image','uses'=>'GoodsGalleryController@index']);
    Route::post('goods/config',['as'=>'goods.config','uses'=>'GoodsGalleryController@config']);
    Route::post('goods/image/redo',['as'=>'goods.image.redo','uses'=>'GoodsGalleryController@redo']);
    

    Route::post('goods/attribute/ajax',['as'=>'goods.attribute','uses'=>'GoodsController@ajax']);
    Route::post('goods/field/ajax',['as'=>'goods.field','uses'=>'GoodsController@FieldAjax']);
    //关联商品ajax搜索
    Route::post('goods/search',['as'=>'goods.search','uses'=>'GoodsController@search']);
    Route::post('goods/article',['as'=>'goods.article','uses'=>'GoodsController@article']);

    //商品相册ajax删除操作
    Route::post('goods/gallery/delete',['as'=>'gallery.delete','uses'=>'GoodsController@GalleryDelete']);

    //商品分类
    Route::resource('category','CategoryController',['only'=>['index','create','store','edit','update']]);
    Route::get('category/del/{id}',['as'=>'category.delete','uses'=>'CategoryController@delete']);
    Route::post('category/batch',['as'=>'category.batch','uses'=>'CategoryController@batch']);
    Route::post('category/grid',['as'=>'category.grid','uses'=>'CategoryController@grid']);


    //商品品牌管理
    Route::resource('brand','BrandController',['only'=>['index','create','store','edit','update']]);
    Route::get('brand/del/{id}',['as'=>'brand.delete','uses'=>'BrandController@delete']);
    Route::post('brand/batch',['as'=>'brand.batch','uses'=>'BrandController@batch']);
    Route::post('brand/grid',['as'=>'brand.grid','uses'=>'BrandController@grid']);

    //商品类型管理
    Route::resource('type','TypeController',['only'=>['index','create','store','edit','update']]);
    Route::get('type/del/{id}',['as'=>'type.delete','uses'=>'TypeController@delete']);
    Route::post('type/batch',['as'=>'type.batch','uses'=>'TypeController@batch']);
    Route::post('type/grid',['as'=>'type.grid','uses'=>'TypeController@grid']);




    //商品属性管理
    Route::resource('attribute','AttributeController',['only'=>['index','create','store','edit','update']]);
    Route::get('attribute/del/{id}',['as'=>'attribute.delete','uses'=>'AttributeController@delete']);
    Route::post('attribute/batch',['as'=>'attribute.batch','uses'=>'AttributeController@batch']);
    Route::post('attribute/grid',['as'=>'attribute.grid','uses'=>'AttributeController@grid']);

    //商品颜色属性管理
    Route::resource('color','ColorController',['only'=>['index','create','store','edit','update']]);
    Route::get('color/del/{id}',['as'=>'color.delete','uses'=>'ColorController@delete']);
    Route::post('color/batch',['as'=>'color.batch','uses'=>'ColorController@batch']);
    Route::post('color/grid',['as'=>'color.grid','uses'=>'ColorController@grid']);
    Route::post('color/img-del',['as'=>'color.img.delete','uses'=>'ColorController@img_del']);


    //商品字段管理
    Route::resource('field','FieldController',['only'=>['index','create','store','edit','update']]);
    Route::get('field/del/{id}',['as'=>'field.delete','uses'=>'FieldController@delete']);
    Route::post('field/batch',['as'=>'field.batch','uses'=>'FieldController@batch']);
    Route::post('field/grid',['as'=>'field.grid','uses'=>'FieldController@grid']);

    //一城一网管理
    Route::resource('site','SiteController',['only'=>['index','create','store','edit','update']]);
    Route::post('site/grid',['as'=>'site.grid','uses'=>'SiteController@grid']);
    Route::get('site/delete/{id}',['as'=>'site.delete','uses'=>'SiteController@delete']);
    Route::post('site/batch',['as'=>'site.batch','uses'=>'SiteController@batch']);

    //自定义导航栏
    Route::resource('nav','NavController',['only'=>['index','create','store','edit','update']]);
    Route::post('nav/grid',['as'=>'nav.grid','uses'=>'NavController@grid']);
    Route::get('nav/delete/{id}',['as'=>'nav.delete','uses'=>'NavController@delete']);
    Route::post('nav/batch',['as'=>'nav.batch','uses'=>'NavController@batch']);

    //图片管理
    Route::resource('image','ImageController',['only'=>['index','create','store','edit','update']]);
    Route::post('image/grid',['as'=>'image.grid','uses'=>'ImageController@grid']);
    Route::get('image/delete/{id}',['as'=>'image.delete','uses'=>'ImageController@delete']);
    Route::post('image/batch',['as'=>'image.batch','uses'=>'ImageController@batch']);

    //首页主幻灯图片管理
    Route::resource('slider','SliderController',['only'=>['index','create','store','edit','update']]);
    Route::post('slider/grid',['as'=>'slider.grid','uses'=>'SliderController@grid']);
    Route::get('slider/delete/{id}',['as'=>'slider.delete','uses'=>'SliderController@delete']);
    Route::post('slider/batch',['as'=>'slider.batch','uses'=>'SliderController@batch']);

    //分类幻灯广告管理
    Route::resource('catad','CatAdController',['only'=>['index','create','store','edit','update']]);
    Route::post('catad/grid',['as'=>'catad.grid','uses'=>'CatAdController@grid']);
    Route::get('catad/delete/{id}',['as'=>'catad.delete','uses'=>'CatAdController@delete']);
    Route::post('catad/batch',['as'=>'catad.batch','uses'=>'CatAdController@batch']);


    //支付方式管理
    Route::resource('payment','PaymentController',['only'=>['index','create','store','edit','update']]);
    Route::post('payment/grid',['as'=>'payment.grid','uses'=>'PaymentController@grid']);
    Route::get('payment/delete/{id}',['as'=>'payment.delete','uses'=>'PaymentController@delete']);
    Route::post('payment/batch',['as'=>'payment.batch','uses'=>'PaymentController@batch']);

    //配送方式管理
    Route::resource('shipping','ShippingController',['only'=>['index','create','store','edit','update']]);
    Route::post('shipping/grid',['as'=>'shipping.grid','uses'=>'ShippingController@grid']);
    Route::get('shipping/delete/{id}',['as'=>'shipping.delete','uses'=>'ShippingController@delete']);
    Route::post('shipping/batch',['as'=>'shipping.batch','uses'=>'ShippingController@batch']);

    //友情链接
    Route::resource('link','LinkController',['only'=>['index','create','store','edit','update']]);
    Route::post('link/grid',['as'=>'link.grid','uses'=>'LinkController@grid']);
    Route::get('link/delete/{id}',['as'=>'link.delete','uses'=>'LinkController@delete']);
    Route::post('link/batch',['as'=>'link.batch','uses'=>'LinkController@batch']);

    //商城系统设置
    Route::get('config',['as'=>'config.index','uses'=>'ConfigController@index']);
    Route::post('config',['as'=>'config.store','uses'=>'ConfigController@store']);

    //系统模板设置
    Route::get('template',['as'=>'template.index','uses'=>'TemplateController@index']);
    Route::post('template',['as'=>'template.store','uses'=>'TemplateController@store']);

    //订单管理
    Route::resource('order','OrderController',['only'=>['index','create','store','edit','update']]);
    Route::post('order/grid',['as'=>'order.grid','uses'=>'OrderController@grid']);
    Route::get('order/delete/{id}',['as'=>'order.delete','uses'=>'OrderController@delete']);
    Route::post('order/batch',['as'=>'order.batch','uses'=>'OrderController@batch']);

    //处理订单相关
    Route::get('order/done',['as'=>'order.action','uses'=>'OrderController@done']);
    Route::post('order/express',['as'=>'order.express','uses'=>'OrderController@express']);

    //订单日志
    Route::get('order/log',['as'=>'order.log','uses'=>'OrderController@log']);
    Route::get('order/log/del/{id}',['as'=>'order.log.delete','uses'=>'OrderController@log_delete']);
    Route::post('order/log/batch',['as'=>'order.log.batch','uses'=>'OrderController@log_batch']);

    //订单打印
    Route::get('order/print',['as'=>'order.print','uses'=>'OrderController@order_print']);
    Route::post('order/print',['as'=>'order.print.post','uses'=>'OrderController@print_post']);

    //发货单管理
    Route::resource('express','ExpressController',['only'=>['index','create','store','edit','update']]);
    Route::post('express/grid',['as'=>'express.grid','uses'=>'ExpressController@grid']);
    Route::get('express/delete/{id}',['as'=>'express.delete','uses'=>'ExpressController@delete']);
    Route::post('express/batch',['as'=>'express.batch','uses'=>'ExpressController@batch']);

    //退货单管理
    Route::resource('return','ReturnController',['only'=>['index','create','store','edit','update']]);
    Route::post('return/grid',['as'=>'return.grid','uses'=>'ReturnController@grid']);
    Route::get('return/delete/{id}',['as'=>'return.delete','uses'=>'ReturnController@delete']);
    Route::post('return/batch',['as'=>'return.batch','uses'=>'ReturnController@batch']);


    //供货商管理
    Route::resource('supplier','SupplierController',['only'=>['index','create','store','edit','update']]);
    Route::post('supplier/grid',['as'=>'supplier.grid','uses'=>'SupplierController@grid']);
    Route::get('supplier/delete/{id}',['as'=>'supplier.delete','uses'=>'SupplierController@delete']);
    Route::post('supplier/batch',['as'=>'supplier.batch','uses'=>'SupplierController@batch']);

    //商品标签管理
    Route::resource('tag','TagController',['only'=>['index','create','store','edit','update']]);
    Route::post('tag/grid',['as'=>'tag.grid','uses'=>'TagController@grid']);
    Route::get('tag/delete/{id}',['as'=>'tag.delete','uses'=>'TagController@delete']);
    Route::post('tag/batch',['as'=>'tag.batch','uses'=>'TagController@batch']);

    //会员充值提现
    Route::resource('account','AccountController',['only'=>['index','create','store','edit','update']]);
    Route::post('account/grid',['as'=>'account.grid','uses'=>'AccountController@grid']);
    Route::get('account/delete/{id}',['as'=>'account.delete','uses'=>'AccountController@delete']);
    Route::post('account/batch',['as'=>'account.batch','uses'=>'AccountController@batch']);

    //会员留言管理
    Route::resource('message','MessageController',['only'=>['index','create','store','edit','update']]);
    Route::post('message/grid',['as'=>'message.grid','uses'=>'MessageController@grid']);
    Route::get('message/delete/{id}',['as'=>'message.delete','uses'=>'MessageController@delete']);
    Route::post('message/batch',['as'=>'message.batch','uses'=>'MessageController@batch']);

    //短消息管理
    Route::resource('sms','SmsController',['only'=>['index','create','store','edit','update']]);
    Route::post('sms/grid',['as'=>'sms.grid','uses'=>'SmsController@grid']);
    Route::get('sms/delete/{id}',['as'=>'sms.delete','uses'=>'SmsController@delete']);
    Route::post('sms/batch',['as'=>'sms.batch','uses'=>'SmsController@batch']);


    //礼品卡管理
    Route::resource('card','CardController',['only'=>['index','create','store','edit','update']]);
    Route::post('card/grid',['as'=>'card.grid','uses'=>'CardController@grid']);
    Route::get('card/delete/{id}',['as'=>'card.delete','uses'=>'CardController@delete']);
    Route::post('card/batch',['as'=>'card.batch','uses'=>'CardController@batch']);

    //模板配色方案
    Route::resource('style','StyleController',['only'=>['index','create','store','edit','update']]);
    Route::post('style/grid',['as'=>'style.grid','uses'=>'StyleController@grid']);
    Route::get('style/delete/{id}',['as'=>'style.delete','uses'=>'StyleController@delete']);
    Route::post('style/batch',['as'=>'style.batch','uses'=>'StyleController@batch']);



    //属性链货品管理
    Route::resource('product','ProductController',['only'=>['index','create','store','edit','update']]);
    Route::post('product/grid',['as'=>'product.grid','uses'=>'ProductController@grid']);
    Route::get('product/delete/{id}',['as'=>'product.delete','uses'=>'ProductController@delete']);
    Route::post('product/batch',['as'=>'product.batch','uses'=>'ProductController@batch']);
    Route::post('product/ajax',['as'=>'product.ajax','uses'=>'ProductController@ajax']);
  

    //清除缓存
    Route::get('cache-clear',['as'=>'cache.clear','uses'=>'AdminLoginController@cache_clear']);

    //系统提示页面
    Route::get('info','IndexController@sysinfo');

    //模板配色方案
    Route::resource('demo','DemoController',['only'=>['index','create','store','edit','update']]);
    Route::post('demo/grid',['as'=>'demo.grid','uses'=>'DemoController@grid']);
    Route::get('demo/delete/{id}',['as'=>'demo.delete','uses'=>'DemoController@delete']);
    Route::post('demo/batch',['as'=>'demo.batch','uses'=>'DemoController@batch']);

    //wap配置
    Route::resource('wap','WapController',['only'=>['index','create','store','edit','update']]);
    Route::post('wap/grid',['as'=>'wap.grid','uses'=>'WapController@grid']);
    Route::get('wap/delete/{id}',['as'=>'wap.delete','uses'=>'WapController@delete']);
    Route::post('wap/batch',['as'=>'wap.batch','uses'=>'WapController@batch']);

    //地区运费管理
    Route::resource('region_shipping','RegionShippingController',['only'=>['index','create','store','edit','update']]);
    Route::post('region_shipping/grid',['as'=>'region_shipping.grid','uses'=>'RegionShippingController@grid']);
    Route::get('region_shipping/delete/{id}',['as'=>'region_shipping.delete','uses'=>'RegionShippingController@delete']);
    Route::post('region_shipping/batch',['as'=>'region_shipping.batch','uses'=>'RegionShippingController@batch']);

    //模板设置json
    Route::get('theme-json',['as'=>'theme.json','uses'=>'TemplateController@getThemeJson']);
    //添加模板
    Route::post('theme-add',['as'=>'theme.add','uses'=>'TemplateController@addTheme']);
    //删除模板
    Route::delete('theme-delete',['as'=>'theme.delete','uses'=>'TemplateController@deleteTheme']);
    //设置默认模板
    Route::post('theme-default',['as'=>'theme.default','uses'=>'TemplateController@setDefault']);

    //ajax删除 商品属性值
    Route::delete('goods-attr-delete',['as'=>'goods.attr.delete','uses'=>'GoodsController@goodsAttrDelete']);

 

}); 

Route::get(env('ADMIN_LOGIN_URL'),['as'=>'admin.login.form','uses'=>'Admin\AdminLoginController@login']);
Route::post(env('ADMIN_LOGIN_URL'),['as'=>'admin.login.post','uses'=>'Admin\AdminLoginController@login_post']);



//前台路由设置
Route::namespace('Front')->group(function () {

    //前台首页
    Route::get('/', 'IndexController@index');

    //文章详情页面
    Route::get('article/{id}','ArticleController@index')->where('id', '[0-9]+');
    Route::get('article/{diy_url}','ArticleController@diy_url');

    //文章分类页面
    Route::get('article_cat/{id}','ArticleCatController@index')->where('id','[0-9]+');
    Route::get('article_cat/{diy_url}','ArticleCatController@diy_url');

    //商品列表页
    Route::get('category/{id}','CategoryController@index')->where('id','[0-9]+');
    Route::get('category/{id}/brid/{brid}','CategoryController@index')->where('id','[0-9]+');
    Route::get('category/{diy_url}','CategoryController@diy_url');
    Route::post('category-ajax','CategoryController@grid');

    //商品详情页
    Route::get('goods/{id}','GoodsController@index')->where('id','[0-9]+');
    //商品自定义url链接
    Route::get('goods/{diy_url}','GoodsController@diy_url');

    //用户登录注册页面
    Route::get('auth/login','UserController@login_form');
    Route::post('auth/login','UserController@login_post');
    Route::get('auth/register','UserController@register_form');
    Route::post('auth/register','UserController@register_post');
    //注册测重
    Route::post('auth/register-check','UserController@register_check');
    //登录检测验证码是否正确
    Route::post('auth/captcha-check','UserController@captcha_check');
    //用户中心
    Route::get('auth/center','UserController@user_center');

    //用户中心资料
    Route::get('auth/profile','UserController@profile');

    //用户资料修改
    Route::post('auth/user-update','UserController@user_update');
    //退出登录
    Route::get('auth/logout','UserController@logout');

    //用户中心 订单管理
    Route::get('auth/order','UserController@order');
    //用户中心查看订单
    Route::get('auth/order/preview/{id}','UserController@order_preview')->where('id','[0-9]+');
    //用户中心取消订单
    Route::get('auth/order/cancel/{id}','UserController@order_cancel')->where('id','[0-9]+');
    //用户中心查看我的收藏
    Route::get('auth/collect','UserController@collect');
    //用户中心删除收藏
    Route::get('auth/collect/del/{id}','UserController@collect_del')->where('id','[0-9]+');
    //用户中心退货单管理
    Route::get('auth/return','UserController@order_return');
    //发起退货
    Route::get('auth/return/send','UserController@return_send');
    Route::post('auth/return/send','UserController@return_post');
    //预览退货单详情
    Route::get('auth/return/preview/{id}','UserController@return_preview')->where('id','[0-9]+');
    //取消退货
    Route::get('auth/return/cancel/{id}','UserController@return_cancel')->where('id','[0-9]+');


    //供货商前台申请 登录界面
    Route::get('supplier/register','SupplierController@register');
    Route::post('supplier/register','SupplierController@register_store');
    Route::get('supplier/login','SupplierController@login');
    Route::post('supplier/login','SupplierController@login_post');
    Route::get('supplier/center','SupplierController@center');
    Route::get('supplier/logout','SupplierController@logout');
    Route::post('supplier/register-validate','SupplierController@register_validate');
    Route::post('supplier/update','SupplierController@update');


    //购物车
    Route::post('cart','CartController@cart_post');
    Route::get('cart','CartController@cart_list');
    Route::post('cart-number-update','CartController@cart_number_update');
    //删除购物车
    Route::post('cart-delete','CartController@delete');
    //购物车取消或者选中某个商品
    Route::post('cart-checked','CartController@checked');
    //购物车全部取消或者选中
    Route::post('cart-checked-all','CartController@checked_all');
    //获取购物车中所有信息
    Route::get('cart-json','CartController@cartJson');
    //结算页面
    Route::get('checkout','CartController@checkout');
    //地址三级联查
    Route::post('checkout-pcd','CartController@pcd');
    //增加新地址
    Route::post('checkout-add-address','CartController@add_address');
    //更新地址信息
    Route::post('checkout-update-address','CartController@update_address');
    //删除地址信息
    Route::post('checkout-del-address','CartController@del_address');
    //设置默认地址
    Route::post('checkout-def-address','CartController@def_address');
    //计算配送费用
    Route::post('shipping-fee','CartController@shipping_fee');
    //下订单
    Route::post('order','CartController@order');
    Route::get('order-done','CartController@done');
    Route::get('order/payment/{id}','CartController@payment');

    //wap页面ajax操作
    Route::post('cart-ajax-mobile','CartController@cart_ajax_mobile');

    //搜索页面
    Route::post('search','SearchController@search');
    Route::get('search','SearchController@search');
    Route::post('getdata','SearchController@getData');


    Route::post('collect','GoodsController@collect');
    Route::post('mobile-collect','GoodsController@mobile_collect');


    //支付宝支付路由
    Route::post('alipayapi','AlipayController@alipayapi');
    Route::any('return_url.php','AlipayController@return_url');
    Route::any('notify_url.php','AlipayController@notify_url');

    //支付WAP支付界面
    Route::post('alipay-wap','AlipayWapController@alipaywap');
    Route::any('alipay-wap/return_url.php','AlipayWapController@return_url');
    Route::any('alipay-wap/notify_url.php','AlipayWapController@notify_url');

    //标签页面
    Route::get('tag','TagController@index');

    //留言板
    Route::get('message','MessageController@index');
    //留言板表单
    Route::get('message-form','MessageController@form');
    Route::post('message','MessageController@store');

    //ajax立即购买
    Route::post('ajax-buy','GoodsController@ajax_buy');
    //ajax添加tag
    Route::post('ajax-tag','GoodsController@ajax_tag');
    //地址管理
    //Route::get('auth/address','AddressController@index');

    //地址列表
    Route::resource('auth/address','AddressController',['only'=>['index','store','edit','update']]);
    Route::get('auth/address/delete/{id}','AddressController@destroy');

    //标签管理
    Route::resource('auth/tag','AuthTagController',['only'=>['index','store','edit','update']]);
    Route::get('auth/tag/delete/{id}','AuthTagController@destroy');

    //标签管理
    Route::resource('auth/sms','SmsController',['only'=>['index','store','edit','update']]);
    Route::get('auth/sms/delete/{id}','SmsController@destroy');

    //站内留言管理
    Route::resource('auth/message','AuthMessageController',['only'=>['index','store','edit','update']]);
    Route::get('auth/message/delete/{id}','AuthMessageController@destroy');

    //充值和提现管理
    Route::resource('auth/money','MoneyController',['only'=>['index','store']]);

    //商品属性链货品ajax操作
    Route::post('front/product/ajax','ProductController@ajax');

    //前台演示页面
    Route::get('demo','DemoController@index');
    Route::post('demo','DemoController@login');
    Route::get('demo/logout','DemoController@logout');

    //刷新验证码
    Route::post('captcha-ajax','UserController@captcha_ajax');

    //品牌页面
    Route::get('brand','BrandController@index');
    Route::get('brand/{id}','BrandController@show');

    //所有分类页面
    Route::get('catalog',['as'=>'front.catalog','uses'=>'CategoryController@catalog']);
    Route::get('catalog/{id}',['as'=>'front.catalog','uses'=>'CategoryController@catalog_mobile']);
    //额外增加的路由
    Route::resource('mobile/address','MobileAddressController');
    Route::post('pcd','MobileAddressController@pcd');
    Route::post('shipping-ajax','CartController@shipping_fee');

    //移动端确认下单
    Route::post('mobile-order','CartController@mobile_order');
    Route::get('auth/profile/edit','UserController@profile_edit');

    //帮助中心
    Route::get('help','HelpController@index');

    //生成二维码
    Route::get('qrcode','IndexController@qrcode');
    //测试页面
    Route::get('test','IndexController@test');


    //移动版本的通用资源控制器

    //显示列表
    Route::get('auth/mobile/{model}','MobileCommonController@index');
    //编辑
    Route::get('auth/mobile/{model}/{id}/edit','MobileCommonController@edit')->where('id','[0-9]+');
    //更新
    Route::put('auth/mobile/{model}','MobileCommonController@update');
    //显示单条信息
    Route::get('auth/mobile/{model}/{id}','MobileCommonController@show')->where('id','[0-9]+');
    //添加
    Route::get('auth/mobile/{model}/create','MobileCommonController@create');
    //存储
    Route::post('auth/mobile/{model}','MobileCommonController@store');
    //删除
    Route::get('auth/mobile/{model}/delete/{id}','MobileCommonController@delete')->where('id','[0-9]+');
    //ajax处理
    Route::post('auth/mobile/{model}/ajax','MobileCommonController@ajax');

    //微信手机版本登录
    Route::get('auth/weixin','UserController@weixin_login');
    Route::get('auth/weixin/login','UserController@weixin_login_code');

    //批量下单
    Route::get('auth/batch-order','OrderController@batch_order');
    Route::post('auth/batch-order','OrderController@batch_order_post');
    Route::post('auth/batch-order-done','OrderController@batch_order_done');
    Route::get('auth/batch-order-done','OrderController@batch_order_done_get');
    Route::post('auth/batch-pay','OrderController@batch_order_pay');

    //elasticsearch测试
    Route::get('es','ElasticsearchController@index');
    Route::get('test','IndexController@test');

});


//api相关
Route::namespace('Api')
     ->prefix('api')
     ->middleware('web')
     ->group(function () {
                //获取推荐商品 包括：新品+精品+热卖商品
                Route::get('recommend/goods','IndexController@getGoodsJson');
                //获取分类页的json数据
                Route::get('category/{id}','CatController@index');
                Route::post('category/grid','CatController@grid');
                Route::post('category/search','CatController@getdata');
                //获取购物车中的数据
                Route::get('cart','CartController@getJson');
                Route::delete('cart/delete','CartController@cartDelete');
                Route::post('cart/add','CartController@addToCart');
                Route::post('cart/checked','CartController@isChecked');
                Route::post('cart/checked-all','CartController@allChecked');
                Route::post('cart/number-sub','CartController@numSub');
                Route::post('cart/number-add','CartController@numAdd');
                //获取商品信息
                Route::get('goods/{id}','GoodsController@index');
                //获取商品属性值
                Route::post('goods-attr','GoodsController@getGoodsAttrList');
                Route::post('goods/add-to-cart','GoodsController@addToCart');
                //获取登录用户的收货地址信息
                Route::get('user/address','UserController@address');
                Route::post('user/address/default','UserController@addressDefault');
                Route::post('user/address/pcd','UserController@pcd');
                Route::put('user/address/update','UserController@update');
                Route::post('user/address','UserController@store');
                Route::delete('user/address/delete','UserController@delete');
                //获取配送方式
                Route::get('payment','PaymentController@index');
                Route::get('shipping','ShippingController@index');
                Route::post('shipping','ShippingController@show');
                Route::post('card/check','CardController@check');
                Route::post('order/done','OrderController@done');
                Route::post('payment/paybtn','PaymentController@paybtn');

                //用户登录相关
                Route::post('login','UserController@login');
                //注册
                Route::post('register','UserController@register');
                //发送短信验证码
                Route::post('sendsms','UserController@getSms');
                //上传用户头像
                Route::post('user-icon','UserController@uploadUserIcon');
                //获取用户信息
                Route::get('user','UserController@show');
                Route::put('user','UserController@updateUser');
                //获取用户的标签
                Route::get('user/tag','UserController@tag');
                Route::delete('user/tag/delete','UserController@tagDelete');
                Route::post('user/tag','UserController@tagAdd');
                //获取留言
                Route::get('message','MessageController@index');
                Route::delete('message/delete','MessageController@delete');
                Route::post('message','MessageController@store');
                //获取订单列表
                Route::get('order','OrderController@index');
                Route::delete('order/delete','OrderController@delete');
                //合并订单
                Route::post('order/merge','OrderController@merge');

                //获取收藏列表
                Route::get('collect','CollectController@index');
                Route::delete('collect/delete','CollectController@delete');
                Route::post('collect','CollectController@store');
                //获取用户账号
                Route::get('account','AccountController@index');
                Route::post('account','AccountController@store');
                //退货信息
                Route::get('return','ReturnController@index');
                Route::post('return','ReturnController@store');
                Route::delete('return/delete','ReturnController@delete');
                //获取品牌下的商品列表
                Route::get('brand/goods','BrandController@goods');

                //注册供货商
                Route::post('supplier/register','SupplierController@register');
                Route::post('supplier/login','SupplierController@login');

                //获取用户评价
                Route::get('comment','CommentController@index');
                Route::post('comment','CommentController@store');

                //批量下单
                Route::post('batch-order','BatchOrderController@createForm');
                //生成订单
                Route::post('batch-order/done','BatchOrderController@order');

                //用户系统余额支付
                Route::get('account/pay/{id}','UserController@accountPay');
                Route::post('account/pay','UserController@accountPayAct');

                Route::get('forget-password','UserController@forgetPassword');
                Route::post('reset-password','UserController@resetPassword');
});

//后台管理员api
Route::group(['prefix' => 'api/admin','namespace'=>'Api\Admin'], function () {

    Route::post('login','UserController@login');
});

//vue 购物车测试
Route::get('cart-vue','Front\VueController@cart_list');
Route::get('cart-json','Front\VueController@cart_json');

Route::get('api/goods',function(){
    return \App\Models\Goods::get();
});

