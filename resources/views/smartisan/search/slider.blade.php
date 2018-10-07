<script src="{{url('front/smartisan/jquery.bxslider/jquery.bxslider.min.js')}}" type="text/javascript"></script>
<link href="{{url('front/smartisan/jquery.bxslider/jquery.bxslider.css')}}" rel="stylesheet" />
<div style='width:100%; height:375px;overflow:hidden;margin-bottom:20px'>
<ul class="bxslider">
  @if($slider)
  @foreach($slider as $item)
  <li>
  	<img src="{{$item->icon()}}" alt="{{$item->img_name}}">
  </li>
  @endforeach
  @endif
</ul>
</div>

<script type="text/javascript">
	$(function(){
    $('.bxslider').bxSlider();
	})
</script>