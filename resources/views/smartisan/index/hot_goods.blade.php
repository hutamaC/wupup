
<div class="row">
<div class="panel panel-goods">
	<div class="panel-heading">
		<h4>手表</h4>
	</div><!--/ls-goods-panel-header-->
	<div class="panel-body">
		
		<div class="goods-item ls-col-md-goods" v-for="(item,index) in rows.hot" v-bind:class="['goods-item'+index]">
			<a href="javascript:">
				<img v-bind:src="item.thumb" class="goods-thumb" width='100%' height="180">
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
		</div>
	</div><!--/ls-goods-panel-body-->
</div><!--/ls-goods-panel-->
</div><!--/row-->
