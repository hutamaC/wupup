
<div class="row">
<div class="panel panel-goods">
	<div class="panel-heading">
		<h4>珠宝</h4>
	</div><!--/ls-goods-panel-header-->
	<div class="panel-body">
		
		<div class="goods-item ls-col-md-goods" v-for="(item,index) in rows.new" v-bind:class="['goods-item'+index]">
			<a href="javascript:">
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
		</div>
	</div><!--/ls-goods-panel-body-->
</div><!--/ls-goods-panel-->
</div><!--/row-->
