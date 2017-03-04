<div class="search_box search_form">
	
	<div class="categories">
		<ul class="firstList">
<!--			<li>categories <span class="down"></span>
				<ul class="subCategory secondList">
					<li>manmade structures</li>
					<li>manmade structures</li>
					<li>manmade structures</li>
					<li>manmade structures</li>
					<li>manmade structures</li>
				</ul> 
			</li>-->
                        <?php
                        $arr_cats_primary = KSM_Taxonomy::custom_list(array('orderby' => 'term_id', 'order' => 'ASC'));
//                        For child cats
//                        $arr_cats_second = KSM_Taxonomy::custom_list(array('parent' => 8662));
//                        pr($arr_cats_second);
                        if( !empty($arr_cats_primary) ){ ?>
                                <li>categories <span class="down"></span>
                                    <ul class="subCategory secondList">
                                        <?php
                                        foreach ($arr_cats_primary as $key => $cat_primary) { ?>
                                            <li data-parent="<?php echo $key; ?>"><?php echo $cat_primary; ?></li>
                                        <?php }
                                        ?>
                                    </ul>
                        <?php } ?>
		</ul>
		<div class="thirdStep">
			<span class="back">back</span>
			<h6 class="title" >all primary category</h6>
			<div class="single-item-category">sub-category</div>
			<div class="single-item-category">sub-category</div>
			<div class="single-item-category">sub-category</div>
			<div class="single-item-category">sub-category</div>
			<div class="single-item-category">sub-category</div>
		</div>
	</div>
	<div class="refine">refine </div>

	<div class="refine-menu">
		<form action="">
			<div class="close-refine-button"></div> 
			<div class="go">Go <span class="arrow-go"></span></div>
			<div class="first-column ">
				<div class="title">style</div>
                                <?php
                                $arr_tax_styles = KSM_Taxonomy::custom_list(array('tax'=>'style'));
                                if( !empty($arr_tax_styles) ){ ?>
                                    <ul class="list-options scrollbar-inner">
                                        <li><input type="checkbox" name="style-options" id="opt1" value="all" checked><label for="opt1" class="active">all</label></li>
                                        <?php
                                        foreach ($arr_tax_styles as $key => $tax_style) { ?>
                                                <li><input type="checkbox" name="style-options[]" id="opt<?php echo $key; ?>" value="<?php echo $key; ?>"><label for="opt<?php echo $key; ?>"><?php echo $tax_style; ?></label></li>
                                        <?php }
                                        ?>
                                    </ul>
                                <?php } ?>
			</div>
			<div class="second-column">
				<div class="title">culture</div>
				<ul class="list-options scrollbar-inner">
					<li><input type="checkbox" name="culture-options" id="cultr-opt1" checked><label for="cultr-opt1" class="active">none/general</label></li>
					<li><input type="checkbox" name="culture-options" id="cultr-opt2"><label for="cultr-opt2">african</label></li>
					<li><input type="checkbox" name="culture-options" id="cultr-opt3"><label for="cultr-opt3">north american</label></li>
					<li><input type="checkbox" name="culture-options" id="cultr-opt4"><label for="cultr-opt4">indic</label></li> 
				    <li><input type="checkbox" name="culture-options" id="cultr-opt5"><label for="cultr-opt5">none/general</label></li>
					<li><input type="checkbox" name="culture-options" id="cultr-opt6"><label for="cultr-opt6">african</label></li>
					<li><input type="checkbox" name="culture-options" id="cultr-opt7"><label for="cultr-opt7">north american</label></li>
					<li><input type="checkbox" name="culture-options" id="cultr-opt8"><label for="cultr-opt8">north american</label></li>
					<li><input type="checkbox" name="culture-options" id="cultr-opt9"><label for="cultr-opt9">north american</label></li>
					<li><input type="checkbox" name="culture-options" id="cultr-opt10"><label for="cultr-opt10">indic</label></li> 
				    
				</ul>
			</div>
			<div class="third-column"> 
				<!-- <div class="row era">
					<div class="sub-title">era <span>present to present</span> </div> 
					<div class="slider"></div>
				</div> -->
				<div class="row format">
					<div class="sub-title">primary file format</div>
					<div class="container-format">
						<div class="columns-all">
							<div class="ind-check"><input type="checkbox" id="format1" value="all" name="check-format"><label for="format1">all</label></div>
						</div>
						<div class="else">
							<div class="ind-check"><input type="checkbox" id="format1" value="max" name="check-format"><label for="format1">max</label></div>
							<div class="ind-check"><input type="checkbox" id="format1" value="mb" name="check-format"><label for="format1">mb</label></div>
							<div class="ind-check"><input type="checkbox" id="format1" value="obj" name="check-format"><label for="format1">obj</label></div>
							<div class="ind-check"><input type="checkbox" id="format1" value="lwo" name="check-format"><label for="format1">lwo</label></div>
							<div class="ind-check"><input type="checkbox" id="format1" value="xsi" name="check-format"><label for="format1">xsi</label></div>
							<div class="ind-check"><input type="checkbox" id="format1" value="c4d" name="check-format"><label for="format1">c4d</label></div>
							<div class="ind-check"><input type="checkbox" id="format1" value="3ds" name="check-format"><label for="format1">3ds</label></div>
							<div class="ind-check"><input type="checkbox" id="format1" value="ma" name="check-format"><label for="format1">ma</label></div>
						</div>
					 </div>
				</div>
				<div class="row price-range">
					<div class="sub-title">price range</div>
					<div class="container-price-range">
						<span>$ <input type="text" value=""></span> to  <span> $ <input value="" type="text"></span>
					</div>
				</div>
			</div>
		</form>
	</div>

    <div class="field field_inp"><input type="text" name="s" id="ff_q" value="" placeholder="Search 3D Models..."> <div class="field button"><span></span></div></div>
 
    <div class="clr"></div>
</div>
 