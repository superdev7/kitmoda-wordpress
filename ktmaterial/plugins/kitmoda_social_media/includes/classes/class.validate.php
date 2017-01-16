<?php


class KSM_Validate
{
    public $fields = array();
    protected $_errors = array();
    protected $_validations = array();
    protected $_labels = array();

    
    
    protected static $_rules = array();
    protected static $_ruleMessages = array();
    
    

    const ERROR_DEFAULT = 'Invalid';

    protected $validUrlPrefixes = array('http://', 'https://');

    public $data = array();
    
    
    
    public function __construct($data, $fields)
    {
        

        foreach($fields as $k => $v) {
            
            $fields[$k]['field_name'] = $k;
            
            
            $value = $this->sanitize($data[$k], $v['sanitize']);
            
            if($v['prepare']) {
                $prepare_cb = 'prepare_'.$v['prepare'];
                $value = call_user_func(array($this, $prepare_cb), $fields[$k] , $value);
            }
            
            
            $fields[$k]['value'] = $value;
            
            $this->data[$k] = $value;
        }
        
        $this->fields = $fields;
        
        
        
        $langFile = KSM_BASE_PATH . 'lang'  . DIRECTORY_SEPARATOR . 'en.php';
        $langMessages = include $langFile;
        static::$_ruleMessages = array_merge(static::$_ruleMessages, $langMessages);
        
    }
    
    
    public function prepare_ds_term_names_array($field, $terms) {
        
        
        $tax = $field['tax'] ? $field['tax'] : $field['field_name'];
        
        
        $_terms = array();
        
        if(is_array($terms)) {
            foreach((Array) $terms as $t) {
                if($t && KSM_DataStore::Term_Exist($tax, $t)) {
                    $_terms[] = $t;
                }
            }
        }
        
        return $_terms;
    }


    public function data() {
        return $this->data;
    }
    
    
    public function sanitize($value, $cbs = array()) {
        
        foreach((Array) $cbs as $cb) {
            if(function_exists($cb)) {
                $value = call_user_func($cb, $value);
            }
            
        }
        return $value;
    }

    
    
    
    
    
    public function __call($name, $arguments) {
        
        $nparts = explode('_', $name);
        $arguments = $arguments[0];
        
        
        
        
        if($nparts[0] == 'validate') {
            if(preg_match("/(max|min)_(\d+)_items/", $name, $output_array)) {
                if($arguments['type'] == 'list') {
                    $callback = 'validate_'.$output_array[1].'_array_items';
                    $arguments["{$output_array[1]}"] = $output_array[2];
                    if(method_exists($this, $callback)) {
                        return call_user_func(array($this, $callback), $arguments);
                    }
                }
            } elseif(preg_match("/(max|min)_(\d+)/", $name, $output_array)) {
                if($arguments['type'] == 'number') {
                    $callback = 'validate_'.$output_array[1];
                    $arguments["{$output_array[1]}"] = $output_array[2];
                    if(method_exists($this, $callback)) {
                        return call_user_func(array($this, $callback), $arguments);
                    }
                }
            }
        }
        
    }
    
    
    public function validate_min($field) {
        
        
        $value = $field['value'];
        
        
         
        
        
        if(is_numeric($value) && $value >= $field['min']) {
            return true;
        }
        
        return false;
    }
    
    public function validate_max($field) {
        $value = $field['value'];
        if(is_numeric($value) && $value <= $field['max']) {
            return true;
        }
        
        return false;
    }

    
    public function validate_in_array($field) {
        
        $value = $field['value'];
        $ar = (Array) $field['rules_data']['in_array'];
        
        if(in_array($value, $ar)) {
            return true;
        } 
        
        return false;
        
    }
    
    
    public function validate_not_empty($field) {
        
        $value = (Array) $field['value'];
        
        if(!empty($value)) {
            return true;
        } 
        
        return false;
        
    }
    
    public function validate_max_array_items($field = array()) {
        
        $value = $field['value'];
        
        if($field['type'] == 'list') {
            $value = explode(',', $field['value']);
        } 
        if(count($value) <= $field['max']) {
            return true;
        }
        
        return false;
    }
    
    
    public function validate_min_array_items($field = array()) {
        $value = $field['value'];
        
        if($field['type'] == 'list') {
            $value = explode(',', $field['value']);
        } 
        
        
        if(count($value) >= $field['min']) {
            return true;
        }
        
        return false;
    }
    
    
    
    public function validate_form() {
        
        
        
        foreach($this->fields as $fname => $fargs) {
            
            $fargs = (Array) $fargs;
            
            foreach((Array) $fargs['rules'] as $k => $v) {
                //$v_rules[$v][] = $fname;
                
                
                $r_name = is_numeric($k) ? $v : $k;
                $message = is_numeric($k) ? $this->rule_message($r_name) : $v;
                $callback = 'validate_' . $r_name;
                
                
                if($r_name == 'required') {
                    switch($fargs['type']) {
                        case "term_id":
                            $callback = 'validate_term_id_' . $r_name;
                            break;
                        case "term_name":
                            $callback = 'validate_term_name_' . $r_name;
                            break;
                        case "no_child_term_id":
                            $callback = 'validate_no_child_term_id_' . $r_name;
                            break;
                    }
                }
                
                
                
                $res = call_user_func(array($this, $callback), $fargs);
                
                if(!$res) {
                    $this->error($fname, $message, array($fname,$r_name));
                }
                
            }
        }
        
        
        
    }
    
    
    public function validate_s3_attachable($field) {
        
        $value = $field['value'];
        
        
        if($value && KSM_S3::can_user_attach($value)) {
            return true;
        }
        
        return false;
    }
    
    
    public function validate_no_child_term_id_required($field) {
        
        
        if($this->validate_required($field)) {
            $tax_name = $field['tax'] ? $field['tax'] : $field['field_name'];
            if($tax_name) {
                $_tax = new KSM_Taxonomy($tax_name);
                if($_tax->term_exists($field['value'], 'id') && !$_tax->get_children($field['value'])) {
                    return true;
                }
            }
        }
        return false;
    }
    
    
    public function validate_term_id_required($field) {
        
        
        if($this->validate_required($field)) {
            
            $tax_name = $field['tax'] ? $field['tax'] : $field['field_name'];
            if($tax_name) {
                $_tax = new KSM_Taxonomy($tax_name);
                if($_tax->term_exists($field['value'], 'id')) {
                    return true;
                }
            }
        }
        return false;
    }
    
    
    public function validate_term_name_required($field) {
        
        
        if($this->validate_required($field)) {
            
            $tax_name = $field['tax'] ? $field['tax'] : $field['field_name'];
            if($tax_name) {
                $_tax = new KSM_Taxonomy($tax_name);
                if($_tax->term_exists($field['value'])) {
                    return true;
                }
            }
        }
        return false;
    }
    
    
    
    public function rule_message($rule)
    {
        $message = (isset(static::$_ruleMessages[$rule]) ? static::$_ruleMessages[$rule] : self::ERROR_DEFAULT);
        
        return "{field} $message";
    }
    
    
    
    public function validate_required($field)
    {
        $value = $field['value'];
        if(is_null($value)) {
            return false;
        } elseif(is_string($value) && trim($value) === '') {
            return false;
        }
        return true;
    }

    
    protected function validateEquals($field, $value, array $params)
    {
        $field2 = $params[0];
        return isset($this->_fields[$field2]) && $value == $this->_fields[$field2];
    }

    
    protected function validateDifferent($field, $value, array $params)
    {
        $field2 = $params[0];
        return isset($this->_fields[$field2]) && $value != $this->_fields[$field2];
    }

    
    protected function validateAccepted($field, $value)
    {
        $acceptable = array('yes', 'on', 1, true);
        return in_array($value, $acceptable, true);
    }

    
    protected function validate_numeric($field)
    {
        $value = $field['value'];
        return is_numeric($value);
    }

    
    protected function validate_integer($field)
    {
        $value = $field['value'];
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }
    
    
    
    protected function validate_float($field)
    {
        $value = $field['value'];
        return filter_var($value, FILTER_VALIDATE_FLOAT) !== false;
    }
    
    
    
    protected function validate_price($field) {
        $value = $field['value'];
        
        if(($this->validate_integer($field) || $this->validate_float($field)) && $value > 0) {
            return true;
        } 
        
        return false;
        
    }
    
    
    protected function validateLength($field, $value, $params)
    {
        $length = strlen($value);
        if(isset($params[1])) {
            return $length >= $params[0] && $length <= $params[1];
        }
        return $length == $params[0];
    }

    
    protected function validateLengthBetween($field, $value, $params) {
        $length = strlen($value);
        return $length >= $params[0] && $length <= $params[1];
    }

    
    protected function validateLengthMin($field, $value, $params) {
        return strlen($value) >= $params[0];
    }

    
    protected function validateLengthMax($field, $value, $params) {
        return strlen($value) <= $params[0];
    }

    
    

    
    protected function validateMin($field, $value, $params)
    {
        return !(bccomp($params[0], $value, 14) == 1);
    }

    
    protected function validateMax($field, $value, $params)
    {
        return !(bccomp($value, $params[0], 14) == 1);
    }

    
    protected function validateIn($field, $value, $params)
    {
        $isAssoc = array_values($params[0]) !== $params[0];
        if($isAssoc) {
            $params[0] = array_keys($params[0]);
        }
        return in_array($value, $params[0]);
    }

    
    protected function validateNotIn($field, $value, $params)
    {
        return !$this->validateIn($field, $value, $params);
    }

    
    protected function validateContains($field, $value, $params)
    {
        if(!isset($params[0])) {
            return false;
        }
        if (!is_string($params[0]) || !is_string($value)) {
            return false;
        }
        return (strpos($value, $params[0]) !== false);
    }

    
    protected function validateIp($field, $value)
    {
        return filter_var($value, FILTER_VALIDATE_IP) !== false;
    }

    
    protected function validateEmail($field, $value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    
    protected function validateUrl($field, $value)
    {
        foreach ($this->validUrlPrefixes as $prefix) {
            if(strpos($value, $prefix) !== false) {
                return filter_var($value, FILTER_VALIDATE_URL) !== false;
            }
        }
        return false;
    }

    
    protected function validateUrlActive($field, $value)
    {
        foreach ($this->validUrlPrefixes as $prefix) {
            if(strpos($value, $prefix) !== false) {
                $url = str_replace($prefix, '', strtolower($value));

                return checkdnsrr($url);
            }
        }
        return false;
    }

    
    protected function validateAlpha($field, $value)
    {
        return preg_match('/^([a-z])+$/i', $value);
    }

    
    protected function validateAlphaNum($field, $value)
    {
        return preg_match('/^([a-z0-9])+$/i', $value);
    }

    
    protected function validateSlug($field, $value)
    {
        return preg_match('/^([-a-z0-9_-])+$/i', $value);
    }

    
    protected function validateRegex($field, $value, $params)
    {
        return preg_match($params[0], $value);
    }

    
    protected function validateDate($field, $value)
    {
        return strtotime($value) !== false;
    }

    
    protected function validateDateFormat($field, $value, $params)
    {
        $parsed = date_parse_from_format($params[0], $value);

        return $parsed['error_count'] === 0;
    }

    
    protected function validateDateBefore($field, $value, $params)
    {
        $vtime = ($value instanceof \DateTime) ? $value->getTimestamp() : strtotime($value);
        $ptime = ($params[0] instanceof \DateTime) ? $params[0]->getTimestamp() : strtotime($params[0]);
        return $vtime < $ptime;
    }

    
    protected function validateDateAfter($field, $value, $params)
    {
        $vtime = ($value instanceof \DateTime) ? $value->getTimestamp() : strtotime($value);
        $ptime = ($params[0] instanceof \DateTime) ? $params[0]->getTimestamp() : strtotime($params[0]);
        return $vtime > $ptime;
    }

    
    protected function validateBoolean($field, $value)
    {
        return (is_bool($value)) ? true : false;
    }

    
    protected function validateCreditCard($field, $value, $params)
    {
        /**
         * I there has been an array of valid cards supplied, or the name of the users card
         * or the name and an array of valid cards
         */
        if (!empty($params)) {
            /**
             * array of valid cards
             */
            if (is_array($params[0])) {
                $cards = $params[0];
            } else if (is_string($params[0])){
                $cardType  = $params[0];
                if (isset($params[1]) && is_array($params[1])) {
                    $cards = $params[1];
                    if (!in_array($cardType, $cards)) {
                        return false;
                    }
                }
            }
        }
        /**
         * Luhn algorithm
         *
         * @return bool
         */
        $numberIsValid = function () use ($value) {
            $number = preg_replace('/[^0-9]+/', '', $value);
            $sum = 0;

            $strlen = strlen($number);
            if ($strlen < 13) {
                return false;
            }
            for ($i = 0; $i < $strlen; $i++) {
                $digit = (int) substr($number, $strlen - $i - 1, 1);
                if ($i % 2 == 1) {
                    $sub_total = $digit * 2;
                    if ($sub_total > 9) {
                        $sub_total = ($sub_total - 10) + 1;
                    }
                } else {
                    $sub_total = $digit;
                }
                $sum += $sub_total;
            }
            if ($sum > 0 && $sum % 10 == 0) {
                    return true;
            }
                return false;
        };

        if ($numberIsValid()) {
            if (!isset($cards)) {
                return true;
            } else {
                $cardRegex = array(
                    'visa'          => '#^4[0-9]{12}(?:[0-9]{3})?$#',
                    'mastercard'    => '#^5[1-5][0-9]{14}$#',
                    'amex'          => '#^3[47][0-9]{13}$#',
                    'dinersclub'    => '#^3(?:0[0-5]|[68][0-9])[0-9]{11}$#',
                    'discover'      => '#^6(?:011|5[0-9]{2})[0-9]{12}$#',
                );

                if (isset($cardType)) {
                    // if we don't have any valid cards specified and the card we've been given isn't in our regex array
                    if (!isset($cards) && !in_array($cardType, array_keys($cardRegex))) {
                        return false;
                    }

                    // we only need to test against one card type
                    return (preg_match($cardRegex[$cardType], $value) === 1);

                } else if (isset($cards)) {
                    // if we have cards, check our users card against only the ones we have
                    foreach($cards as $card) {
                        if (in_array($card, array_keys($cardRegex))) {
                            // if the card is valid, we want to stop looping
                            if (preg_match($cardRegex[$card], $value) === 1) {
                                return true;
                            }
                        }
                    }
                } else {
                    // loop through every card
                    foreach($cardRegex as $regex) {
                        // until we find a valid one
                        if (preg_match($regex, $value) === 1) {
                            return true;
                        }
                    }
                }
            }
        }

        // if we've got this far, the card has passed no validation so it's invalid!
        return false;
    }


    
    /*
    public function data()
    {
        return $this->_fields;
    }
    */

    
    public function errors($field = null)
    {
        if($field !== null) {
            return isset($this->_errors[$field]) ? $this->_errors[$field] : false;
        }
        return $this->_errors;
    }

    
    public function error($field, $msg, array $params = array())
    {
        $msg = $this->checkAndSetLabel($field, $msg, $params);

        $values = array();
        // Printed values need to be in string format
        foreach($params as $param) {
            if(is_array($param)) {
                $param = "['" . implode("', '", $param) . "']";
            }
            if($param instanceof \DateTime) {
                $param = $param->format('Y-m-d');
            }
            // Use custom label instead of field name if set
            if(isset($this->_labels[$param])) {
                $param = $this->_labels[$param];
            }
            $values[] = $param;
        }

        $this->_errors[$field][] = vsprintf($msg, $values);
    }

    
    public function message($msg)
    {
        $this->_validations[count($this->_validations)-1]['message'] = $msg;
        return $this;
    }
    
    
    public function reset()
    {
        $this->_fields = array();
        $this->_errors = array();
        $this->_validations = array();
        $this->_labels = array();
    }

    public function validate()
    {
        foreach($this->_validations as $v) {
            foreach($v['fields'] as $field) {
                $value = isset($this->_fields[$field]) ? $this->_fields[$field] : null;

                // Don't validate if the field is not required and the value is empty
                if ($v['rule'] !== 'required' && !$this->hasRule('required', $field) && $value == '') {
                    continue;
                }

                // Callback is user-specified or assumed method on class
                if(isset(static::$_rules[$v['rule']])) {
                    $callback = static::$_rules[$v['rule']];
                } else {
                    $callback = array($this, 'validate' . ucfirst($v['rule']));
                }

                $result = call_user_func($callback, $field, $value, $v['params']);
                if(!$result) {
                    $this->error($field, $v['message'], $v['params']);
                }
            }
        }

        return count($this->errors()) === 0;
    }

    
    protected function hasRule($name, $field)
    {
        foreach($this->_validations as $validation) {
            if ($validation['rule'] == $name) {
                if (in_array($field, $validation['fields'])) {
                    return true;
                }
            }
        }
        return false;
    }

    
    public static function addRule($name, $callback, $message = self::ERROR_DEFAULT)
    {
        if(!is_callable($callback)) {
            throw new \InvalidArgumentException("Second argument must be a valid callback. Given argument was not callable.");
        }

        static::$_rules[$name] = $callback;
        static::$_ruleMessages[$name] = $message;
    }

    
    public function rule($rule, $fields)
    {
        if(!isset(static::$_rules[$rule])) {
            $ruleMethod = 'validate' . ucfirst($rule);
            if(!method_exists($this, $ruleMethod)) {
                throw new \InvalidArgumentException("Rule '" . $rule . "' has not been registered with " . __CLASS__ . "::addRule().");
            }
        }

        // Ensure rule has an accompanying message
        $message = isset(static::$_ruleMessages[$rule]) ? static::$_ruleMessages[$rule] : self::ERROR_DEFAULT;

        // Get any other arguments passed to function
        $params = array_slice(func_get_args(), 2);

        $this->_validations[] = array(
            'rule' => $rule,
            'fields' => (array) $fields,
            'params' => (array) $params,
            'message' => '{field} ' . $message
        );
        return $this;
    }

    
    public function label($value)
    {
        $lastRules = $this->_validations[count($this->_validations)-1]['fields'];
        $this->labels(array($lastRules[0] => $value));

        return $this;
    }

    
    public function labels($labels = array())
    {
        $this->_labels = array_merge($this->_labels, $labels);
        return $this;
    }

    
    private function checkAndSetLabel($field, $msg, $params)
    {
        if (isset($this->_labels[$field])) {
            $msg = str_replace('{field}', $this->_labels[$field], $msg);

            if (is_array($params)) {
                $i = 1;
                foreach ($params as $k => $v) {
                    $tag = '{field'. $i .'}';
                    $label = isset($params[$k]) && !is_array($params[$k]) && isset($this->_labels[$params[$k]]) ? $this->_labels[$params[$k]] : $tag;
                    $msg = str_replace($tag, $label, $msg);
                    $i++;
                }
            }
        } else {
            $msg = str_replace('{field}', ucwords(str_replace('_', ' ', $field)), $msg);
        }

        return $msg;
    }

    
    public function rules($rules)
    {
        foreach ($rules as $ruleType => $params) {
            if (is_array($params)) {
                foreach ($params as $innerParams) {
                    array_unshift($innerParams, $ruleType);
                    call_user_func_array(array($this, "rule"), $innerParams);
                }
            } else {
                $this->rule($ruleType, $params);
            }
        }
    }
}
