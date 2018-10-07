<script type="text/javascript">
	var  loginroot  = new Vue({

		  el:'#loginroot',
		  data:{

		  		 username:'',
		  		 password:'',
		  		 _token: "{{csrf_token()}}",
		  },
		  methods:{

		  	  //后台管理员登录
		  	  adminLogin:function(){

		  	  	    var username  = this.username;
		  	  	    var password  = this.password;
		  	  	    var _token    = this._token;

		  	  	    $.ajax({

		  	  	    	url:"{{url('api/admin/login')}}",
		  	  	    	type:'POST',
		  	  	    	data:'username='+username+'&password='+password + '&_token=' + _token,
		  	  	    	dataType:'json',
		  	  	    	success:function(data){
		  	  	    		var res  = data.data;
		  	  	    		if(res.tag == 'error'){

		  	  	    			swal({
		  	  	    				title:"错误提示",
		  	  	    				text:res.info,
		  	  	    				html:true,
		  	  	    				type:'error'
		  	  	    			});
		  	  	    			return false;
		  	  	    		}

		  	  	    		if(res.tag == 'success'){

		  	  	    			swal({
		  	  	    				title:"成功登录",
		  	  	    				text:res.info,
		  	  	    				type:'success'
		  	  	    			});

		  	  	    			window.location.href = "{{url('admin/index')}}";
		  	  	    		}
		  	  	    	}
		  	  	    });
		  	  },
		  }
	})
</script>