<?php

/**
 * Description of class
 *
 * @author tahir
 */



class KSM_DataStore {
    
    
    public  $path = '',
            $type = 'array',
            $extension = ''
            ;
    
    
    
    function __construct() {
        
        
        if($this->type == 'array') {
            $this->extension = '.php';
        } else {
            $this->extension = '.txt';
        }
        
        
    }
    
    
    
    
    static function __callStatic($name, $arguments) {
        
        switch($name) {
            
            case "Options" :
                $ds = new KSM_Options_DataStore();
                
                return call_user_func_array(array($ds, 'getAll'), $arguments);
                break;
            case "Option" :
                $ds = new KSM_Options_DataStore();
                
                return call_user_func_array(array($ds, 'getOne'), $arguments);
                break;

            case "Option_Exist" :
                $ds = new KSM_Options_DataStore();
                return call_user_func_array(array($ds, 'exists'), $arguments);
                break;
            
            
            case "Terms" :
                
                $ds = new KSM_Terms_Datastore();
                return call_user_func_array(array($ds, 'getAll'), $arguments);
                break;
            case "Term" :
                
                $ds = new KSM_Terms_Datastore();
                return call_user_func_array(array($ds, 'getOne'), $arguments);
                break;
            
            case "Term_Exist" :
                $ds = new KSM_Terms_Datastore();
                return call_user_func_array(array($ds, 'exists'), $arguments);
                break;
            
            
            
            case "Views" :
                $ds = new KSM_Views_Datastore();
                return call_user_func_array(array($ds, 'getAll'), $arguments);
                break;
            
            case "View" :
                $ds = new KSM_Views_Datastore();
                return call_user_func_array(array($ds, 'getOne'), $arguments);
                break;
            
            case "View_Exist" :
                $ds = new KSM_Views_Datastore();
                
                return call_user_func_array(array($ds, 'exists'), $arguments);
                break;
            
            
            
            case "Save_Views" :
                $ds = new KSM_Views_Datastore();
                return call_user_func_array(array($ds, 'Save'), $arguments);
                break;
        }
        
        

        
        
    }
    
    
    
    public function Read($name, $single = false) {
        
        $file = $this->path.$name.$this->extension;
        
        
        
        
        
        if(is_file($file)) {
            
            if($this->type == 'plain') {
                return file_get_contents($file);
            } 
            
            
            @include($file);
            
            if(isset($data)) {
                if($single) {
                    $single_data = array();
                    foreach ((Array) $data as $k => $v) {
                        $single_data[$k] = $v[$single];
                    }
                    return $single_data;
                }
                return $data;
            }
            
        }
        
        if($this->type == 'array') {
            return array();
        }
        
        return '';
    }
    
    
    
    
    
    
    
    
    
    public function getAll($name, $single = false, $section = '') {
        return $this->Read($name, $single);
    }
    
    public function getOne($name, $key) {
        $data = $this->getAll($name);
        return $data[$key];
    }
    
    
    public function exists($name, $key) {
        $data = $this->getAll($name);
        
        if(isset($data[$key])) {
            return true;
        }
        return false;
    }
    
    
    public function Save($name, $data, $mode = 'append') {
        
        
        
        
        
        
        $path = $this->path.$name.$this->extension;
        
        
        if($this->type == 'array') {
            
            if($mode == 'append') {
                $_data = $this->getAll($name);
                $data = array_merge($_data, $data);
            }
            
            $contents = "<"."?php\n\n";
            $contents .= "\$data = ".var_export($data, true).";\n";
            file_put_contents($path, $contents);
            return true;
        }
        
        
        
        $handle = fopen($path, 'a');
        
        fwrite($handle, $data);
        
        fclose($handle);
        
    }
    


    /*
    public function Delete($name) {
        return @unlink(self::$path.'/'.$name.'.php');
    }

    
    
    
    public function Clear() {
        $files = scandir(self::$path);
        foreach($files as $file) {
            if(!preg_match("#\.php\$#i", $file)) {
                continue;
            }
            $cacheName = preg_replace("#\.php\$#i", "", $file);
            if(!$this->Delete($cacheName)) {
                return false;
            }
        }
        return true;
    }
    
    */
    
}






class KSM_Options_DataStore extends KSM_DataStore {
    
    public  $path = OPTIONS_DATASTORE_PATH;
    
    public function getAll($name, $single = false, $section = '') {
        $name = ucfirst($name);
        return parent::getAll($name, $single);
    }
}


class KSM_Terms_Datastore extends KSM_DataStore {
    
    public  $path = TERMS_DATASTORE_PATH;
    
    
    public function getAll($name, $single = false, $section = '') {
        $name = implode('_', array_map('ucfirst', explode('_', $name)));
        $data = parent::getAll($name, false);
        
        
        
        if($section) {
            $section_data = array();
            
            foreach ($data as $k => $v) {
                
                if($v['section'] == $section) {
                    $section_data[$k] = $v;
                }
            }
            
            $data = $section_data;
        }
        
        
        if($single) {
            $single_data = array();
            foreach ($data as $k => $v) {
                $single_data[$k] = $v[$single] ? $v[$single] : $v['label'];
            }
            return $single_data;
        }
        return $data;
    }
}


class KSM_Views_Datastore extends KSM_DataStore {
    
    public  $path = KSM_VIEWS_CACHE_PATH,
            $type = 'plain';
    
    
    function getAll($name, $single = false, $section = '') {
        $data = parent::getAll($name, false);
        
        //pr($data);
        return explode(',', $data);
    }
    
    public function exists($name, $val) {
        
        
        
        
        $data = $this->getAll($name);
        
        
        //pr($data);
        
        if(in_array($val, $data)) {
            return true;
        }
        
        
        return false;
    }
}