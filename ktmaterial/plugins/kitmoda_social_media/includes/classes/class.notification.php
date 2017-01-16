<?php



class KSM_Notification extends KSM_Object {
    
    public $name,
           $notification
           ;
    
    public function __construct($args = array()) {
        parent::__construct($args);
    }
    
    static function get($name, $args = array()) {
        
        if($name) {
            $cls_name = "KSM_Notification_" . ucfirst(ksm_camelcase($name));
            
            $args['name'] = $name;
            if(class_exists($cls_name)) {
                return new $cls_name($args);
            }
            
        }
        
        
        return null;
    }
    
    
    
    public function send() {
        $data = $this->add_data();
        
        if($data) {
            self::add($data['user_id'], $this->name, $data['value']);
        }
        
    }


    public function render() {
        $data = $this->view_data();
        
        
        $data['time_ago'] = time_ago($this->notification->date);
        $data['id'] = $this->notification->id;
        $data['read'] = $this->notification->read ? true : false;
        
        extract($data);
        include KSM_VIEWS_PATH ."__Notification/{$this->name}.php";
    }



    static function add($user_id, $key, $value) {
        global $wpdb;
        $date = time();
        
        $value = maybe_serialize($value);
        
        $wpdb->insert(
                $wpdb->prefix."ksm_notifications", 
                array('user_id' =>  $user_id, 'key' => $key, 'value' => $value , 'date' => $date), 
                array('%d' ,'%s', '%s' , '%d') 
                );
        
        
        update_user_meta($user_id, 'notifications_news_count', self::count_news($user_id));
        update_user_meta($user_id, 'notifications_count', self::count_user_notifications($user_id));
                
    }
    
    
    
    
    static function count_user_notifications($user_id) {
        global $wpdb;
        return $wpdb->get_var("SELECT COUNT(id) FROM {$wpdb->prefix}ksm_notifications WHERE user_id = '{$user_id}'");
    }
    
    static function count_news($user_id) {
        global $wpdb;
        
        return $wpdb->get_var("SELECT COUNT(id) FROM {$wpdb->prefix}ksm_notifications WHERE user_id = '{$user_id}' AND `read` < 1");
    }
    
    
    
    static function get_notifications($user_id, $p, $rpp) {
        global $wpdb;
        $start = ($p * $rpp) - $rpp;
        
        $sql = "SELECT * FROM {$wpdb->prefix}ksm_notifications WHERE user_id = '%d' ORDER BY date DESC LIMIT %d, %d";
        $result = $wpdb->get_results($wpdb->prepare($sql, $user_id, $start, $rpp));
        return $result;
    }
    
    static function get_notification($id) {
        global $wpdb;
        
        $sql = "SELECT * FROM {$wpdb->prefix}ksm_notifications WHERE id = '%d'";
        $result = $wpdb->get_results($wpdb->prepare($sql, $id));
        return $result[0];
    }
    
    
    static function mark_read($id) {
        global $wpdb;
        
        $wpdb->update( "{$wpdb->prefix}ksm_notifications", 
                array('read' => '1') ,
                array('id' => $id) , 
                array('%d'), 
                array('%d') );
        
    }
    
    static function delete_notification($id) {
        global $wpdb;
        
        $wpdb->delete(
                    $wpdb->prefix."ksm_notifications", 
                    array('id' =>  $id), 
                    array( '%d') 
                    );
        
    }
        
    static function delete_notifications() {
        global $user_ID;
            
            
        $items = $_POST['items'] ? $_POST['items'] : array();
        $ids = array();
        foreach($items as $i) {
            if($i['value'] && is_numeric($i['value']) && $i['value'] > 0) {
                $ids[] = $i['value'];
            }
        }
            
        $deleted = array();
            
        foreach($ids as $id) {
            $not = self::get_notification($id);
            if($not && $not->user_id == $user_ID) {
                self::delete_notification($id);
                $deleted[] = $id;
            }
        }
        
        update_user_meta($user_ID, 'notifications_count', self::count_user_notifications($user_ID));
        update_user_meta($user_ID, 'notifications_news_count', self::count_news($user_ID));
        
        
        $total_deleted = count($deleted);
        if($total_deleted > 0) {
                
            $user = wp_get_current_user();

            $rpp = KSM_MESSAGES_DROPDOWN_RESULTS_PER_PAGE;
            $total_pages = ceil(get_number($user->notifications_count)/$rpp);

            $p = $_POST['p'] ? $_POST['p'] : 1;
            $p = (!is_numeric($p) || $p < 1) ? 1 : $p;

            if($p > $total_pages) {
                $p = $total_pages;
                $total_deleted = 0;
            }


            self::dd_list_notifications($total_deleted, $p);
        }
            
            
    }
        
        
    static function dd_list_notifications($max, $page) {
            
            global $user_ID;
            
            $user = wp_get_current_user();
            
            
            $html = '';
            
            $rpp = KSM_MESSAGES_DROPDOWN_RESULTS_PER_PAGE;
            $p = $page;
            $p = (!is_numeric($p) || $p < 1) ? 1 : $p;
            
            $total_pages = ceil(get_number($user->notifications_count)/$rpp);
            
            $p = $p > $total_pages ? $total_pages : $p;
            
            if(get_number($user->notifications_count) == 0) {
                ob_start();
                include KSM_VIEWS_PATH .'__Element/empty_dd_notification_item.php';
                $html = ob_get_clean();
                $paging = false;
            } else {
                
                $notifications = self::get_notifications($user_ID, $p, $rpp);
                
                
                
                
                
                $skip = $max ? $rpp - $max : 0;
                $c = 0;
                ob_start();
                foreach ($notifications as $not) {
                    if($skip > $c) {
                        continue;
                    }
                    
                    $notification = KSM_Notification::get($not->key, array('notification'=> $not));
                    $notification->render();
                    
                    
                    if($not->read == '0') {
                        KSM_Notification::mark_read($not->id);
                    }
                    
                    $c++;
                }
                $html = ob_get_clean();
                
                
                
                update_user_meta($user_ID, 'notifications_news_count', self::count_news($user_ID));
                
                
                
                ob_start();
                include KSM_VIEWS_PATH .'__Element/dd_paging.php';
                
                $paging = ob_get_clean();
                
                
                
                
            }
            
            echo json_encode(
                    array(
                        'messages' => $html, 
                        'paging' => $paging,
                        'p' => $p
                    ));
            
            die();
            
        }
        
        
        
        static function notifications() {
            
            global $user_ID;
            
            $user = wp_get_current_user();
            
            $html = '';
            
            $rpp = KSM_MESSAGES_DROPDOWN_RESULTS_PER_PAGE;
            $total_pages = ceil(get_number($user->notifications_count)/$rpp);
            
            $p = $_POST['p'] ? $_POST['p'] : 1;
            $p = (!is_numeric($p) || $p < 1) ? 1 : $p;
            $p = $p > $total_pages ? $total_pages : $p;
            
            
            self::dd_list_notifications(0, $p);
        }
    
    
    
}