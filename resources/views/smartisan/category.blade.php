@extends('smartisan.layout.common')

@section('title')
{{$title}}
@stop

@section('content')
	<div class="main-box">
	    
		@include('smartisan.category.slider')
		@include('smartisan.lib.breadcrumb')
		<div id="catapp">
			@if($id == 29 && !$brid)
	    	@include('smartisan.category.goods_select')
			
	    	@include('smartisan.category.goods_cat')
	    	@elseif($brid)
	    	@include('smartisan.category.jewelsearch')
	    	@include('smartisan.category.jewel')
	    	@else
			@include('smartisan.category.select')
			@include('smartisan.category.goods_list')
			@endif
			@include('smartisan.vue.category')
		</div>
	</div>
@stop