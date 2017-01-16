<div class="search_box search_form">
    <div class="select_boxes">		
        <?=KSM_Taxonomy::dropdown(array('class'=>'sb_category' ,'none'=>'CATEGORY'));?>
        <?=KSM_Taxonomy::dropdown(array('tax'=>'style', 'class'=>'sb_style', 'value'=>'name', 'none'=>'STYLE'));?>
        <div class="clr"></div>
    </div>	 

    <div class="field field_inp"><input type="text" name="s" id="ff_q" value="" placeholder="Search..."> <div class="field button"><span></span></div></div>

   

    <div class="clr"></div>
</div>