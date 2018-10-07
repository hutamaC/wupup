<div class="row">
<div class="col s12">
<div class="user-box z-depth-1">
		
		{!!Form::open(['url'=>'auth/register','method'=>'post','class'=>'register-form'])!!}
        @include('materialize.lib.users.error')
        <div class="input-field col s12">
          <input type="text" id="username" name="username" class="validate" value="{!!old('username')!!}">
          <label for="username">{!!trans('front.username')!!}</label>
        </div>
       
        <div class="input-field col s12">
          <input type="email" id="email" name="email" class="validate" value="{!!old('email')!!}">
          <label for="email">{!!trans('front.email')!!}</label>
        </div>
        
        <div class="input-field col s12">
          <input type="password" id="password" name="password" class="validate">
          <label for="password">{!!trans('front.password')!!}</label>
        </div>
         

        

      <div class="input-field col s12">
			<button class="waves-effect waves-light btn-large red accent-3 register-btn col s6" type="submit">
				<i class="material-icons left">check_circle</i>
				{!!trans('front.register')!!}
			</button>
			<a href="{!!url('auth/login')!!}" class="btn-large grey col s6">
			<i class="material-icons right">arrow_forward</i>
			{!!trans('front.login')!!}
			</a>
		</div>


        {!!Form::close()!!}


</div>
</div>     
</div><!--row-->
