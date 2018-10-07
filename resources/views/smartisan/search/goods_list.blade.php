<div class="row">
	<div class="panel panel-goods">
		<div class="panel-body">
			<div class="goods-item ls-col-md-goods" 
			     v-bind:class="['goods-item'+ index]"
				 v-for="(item,index) in rows.goods_list">
				<a v-bind:href="item.url" class="thumb-img">
					<img v-bind:src="item.thumb" class="goods-thumb" width='100%' height="180" v-if="item.thumb">
					<img v-bind:src="'http://albft01.s3-ap-southeast-1.amazonaws.com/images/gray/'+item.short_goods_name+'.jpg'" class="goods-thumb" v-if="!item.thumb">

				</a>
				<p class="rname">
					<a v-bind:href="item.url">@{{item.short_goods_name}}</a>
				</p>
				
				<p class="price">
					￥@{{item.shop_price}}
				</p>	
				
				<div class="goods-button">
					<a v-bind:href="item.url" class="btn btn-default">查看详情</a>
					<span class="btn btn-blue-purple" v-on:click="addCart(item.id)">加入购物车</span>
				</div>
			</div><!--/goods-item-->
			
		</div><!--/panel-body-->
	</div>
</div>

<div class="row">
<div class="ls-pagination" v-if="rows.total > 0">
	<span v-if="rows.current_page > 1"
		  v-on:click="changePage(rows.current_page - 1)">
		  <i class="fa fa-arrow-left"></i>
	</span>
	<span class="disable" v-else><i class="fa fa-arrow-left"></i></span>
	<span 	v-for="number in rows.number"
			v-bind:data-page="number"
			v-on:click="changePage(number)"
			v-bind:class="{'active':number == rows.current_page}">
			@{{number}}
	</span>
	<span v-on:click="changePage(rows.current_page + 1)"
		  v-if="rows.last_page > rows.current_page">
		  <i class="fa fa-arrow-right"></i>
	</span>
	<span class="disable" v-else><i class="fa fa-arrow-right"></i></span>
</div>
</div>