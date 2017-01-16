<?php



class Ksm_Hash  {
    
    
    static function encrypt($string) {
        
        $key = NONCE_KEY;
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
    }
    
    static function decrypt($encoded) {
        $key = NONCE_KEY;
        return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encoded), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
    }
    
    
}




?>