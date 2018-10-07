
<div class="cat-select-list">

<!-- <div class="attr-list" id="selected-btn-list">
	<div class="row">
        <div class="col-md-12">
        <span class="item active-item"
              v-on:click="countryGradeDel"
              >
            @{{rows.country_name}}            
            <i class="fa fa-times"></i>
        </span>
        </div>    
        </div>
</div> -->

<div class="attr-list" v-if="rows.country">
	<div class="row">
    	<div class="col-md-1">
        	<span class="tit">国家</span>
        </div><!--/col-md-2-->
        <div class="col-md-10">
        <span  class="item price-item"
               v-on:click="countryGrade('所有',$event)"
               data-min="0" data-max="0">所有</span>
        
        	<span class="item price-item" 
                  v-for="country in rows.country" v-on:click="countryGrade(country,$event)">
            @{{country}}
            </span>

        </div><!--/col-md-10-->
    </div><!--/row-->
</div><!--/attr_list-->






</div>