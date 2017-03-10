<div class="search_box search_form">

	<div class="categories" ng-controller="searchBox">
		<ul class="firstList">
            <li class="firstItemList" ng-if="categories_list"><span class="open_ctg">categories <span class="down"></span></span>
                <ul class="subCategory secondList">
                    <li ng-repeat="(key,value) in categories_list" ng-click="get_child(key,value)">{{value}}</li>
                </ul>
            </li>
		</ul>
		<div class="thirdStep" style="box-shadow: black -7px 7px 17px 5px;">
			<span class="back" ng-click="go_to_parent()">back</span>
			<h6 class="title" style="cursor: pointer;" ng-click="goto_category()">{{selected_categorie_name}}</h6>
			<div class="single-item-category" style="cursor: pointer;" ng-repeat="(key,value) in child_categories_list" ng-click="get_child(key,value)">{{value}}</div>
		</div>
	</div>
	<div class="refine">refine </div>

	<div class="refine-menu" ng-controller="refineMenu">
		<form action="">
			<div class="close-refine-button"></div> 
			<div class="go" ng-click="filtering_refine()">Go <span class="arrow-go"></span></div>
			<div class="first-column ">
				<div class="title">style</div>
                                <?php
                                $arr_tax_styles = KSM_Taxonomy::custom_list(array('tax'=>'style'));
                                if( !empty($arr_tax_styles) ){ ?>
                                    <ul class="list-options scrollbar-inner" id="scrollbar-inner2">
                                        <li><input type="radio" name="style-options" id="opt1" ng-model="style" ng-true-value="all" value="all" checked><label for="opt1" class="active">all</label></li>
                                        <?php
                                        foreach ($arr_tax_styles as $key => $tax_style) { ?>
                                                <li>
                                                    <input type="radio"
                                                           name="style-options"
                                                           id="opt<?php echo $key; ?>"
                                                           ng-model="style"
                                                           ng-true-value="<?php echo $tax_style; ?>"
                                                           value="<?php echo $tax_style; ?>">
                                                    <label style="cursor: pointer;" for="opt<?php echo $key; ?>"><?php echo $tax_style; ?></label>
                                                </li>
                                        <?php }
                                        ?>
                                    </ul>
                                <?php } ?>
			</div>
			<div class="second-column">
				<div class="title">culture</div>
				<ul class="list-options scrollbar-inner" id="scrollbar-inner1">
					<li><input type="radio" name="culture-options" id="cultr-opt1" ng-model="culture" ng-true-value="all" checked><label for="cultr-opt1" class="active">none/general</label></li>
                                        <?php
                                        $terms = get_terms( 'ksm_tax_culture', array(
                                                            'orderby'    => 'name',
                                                            'hide_empty' => false,
                                                            'fields'     => 'id=>name',
                                        ) );
                                        if( !empty($terms) ){
                                            foreach ($terms as $key => $value) {
                                                echo '<li><input type="radio" name="culture-options" ng-model="culture" ng-true-value="'. $value .'" id="cultr-'. $key .'" value="'. $value .'"><label for="cultr-'. $key .'">'. $value .'</label></li>';
                                            }
                                        }
                                        ?>				    
				</ul>
			</div>
			<div class="third-column">  
                            <div class="row era">
                                <div class="sub-container">
                                    <div class="sub-title">era</div>
                                    <div class="slider-desciption">
                                        <span class="first">present</span>
                                        <span class="to">to</span>
                                        <span class="second">present</span>
                                    </div>
                                </div>                    
                                <div id="polygonEra"></div>
                            </div> 
                            <div class="row objInv">
                                <div class="sub-container">
                                    <div class="sub-title">object or environment</div> 
                                </div>                    
                                <div id="polygonObjInv"></div>
                            </div>

                            <div class="row format">
                                    <div class="sub-container">
                                            <div class="sub-title">primary file format</div>
                                    </div>
                                    <div class="container-format">
                                            <div class="columns-all">
                                                    <div class="ind-check"><input type="radio" id="format-all" value="all" ng-model="file_format['all']" name="check-format"><label for="format-all">all</label></div>
                                            </div>
                                            <div class="else">
                                                <?php
                                                $terms = get_terms( 'ksm_tax_file_format', array(
                                                                    'orderby'    => 'id',
                                                                    'hide_empty' => false,
                                                                    'fields'     => 'id=>name',
                                                                    'exclude'    => '77,76,83,81' // blend,mud,stl,ztl and without 3ds
                                                ) );
                                                if( !empty($terms) ){
                                                    foreach ($terms as $key => $value) {
                                                        echo '<div class="ind-check"><input type="radio" id="format-'. $value .'" ng-model="file_format[\''. $value .'\']" value="'. $value .'" name="check-format"><label for="format-'. $value .'">'. $value .'</label></div>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                     </div>
                            </div>
                            <div class="row polCount">
                                <div class="sub-container">
                                    <div class="sub-title">polygon count range</div>
                                    <div class="slider-desciption">
                                        <span class="first">0</span>
                                        <span class="to">to</span>
                                        <span class="second">15</span>
                                    </div>
                                </div>                    
                                <div id="countRange"></div>
                            </div>
                            <div class="row product-rating">
                                <div class="sub-container">
                                    <div class="sub-title">product rating</div>
                                    <div class="slider-desciption">
                                        <span class="first"><span id="product-rating-number">1</span> <i>&#9733;</i></span> 
                                        <span class="second">& up</span>
                                    </div>
                                </div>                    
                                <div id="productRating"></div>
                            </div>
                            <div class="row price-range">
                                <div class="sub-container">
                                    <div class="sub-title">price range</div>
                                </div>
                                <div class="container-price-range">
                                    <span>$ <input type="text" name="firstPrice" value="" ng-model="price_min"></span>
                                    <span class="to">to</span>   
                                    <span> $ <input value="" name="secondPrice" type="text" ng-model="price_max"></span>
                                </div>
                            </div>
			</div>
		</form>
	</div>

    <div class="field field_inp" ng-controller="searchInput">
        <input type="text" name="s" id="ff_q" value="" ng-model="search_text" placeholder="Search 3D Models...">
        <div class="field button" ng-click="search_by_text()"><span></span></div>
    </div>
 
    <div class="clr"></div>
</div> 
<?php
//Data for js-slider
$terms = get_terms( 'ksm_tax_era', array(
                    'orderby'    => 'id',
                    'hide_empty' => false,
                    'fields'     => 'names',
) );
$json = !empty($terms) ? json_encode($terms) : '';
?>
<script>
var eras = <?php echo $json; ?>;
var erasLength = eras.length - 1;
</script>