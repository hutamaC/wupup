@if ($errors->any())
    <div class="alert alert-danger" id="error-info-contnent">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script type="text/javascript">
	$(function(){
		$('#error-info-contnent').delay(3000).fadeOut();
	})
</script>