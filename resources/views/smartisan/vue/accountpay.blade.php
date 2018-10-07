<script type="text/javascript">
	var  acpay  = new Vue({

		  el:'#acpay',
		  data:{

		  	     'order_id':"{{$order->id}}"
		  },

		  methods:{

		  	        //确认支付
		  	        accountPay:function(){

		  	        	    var  order_id 	= this.order_id;

		  	        	    $.ajax({

		  	        	    	url:"{{url('api/account/pay')}}",
		  	        	    	type:"post",
		  	        	    	data:"order_id="+order_id,
		  	        	    	dataType:"json",
		  	        	    	success:function(data){

		  	        	    		var  res  = data.data;
		  	        	    		//错误提示
		  	        	    		if(res.tag == 'error'){

		  	        	    			swal({
		  	        	    				title:"余额不足",
		  	        	    				text:'请马上充值',
		  	        	    				html:true,
		  	        	    				type: "warning",
											showCancelButton: true, 
											confirmButtonColor: "#DD6B55",
											confirmButtonText: "去充值", 
											cancelButtonText: "取消",
											closeOnConfirm: true, 
											closeOnCancel: true,	
		  	        	    			},
		  	        	    			function(isConfirm){ 
										  if (isConfirm) { 
										  	window.location.href = "{{url('auth/money')}}";
										  } else { 
										  	return true ;
										  } 
										});
		  	        	    			return false;
		  	        	    		}

		  	        	    		//成功执行
		  	        	    		if(res.tag  == 'success'){

		  	        	    			swal({

		  	        	    				title:"成功余额支付",
		  	        	    				text:res.info,
		  	        	    				html:true,
		  	        	    				type:"success"
		  	        	    			});

		  	        	    			window.location.href = "{{url('auth/order')}}";
		  	        	    		}


		  	        	    	}
		  	        	    });
		  	        },
		  }
	})
</script>