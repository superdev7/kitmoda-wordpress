<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script>
$.noConflict()(function($){
$(document).ready(function(){
$(":checkbox").on('click', function(){
    $(this).parent().toggleClass("checked");
	
});
});
});
   
</script>

<div class="sidebar">



    



    <div class="header"><span>Narrow Results</span></div>



    <input type="hidden" name="cat" value="" id="ff_cat" />

    <input type="hidden" name="sort" value="" id="ff_sort" />
    
    <div class="coll_sidebar_shadow">
    
    <div class="sb_content">

        <div class="field_group">

            <div class="title">Price</div>

            <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>



            <?=KSM_Form::store_facet_field('price', 'filter_label', 6);?>

        </div>



        <div class="field_group">

            <div class="title">Style</div>

            <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>



            <?=KSM_Form::store_facet_field('style', 'filter_label', 8);?>

        </div>



        <div class="field_group">

            <div class="title">Era / Time</div>

            <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>

            <?=KSM_Form::store_facet_field('era', 'filter_label');?>

        </div>



        <div class="field_group">

            <div class="title">File Format</div>

            <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>



            <?=KSM_Form::store_facet_field('file_format', 'filter_label', 7);?>

        </div>



        

        <div class="field_group">

            <div class="title">Model Type</div>

            <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>



            <?=KSM_Form::store_facet_field(array('game_ready', 'print_ready', 'environment'), 'filter_label');?>

        </div>



        <div class="field_group">

            <div class="title">Model Specs</div>

            <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>



            <?=KSM_Form::store_facet_field(array('model_quads', 'world_scale'), 'filter_label');?>

        </div>



        <div class="field_group">

            <div class="title">Poly Count (Triangles)</div>

            <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>



            <?=KSM_Form::store_facet_field('poly_count', 'filter_label', 8);?>

        </div>



        <div class="field_group">

            <div class="title">Texturing Method</div>

            <?=KSM_Form::store_facet_field(array('texturing_method'), 'filter_label', 2);?>

        </div>



        <div class="field_group">

            <div class="title">Detail Mapping</div>

            <?=KSM_Form::store_facet_field('mapping', 'filter_label');?>

        </div>



        <div class="field_group">

            <div class="title">Lighting Setup</div>

            <?=KSM_Form::store_facet_field('lighting', 'filter_label');?>

        </div>



        <div class="field_group">

            <div class="title">Renderer</div>

            <?=KSM_Form::store_facet_field('renderer', 'filter_label', 6);?>

        </div>



    </div>
    
    </div>



    

<div class="">

                <div class="community_sidebar_footer"></div>

            </div>

</div>




    