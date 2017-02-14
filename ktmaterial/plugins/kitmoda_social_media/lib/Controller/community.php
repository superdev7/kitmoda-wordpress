<?php

class KSM_CommunityController extends KSM_BaseController {



    public $scripts = array(
        array('justifiedGallery', array('jquery')),
        array('imagesloaded', array('jquery')),
        array('isotope', array('jquery')),
        array('autosize', array('jquery')),
        array('community', array('jquery', 'jquery-ui-sortable' , 'ksm_scripts', 'justifiedGallery')),
        array('selectbox/jquery.selectbox-0.2.min', array('jquery', 'ksm_scripts')),
        array('jquery.kmos', array('jquery', 'jquery-ui-sortable', 'justifiedGallery', 'isotope')),



        //array('components/common', array('jquery', 'angular')),
        array('community-app', array('jquery', 'angular', 'components-common' , 'ksm_scripts'))


    );




    public $styles = array('justifiedGallery.min', 'selectbox/jquery.selectbox');








    public function ksm_index() {

        $galleries = array();


        $galleries['Trending_Community'] = array();
        $galleries['New_Community'] = array();
        $galleries['Top_Rated_Community'] = array();
        $galleries['Challenge_Community'] = array();
        $galleries['Wip_Community'] = array();



        $this->Helpers['Mvg_kit_mosaic'] = array('galleries' => $galleries);



        $kitmoda_updates = get_posts(array(
            'post_type' => 'ksm_kitmoda_update',
            'status' => 'publish'
        ));


        $this->set('kitmoda_updates', $kitmoda_updates);
    }










    public function ksm_ajax_filter_posts() {

        $topics = (Array) $_POST['topic'];

        $only_following = $_POST['following'] ? true : false;
        $only_with_images = $_POST['with_images'] ? true : false;

        $tax_terms = array();

        $sorts = array('newest', 'likes', 'views');

        $sort = $_POST['sort'];


        $sort_args = array('orderby' => 'date', 'order' => 'DESC');

        if($sort == 'likes') {
            $sort_args = array('meta_key' => 'likes_count', 'orderby' => 'meta_value_num', 'order' => 'DESC');
        } elseif($sort == 'views') {
            $sort_args = array('meta_key' => 'views_count','orderby' => 'meta_value_num', 'order' => 'DESC');
        }

        foreach ($topics as $t) {
            if(in_array($t, $this->Community->topic_terms) || in_array($t, $this->Community->gallery_terms)) {
                $tax_terms[] = $t;
            }
        }





        $page = $_POST['page'];
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;

        $args = array(
            'posts_per_page' => COMMUNITY_POSTS_PER_PAGE,
            'paged' => $page,
            'post_type' => 'ksm_post'
            );



        $args['tax_query'] = array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'ksm_tax_post_at',
                'field' => 'name',
                'terms' => 'community'
                )
            );

        if($tax_terms) {
            $args['tax_query'][] = array(
                'taxonomy' => 'ksm_tax_topic',
                'field' => 'name',
                'terms' => $tax_terms);
        }



        $args = array_merge($args , $sort_args);









        if($only_with_images) {
            $args['meta_query'] = array(
                array(
                    'key' => 'images_count',
                    'value' => 0 ,
                    'compare' => '>'
                    )
                );

        }

        if($only_following) {

            if($this->KUser->Auth->ID) {
                $authors = KSM_Follow::get_all_user_following_ids($this->KUser->Auth->ID);
                if(!empty($authors)) {
                    $args['author'] = implode(',', $authors);
                }
            }

            if(!$args['author']) {
                echo json_encode(array('posts' => '<div class="empty_msg">No Post found.</div>', 'pagination' => ''));
                die();
            }
        }


        if($_POST['q']) {
            $args['s'] = $_POST['q'];
        }




        $query = new WP_Query( $args );



        $posts = array();

        foreach( $query->posts as $p ) {
            $posts[] = new KSM_Social_Post($p->ID);
        }


        $found = false;


        $containers = array();
        $containers['pagination'] = '';
        if($query->post_count > 0) {
            $found = true;
            $containers['pagination'] =
                $this->Model->paginate_links(array('prev_text' => '', 'next_text' => ''), $query);
        } else {
            $containers['posts'] = '<div class="empty_msg">No Post found.</div>';
        }

        /*
        $containers = array();
        ob_start();


        while ( $query->have_posts() ) : $query->the_post();
            $this->render_element('post_item');
        endwhile;
        $containers['posts'] = ob_get_clean();

        $containers['pagination'] =
                $this->Model->paginate_links(array('prev_text' => '', 'next_text' => ''), $query);

        */


        //wp_reset_postdata();


        //if($query->post_count == 0) {
        //    $containers['posts'] = '<div class="empty_msg">No Post found.</div>';
        //}



        wp_reset_query();
        wp_reset_postdata();

        if($found) {
            ob_start();
            foreach($posts as $p) {
                $this->render_element('post_item', array('post'=> $p));
            }
            $containers['posts'] = ob_get_clean();
        }


        echo json_encode($containers);



    }




    function ksm_ajax_kmvg() {



        $community_galleries = KSM_DataStore::Options('Community_Gallery');



        $galleries_list = array();

        $page = 1;
        switch($_POST['type']) {

            case "reset":
                $gal_names = $_POST['galleries'] == 'all' ? $community_galleries : explode(',', $_POST['galleries']);
                foreach($gal_names as $n) {
                    if(in_array($n, array_keys($community_galleries))) {
                        $galleries_list[$n] = $community_galleries[$n];
                    }
                }
                break;
            case "ftl" :
                $galleries_list = $community_galleries;
                break;
            case "":

                break;

        }

        foreach($galleries_list as $g) {
            $galleries[$g] = array();
        }



        if(empty($galleries)) {
            echo json_encode(array(
                'galleries' => array()
            ));
            die();
        }


        $mvg_kit_mosaic = new KSM_Mvg_kit_mosaicHelper(array('galleries' => $galleries));
        $result = $mvg_kit_mosaic->ajaxLoad($page, $_POST['type']);
        $response = array('galleries' => $result);
        echo json_encode($response);
    }




    public function ksm_ajax_submit_post() {

        $result = $this->Model->add_post();


        if($result['error']) {
            KSM_Js::setWallPostError($result['msg']);
        } elseif($result['success']) {
            KSM_Js::onCommunityPostAdded($result['post_id']);
        }
    }





    /////////////////////////////////////////////////////////////////////////






    public function ksm_post_options() {

        $is_edit = $this->params['action_type'] == 'edit' ? true : false;


        $this->layout = 'colorbox';
        $id = $this->params['id'];

        $post = new KSM_Social_Post($id);
        $post->view_type = 'community';



        if(!$post->post_options_available($is_edit)) {
            KSM_Js::closeColorBoxWithError("Post options are not available");
            exit;
        }

        $this->scripts[] = array('toggles.min', array('jquery'));
        $this->styles[] = 'toggles-full';



        $attachments = $post->image_attachments(array(
            'order'     => 'ASC',
            'meta_key' => 'image_sort',
            'orderby'   => 'meta_value_num',
        ));



        $post_at = $post->posted_at_type();
        $post_at_options = array('2' => 'Community + Studio', '1'=>'Only Community');
        $post_at_settings = array('name' => 'post_to', 'value' => ($post_at ? $post_at : 2));



        $this->set('is_edit', $is_edit);
        $this->set('submit_action', ($is_edit ? 'Community_submit_edit_post' : 'Community_submit_post_options'));

        $this->set('post_topic', $post->Topic());
        $this->set('post_progress', $post->Progress());
        $this->set('post_at_options', $post_at_options);
        $this->set('post_at_settings', $post_at_settings);
        $this->set('post', $post);
        $this->set('attachments', $attachments);

    }








    public function ksm_ajax_submit_edit_post() {
        $this->params['action_type'] = 'edit';
        $this->ksm_ajax_submit_post_options();
    }




    public function ksm_ajax_submit_post_options() {


        $is_edit = $this->params['action_type'] == 'edit' ? true : false;


        $post_id = $_POST['_id'];
        $post = new KSM_Social_Post($post_id);
        $post->view_type = 'community';


        $result = $post->save_post_options($is_edit);



        if($result['error']) {
            KSM_Js::setPopupError($result['msg']);
        } elseif($result['success']) {

            unset($post);
            $post = new KSM_Social_Post($post_id);
            $post->view_type = 'community';

            $galleries = array();
            if($result['update_galleries']) {
                $galleries = array_keys(KSM_DataStore::Options('Community_Gallery'));
            }


            $item = $post->rest_item('get', array('images' => null ,
                                                  'is_community' => true,
                                                  'gallery' => true
                                                  ));

            if($is_edit) {
                KSM_Js::editCommunityPost($post->ID, json_encode($item), $galleries);
            } else {
                KSM_Js::addCommunityPost(json_encode($item), $galleries);
            }
        }
    }




    public function ksm_delete_post() {

        $this->layout = 'colorbox';
        $id = $this->params['id'];


        $post = new KSM_Social_Post($id);
        $result = $post->can_delete_post();

        if($result['error']) {
            KSM_Js::closeColorBoxWithError($result['msg']);
            exit;
        }

        $this->set('post', $post);
    }



    public function ksm_ajax_submit_delete_post() {

        $id = $_POST['_id'];

        $delete_gallery_images = $_POST['delete_images'] == 'yes' ? true : false;

        $post = new KSM_Social_Post($id);
        $result = $post->delete($delete_gallery_images);





        if($result['error']) {
            KSM_Js::closeColorBoxWithError($result['msg']);
        } else {
            $galleries = array();
            if($result['update_galleries']) {
                $galleries = KSM_DataStore::Options('Community_Gallery');
            }
            KSM_Js::communityPostDeleted($id, $result['msg'], $galleries);
        }

    }






    /////////////////////////////////////////////////////////////////////////



    function ksm_ajax_submit_comment() {

        $comment = $_POST['comment'];
        $post_id = $_POST['_id'];




        $args = array(
            'user'=> wp_get_current_user(),
            'post_id' => $post_id,
            'comment' => $comment,
            'comment_type' => 'ksm_post',
            'extra_meta' => array(
                array('post_at', 'community')
            )
        );

        $result = $this->Model->submit_comment($args);

        if($result['error']) {
            KSM_Js::setCommunityCommentError($post_id, $result['error']);
            die();
        } elseif($result['success']) {
            $comment_id = $result['comment_id'];
            $wpc = get_comment($comment_id);
            ob_start();
            $this->render_element('comment_item', array('comment' => $wpc));
            $comment_item_html = ob_get_clean();
            $comment_item_html = preg_replace( "/\r|\n/", "", $comment_item_html );
            KSM_Js::addCommunityComment($post_id, $comment_item_html);
        }
    }

}
?>