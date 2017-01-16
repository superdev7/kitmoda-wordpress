<?php






class KSM_Downloader extends KSM_Object {
    
    
    
    public $resumable = true , 
           $mime_type,
           $file,
           $dl_filename,
           $file_size,
           $offset
           ;
    
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
    }
    
    public function isResumable() {
        if($this->resumable && isset($_SERVER['HTTP_RANGE']) )
            return true;
        
        return false;
    }
    
    public function is_file() {
        
        
        if( is_file( $this->file ) ) 
            return true;
        
        return false;
    }
    
    public function is_readable() {
        if( is_readable( $this->file ) )
            return true;
        
        return false;
    }
    
    public function getFileSize() {
        return filesize( $this->file );
    }
    
    
    public function downloadable_filename() {
        return $this->dl_filename ? $this->dl_filename : basename($this->file);
    }
    
    
    
    public function resuming_support() {
        
        if( $this->isResumable() ) {
            list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
            list($range) = explode(",",$range,2);
            list($range, $range_end) = explode("-", $range);

            $range = intval($range);

            if(!$range_end) 
                    $range_end = $size-1;
            else
                    $range_end = intval( $range_end );

            $new_length = $range_end - $range+1;
            header('HTTP/1.1 206 Partial Content');
            header('Content-Length: '.$new_length );
            header('Content-Range: bytes '.$range.'-'.$range_end.'/'.$size);

            //set the offset range
            $this->offset = $range;
	}
        
    }
    
    
    
    private function prepare_headers( $size = 0 ) {
        
        if(ini_get('zlib.output_compression')) 
            ini_set('zlib.output_compression', 'Off');
        
        header('Content-Type: ' . $this->mime_type);
	header('Content-Disposition: attachment; filename="'.$this->downloadable_filename().'"');
	header("Content-Transfer-Encoding: binary");
	header('Accept-Ranges: bytes');
	
	
	header("Cache-control: private");
	header('Pragma: private');
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	
        $size = $this->file_size;
	
	if( $this->isResumable()) {
            list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
            list($range) = explode(",",$range,2);
            list($range, $range_end) = explode("-", $range);

            $range = intval($range);

            if(!$range_end) 
                $range_end = $size-1;
            else
                $range_end = intval( $range_end );

            $new_length = $range_end - $range+1;
            header('HTTP/1.1 206 Partial Content');
            header('Content-Length: '.$new_length );
            header('Content-Range: bytes '.$range.'-'.$range_end.'/'.$size);

            //set the offset range
            $this->offset = $range;
	} 
	else 
	{
		$new_length = $size;
		header("Content-Length: ".$size);
	}
	
	return $new_length;			
    }
    
    
    
    
    
    
    
    
    function init_download() {
        
        if( ! $this->is_file()) {
            throw new Exception( 'Downloader: Could not find file \''.$filename.'\'' );
        }
        
        if( !$this->is_readable() )	{
            throw new Exception( 'Downloader: File was unreadable \''.$filename.'\'' );
        }
        
        set_time_limit(0);
        
        $this->file_size =  $this->getFileSize();
        
        $block_size = $this->prepare_headers();
		
		
        $chunksize = 1*(1024*1024);
	$bytes_send = 0;
		
        
        
        
        
	if ($file = fopen($this->file, 'r')) {
            if( $this->resuming_support() ) fseek( $file, $this->offset );

            while( !feof( $file ) && !connection_aborted() && $bytes_send < $block_size ) {
                $buffer = fread( $file, $chunksize );
                echo $buffer;
                flush();
                $bytes_send += strlen( $buffer );
            }
            
            fclose($file);
	} 
	else {
            throw new Exception( 'Downloader: Could not open file \''.$filename.'\'' );
	}
        die();
    }
    
    
    
    
}











class KSM_Message_Images_Archive_Downloader extends KSM_Downloader {
    
    public $message;
    
    public function __construct($args = array()) {
        parent::__construct($args);
    }
    
    
    
    
    
    
    public function prepare() {
        
        
        if($this->message) {
            
            
            $attachments = post_attacments($this->message->ID);
            
            if($attachments) {
                
                $files = array();
                foreach ($attachments as $att) {
                    $src = get_attached_file($att->ID);
                    if($src && is_file($src)) {
                        $files[] = $src;
                    }
                }
                
                
                
                
                
                if($files) {
                    
                    $_name = wp_generate_password( 6, false );
                    
                    $zip_name = KSM_CACHE_PATH . "message_images_{$_name}.zip";
                    $zip = new ZipArchive();
                    $zip->open($zip_name, ZipArchive::CREATE);
                    
                    foreach($files as $f) {
                        $zip->addFile($f , basename($f));
                    }
                    $zip->close();
                    $this->file = $zip_name;
                    $this->dl_filename = 'message_images';
                    $this->mime_type = 'application/zip';
                    return true;
                }
            }
        }

    }

}




class KSM_Post_Images_Archive_Downloader extends KSM_Downloader {
    
    public $post;
    
    public function __construct($args = array()) {
        parent::__construct($args);
    }
    
    
    
    
    
    
    public function prepare() {
        
        
        if($this->post) {
            
            
            $attachments = post_attacments($this->post->ID);
            
            if($attachments) {
                
                $files = array();
                foreach ($attachments as $att) {
                    $src = get_attached_file($att->ID);
                    if($src && is_file($src)) {
                        $files[] = $src;
                    }
                }
                
                
                
                
                
                if($files) {
                    
                    $_name = wp_generate_password( 6, false );
                    
                    $zip_name = KSM_CACHE_PATH . "post_images_{$_name}.zip";
                    $zip = new ZipArchive();
                    $zip->open($zip_name, ZipArchive::CREATE);
                    
                    foreach($files as $f) {
                        $zip->addFile($f , basename($f));
                    }
                    $zip->close();
                    $this->file = $zip_name;
                    $this->dl_filename = $this->dl_filename ? $this->dl_filename : 'images';
                    $this->mime_type = 'application/zip';
                    return true;
                }
            }
        }

    }

}


class KSM_S3_Downloader extends KSM_Downloader {
    
    
    public $s3_key, 
           $error,
            $post
            ;
    
    public function __construct($args = array()) {
        parent::__construct($args);
    }
    
    public function prepare() {
        
        
        $attachment_id = $this->post->attachment_id;
        
        $this->s3_key = get_post_meta($attachment_id, 's3_file_key', true);
        
        
        if(!$this->s3_key) {
            $this->error = "File not found.";
            
        } 
        //elseif($this->limit_exceeded()) {
        //    $this->error = "Download limit exceeded.";
        //} 
        else {
            $url = KSM_S3::signKey($this->s3_key);
            if($url) {
                $this->file = $url;
                return true;
            }
        }

    }
    
    public function limit_exceeded() {
        
        $limit_exceeded = true;
        
        if($this->post->downloaded_count < $this->post->download_limit) {
            $limit_exceeded = false;
        }
        
        return $limit_exceeded;
    }
    
    
    function set_headers() {
        
        $file_extension = edd_get_file_extension( $this->file );
	$ctype          = edd_get_file_ctype( $file_extension );
        
        if ( ! edd_is_func_disabled( 'set_time_limit' ) && ! ini_get( 'safe_mode' ) ) 
            @set_time_limit(0);
	
	if ( function_exists( 'get_magic_quotes_runtime' ) && get_magic_quotes_runtime() ) 
            set_magic_quotes_runtime(0);
	
	@session_write_close();
	if( function_exists( 'apache_setenv' ) ) @apache_setenv('no-gzip', 1);
	@ini_set( 'zlib.output_compression', 'Off' );
        
	nocache_headers();
	header("Robots: none");
	header("Content-Type: " . $ctype . "");
	header("Content-Description: File Transfer");
	header("Content-Disposition: attachment; filename=\"" . basename($this->file) . "\"");
	header("Content-Transfer-Encoding: binary");
    }
    
    function method() {
        return 'redirect';
    }
    
    
    
    
    function init_download() {
        
        
	//$method  = $this->method();

        $this->set_headers();
        header( "Location: " . $this->file );
	edd_die();
	exit;
    }
}



class KSM_Purchase_Downloader extends KSM_S3_Downloader {
    
    
    
    

    
    
    
    
}



class KSM_Collaboration_Untextured_Downloader extends KSM_S3_Downloader {
    
    
    public function prepare() {
        
        
        
        $edd_files = $this->post->edd_download_files;
        
        
        $attachment_id = @$edd_files[0]['attachment_id'];
        
         
        
        
        
        
        
        $this->s3_key = get_post_meta($attachment_id, 's3_file_key', true);
        
        
        if(!$this->s3_key) {
            $this->error = "File not found.";
        } else {
            $url = KSM_S3::signKey($this->s3_key);
            
            if($url) {
                $this->file = $url;
                return true;
            } else {
                $this->error = "File not found.";
            }
        }

    }
    

    public function limit_exceeded() {
        
        $limit_exceeded = false;
        return $limit_exceeded;
    }
    
    
    
}



















/*
 
 
 

if ( ! defined( 'ABSPATH' ) ) exit;



add_action( 'init', 'edd_process_download', 100 );


function edd_deliver_download( $file = '' ) {

	global $edd_options;

	$symlink = apply_filters( 'edd_symlink_file_downloads', isset( $edd_options['symlink_file_downloads'] ) );

	
	// * If symlinks are enabled, a link to the file will be created
	// * This symlink is used to hide the true location of the file, even when the file URL is revealed
	// * The symlink is deleted after it is used
	 

	if( $symlink && function_exists( 'symlink' ) ) {

		// Generate a symbolic link
		$ext       = edd_get_file_extension( $file );
		$parts     = explode( '.', $file );
		$name      = basename( $parts[0] );
		$md5       = md5( $file );
		$file_name = $name . '_' . substr( $md5, 0, -15 ) . '.' . $ext;
		$path      = edd_get_symlink_dir() . '/' . $file_name;
		$url       = edd_get_symlink_url() . '/' . $file_name;

		// Set a transient to ensure this symlink is not deleted before it can be used
		set_transient( md5( $file_name ), '1', 30 );

		// Schedule deletion of the symlink
		if ( ! wp_next_scheduled( 'edd_cleanup_file_symlinks' ) )
			wp_schedule_single_event( current_time( 'timestamp' )+60, 'edd_cleanup_file_symlinks' );

		// Make sure the symlink doesn't already exist before we create it
		if( ! file_exists( $path ) )
			$link = symlink( $file, $path );
		else
			$link = true;

		if( $link ) {
			// Send the browser to the file
			header( 'Location: ' . $url );
		} else {
			edd_readfile_chunked( $file );
		}

	} else {

		// Read the file and deliver it in chunks
		edd_readfile_chunked( $file );

	}

}



edd_get_file_ctype( $extension )

function edd_readfile_chunked( $file, $retbytes = true ) {

	$chunksize = 1024 * 1024;
	$buffer    = '';
	$cnt       = 0;
	$handle    = @fopen( $file, 'r' );

	if ( $size = @filesize( $file ) ) {
		header("Content-Length: " . $size );
	}

	if ( false === $handle ) {
		return false;
	}

	while ( ! @feof( $handle ) ) {
		$buffer = @fread( $handle, $chunksize );
		echo $buffer;

		if ( $retbytes ) {
	   		$cnt += strlen( $buffer );
   		}
	}

	$status = @fclose( $handle );

	if ( $retbytes && $status ) {
		return $cnt;
	}

	return $status;
}

 
 
 * 
 */