<script type="text/javascript">

    $(function(){
		larastore.goods.gallery();
	})

	var catapp = new Vue({

		  el:'#catapp',
		  data:{

		  			rows:'',
		  			keywords:'{{$keywords?$keywords:""}}',


		  },
		  created:function(){
		  	console.log(this.rows);
		  	this.getList();
		  },
		  
		  methods:{

					
		  		//获取商品记录
		  		getList:function(){

		  			$.ajax({
		  				url:"{{url('api/category/search')}}",
		  				type:'POST',
						data:{keywords:this.keywords},
		  				dataType:'json',
		  				success:function(data){
		  					 catapp.rows 	= data.data;

		  				}
		  			});
		  		},

		  		//加入购物车
		  		addCart:function(id){

		  			$.ajax({

		  				url:"{{url('api/cart/add')}}",
		  				type:'POST',
		  				data:'id='+ id,
		  				dataType:'json',
		  				success:function(data){
		  					var content  = data.data;
		  					if(content.tag == 'error'){

		  						swal({
		  							title:"错误提示",
		  							text:content.info,
		  							html:true
		  						});
		  						return false;
		  					}

		  					if(content.tag == 'success'){
		  						swal("成功添加","您已经成功添加商品到购物车","success");
		  					}

		  					cartapp.rows 	= content;
		  				}
		  			})
		  		},

		  		//分页
		  		changePage:function(page){
					console.log(page);
		  			catapp.rows.current_page = page;

		  			//执行ajax
		  			this.doAjax();

		  		},

		  		//执行ajax
		  		doAjax:function(){

		  			//获取参数
		  			var param 		= this.getParam();

		  			//执行ajax操作
		  			$.ajax({

		  				url:"{{url('api/category/search')}}",
		  				type:'POST',
		  				data:'param=' + $.toJSON(param)+'&keywords='+this.keywords,
		  				dataType:'json',
		  				success:function(data){
		  					var  content 			    = data.data;
		  					//更新需要刷新的数据
		  					catapp.rows.goods_list 		= content.goods_list;
		  					catapp.rows.page 			= content.page;
		  					catapp.rows.number 			= content.number;
		  					catapp.rows.current_page 	= content.current_page;
		  					catapp.rows.per_page 		= content.per_page;
		  					catapp.rows.last_page 		= content.last_page;
		  					catapp.rows.total 			= content.total;
		  				}
		  			});
		  		},

		  		//获取参数
		  		getParam:function(){

		  			var  info 					= {};
		  				 info.current_page 		= catapp.rows.current_page;
		  			return info;
		  		
		  		},
		  	}
		  })
</script>