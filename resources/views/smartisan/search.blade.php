@extends('smartisan.layout.common')

@section('title')
{{$title}}
@stop

@section('content')
	<div class="main-box">
	    
		@include('smartisan.search.slider')
		@include('smartisan.lib.breadcrumb')
		<div id="catapp">
			@include('smartisan.search.goods_list')
			@include('smartisan.vue.search')
		</div>
	</div>
@stop