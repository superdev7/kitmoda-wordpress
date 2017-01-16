<?php if ( EDD_FES()->vendors->is_pending( get_current_user_id() ) ) { ?>
	<p><?php _e( 'Your application has been submitted and will be reviewed.', 'edd_fes' ); ?></p>
<?php } else { 
	$base_url = get_permalink(EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page', false ));
	wp_redirect( $base_url ); exit;		
}