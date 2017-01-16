<?php
// this will be split into a menu class, welcome class, system info class, import/export class, and the rest into the vendor table class in 2.3

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

// This is based off of work by bbPress and also EDD itself.
class FES_Menu {

	public $minimum_capability = 'manage_shop_settings';

	public function __construct() {
		add_action( 'user_row_actions', array( $this, 'vendor_row_links' ), 10, 2 );
		add_action( 'admin_menu', array( $this, 'admin_menus' ), 9 );
		add_action( 'admin_head', array( $this, 'admin_head' ) );
		add_action( 'admin_init', array( $this, 'welcome'    ) );
		add_action( 'edd_download_fes_sysinfo',  array( $this, 'edd_generate_fes_sysinfo_download' ) );
		add_action( 'admin_init', array( $this, 'fes_process_form_export' ) );
		add_action( 'admin_init', array( $this, 'fes_process_form_import' ) );
		add_action( 'admin_init', array( $this, 'fes_process_form_reset' ), 999 );
		add_action( 'admin_init', array( $this, 'fes_process_form_tools' ), 999 );
		add_action( 'admin_init', array( $this, 'process_bulk_action' ) );
	}

	public function vendor_row_links( $actions, $user_object ) {
		if( EDD_FES()->vendors->vendor_is_vendor( $user_object->ID ) ) {
			$actions['to_vendor_page'] = "<a class='cgc_ub_edit_badges' href='" . admin_url( "admin.php?page=fes-vendors&action=edit&vendor=$user_object->ID") . "'>" . __( 'Vendor profile', 'edd_fes' ) . "</a>";
		}

		return $actions;
	}

	public function admin_menus() {
		global $fes_settings;
		// About Page
		//echo '<pre>'; var_dump( $fes_settings ); echo '</pre>'; exit;
		add_menu_page(
			__( 'EDD FES', 'edd_fes' ),
			__( 'EDD FES', 'edd_fes' ),
			$this->minimum_capability,
			'fes-about',
			array( $this, 'about_screen' ), '', '25.01'
		);
		add_submenu_page( 'fes-about', __( 'About', 'edd_fes' ), __( 'About', 'edd_fes' ), $this->minimum_capability, 'fes-about', array( $this, 'about_screen' ) );
		add_submenu_page( 'fes-about', EDD_FES()->vendors->get_vendor_constant_name( $plural = true, $uppercase = true ), EDD_FES()->vendors->get_vendor_constant_name( $plural = true, $uppercase = true ), 'manage_shop_settings', 'fes-vendors', array( $this, 'fes_applications_page' ) );
		if ( isset( $fes_settings['fes-submission-form'] ) && $fes_settings['fes-submission-form'] != '' ) {
			add_submenu_page( 'fes-about', 'Submission Form', 'Submission Form', 'manage_shop_settings', 'post.php?post=' . $fes_settings['fes-submission-form'] . '&action=edit' );
		}
		if ( isset( $fes_settings['fes-profile-form'] ) && $fes_settings['fes-profile-form'] != '' ) {
			add_submenu_page( 'fes-about', 'Profile Form', 'Profile Form', 'manage_shop_settings', 'post.php?post=' . $fes_settings['fes-profile-form'] . '&action=edit' );
		}
		if ( isset( $fes_settings['fes-registration-form'] ) && $fes_settings['fes-registration-form'] != '' ) {
			add_submenu_page( 'fes-about', 'Registration Form', 'Registration Form', 'manage_shop_settings', 'post.php?post=' . $fes_settings['fes-registration-form'] . '&action=edit' );
		}
		add_submenu_page( 'fes-about', 'System Info', 'System Info', 'manage_shop_settings', 'fes-system-info', array( $this, 'fes_system_info_page' ) );
		add_submenu_page( 'fes-about', 'Form Import/Export', 'Form Import/Export', 'manage_shop_settings', 'fes-form-import-export', array( $this, 'fes_form_import_page' ) );
	}

	/**
	 * Hide Individual Dashboard Pages
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function admin_head() {
		// Badge for welcome page
		$page = get_current_screen();
		if ( isset( $page->id  ) && $page->id == 'toplevel_page_fes-about' )  {
		$badge_url = fes_assets_url . 'img/extensions2.jpg'; ?>
		<style type="text/css" media="screen">
		/*<![CDATA[*/
		.fes-badge {
			padding: 5px;
			height: 217px;
			width: 354px;
			color: #666;
			font-weight: bold;
			font-size: 14px;
			text-align: center;
			text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8);
			margin: 0 -5px;
			background: #fff url('<?php echo $badge_url; ?>') 5px 5px no-repeat;
			border: 1px solid #ddd;
		}

		.about-wrap .fes-badge {
			position: absolute;
			top: 0;
			right: 0;
		}

		.fes-welcome-screenshots {
			float: right;
			margin-left: 10px!important;
		}
		/*]]>*/
		</style>
		<?php
		}
	}

	/**
	 * Render About Screen
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function about_screen() {
		list( $display_version ) = explode( '-', fes_plugin_version );
		$fes_version = get_option( 'fes_db_version', '2.1' );

		if ( version_compare( $fes_version, '2.2', '<' ) && ! isset( $_GET['edd_upgrade'] ) ) {
			printf(
				'<div class="wrap about-wrap"><p>' . __( 'Vendor Permissions need to be updated, click <a href="%s">here</a> to start the upgrade.', 'edd_fes' ) . '</p></div>',
				esc_url( add_query_arg( array( 'edd_action' => 'upgrade_vendor_permissions' ), admin_url() ) )
			);
		}
		else{
?>
		<div class="wrap about-wrap">
			<h1><?php printf( __( 'Welcome to EDD FES %s!', 'edd_fes' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for updating to the latest version! <br />Easy Digital Downloads Frontend Submissions %s  <br /> is ready to make your online store faster, safer and better!', 'edd_fes' ), $display_version ); ?></div>
			<div class="fes-badge"></div>
			<h1>
			<?php _e( "Release Summary:", 'edd_fes' ); ?>
			</h1>
			<p><?php _e('EDD FES version 2.2 is the culmination of a 3 month rewrite of approximately 80,000 lines of code. From a new settings panel to new forms and email classes
				FES is now more developer, user and admin friendly than ever before. Gone is the 2 step registration/application system, and in its place, a new single form 1 step
				process. With new integrations with Simple Shipping and Audio Player, FES is more powerful than ever. Finally, with a smarter way to manage vendors, by
				using the new vendors table, a new import/export system, and a better formbuilder, FES is easier for store owners to administrate than ever before.','edd_fes'); ?></p>
				<p><?php _e('From the control deck at EDD Headquarters,','edd_fes'); ?></p>
				<p><?php _e('-Chris','edd_fes'); ?></p>
			<h1>
			<?php _e( "What's New:", 'edd_fes' ); ?>
			</h1>



			<div class="changelog">
				<h3><?php _e( 'New FES Forms Class', 'edd_fes' );?></h3>

				<div class="feature-section">
					<li><?php _e( 'Introduces the much requested vendor contact form', 'edd_fes' );?></li>
					<li><?php _e( 'Converted to using the WordPress Media Uploader for all uploaders', 'edd_fes' );?></li>
					<li><?php _e( 'Introduced a new featured image/avatar uploader', 'edd_fes' );?></li>
					<li><?php _e( 'Over 300 new filters and actions to make it more developer friendly', 'edd_fes' );?></li>
					<li><?php _e( 'Redesigned form editor makes creating forms even easier than before', 'edd_fes' );?></li>
					<li><?php _e( 'Added validation for the multiple price field', 'edd_fes' );?></li>
					<li><?php _e( 'Allows vendors to change the name of their store', 'edd_fes' );?></li>
					<li><?php _e( 'Allows vendors to change the email the vendor contact form sends emails for them to', 'edd_fes' );?></li>
					<li><?php _e( 'Added a simple UI to let store owners set prices and the names of price options on the multiple pricing field', 'edd_fes' );?></li>
					<li><?php _e( 'Added more ways to customize the multiple pricing field to meet your exact store needs', 'edd_fes' );?></li>
				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'New FES Emails Class', 'edd_fes' );?></h3>

				<div class="feature-section">
					<li><?php _e( 'Allows for a consistent email experience with FES', 'edd_fes' );?></li>
					<li><?php _e( 'Added the ability to use fields from the profile, registration and submission forms in emails', 'edd_fes' );?></li>
					<li><?php _e( 'Added the ability for people to create their own email tags', 'edd_fes' );?></li>
				</div>
			</div>


			<div class="changelog">
				<h3><?php _e( 'New Admin Features', 'edd_fes' );?></h3>

				<div class="feature-section">
					<li><?php _e( 'New settings panel with the ablity to import/export settings', 'edd_fes' );?></li>
					<li><?php _e( 'New vendor management list table to let store owners easily manage vendors', 'edd_fes' );?></li>
					<li><?php _e( 'Added the ability for store owners to instantly see the data entered into the profile and registration forms of vendors', 'edd_fes' );?></li>
					<li><?php _e( 'Added the ability to import and export FES Forms', 'edd_fes' );?></li>
					<li><?php _e( 'Added the ability to revoke (trash) previously approved submissions', 'edd_fes' );?></li>
					<li><?php _e( 'Added the ability to suspend/unsuspend vendors', 'edd_fes' );?></li>
					<li><?php _e( 'Added a new System Info allowing quick access to essential inform for suport purposes', 'edd_fes' );?></li>
				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'New Frontend Features', 'edd_fes' );?></h3>

				<div class="feature-section">
					<li><?php _e( 'Merged the vendor application and registration forms into a single 1 step form submission process, making it easier for vendors to sign up', 'edd_fes' );?></li>
					<li><?php _e( 'Added the ability to show a CAPTCHA field on the vendor contact and login forms', 'edd_fes' );?></li>
					<li><?php _e( 'Added the ability to let customers sign into the vendor dashboard\'s login form and be brought to the My Account page ', 'edd_fes' );?></li>
					<li><?php _e( 'Added new shortcodes to let you show information from the submission form on the frontend of products', 'edd_fes' );?></li>
					<li><?php _e( 'Changed the vendor store URLs to use pretty permalinks', 'edd_fes' );?></li>
					<li><?php _e( 'Created the ability for vendors to be able to see orders involving their products', 'edd_fes' );?></li>
					<li><?php _e( 'Integrated with Simple Shipping to allow vendors to mark orders as "completed"', 'edd_fes' );?></li>
					<li><?php _e( 'Added a "forgot password" link to the login form', 'edd_fes' );?></li>
					<li><?php _e( 'Integrated with EDD Audio Player to let vendors offer previews of their music', 'edd_fes' );?></li>
				</div>
			</div>

		</div>
		<?php
		}
	}

	public function welcome() {
		global $edd_options;

		// Bail if no activation redirect
		if ( ! get_transient( '_fes_activation_redirect' ) )
			return;

		// Delete the redirect transient
		delete_transient( '_fes_activation_redirect' );

		// Bail if activating from network, or bulk
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) )
			return;

		wp_safe_redirect( admin_url( 'index.php?page=fes-about' ) ); exit;
	}


	function fes_applications_page() {
?>
    <div class="wrap">

        <div id="icon-edit" class="icon32"><br/></div>
        <h2 id="fes-vendor-edit-page" ><?php printf( __( 'FES %s', 'edd_fes' ), EDD_FES()->vendors->get_vendor_constant_name( $plural = true, $uppercase = true ) ); ?></h2>

        <?php

		if ( isset( $_GET['action'] ) && $_GET['action'] == 'edit' ) {
			EDD_FES()->edit_vendor->show_page();
		} else {

			$applications_table = new FES_Vendor_Table();

			//Fetch, prepare, sort, and filter our data...
			$applications_table->prepare_items();

?>
            <form id="fes-vendors-filter" method="get">

                <input type="hidden" name="page" value="fes-vendors" />
                <!-- Now we can render the completed list table -->
                <?php $applications_table->views() ?>

                <?php $applications_table->display() ?>
            </form>
           <?php
		}
?>
    </div>
    <?php

	}

	function fes_system_info_page() {
		global $wpdb, $fes_settings; ?>
	<div class="wrap">
		<style>#system-info-textarea { width: 800px; height: 400px; font-family: Menlo, Monaco, monospace; background: none; white-space: pre; overflow: auto; display: block; }</style>
		<h2><?php _e( 'EDD Frontend Submissions Debugging Information', 'edd_fes' ); ?></h2><br/>
		<form action="<?php echo esc_url( admin_url() ); ?>" method="post" dir="ltr">
			<textarea readonly="readonly" onclick="this.focus();this.select()" id="system-info-textarea" name="fes-sysinfo" title="<?php _e( 'To copy the system info, click below then press Ctrl + C (PC) or Cmd + C (Mac).', 'edd' ); ?>">
### Begin EDD Frontend Submissions Debugging Information ###

## Please include this information when posting support requests regarding FES ##

<?php do_action( 'fes_system_info_before' ); ?>
Dashboard URL:                 <?php echo get_permalink( EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page', false ) ) . "\n"; ?>
FES Version:                 <?php echo fes_plugin_version . "\n"; ?>
FES Plugin Name:                 <?php echo fes_plugin_name . "\n"; ?>
FES File Name:                 <?php echo fes_plugin_file . "\n"; ?>
FES Plugin Path:                 <?php echo fes_plugin_dir . "\n"; ?>
FES Plugin Url:                 <?php echo fes_plugin_url . "\n"; ?>
FES Assets Url:                 <?php echo fes_assets_url . "\n"; ?>
<?php
		print_r( array_filter( $fes_settings ) );
		$posts = get_posts( array( 'post_type' => 'fes-forms', 'posts_per_page'=>- 1 ) );
		foreach ( $posts as $post ) {
			echo $post->id ;
			echo get_the_title( $post->id );
			print_r( get_post_meta( $post->id, 'fes-form', false ) );
		}
?>

FES TEMPLATES:

<?php
		// Show templates that have been copied to the theme's fes_templates dir
		$dir = get_stylesheet_directory() . '/fes_templates/*';
		if ( !empty( $dir ) ) {
			foreach ( glob( $dir ) as $file ) {
				echo "Filename: " . basename( $file ) . "\n";
			}
		}
		else {
			echo 'No overrides found';
		}

		do_action( 'fes_system_info_after' );
?>
### End System Info ###</textarea>
			<p class="submit">
				<input type="hidden" name="edd-action" value="download_fes_sysinfo" />
				<?php submit_button( 'Download System Info File', 'primary', 'edd-download-fes-sysinfo', false ); ?>
			</p>
		</form>
		</div>
	</div>
<?php

	}
	/**
	 * Generates the System Info Download File
	 *
	 * @since 1.4
	 * @return void
	 */
	function edd_generate_fes_sysinfo_download() {
		nocache_headers();

		header( "Content-type: text/plain" );
		header( 'Content-Disposition: attachment; filename="fes-system-info.txt"' );

		echo wp_strip_all_tags( $_POST['fes-sysinfo'] );
		edd_die();
	}

	function fes_form_import_page() {
		$options = get_option( 'pwsix_settings' );
		wp_enqueue_style('dashboard');
		wp_enqueue_script('dashboard');
		?>
		<div class="wrap">
		<h2><?php screen_icon(); _e( 'Import/Export/Reset FES Forms' ); ?></h2>

		<?php if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'import' && isset( $_REQUEST['form'] ) ){
			echo '<div class="updated"><p>'.__('Successfully imported the ', 'edd_fes' ) . $_REQUEST['form'] . __( ' form!' , 'edd_fes').'</p></div>';
		}
		else if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'reset' && isset( $_REQUEST['form'] ) ){
			echo '<div class="updated"><p>'.__('Successfully reset the ', 'edd_fes' ) . $_REQUEST['form'] . __( ' form!' , 'edd_fes').'</p></div>';
		}
		else if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'delete' && isset( $_REQUEST['result'] ) ){
			if ( $_REQUEST['action'] == 'success' && isset ( $_REQUEST['count'] ) ){
				if ( $_REQUEST['count'] > 0 ){
					echo '<div class="updated"><p>'.__('Successfully removed ', 'edd_fes' ) . $_REQUEST['count'] . __( ' extra form(s)!' , 'edd_fes').'</p></div>';
				}
				else{
					echo '<div class="updated"><p>'.__('No extra forms to remove!' , 'edd_fes').'</p></div>';
				}
			}
			else{
				echo '<div class="updated"><p>'.__('No extra forms to remove!' , 'edd_fes').'</p></div>';
			}
		}
		?>
		<div class="metabox-holder meta-box-sortables ui-sortable">
			<div class="postbox ">
				<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span><?php _e( 'Submission Form Settings' ); ?></span></h3>
				<div class="inside">
					<p><?php _e( 'Import the submission form settings from a .json file.' ); ?></p>
					<form method="post" enctype="multipart/form-data">
						<p>
							<input type="file" name="import_file"/>
						</p>
						<p>
							<input type="hidden" name="fes_action" value="import_submission_form_settings" />
							<?php wp_nonce_field( 'import_submission_form_settings', 'import_submission_form_settings' ); ?>
							<?php submit_button( __( 'Import','edd_fes' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
					<p><?php _e( 'Export the submission form settings for this site as a .json file', 'edd_fes' ); ?></p>
					<form method="post">
						<p><input type="hidden" name="fes_action" value="export_submission_form_settings" /></p>
						<p>
							<?php wp_nonce_field( 'export_submission_form_settings', 'export_submission_form_settings' ); ?>
							<?php submit_button( __( 'Export','edd_fes' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
					<p><?php _e( 'Reset the submission form settings. This action restores the form settings back to their new install defaults', 'edd_fes' ); ?></p>
					<form method="post">
						<p><input type="hidden" name="fes_action" value="reset_submission_form_settings" /></p>
						<p>
							<?php wp_nonce_field( 'reset_submission_form_settings', 'reset_submission_form_settings' ); ?>
							<?php submit_button( __( 'Reset','edd_fes' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
				</div><!-- .inside -->
			</div><!-- .postbox -->
		</div><!-- .metabox-holder -->

		<div class="metabox-holder meta-box-sortables ui-sortable">
			<div class="postbox closed">
				<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span><?php _e( 'Profile Form Settings' ); ?></span></h3>
				<div class="inside">
					<p><?php _e( 'Import the profile form settings from a .json file.' ); ?></p>
					<form method="post" enctype="multipart/form-data">
						<p>
							<input type="file" name="import_file"/>
						</p>
						<p>
							<input type="hidden" name="fes_action" value="import_profile_form_settings" />
							<?php wp_nonce_field( 'import_profile_form_settings', 'import_profile_form_settings' ); ?>
							<?php submit_button( __( 'Import','edd_fes' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
					<p><?php _e( 'Export the profile form settings for this site as a .json file', 'edd_fes' ); ?></p>
					<form method="post">
						<p><input type="hidden" name="fes_action" value="export_profile_form_settings" /></p>
						<p>
							<?php wp_nonce_field( 'export_profile_form_settings', 'export_profile_form_settings' ); ?>
							<?php submit_button( __( 'Export','edd_fes' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
					<p><?php _e( 'Reset the profile form settings. This action restores the form settings back to their new install defaults', 'edd_fes' ); ?></p>
					<form method="post">
						<p><input type="hidden" name="fes_action" value="reset_profile_form_settings" /></p>
						<p>
							<?php wp_nonce_field( 'reset_profile_form_settings', 'reset_profile_form_settings' ); ?>
							<?php submit_button( __( 'Reset','edd_fes' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
				</div><!-- .inside -->
			</div><!-- .postbox -->
		</div><!-- .metabox-holder -->

		<div class="metabox-holder meta-box-sortables ui-sortable">
			<div class="postbox closed">
				<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span><?php _e( 'Contact Form Settings' ); ?></span></h3>
				<div class="inside">
					<p><?php _e( 'Import the contact form settings from a .json file.' ); ?></p>
					<form method="post" enctype="multipart/form-data">
						<p>
							<input type="file" name="import_file"/>
						</p>
						<p>
							<input type="hidden" name="fes_action" value="import_contact_form_settings" />
							<?php wp_nonce_field( 'import_contact_form_settings', 'import_contact_form_settings' ); ?>
							<?php submit_button( __( 'Import','edd_fes' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
					<p><?php _e( 'Export the contact form settings for this site as a .json file', 'edd_fes' ); ?></p>
					<form method="post">
						<p><input type="hidden" name="fes_action" value="export_contact_form_settings" /></p>
						<p>
							<?php wp_nonce_field( 'export_contact_form_settings', 'export_contact_form_settings' ); ?>
							<?php submit_button( __( 'Export','edd_fes' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
					<p><?php _e( 'Reset the contact form settings. This action restores the form settings back to their new install defaults', 'edd_fes' ); ?></p>
					<form method="post">
						<p><input type="hidden" name="fes_action" value="reset_contact_form_settings" /></p>
						<p>
							<?php wp_nonce_field( 'reset_contact_form_settings', 'reset_contact_form_settings' ); ?>
							<?php submit_button( __( 'Reset','edd_fes' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
				</div><!-- .inside -->
			</div><!-- .postbox -->
		</div><!-- .metabox-holder -->

		<div class="metabox-holder meta-box-sortables ui-sortable">
			<div class="postbox closed">
				<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span><?php _e( 'Registration Form Settings' ); ?></span></h3>
				<div class="inside">
					<p><?php _e( 'Import the registration form settings from a .json file.' ); ?></p>
					<form method="post" enctype="multipart/form-data">
						<p>
							<input type="file" name="import_file"/>
						</p>
						<p>
							<input type="hidden" name="fes_action" value="import_registration_form_settings" />
							<?php wp_nonce_field( 'import_registration_form_settings', 'import_registration_form_settings' ); ?>
							<?php submit_button( __( 'Import','edd_fes' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
					<p><?php _e( 'Export the registration form settings for this site as a .json file', 'edd_fes' ); ?></p>
					<form method="post">
						<p><input type="hidden" name="fes_action" value="export_registration_form_settings" /></p>
						<p>
							<?php wp_nonce_field( 'export_registration_form_settings', 'export_registration_form_settings' ); ?>
							<?php submit_button( __( 'Export','edd_fes' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
					<p><?php _e( 'Reset the registration form settings. This action restores the form settings back to their new install defaults', 'edd_fes' ); ?></p>
					<form method="post">
						<p><input type="hidden" name="fes_action" value="reset_registration_form_settings" /></p>
						<p>
							<?php wp_nonce_field( 'reset_registration_form_settings', 'reset_registration_form_settings' ); ?>
							<?php submit_button( __( 'Reset','edd_fes' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
				</div><!-- .inside -->
			</div><!-- .postbox -->
		</div><!-- .metabox-holder -->

		<div class="metabox-holder meta-box-sortables ui-sortable">
			<div class="postbox closed">
				<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span><?php _e( 'Login Form Settings' ); ?></span></h3>
				<div class="inside">
					<p><?php _e( 'Import the login form settings from a .json file.' ); ?></p>
					<form method="post" enctype="multipart/form-data">
						<p>
							<input type="file" name="import_file"/>
						</p>
						<p>
							<input type="hidden" name="fes_action" value="import_login_form_settings" />
							<?php wp_nonce_field( 'import_login_form_settings', 'import_login_form_settings' ); ?>
							<?php submit_button( __( 'Import','edd_fes' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
					<p><?php _e( 'Export the login form settings for this site as a .json file', 'edd_fes' ); ?></p>
					<form method="post">
						<p><input type="hidden" name="fes_action" value="export_login_form_settings" /></p>
						<p>
							<?php wp_nonce_field( 'export_login_form_settings', 'export_login_form_settings' ); ?>
							<?php submit_button( __( 'Export','edd_fes' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
					<p><?php _e( 'Reset the login form settings. This action restores the form settings back to their new install defaults', 'edd_fes' ); ?></p>
					<form method="post">
						<p><input type="hidden" name="fes_action" value="reset_login_form_settings" /></p>
						<p>
							<?php wp_nonce_field( 'reset_login_form_settings', 'reset_login_form_settings' ); ?>
							<?php submit_button( __( 'Reset','edd_fes' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
				</div><!-- .inside -->
			</div><!-- .postbox -->
		</div><!-- .metabox-holder -->

		<div class="metabox-holder meta-box-sortables ui-sortable">
			<div class="postbox closed">
				<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span><?php _e( 'FES Tools' ); ?></span></h3>
				<div class="inside">
					<p><?php _e( 'Delete extraneous forms: This action deletes all FES Forms which are not assigned to a form in the FES Settings Panel' ); ?></p>
					<form method="post">
						<p><input type="hidden" name="fes_action" value="delete_extra_forms" /></p>
						<p>
							<?php wp_nonce_field( 'delete_extra_forms', 'delete_extra_forms' ); ?>
							<?php submit_button( __( 'Delete Unassigned Forms','edd_fes' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
				</div><!-- .inside -->
			</div><!-- .postbox -->
		</div><!-- .metabox-holder -->
	</div><!--end .wrap-->
	<?php
	}

	function fes_process_form_import() {

		if ( !isset( $_POST['fes_action'] ) || empty( $_POST['fes_action'] ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_shop_settings' ) ) {
			return;
		}

		$form = $_POST['fes_action'];
		switch ( $form ) {
			case 'import_login_form_settings':
				if ( !wp_verify_nonce( $_POST['import_login_form_settings'], 'import_login_form_settings' ) ) {
					return;
				}
				$extension = explode( '.', $_FILES['import_file']['name'] );
				$extension = end( $extension );

				if ( $extension != 'json' ) {
					wp_die( __( 'Please upload a valid .json file' ) );
				}

				$import_file = $_FILES['import_file']['tmp_name'];

				if ( empty( $import_file ) ) {
					wp_die( __( 'Please upload a file to import' ) );
				}

				// Retrieve the settings from the file and convert the json object to an array.
				$settings =  edd_object_to_array( json_decode( file_get_contents( $import_file ) ) );

				// if there's no form, let's make one
				if ( ! EDD_FES()->helper->get_option( 'fes-login-form', false ) ) {
					$page_data = array(
						'post_status' => 'publish',
						'post_type' => 'fes-forms',
						'post_author' => get_current_user_id(),
						'post_title' => __( 'Login Form', 'edd_fes' )
					);
					$page_id   = wp_insert_post( $page_data );
					update_post_meta( $page_id, 'fes-form', $settings );
				}
				else {
					update_post_meta( EDD_FES()->helper->get_option( 'fes-login-form', false ), 'fes-form', $settings );
				}

				wp_safe_redirect( admin_url( 'admin.php?page=fes-form-import-export&action=import&form=login&result=success' ) ); exit;
				break;
			case 'import_registration_form_settings':
				if ( !wp_verify_nonce( $_POST['import_registration_form_settings'], 'import_registration_form_settings' ) ) {
					return;
				}
				$extension = explode( '.', $_FILES['import_file']['name'] );
				$extension = end( $extension );

				if ( $extension != 'json' ) {
					wp_die( __( 'Please upload a valid .json file' ) );
				}

				$import_file = $_FILES['import_file']['tmp_name'];

				if ( empty( $import_file ) ) {
					wp_die( __( 'Please upload a file to import' ) );
				}

				// Retrieve the settings from the file and convert the json object to an array.
				$settings =  edd_object_to_array( json_decode( file_get_contents( $import_file ) ) );

				// if there's no form, let's make one
				if ( ! EDD_FES()->helper->get_option( 'fes-registration-form', false ) ) {
					$page_data = array(
						'post_status' => 'publish',
						'post_type' => 'fes-forms',
						'post_author' => get_current_user_id(),
						'post_title' => __( 'Registration Form', 'edd_fes' )
					);
					$page_id   = wp_insert_post( $page_data );
					update_post_meta( $page_id, 'fes-form', $settings );
				}
				else {
					update_post_meta( EDD_FES()->helper->get_option( 'fes-registration-form', false ) , 'fes-form', $settings );
				}

				wp_safe_redirect( admin_url( 'admin.php?page=fes-form-import-export&action=import&form=registration&result=success' ) ); exit;
				break;
			case 'import_submission_form_settings':
				if ( !wp_verify_nonce( $_POST['import_submission_form_settings'], 'import_submission_form_settings' ) ) {
					return;
				}
				$extension = explode( '.', $_FILES['import_file']['name'] );
				$extension = end( $extension );

				if ( $extension != 'json' ) {
					wp_die( __( 'Please upload a valid .json file' ) );
				}

				$import_file = $_FILES['import_file']['tmp_name'];

				if ( empty( $import_file ) ) {
					wp_die( __( 'Please upload a file to import' ) );
				}

				// Retrieve the settings from the file and convert the json object to an array.
				$settings =  edd_object_to_array( json_decode( file_get_contents( $import_file ) ) );

				// if there's no form, let's make one
				if ( ! EDD_FES()->helper->get_option( 'fes-submission-form', false ) ) {
					$page_data = array(
						'post_status' => 'publish',
						'post_type' => 'fes-forms',
						'post_author' => get_current_user_id(),
						'post_title' => __( 'Submission Form', 'edd_fes' )
					);
					$page_id   = wp_insert_post( $page_data );
					update_post_meta( $page_id, 'fes-form', $settings );
				}
				else {
					update_post_meta( EDD_FES()->helper->get_option( 'fes-submission-form', false ), 'fes-form', $settings );
				}

				wp_safe_redirect( admin_url( 'admin.php?page=fes-form-import-export&action=import&form=submission&result=success' ) ); exit;
				break;
			case 'import_profile_form_settings':
				if ( !wp_verify_nonce( $_POST['import_profile_form_settings'], 'import_profile_form_settings' ) ) {
					return;
				}
				$extension = explode( '.', $_FILES['import_file']['name'] );
				$extension = end( $extension );

				if ( $extension != 'json' ) {
					wp_die( __( 'Please upload a valid .json file' ) );
				}

				$import_file = $_FILES['import_file']['tmp_name'];

				if ( empty( $import_file ) ) {
					wp_die( __( 'Please upload a file to import' ) );
				}

				// Retrieve the settings from the file and convert the json object to an array.
				$settings =  edd_object_to_array( json_decode( file_get_contents( $import_file ) ) );

				// if there's no form, let's make one
				if ( ! EDD_FES()->helper->get_option( 'fes-profile-form', false ) ) {
					$page_data = array(
						'post_status' => 'publish',
						'post_type' => 'fes-forms',
						'post_author' => get_current_user_id(),
						'post_title' => __( 'Profile Form', 'edd_fes' )
					);
					$page_id   = wp_insert_post( $page_data );
					update_post_meta( $page_id, 'fes-form', $settings );
				}
				else {
					update_post_meta( EDD_FES()->helper->get_option( 'fes-profile-form', false ) , 'fes-form', $settings );
				}

				wp_safe_redirect( admin_url( 'admin.php?page=fes-form-import-export&action=import&form=profile&result=success' ) ); exit;
				break;
			case 'import_contact_form_settings':
				if ( !wp_verify_nonce( $_POST['import_contact_form_settings'], 'import_contact_form_settings' ) ) {
					return;
				}
				$extension = explode( '.', $_FILES['import_file']['name'] );
				$extension = end( $extension );

				if ( $extension != 'json' ) {
					wp_die( __( 'Please upload a valid .json file' ) );
				}

				$import_file = $_FILES['import_file']['tmp_name'];

				if ( empty( $import_file ) ) {
					wp_die( __( 'Please upload a file to import' ) );
				}

				// Retrieve the settings from the file and convert the json object to an array.
				$settings =  edd_object_to_array( json_decode( file_get_contents( $import_file ) ) );

				// if there's no form, let's make one
				if ( ! EDD_FES()->helper->get_option( 'fes-vendor-contact-form', false ) ) {
					$page_data = array(
						'post_status' => 'publish',
						'post_type' => 'fes-forms',
						'post_author' => get_current_user_id(),
						'post_title' => __( 'Contact Form', 'edd_fes' )
					);
					$page_id   = wp_insert_post( $page_data );
					update_post_meta( $page_id, 'fes-form', $settings );
				}
				else {
					update_post_meta( EDD_FES()->helper->get_option( 'fes-vendor-contact-form', false ) , 'fes-form', $settings );
				}

				wp_safe_redirect( admin_url( 'admin.php?page=fes-form-import-export&action=import&form=contact&result=success' ) ); exit;
				break;
		}
	}


	function fes_process_form_reset() {
		if ( !isset( $_POST['fes_action'] ) || empty( $_POST['fes_action'] ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_shop_settings' ) ) {
			return;
		}

		$form = $_POST['fes_action'];
		switch ( $form ) {
		case 'reset_login_form_settings':
			if ( !wp_verify_nonce( $_POST['reset_login_form_settings'], 'reset_login_form_settings' ) ) {
				return;
			}

			$import_file = fes_plugin_dir . 'assets/backups/login-form.json';

			// Retrieve the settings from the file and convert the json object to an array.
			$settings =  edd_object_to_array( json_decode( file_get_contents( $import_file ) ) );

			// if there's no form, let's make one
			if ( ! EDD_FES()->helper->get_option( 'fes-login-form', false ) ) {
				$page_data = array(
					'post_status' => 'publish',
					'post_type' => 'fes-forms',
					'post_author' => get_current_user_id(),
					'post_title' => __( 'Login Form', 'edd_fes' )
				);
				$page_id   = wp_insert_post( $page_data );
				update_post_meta( $page_id, 'fes-form', $settings );
			}
			else {
				update_post_meta( EDD_FES()->helper->get_option( 'fes-login-form', false ), 'fes-form', $settings );
			}

			wp_safe_redirect( admin_url( 'admin.php?page=fes-form-import-export&action=reset&form=login&result=success' ) ); exit;
			break;
		case 'reset_registration_form_settings':
			if ( !wp_verify_nonce( $_POST['reset_registration_form_settings'], 'reset_registration_form_settings' ) ) {
				return;
			}

			$import_file = fes_plugin_dir . 'assets/backups/registration-form.json';

			// Retrieve the settings from the file and convert the json object to an array.
			$settings =  edd_object_to_array( json_decode( file_get_contents( $import_file ) ) );

			// if there's no form, let's make one
			if ( ! EDD_FES()->helper->get_option( 'fes-registration-form', false ) ) {
				$page_data = array(
					'post_status' => 'publish',
					'post_type' => 'fes-forms',
					'post_author' => get_current_user_id(),
					'post_title' => __( 'Registration Form', 'edd_fes' )
				);
				$page_id   = wp_insert_post( $page_data );
				update_post_meta( $page_id, 'fes-form', $settings );
			}
			else {
				update_post_meta( EDD_FES()->helper->get_option( 'fes-registration-form', false ) , 'fes-form', $settings );
			}

			wp_safe_redirect( admin_url( 'admin.php?page=fes-form-import-export&action=reset&form=registration&result=success' ) ); exit;
			break;
		case 'reset_submission_form_settings':
			if ( !wp_verify_nonce( $_POST['reset_submission_form_settings'], 'reset_submission_form_settings' ) ) {
				return;
			}

			$import_file = fes_plugin_dir . 'assets/backups/submission-form.json';

			// Retrieve the settings from the file and convert the json object to an array.
			$settings =  edd_object_to_array( json_decode( file_get_contents( $import_file ) ) );

			// if there's no form, let's make one
			if ( ! EDD_FES()->helper->get_option( 'fes-submission-form', false ) ) {
				$page_data = array(
					'post_status' => 'publish',
					'post_type' => 'fes-forms',
					'post_author' => get_current_user_id(),
					'post_title' => __( 'Submission Form', 'edd_fes' )
				);
				$page_id   = wp_insert_post( $page_data );
				update_post_meta( $page_id, 'fes-form', $settings );
			}
			else {
				update_post_meta( EDD_FES()->helper->get_option( 'fes-submission-form', false ), 'fes-form', $settings );
			}

			wp_safe_redirect( admin_url( 'admin.php?page=fes-form-import-export&action=reset&form=submission&result=success' ) ); exit;
			break;
		case 'reset_profile_form_settings':
			if ( !wp_verify_nonce( $_POST['reset_profile_form_settings'], 'reset_profile_form_settings' ) ) {
				return;
			}

			$import_file = fes_plugin_dir . 'assets/backups/profile-form.json';

			// Retrieve the settings from the file and convert the json object to an array.
			$settings =  edd_object_to_array( json_decode( file_get_contents( $import_file ) ) );

			// if there's no form, let's make one
			if ( ! EDD_FES()->helper->get_option( 'fes-profile-form', false ) ) {
				$page_data = array(
					'post_status' => 'publish',
					'post_type' => 'fes-forms',
					'post_author' => get_current_user_id(),
					'post_title' => __( 'Profile Form', 'edd_fes' )
				);
				$page_id   = wp_insert_post( $page_data );
				update_post_meta( $page_id, 'fes-form', $settings );
			}
			else {
				update_post_meta( EDD_FES()->helper->get_option( 'fes-profile-form', false ) , 'fes-form', $settings );
			}

			wp_safe_redirect( admin_url( 'admin.php?page=fes-form-import-export&action=reset&form=profile&result=success' ) ); exit;
			break;
		case 'reset_contact_form_settings':
			if ( !wp_verify_nonce( $_POST['reset_contact_form_settings'], 'reset_contact_form_settings' ) ) {
				return;
			}

			$import_file = fes_plugin_dir . 'assets/backups/contact-form.json';

			// Retrieve the settings from the file and convert the json object to an array.
			$settings =  edd_object_to_array( json_decode( file_get_contents( $import_file ) ) );

			// if there's no form, let's make one
			if ( ! EDD_FES()->helper->get_option( 'fes-vendor-contact-form', false ) ) {
				$page_data = array(
					'post_status' => 'publish',
					'post_type' => 'fes-forms',
					'post_author' => get_current_user_id(),
					'post_title' => __( 'Contact Form', 'edd_fes' )
				);
				$page_id   = wp_insert_post( $page_data );
				update_post_meta( $page_id, 'fes-form', $settings );
			}
			else {
				update_post_meta( EDD_FES()->helper->get_option( 'fes-vendor-contact-form', false ) , 'fes-form', $settings );
			}

			wp_safe_redirect( admin_url( 'admin.php?page=fes-form-import-export&action=reset&form=contact&result=success' ) ); exit;
			break;
		}
	}





	function fes_process_form_export() {

		if ( !isset( $_POST['fes_action'] ) || empty( $_POST['fes_action'] ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_shop_settings' ) ) {
			return;
		}

		$form = $_POST['fes_action'];

		switch ( $form ) {
			case 'export_login_form_settings':
				if ( !wp_verify_nonce( $_POST['export_login_form_settings'], 'export_login_form_settings' ) ) {
					return;
				}
				if ( !EDD_FES()->helper->get_option( 'fes-login-form', true ) ) {
					return;
				}

				$settings = get_post_meta( EDD_FES()->helper->get_option( 'fes-login-form', false ) , 'fes-form', true );
				ignore_user_abort( true );

				nocache_headers();
				header( 'Content-Type: application/json; charset=utf-8' );
				header( 'Content-Disposition: attachment; filename=fes-login-form-export-' . date( 'm-d-Y' ) . '.json' );
				header( "Expires: 0" );

				echo json_encode( $settings );
				exit;
				break;
			case 'export_registration_form_settings':
				if ( !wp_verify_nonce( $_POST['export_registration_form_settings'], 'export_registration_form_settings' ) ) {
					return;
				}

				if ( !EDD_FES()->helper->get_option( 'fes-registration-form', true ) ) {
					return;
				}

				$settings = get_post_meta( EDD_FES()->helper->get_option( 'fes-registration-form', false ) , 'fes-form', true );

				ignore_user_abort( true );

				nocache_headers();
				header( 'Content-Type: application/json; charset=utf-8' );
				header( 'Content-Disposition: attachment; filename=fes-registration-form-export-' . date( 'm-d-Y' ) . '.json' );
				header( "Expires: 0" );

				echo json_encode( $settings) ;
				exit;
				break;
			case 'export_submission_form_settings':
				if ( !wp_verify_nonce( $_POST['export_submission_form_settings'], 'export_submission_form_settings' ) ) {
					return;
				}
				if ( !EDD_FES()->helper->get_option( 'fes-submission-form', true ) ) {
					return;
				}
				$settings = get_post_meta( EDD_FES()->helper->get_option( 'fes-submission-form', false ), 'fes-form', true );
				ignore_user_abort( true );

				nocache_headers();
				header( 'Content-Type: application/json; charset=utf-8' );
				header( 'Content-Disposition: attachment; filename=fes-submission-form-export-' . date( 'm-d-Y' ) . '.json' );
				header( "Expires: 0" );

				echo json_encode( $settings );
				exit;
				break;
			case 'export_profile_form_settings':
				if ( !wp_verify_nonce( $_POST['export_profile_form_settings'], 'export_profile_form_settings' ) ) {
					return;
				}

				if ( !EDD_FES()->helper->get_option( 'fes-profile-form', true ) ) {
					return;
				}

				$settings = get_post_meta( EDD_FES()->helper->get_option( 'fes-profile-form', false ), 'fes-form', true );

				ignore_user_abort( true );

				nocache_headers();
				header( 'Content-Type: application/json; charset=utf-8' );
				header( 'Content-Disposition: attachment; filename=fes-profile-form-export-' . date( 'm-d-Y' ) . '.json' );
				header( "Expires: 0" );

				echo json_encode( $settings );
				exit;
				break;
			case 'export_contact_form_settings':
				if ( !wp_verify_nonce( $_POST['export_contact_form_settings'], 'export_contact_form_settings' ) ) {
					return;
				}

				if ( !EDD_FES()->helper->get_option( 'fes-vendor-contact-form', true ) ) {
					return;
				}

				$settings = get_post_meta( EDD_FES()->helper->get_option( 'fes-vendor-contact-form', false ), 'fes-form', true );

				ignore_user_abort( true );

				nocache_headers();
				header( 'Content-Type: application/json; charset=utf-8' );
				header( 'Content-Disposition: attachment; filename=fes-contact-form-export-' . date( 'm-d-Y' ) . '.json' );
				header( "Expires: 0" );

				echo json_encode( $settings );
				exit;
				break;
		}
	}

	function fes_process_form_tools() {

		if ( !isset( $_POST['fes_action'] ) || empty( $_POST['fes_action'] ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_shop_settings' ) ) {
			return;
		}

		$form = $_POST['fes_action'];

		switch ( $form ) {
			case 'delete_extra_forms':
				if ( !wp_verify_nonce( $_POST['delete_extra_forms'], 'delete_extra_forms' ) ) {
					return;
				}
				$forms = new WP_Query( array('post_type' => 'fes-forms', 'fields' => 'ids', 'posts_per_page' => -1 ) );
				$forms = $forms->posts;
				if ( !$forms ){
					wp_safe_redirect( admin_url( 'admin.php?page=fes-form-import-export&action=delete&result=fail' ) ); exit;
					break;
				}
				global $fes_settings;
				$count = 0;
				foreach ( $forms as $form ){
					    if ( isset( $fes_settings['fes-submission-form'] ) && $fes_settings['fes-submission-form'] == $form && $fes_settings['fes-submission-form'] ){
					    	continue;
					    }
					    else if ( isset( $fes_settings['fes-profile-form'] ) && $fes_settings['fes-profile-form'] == $form && $fes_settings['fes-profile-form'] ){
					    	continue;
					    }
					    else if ( isset( $fes_settings['fes-registration-form'] ) && $fes_settings['fes-registration-form'] == $form && $fes_settings['fes-registration-form'] ){
					    	continue;
					    }
					    else if ( isset( $fes_settings['fes-login-form'] ) && $fes_settings['fes-login-form'] == $form && $fes_settings['fes-login-form'] ){
					    	continue;
					    }
					    else if ( isset( $fes_settings['fes-vendor-contact-form'] ) && $fes_settings['fes-vendor-contact-form'] == $form && $fes_settings['fes-vendor-contact-form'] ){
					    	continue;
					    }
					    else{
					    	wp_delete_post( $form, true ); // not assigned so delete it
					    	$count++;
					    }
				}

				$settings = get_post_meta( EDD_FES()->helper->get_option( 'fes-login-form', false ) , 'fes-form', true );
				wp_safe_redirect( admin_url( 'admin.php?page=fes-form-import-export&action=delete&count='.$count.'&result=success' ) ); exit;
				break;
		}
	}

    function process_bulk_action() {

    	global $edd_options;

        $ids = isset( $_GET['vendor'] ) ? $_GET['vendor'] : false;

        if ( empty( $ids ) )
            return;

        if ( !is_array( $ids ) )
            $ids = array( $ids );

        $current_action = $_GET['action'];

        $from_name = isset( $edd_options[ 'from_name' ] ) ? $edd_options[ 'from_name' ] : get_bloginfo( 'name' );
        $from_email = isset( $edd_options[ 'from_email' ] ) ? $edd_options[ 'from_email' ] : get_option( 'admin_email' );

        foreach ( $ids as $id ) {
            if ( 'approve_vendor' === $current_action ) {
                if ( $id < 2 ) {
                    break;
                }
                if (  user_can( $id , 'fes_is_admin' ) ||  user_can( $id, 'frontend_vendor' ) ) {
                    break;
                }
                if ( ! user_can( $id, 'pending_vendor' ) ) {
                    break;
                }
                $user = new WP_User($id);

                $user->remove_role( 'pending_vendor' );
                $user->add_role( 'frontend_vendor' );

                $subject = apply_filters( 'fes_application_approved_message_subj', __( 'Application Approved', 'edd_fes' ), 0 );
                $message = EDD_FES()->helper->get_option( 'fes-vendor-app-approved-email', '' );

                $type = "user";

                $args['permissions'] = 'fes-vendor-app-approved-email-toggle';

                EDD_FES()->emails->send_email( $user->user_email, $from_name, $from_email, $subject, $message, $type, $id, $args );

                do_action('fes_approve_vendor_admin', $id);

                if ( isset($_GET['redirect']) && $_GET['redirect'] == '2'){
                    wp_redirect(admin_url( 'admin.php?page=fes-vendors&vendor='.$id.'&action=edit&approved=2' )); exit;
                }
            }
            if ( 'revoke_vendor' === $current_action ) {
                if ( $id < 2 ) {
                    break;
                }
                if ( ! ( user_can( $id , 'fes_is_admin' ) ||  user_can( $id, 'frontend_vendor' ) ) ) {
                    break;
                }

                $user = new WP_User($id);
                $user->remove_role('frontend_vendor');
                $user->remove_cap('fes_is_admin');
                $user->add_role('subscriber');

                // remove all their posts
                $args = array('post_type' => 'download', 'author' => $id, 'posts_per_page'=> -1, 'fields' => 'ids', 'post_status' => 'any' );
                $query = new WP_Query( $args );
                foreach ( $query->posts as $id ){
                    wp_delete_post( $id, false );
                }

                $subject = apply_filters( 'fes_application_revoked_message_subj', __( 'Application Revoked', 'edd_fes' ), 0 );
                $message = EDD_FES()->helper->get_option( 'fes-vendor-app-revoked-email', '' );

                EDD_FES()->emails->send_email( $user->user_email, $from_name, $from_email, $subject, $message, "user", $id, array( 'fes-vendor-app-revoked-email-toggle' ) );
                do_action('fes_revoke_vendor_admin', $id);

            }
            if ( 'decline_vendor' === $current_action ) {
                if ( $id < 2 ) {
                    break;
                }
                if ( user_can( $id , 'fes_is_admin' ) ||  user_can( $id, 'frontend_vendor' ) ) {
                    break;
                }
                if ( ! user_can( $id, 'pending_vendor' ) ) {
                    break;
                }

                $user = new WP_User($id);
                $user->remove_role('pending_vendor');

                $subject    = apply_filters( 'fes_application_declined_message_subj', __( 'Application Declined', 'edd_fes' ), 0 );
                $message    = EDD_FES()->helper->get_option( 'fes-vendor-app-declined-email', '' );
                EDD_FES()->emails->send_email( $user->user_email, $from_name, $from_email, $subject, $message, "user", $id, array( 'fes-vendor-app-declined-email-toggle' ) );

                do_action( 'fes_decline_vendor_admin', $id );

            }
            if ( 'suspend_vendor' === $current_action ) {
                if ( $id < 2 ) {
                    break;
                }
                if ( user_can( $id, 'pending_vendor' ) ) {
                    break;
                }
                if ( user_can( $id, 'suspended_vendor' ) ) {
                    break;
                }
                $user = new WP_User($id);
                $user->remove_role('frontend_vendor');
                $user->add_role('suspended_vendor');

                // remove all their posts
                $args = array('post_type' => 'download', 'author' => $id, 'posts_per_page'=> -1, 'fields' => 'ids', 'post_status' => 'any' );
                $query = new WP_Query( $args );
                foreach ( $query->posts as $download ){
                    update_post_meta( $download, 'fes_previous_status', get_post_status( $download ) );

                  	// Make sure products are never entirely deleted when suspending a vendor
                    if( defined( 'EMPTY_TRASH_DAYS' ) && ! EMPTY_TRASH_DAYS ) {
                    	wp_update_post( array( 'ID' => $download, 'post_status' => 'draft' ) );
                    } else {
	                    wp_trash_post( $download );
                    }
                }

                $subject    = apply_filters( 'fes_vendor_suspended_message_subj', __( 'Suspended', 'edd_fes' ), 0 );
                $message    = EDD_FES()->helper->get_option( 'fes-vendor-suspended-email', '' );

            	EDD_FES()->emails->send_email( $user->user_email, $from_name, $from_email, $subject, $message, 'user', $id, array( 'fes-vendor-suspended-email-toggle' ) );

                do_action('fes_vendor_suspended_admin', $id );

                if ( isset( $_GET['redirect'] ) && $_GET['redirect'] == '2' ) {
                    wp_redirect(admin_url( 'admin.php?page=fes-vendors&vendor='.$id.'&action=edit&approved=2' )); exit;
                }
            }
            if ( 'unsuspend_vendor' === $current_action ) {
                if ( $id < 2 ) {
                    break;
                }
                if ( user_can( $id, 'pending_vendor' ) ) {
                    break;
                }
                if ( user_can( $id, 'frontend_vendor' ) ) {
                    break;
                }
                $user = new WP_User($id);
                $user->add_role('frontend_vendor');
                $user->remove_role('suspended_vendor');

                // remove all their posts
                $args = array('post_type' => 'download', 'author' => $id, 'posts_per_page'=> -1, 'fields' => 'ids', 'post_status' => array( 'pending', 'trash' ) );
                $query = new WP_Query( $args );
                foreach ( $query->posts as $download ){
                    $status = get_post_meta( $download, 'fes_previous_status', true );
                    if ( ! $status ) {
                        $status = 'pending';
                    }
                    wp_update_post( array( 'ID' => $download, 'post_status' => $status ) );
                    wp_untrash_post_comments( $download );
                }

                $subject = apply_filters( 'fes_vendor_unsuspended_message_subj', __( 'Unsuspended', 'edd_fes' ), 0 );
                $message = EDD_FES()->helper->get_option( 'fes-vendor-unsuspended-email', '' );

                EDD_FES()->emails->send_email( $user->user_email, $from_name, $from_email, $subject, $message, "user", $id, array( 'fes-vendor-unsuspended-email-toggle' ) );

                do_action('fes_vendor_unsuspended_admin', $id);

               if ( isset( $_GET['redirect'] ) && $_GET['redirect'] == '2' ) {
                    wp_redirect(admin_url( 'admin.php?page=fes-vendors&vendor='.$id.'&action=edit&approved=2' )); exit;
                }
            }
        }
    }
}
