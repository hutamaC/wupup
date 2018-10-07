
<div class="container">
<div class="sub-nav-list">
	<ul class="nav-home-category">
		@if($category)
		@foreach($category as $item)
		<li @if($is_category&&$id==$item->id)style="color:red"@endif>
			<a href="{{$item->url()}}" @if($is_category&&$id==$item->id)style="color:red"@endif>{{$item->cat_en_name}}</a>/
			<a href="{{$item->url()}}" @if($is_category&&$id==$item->id)style="color:red"@endif>{{$item->cat_name}}</a>
		</li>
		@endforeach
		@endif
	</ul>
	@include('smartisan.lib.cart')
</div><!--/sub-nav-list-->
</div><!--/container-->