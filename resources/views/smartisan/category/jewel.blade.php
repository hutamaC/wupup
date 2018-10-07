<div class="row">
	<div class="panel panel-goods">
		<div class="panel-body">
			<table class="table table-striped" >
				<thead>
				<tr>
					<th>编号</th>
					<th>证书号</th>
					<th>CERT</th>
					<th>克拉</th>
					<th>形状</th>
					<th>色泽</th>
					<th>透明度</th>
					<th>CUT</th>
					<th>POL</th>
					<th>SYM</th>
					<th>FLUOR</th>
					<th>价格</th>
					<th>操作</th>
				</tr>
				</thead>
				<tbody v-bind:class="['goods-item'+ index]" v-for="(item,index) in rows.goods_list">
				<tr v-bind:style="{ color: item.goods_number!=0?'black':'red'}">
					<td>@{{item.short_goods_name}}</td>
					<td>@{{item.goods_sn}}</td>	
					<td>@{{item.field[0].field_value}}</td>
					<td>@{{item.goods_weight}}</td>		
					<td>@{{item.field[1].field_value}}</td>
					<td>@{{item.field[2].field_value}}</td>
					<td>@{{item.field[3].field_value}}</td>
					<td>@{{item.field[4].field_value}}</td>
					<td>@{{item.field[5].field_value}}</td>
					<td>@{{item.field[6].field_value}}</td>
					<td>@{{item.field[7].field_value}}</td>
					<td>￥@{{item.shop_price*7}}</td>
					<td class="col-xs-3">
						<div class="">
							<a v-bind:href="item.url" class="btn btn-default" v-if="item.goods_number!=0">查看详情</a>
							<span class="btn btn-blue-purple" v-on:click="addCart(item.id)" v-if="item.goods_number!=0">加入购物车</span>
							<span v-if="item.goods_number==0">本商品已没有库存</span>

						</div>
					</td>
				</tr>
				</tbody>
			</table>
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