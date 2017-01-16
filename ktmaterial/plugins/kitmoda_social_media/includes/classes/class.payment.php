<?php

class KSM_Payment extends KSM_Post {
    
    
    public $_post_type = 'edd_payment';
    
    
    
    public function method() {
        
        $gateway = $this->_edd_payment_gateway;

        $method = '';
        
        if($gateway == 'paypalpro') {
            $method = 'creditcard';
        } elseif($gateway == 'paypalexpress') {
            $method = 'paypal';
        } elseif($gateway == 'manual') {
            $method = 'manual';
        }
	return $method;
    }
    
    
    public function method_label() {
        
        $method = $this->method();
        
        $method_label = "";
        
        if($method == 'creditcard') {
            $method_label = 'Credit Card';
        } elseif($method == 'paypal') {
            $method_label = 'Paypal';
        } elseif($method == 'manual') {
            $method_label = 'Manual';
        }
	return $method_label;
    }
    
    
    public function payment_date() {
        $date_time = $this->_edd_completed_date;
        return date('M, d, Y', strtotime($date_time));
    }
    
    public function payment_time() {
        $date_time = $this->_edd_completed_date;
        return date('H:i A', strtotime($date_time));
    }
    
    
    public function amount($format = true) {
        $amount = $this->_edd_payment_total;
        
        if($format) {
            $amount = edd_currency_filter( edd_format_amount($amount));
        }
        
        return $amount;
    }
    
    
    
}