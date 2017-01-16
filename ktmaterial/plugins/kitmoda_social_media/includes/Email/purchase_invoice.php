<?php



class KSM_Email_PurchaseInvoice extends KSM_Email {
    
    
    public $User,
           $name,
           $key;
    
           
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
        
        if($args['id']) {
            $this->Post = KSM_Payment::get($args['id']);
            
            if($this->Post) {
                $this->User = $this->Post->Author;
            }
            
        }
    }
    
    
    
    public function subject() {
        $subject = 'Purchase Invoice';
        return $subject;
    }
    
    function prepare_data() {
        
        
        
        
        $data = array();
        
        
        $data['total_amount'] =  $this->Post->amount();
        
        //$data['item_thumb'] = $this->Post->Download->the_thumb('purchase_lib_thumb');
        //$data['item_category'] = $this->Post->Download->get_tax_label('category', false);
        //$data['item_keywords'] = $this->Post->Download->get_tax_label('keyword', false);
        //$data['item_era'] = $this->Post->Download->get_tax_label('era');
        //$data['item_style'] = $this->Post->Download->get_tax_label('style');
        //$data['item_culture'] = $this->Post->Download->get_tax_label('culture');
        //$data['item_title'] = $this->Post->Download->post_title;
        
        
        
        
        $data['items'] = $this->getItems();
        
        $data['payment_method'] = $this->Post->method_label();
        $data['payment_date'] = $this->Post->payment_date();
        $data['payment_time'] = $this->Post->payment_time();
        
        
        
        return $data;
        
    }

    
    function getItems() {
        
        $items = KSM_Purchased_Download::get_from_payment($this->Post->ID);
    
        ob_start();
        
        if( $items ) :
            foreach ( $items as $item ) : 
                $download = $item->Download;
                include KSM_VIEWS_PATH . '__Email' . DIRECTORY_SEPARATOR . '__Element' . DIRECTORY_SEPARATOR . 'invoice_item.php';
            endforeach;
        endif;
        
        
        return ob_get_clean();
    }
}