    <div class="topper">
        <div class="wrapper">
            <div class="left-bar">
                <div class="back-home divider">
                    <em></em><a href="index.html">商城首页</a>
                </div>
            </div>
            <div class="right-bar">
            	@if(Auth::check('user'))
                <div class="login-user sub-menu">
                    <a class="menu-hd" href="{{url('auth/center')}}">{{Auth::user('user')->username}}<em></em></a>
                    <div class="down">
                        <a href="{!!url('auth/center')!!}">{!!trans('front.profile')!!}</a>
                        <a href="{!!url('auth/address')!!}">{!!trans('front.address_manager')!!}</a>
                        <a href="{!!url('auth/message')!!}">{!!trans('front.my_message')!!}</a>
                        <a href="{!!url('auth/order')!!}">{!!trans('front.my_order')!!}</a>
                        <a href="{!!url('auth/money')!!}">{!!trans('front.my_money')!!}</a>
                    </div>
                </div>
                <!-- <div class="item"><a href="">消息（<span class="txt-theme">0</span>）</a></div> -->
                <div class="logout divider"><a href="{!!url('auth/logout')!!}">退出</a></div>
                <span class=""></span>
<!--                 <div class="cart"><em></em><a href="">购物车<span class="txt-theme">2</span>件</a></div>
                <div class="order"><em></em><a href="">我的订单</a></div>
                <div class="fav"><em></em><a href="">我的收藏</a></div>
                <div class="help"><em></em><a href="">帮助中心</a></div> -->
                @else
                <div class="item"><a href="{{url('auth/login')}}">登录</a></div>
                <div class="item"><a href="{{url('auth/register')}}">注册</a></div>
                @endif
            </div>
        </div>
    </div>
    <div class="header-wrap">
        <div class="header wrapper">
            <a href="" class="logo">
                <img src="{{url('front/smartisan/images/logo3.png')}}" alt="" />
            </a>
            <div class="header-schbox">
                <div class="inner clearfix">
                <form action="{{url('/search')}}" method="post" id="searchform">
                    <div class="search-switch">
                        <div class="item">商品</div>
                    </div>
                    <input class="search-txt" placeholder="搜流行宝贝" name="keywords">
                    <button class="search-btn" onclick="checkForm();"></button>
                </form>
                <script>
                function checkForm(){
                	$('searchform').submit();
                }
                </script>
                </div>
            </div>
        </div>
    </div>
<!-- <div class="header-top">
	<div class="container header-top-bb">
		
		把logo注释了
		<a href="{{url('/')}}" class="logo" title="{{$title}}">
			<img src="{{url($shop_logo)}}" alt="">
		</a>
		
		<div class="nav">
			<ul class="nav-main">
				@if($middle_nav)
				@foreach($middle_nav as $nav)
				<li @if(Request::url() == url($nav->nav_url)) class="active" @endif>
					<a href="{{url($nav->nav_url)}}">{{$nav->nav_name}}</a>
				</li>
				@endforeach
				@endif
			</ul>
		</div>
        
        <div class="account-panel">
        	@if(Auth::check('user'))
				<a href='{{url('auth/center')}}' class="btn btn-success btn-login">
					<span class="glyphicon glyphicon-user"></span>
					个人中心
					<span class="caret"></span>
				</a>
				@include('smartisan.lib.popmenu')
        	@else
			<a href="{{url('auth/login')}}" class="btn btn-success btn-login">
				<i class="fa fa-user"></i>
				{{trans('front.login')}}
			</a>
        	@endif
        </div>
	</div> -->
</div><!--/header-top-->
@include('smartisan.index.category')

