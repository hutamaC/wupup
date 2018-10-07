<div class="row">
	<div class="panel panel-goods">
	
		<div class="panel-body">
			
			<div class="goods-item ls-col-md-goods" 
			     v-bind:class="['goods-item'+ index]"
				 v-for="(item,index) in rows.goods_list">

				<!-- 
				改框 这是原代码
				<a v-bind:href="item.url" class="thumb-img">
					<img v-bind:src="item.thumb" v-bind:alt="item.goods_name">
				</a>
				<p class="name">
					<a v-bind:href="item.url">@{{item.short_goods_name}}</a>
				</p>
				<p class="price">￥@{{item.shop_price}}</p>
				
				<div class="gallery-list" v-if="item.gallerys">
					
					<img v-bind:src="gallery.thumbOss" 
						v-bind:alt="item.goods_name" 
						class="gallery-thumb" v-for="gallery in item.gallerys">
					
				</div> 

				-->
				<a v-bind:href="item.url" class="thumb-img">
					<img v-bind:src="item.brand_logo" class="goods-thumb" width='100%' height="180">
				</a>
				<p class="rname">
					<a v-bind:href="item.url">@{{item.brand_name}}</a>
				</p>
				
				<p class="price">
					@{{item.brand_en_name}}
				</p>	
				
				<div class="goods-button">
					<a v-bind:href="item.url" class="btn btn-default">查看详情</a>
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