<?php


class KSM_Rest_Controller_Store extends KSM_BaseRest {
       
    
    public function get_featured() {
        
        //$action = KSM_Action::get($this->param('id'));
                   
        
        $result = '';
        return $result;
        

    }


    public function get_categories_for_menu_permission($request) {

    return true;

}
    public function get_categories_for_menu(){
        if($_POST['id'] != '-')
        $arr_cats_primary = KSM_Taxonomy::custom_list(array('orderby' => 'term_id', 'order' => 'ASC', 'parent' => $_POST['id']));
        else
        $arr_cats_primary = KSM_Taxonomy::custom_list(array('orderby' => 'term_id', 'order' => 'ASC'));

        foreach ($arr_cats_primary as $key => $value){
            $arr_cats_primary[$key] = str_replace('&amp;', '&', $arr_cats_primary[$key]);
        }

        return $arr_cats_primary;
    }
    
}

?>
