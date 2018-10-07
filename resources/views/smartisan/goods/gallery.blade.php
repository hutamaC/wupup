

@if($goods->gallery)
<div class="gallery-wrapper">
<div class="thumb-list">
@foreach($goods->gallery()->get() as $gallery)
		<img 	src="{{$gallery->thumb()}}"
			   alt="{{$goods->goods_name}}" 
			   data-img="{{$gallery->img()}}"
			   class="goods-thumb">
@endforeach
</div><!--/thumbnail-->
<div class="detail-img">
@if($goods->gallery()->first())
<img src="{{$goods->gallery()->first()->img()}}" alt="{{$goods->goods_name}}" class="goods-img">
@else
<img src="http://albft01.s3-ap-southeast-1.amazonaws.com/images/gray/{{$goods->goods_name}}.jpg" alt="图片加载失败" class="goods-img">
@endif
</div><!--/detail-->
</div><!--/gallery-wrapper-->
@endif

<script type="text/javascript">
	$(function(){
		larastore.goods.detail();
	})
</script>