
<div class="search">

    <form class="bs-example bs-example-form" role="form">
        <div class="row">
            <h3>@{{$data['rows']['brand_name']}}.<span v-html="type"><span></h3>
            <div class="jewelinput col-lg-3">
                <div class="input-group">
                    <span class="input-group-btn">
                    @if($brid)
                        @include('smartisan.category.jewelCat')
                    @endif
                        s<button class="btn btn-default" type="button" v-on:click="reGetList()">查找</button>
                    </span>
                    <input type="text" class="form-control" v-model="search">
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <br>
        </div><!-- /.row -->
    </form>
</div>