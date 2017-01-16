<?php


class KSM_Purchased_Download extends KSM_Post {
    
    
    public $_post_type = 'ksm_p_download';
    
    public function __construct($id) {
        parent::__construct($id);
    }
    
    
    public function __get($name) {
        if($name == 'Download' && !isset($this->Download)) {
            $this->Download = new KSM_Download($this->download_id);
        } 
        
        //elseif($name == 'Payment' && !isset($this->Payment)) {
        //    $this->Payment = new KSM_Payment($this->post_parent);
        //}
        return parent::__get($name);
    }
    
    
    
    static function get_from_payment($payment_id) {
        
        $items = array();
        
        if($payment_id) {
            $args = array(
                'post_type' => 'ksm_p_download',
                'post_status' => 'any',
                'post_parent' => $payment_id,
                'posts_per_page' => -1
            );
            $query = new WP_Query( $args );
            
            foreach($query->posts as $post) {
                 $items[] = self::get($post->ID);
            }
        }
        
        return $items;
    }
    
    
    
    public function ReturnModel() {
        
        
        $payment_meta = edd_get_payment_meta($this->post_parent);
        
        $currency = $payment_meta['currency'];
        $payment_id = $this->post_parent;
        $download_id = $this->download_id;
        $amt = $this->subtotal;
        
        
        
        $refundReqest = new RefundTransactionRequestType();
        $refundReqest->Amount = new BasicAmountType($currency, $amt);
        
        //$refund_type = 'Partial';
        $refund_type = edd_get_payment_amount($payment_id) == $amt ? 'Full' : 'Partial';
        
        
        
        
        $refundReqest->RefundType = $refund_type;
        $refundReqest->TransactionID = edd_get_payment_transaction_id($payment_id);
        
        //$refundReqest->MerchantStoreDetails = "Kitmoda";
        $refundReqest->RefundItemDetails = $this->post_title;
        $refundReqest->Memo = "3D Model Refund";
        
        $refundReq = new RefundTransactionReq();
        $refundReq->RefundTransactionRequest = $refundReqest;
        
        
        $api_credentials = eppe_api_credentials();
        
        
        $config = 
        array(
            "acct1.UserName" => $api_credentials['api_username'],
            "acct1.Password" => $api_credentials['api_password'],
            "acct1.Signature" => $api_credentials['api_signature'],
            //"service.EndPoint" => $api_credentials['api_end_point']
            'service.EndPoint' => 'https://api-3t.sandbox.paypal.com/2.0/',
            'log.FileName' => '../PayPal.log',
            'log.LogLevel' => 'INFO',
            'log.LogEnabled' => true
        );
        
        
        $paypalService = new PayPalAPIInterfaceServiceService($config);
        try {
            $refundResponse = $paypalService->RefundTransaction($refundReq);
        } catch (Exception $ex) {}
        
        if (isset($refundResponse)) {
            if ($refundResponse->Ack == 'Success') {
                wp_update_post( array( 'ID' => $this->ID, 'post_status' => 'refunded'));
                
                $this->update_meta('RefundTransactionID', $refundResponse->RefundTransactionID);
                
                edd_undo_purchase( $download_id, $payment_id );		
                $customer = new KSM_User($this->post_author);
                $customer->recordModelReturn();
                $current_model_returns = (INT) get_post_meta($download_id, 'model_returns', true);
                update_post_meta($download_id, 'model_returns', $current_model_returns + 1);
                
                
                edd_insert_payment_note($payment_id, "Purchased Download {$download_id} Returned");
                edd_insert_payment_note($payment_id, "{$amt} Returned to {$this->post_author}");
                
                if($refund_type == 'Full') {
                    wp_update_post( array( 'ID' => $payment_id, 'post_status' => 'refunded' ) );
                }
                
                $success = true;
            } 
            //else {
            //      $error = "Refund Failed, please try again later.";
            //      $refundResponse->Errors[0]->LongMessage;
            //}
        }
        
        
        if($success) {
            $this->emit('model_return');
            return $this->Success("Product Returned.");
        } else {
            return $this->Error("Refund Failed, please try again later.");
        }
        
    }
    
    public function isReturnable() {
        $_time = time() - strtotime($this->post_date);
        if($_time < DAY_IN_SECONDS) {
            return true;
        }
        
        return false;
    }
    
    
    public function isReturned() {
        return (($this->post_status == 'refunded') ? true : false);
    }
    
    public function is_rated() {
        return ($this->rate_id() ? true : false);
    }
    
    
    public function rate_id() {
        return $this->rate_id;
    }
    
    
}


?>
