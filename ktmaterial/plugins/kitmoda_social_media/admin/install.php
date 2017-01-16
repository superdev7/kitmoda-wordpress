<?php





/*
 
CREATE TRIGGER `ksm_count_total_posts` AFTER INSERT ON  `wp_posts` 
FOR EACH ROW 
BEGIN 
DECLARE ksm_total_posts BIGINT;

SET ksm_total_posts := ( SELECT COUNT( p.ID ) AS ksm_total_posts
FROM wp_posts p
WHERE p.post_type =  'ksm_wall_post' ) ;

UPDATE wp_options SET option_value = ksm_total_posts WHERE option_name =  'ksm_total_posts';

END







CREATE TRIGGER `ksm_count_total_favorites` AFTER UPDATE ON  `wp_usermeta` 
FOR EACH ROW 
BEGIN 
DECLARE ksm_total_favorites BIGINT;

SET ksm_total_favorites := ( SELECT SUM( um.meta_value ) AS ksm_total_favorites
FROM wp_usermeta um
WHERE um.meta_key =  'favorites_count' ) ;

UPDATE wp_options SET option_value = ksm_total_favorites WHERE option_name =  'ksm_total_favorites';

END















CREATE TRIGGER `ksm_count_totals` AFTER UPDATE ON  `wp_postmeta` FOR EACH ROW 
BEGIN 
    DECLARE ksm_total_likes BIGINT;
    DECLARE ksm_total_sales BIGINT;

    IF NEW.meta_key =  'likes_count' THEN 
        SET ksm_total_likes := ( SELECT SUM( pm.meta_value ) AS ksm_total_likes FROM wp_postmeta pm WHERE pm.meta_key =  'likes_count' ) ;
        UPDATE wp_options SET option_value = ksm_total_likes WHERE option_name =  'ksm_total_likes';
    END IF ;

    IF NEW.meta_key =  '_edd_download_earnings' THEN 
        SET ksm_total_sales := ( SELECT SUM( pm.meta_value ) AS ksm_total_sales FROM wp_postmeta pm WHERE pm.meta_key =  '_edd_download_earnings' ) ;
        UPDATE wp_options SET option_value = ksm_total_sales WHERE option_name =  'ksm_total_sales';
    END IF ;
END












 */

class KSM_Install {
    
    
    
    function init() {
        
        global $wpdb;
        require_once(ABSPATH . 'magento-help/includes/upgrade.php');
        $ksm_plugin_version = get_option('ksm_plugin_version');

        if(!$ksm_plugin_version) {
            
            
            
            require_once 'schema.php';
            
            
            foreach($tables as $table_name => $table_args) {
                $tbl_name = "{$wpdb->prefix}ksm_{$table_name}";
                $fields = array();
                foreach($table_args as $fname => $f) {
                    $fields[] = "`{$fname}` {$f}";
                }
                $query = 
                "CREATE TABLE IF NOT EXISTS {$tbl_name} (".implode(', ', $fields).") ENGINE = InnoDB;";
                dbDelta($query);
            }
            
            
            $count_totals_trigger = "
                CREATE TRIGGER `ksm_count_totals` AFTER UPDATE ON ".$wpdb->postmeta." FOR EACH ROW BEGIN 
                    DECLARE ksm_total_likes BIGINT;
                    IF NEW.meta_key = 'likes_count' THEN
                        SET ksm_total_likes := ( SELECT sum( pm.meta_value ) AS ksm_total_likes FROM ".$wpdb->postmeta." pm WHERE pm.meta_key =  'likes_count' ) ;
                        UPDATE ".$wpdb->options." SET option_value = ksm_total_likes WHERE option_name =  'ksm_total_likes';
                    END IF;
                END";
            
            
            
            
            $count_total_posts_trigger = "
                CREATE TRIGGER `ksm_count_total_posts` AFTER INSERT ON ".$wpdb->posts." FOR EACH ROW BEGIN
                    DECLARE ksm_total_posts BIGINT;
                    SET ksm_total_posts := (SELECT COUNT(p.ID) as ksm_total_posts FROM ".$wpdb->posts." p WHERE p.post_type = 'ksm_wall_post');
                    UPDATE ".$wpdb->options." SET option_value = ksm_total_posts WHERE option_name='ksm_total_posts';
                END";
            
            $count_total_favorites_trigger = "
                CREATE TRIGGER `ksm_count_total_favorites` AFTER UPDATE ON ".$wpdb->usermeta." FOR EACH ROW BEGIN 
                    DECLARE ksm_total_favorites BIGINT;
                    SET ksm_total_favorites := ( SELECT SUM( um.meta_value ) AS ksm_total_favorites FROM ".$wpdb->usermeta." um WHERE um.meta_key =  'favorites_count' ) ;
                    UPDATE ".$wpdb->options." SET option_value = ksm_total_favorites WHERE option_name =  'ksm_total_favorites';
                END";
            
            
            $drop_triggers = array(
                "DROP TRIGGER IF EXISTS ksm_count_totals",
                "DROP TRIGGER IF EXISTS ksm_count_total_posts",
                "DROP TRIGGER IF EXISTS ksm_count_total_favorites"
                );
            
            
            
            foreach($drop_triggers as $dt) {
                $wpdb->query($dt);
            }
            
            $wpdb->query($count_totals_trigger);
            $wpdb->query($count_total_posts_trigger);
            $wpdb->query($count_total_favorites_trigger);
            
            
            update_option("ksm_plugin_version", KSM_PLUGIN_VERSION);
            
            
            if(!get_option('ksm_total_posts')) {
                update_option('ksm_total_posts', '0');
            }
            
            if(!get_option('ksm_total_favorites')) {
                update_option('ksm_total_favorites', '0');
            }
            
            if(!get_option('ksm_total_likes')) {
                update_option('ksm_total_likes', '0');
            }
            
            
            
        
            
            
            $this->ksm_create_pages();
        }
    }


    function ksm_create_pages() {
        
        //$this->create_page( 'ksm-tab-community', __( 'Community', 'ksm' ), '[ksm_profile_community]' );
        //$this->create_page( 'ksm-tab-studio', __( 'Studio', 'ksm' ), '[ksm_profile_studio]' );
        //$this->create_page( 'ksm-tab-collaboration', __( 'Collaborate', 'ksm' ), '[ksm_profile_collaboration]' );
        //$this->create_page( 'ksm-tab-store', __( 'Store', 'ksm' ), '[ksm_profile_store]' );
        //$this->create_page( 'ksm-page-edit_profile', __( 'Edit Profile', 'ksm' ), '[ksm_edit_profile]' );
        //$this->create_page( 'ksm-page-following', __( 'Following', 'ksm' ), '[ksm_profile_following]' );
        //$this->create_page( 'ksm-page-favorites', __( 'Favorites', 'ksm' ), '[ksm_profile_favorites]' );
        //$this->create_page( 'ksm-page-top_selling', __( 'Top Sellings', 'ksm' ), '[ksm_profile_top_selling]' );
        //$this->create_page( 'ksm-page-compose', __( 'Compose', 'ksm' ), '[ksm_compose_message]' );
        //$this->create_page( 'ksm-page-settings', __( 'Settings', 'ksm' ), '[ksm_profile_settings]' );
        //$this->create_page( 'ksm-page-add_wip', __( 'Add WIP Image', 'ksm' ), '[ksm_profile_add_wip]' );
        //$this->create_page( 'ksm-page-publisher', __( 'Publisher', 'ksm' ), '[ksm_profile_publisher]' );
        //$this->create_page( 'ksm-page-post_options', __( 'Post Options', 'ksm' ), '[ksm_post_options]' );
        //$this->create_page( 'ksm-page-share', __( 'Share', 'ksm' ), '[ksm_share_page]' );
        //$this->create_page( 'ksm-page-sl', __( 'Short Link', 'ksm' ), '' );
        
    }


    function create_page( $slug , $page_title = '', $page_content = '', $post_parent = 0 ) {
	global $wpdb;
        
        $option = $slug.'-page';
	$option_value = get_option( $option );
	if ( $option_value > 0 && get_post( $option_value ) ) {
            return;
        }
        
	$page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM " . $wpdb->posts . " WHERE post_name = %s LIMIT 1;", $slug ) );
	if ( $page_found ) {
            if ( ! $option_value ) {
		update_option( $option, $page_found );
            }
            return;
	}
        
        

	$page_data = array(
            'post_status' 		=> 'publish',
            'post_type' 		=> 'page',
            'post_author' 		=> 1,
            'post_name' 		=> $slug,
            'post_title' 		=> $page_title,
            'post_content' 		=> $page_content,
            'post_parent' 		=> $post_parent,
            'comment_status' 	=> 'closed'
        );
        
        $page_id = wp_insert_post( $page_data );
        update_option( $option, $page_id );
    }


}


?>