<?php
function fes_register_upgrades_page() {
	add_submenu_page( null, __( 'FES Upgrades', 'edd_fes' ), __( 'FES Upgrades', 'edd_fes' ), 'install_plugins', 'fes-upgrades', 'fes_upgrades_screen' );
}
add_action( 'admin_menu', 'fes_register_upgrades_page', 10 );

function fes_upgrades_screen() {
	$step   = isset( $_GET['step'] ) ? absint( $_GET['step'] ) : 1;
	$counts = count_users();
	$total  = isset( $counts['total_users'] ) ? $counts['total_users'] : 1;
	$total_steps = round( ( $total / 100 ), 0 );
	?>
	<div class="wrap">
		<h2><?php _e( 'Frontend Submissions - Upgrades', 'edd_fes' ); ?></h2>
		<div id="edd-upgrade-status">
			<p><?php _e( 'The upgrade process is running, please be patient. This could take several minutes to complete.', 'edd_fes' ); ?></p>
			<p><strong><?php printf( __( 'Step %d of approximately %d running', 'edd_fes' ), $step, $total_steps ); ?>
		</div>
		<script type="text/javascript">
			document.location.href = "index.php?edd_action=<?php echo htmlentities($_GET['edd_upgrade'],ENT_QUOTES); ?>&step=<?php echo absint( $_GET['step'] ); ?>";
		</script>
	</div>
<?php	
}

/**
 * Triggers all upgrade functions
 *
 * @since 2.2
 * @return void
*/
function fes_show_upgrade_notice() {
	$fes_version = get_option( 'fes_db_version', '2.1' );

	if ( version_compare( $fes_version, '2.2', '<' ) && ! isset( $_GET['edd_upgrade'] ) ) {
		printf(
			'<div class="updated"><p>' . __( 'Vendor Permissions need to be updated, click <a href="%s">here</a> to start the upgrade.', 'edd_fes' ) . '</p></div>',
			esc_url( add_query_arg( array( 'edd_action' => 'upgrade_vendor_permissions' ), admin_url() ) )
		);
	}

}
add_action( 'admin_notices', 'fes_show_upgrade_notice' );

/**
 * Upgrades vendor permissions
 *
 * @since 2.2
 * @return void
 */
function fes_22_upgrade_vendor_permissions() {

	$fes_version = get_option( 'fes_db_version', '2.1' );

	if ( version_compare( $fes_version, '2.2', '>=' ) ) {
		return;
	}

	ignore_user_abort( true );

	if ( ! edd_is_func_disabled( 'set_time_limit' ) && ! ini_get( 'safe_mode' ) )
		set_time_limit( 0 );

	$step   = isset( $_GET['step'] ) ? absint( $_GET['step'] ) : 1;
	$offset = $step == 1 ? 0 : $step * 100; 

	$users = new WP_User_Query( array( 'fields' => 'ID', 'number' => 100, 'offset' => $offset ) );
	$users = $users->results;
	if( $users && count( $users ) > 0 ) {
		foreach( $users as $user => $id ) {
			if ( user_can( $id, 'fes_is_vendor' ) && !user_can( $id, 'fes_is_admin' ) && !user_can( $id,'administrator' ) && !user_can( $id,'editor') ){
				$user = new WP_User( $id );
				$user->add_role( 'frontend_vendor' );
			}
		
		}

		// Keys found so upgrade them
		$step++;
		$redirect = add_query_arg( array(
			'page'        => 'fes-upgrades',
			'edd_upgrade' => 'upgrade_vendor_permissions',
			'step'        => $step
		), admin_url( 'index.php' ) );
		wp_redirect( $redirect ); exit;

	} else {

		// No more keys found, update the DB version and finish up
		update_option( 'fes_db_version', fes_plugin_version );
		wp_redirect( admin_url( 'admin.php?page=fes-about' ) ); exit;
	}

}
add_action( 'edd_upgrade_vendor_permissions', 'fes_22_upgrade_vendor_permissions' );
