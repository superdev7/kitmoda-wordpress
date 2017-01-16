<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class FES_Integrations {
	function __construct() {
		add_filter( 'edd_download_supports', array(
			 $this,
			'enable_reviews' 
		) );
	}
	public static function is_commissions_active() {
		if ( !defined( 'EDDC_PLUGIN_DIR' ) ) {
			return false;
		} else {
			return true;
		}
	}

	public function enable_reviews( $supports ) {
		return array_merge( $supports, array(
			 'reviews' 
		) );
	}
}