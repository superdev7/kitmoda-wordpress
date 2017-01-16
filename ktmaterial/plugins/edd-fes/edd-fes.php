<?php
/**
 * Plugin Name:         Easy Digital Downloads - Frontend Submissions
 * Plugin URI:          https://easydigitaldownloads.com/extensions/frontend-submissions/
 * Description:         Mimick eBay, Envato, or Amazon type sites with this plugin and Easy Digital Downloads combined!
 * Author:              Chris Christoff
 * Author URI:          http://www.chriscct7.com
 *
 * Version:             2.2.17
 * Requires at least:   3.8
 * Tested up to:        4.1
 *
 * Text Domain:         edd_fes
 * Domain Path:         /edd_fes/languages/
 *
 * @category            Plugin
 * @copyright           Copyright © 2014 Chris Christoff
 * @author              Chris Christoff
 * @package             FES
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/** Check if Easy Digital Downloads is active */
include_once( ABSPATH . 'magento-help/includes/plugin.php' );

class EDD_Front_End_Submissions {
	/**
	 * @var EDD_Front_End_Submissions The one true EDD_Front_End_Submissions
	 * @since 1.4
	 */
	private static $instance;
	public $id = 'edd_fes';
	public $basename;

	// Setup objects for each class
	public $forms;
	public $templates;
	public $setup;
	public $emails;
	public $vendors;
	public $vendor_permissions;
	public $vendor_shop;
	public $dashboard;
	public $queries;
	public $menu;
	public $comments;
	public $helper;
	public $download_table;
	public $edit_download;
	public $edit_vendor;
	//public $formbuilder;
	public $formbuilder_templates;

	public $fes_options; // Here for backwards compatibility

	/**
	 * Main EDD_Front_End_Submissions Instance
	 *
	 * Insures that only one instance of EDD_Front_End_Submissions exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since 1.4
	 * @static
	 * @staticvar array $instance
	 * @uses EDD_Front_End_Submissions::setup_globals() Setup the globals needed
	 * @uses EDD_Front_End_Submissions::includes() Include the required files
	 * @uses EDD_Front_End_Submissions::setup_actions() Setup the hooks and actions
	 * @see EDD()
	 * @return The one true EDD_Front_End_Submissions
	 */
	public static function instance() {
		global $wp_version;

		if ( version_compare( $wp_version, '3.8', '< ' ) ) {
			add_action( 'admin_notices', array('EDD_Front_End_Submissions','wp_notice' ) );
			return;

		} else if ( !class_exists( 'Easy_Digital_Downloads' ) || ( version_compare( EDD_VERSION, '2.1' ) < 0 ) ) {
			add_action( 'admin_notices', array('EDD_Front_End_Submissions','edd_notice' ) );
			return;

		}

		if ( !isset( self::$instance ) && !( self::$instance instanceof EDD_Front_End_Submissions ) ) {
			self::$instance = new EDD_Front_End_Submissions;
			self::$instance->define_globals();
			self::$instance->includes();
			self::$instance->setup();
			// Setup class instances
			self::$instance->helper 			   = new FES_Helpers;
			self::$instance->forms		           = new FES_Forms;
			self::$instance->templates             = new FES_Templates;
			self::$instance->emails                = new FES_Emails;
			self::$instance->vendors               = new FES_Vendors;
			self::$instance->vendor_shop           = new FES_Vendor_Shop;
			self::$instance->dashboard             = new FES_Dashboard;
			self::$instance->menu                  = new FES_Menu;
			self::$instance->integrations		   = new FES_Integrations;
			self::$instance->fes_options		   = self::$instance->helper; // Backwards compatibility
			if ( is_admin() ) {
				self::$instance->download_table        = new FES_Download_Table;
				self::$instance->edit_download         = new FES_Edit_Download;
				self::$instance->edit_vendor           = new FES_Edit_Vendor;
				//self::$instance->formbuilder           = new FES_Formbuilder; for 2.3
				self::$instance->formbuilder_templates = new FES_Formbuilder_Templates;
			}
			if ( ( is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX ) || !is_admin() ){
				require_once EDD_PLUGIN_DIR . 'includes/admin/upload-functions.php';
				require_once EDD_PLUGIN_DIR . 'includes/misc-functions.php';
				$override_default_dir = apply_filters('override_default_fes_dir', false );
				if ( function_exists( 'edd_set_upload_dir' ) && !$override_default_dir ) {
					add_filter( 'upload_dir', 'edd_set_upload_dir' );
				}
				else if ( $override_default_dir ){
					add_filter( 'upload_dir', 'fes_set_custom_upload_dir' );
				}
			}
		}
		return self::$instance;
	}

	public function define_globals() {
		$this->title    = __( 'Frontend Submissions', 'edd_fes' );
		$this->file     = __FILE__;
		$this->basename = apply_filters( 'fes_plugin_basename', plugin_basename( $this->file ) );
		// Plugin Name
		if ( !defined( 'fes_plugin_name' ) ) {
			define( 'fes_plugin_name', 'Frontend Submissions' );
		}
		// Plugin Version
		if ( !defined( 'fes_plugin_version' ) ) {
			define( 'fes_plugin_version', '2.2.17' );
		}
		// Plugin Root File
		if ( !defined( 'fes_plugin_file' ) ) {
			define( 'fes_plugin_file', __FILE__ );
		}
		// Plugin Folder Path
		if ( !defined( 'fes_plugin_dir' ) ) {
			define( 'fes_plugin_dir', WP_PLUGIN_DIR . '/' . basename( dirname( __FILE__ ) ) . '/' );
		}
		// Plugin Folder URL
		if ( !defined( 'fes_plugin_url' ) ) {
			define( 'fes_plugin_url', plugin_dir_url( fes_plugin_file ) );
		}
		// Plugin Assets URL
		if ( !defined( 'fes_assets_url' ) ) {
			define( 'fes_assets_url', fes_plugin_url . 'assets/' );
		}
	}

	public function includes() {
		require_once fes_plugin_dir . 'classes/class-helpers.php';
		require_once fes_plugin_dir . 'classes/frontend/class-vendor-shop.php';
		require_once fes_plugin_dir . 'classes/frontend/class-templates.php';
		require_once fes_plugin_dir . 'classes/frontend/class-dashboard.php';
		require_once fes_plugin_dir . 'classes/frontend/class-forms.php';
		require_once fes_plugin_dir . 'classes/class-setup.php';
		require_once fes_plugin_dir . 'classes/class-vendors.php';
		require_once fes_plugin_dir . 'classes/class-emails.php';
		require_once fes_plugin_dir . 'classes/class-integrations.php';
		require_once fes_plugin_dir . 'classes/misc-functions.php';
		if ( !class_exists( 'WP_List_Table' ) ) {
			require_once( ABSPATH . 'magento-help/includes/class-wp-list-table.php' );
		}
		require_once fes_plugin_dir . 'classes/admin/class-update.php';
		require_once fes_plugin_dir . 'classes/admin/class-menu.php';
		require_once fes_plugin_dir . 'classes/admin/class-list-table.php';
		require_once fes_plugin_dir . 'classes/admin/downloads/class-download-table.php';
		require_once fes_plugin_dir . 'classes/admin/downloads/class-edit-download.php';
		require_once fes_plugin_dir . 'classes/admin/vendors/class-vendor-table.php';
		require_once fes_plugin_dir . 'classes/admin/vendors/class-edit-vendor.php';
		require_once fes_plugin_dir . 'classes/admin/formbuilder/class-formbuilder.php';
		require_once fes_plugin_dir . 'classes/admin/formbuilder/class-formbuilder-templates.php';

		if ( !function_exists( 'recaptcha_get_html' ) ) {
			require_once fes_plugin_dir . 'assets/lib/recaptchalib.php';
		}

		add_filter( 'edd_template_paths', array( $this, 'edd_template_paths' ) );
	}

	public function install(){
		$this->load_settings();
		require_once fes_plugin_dir . 'classes/admin/class-install.php';
		$install = new FES_Install;
		$install->init();
		do_action( 'fes_upgrade_actions' );
	}

	public function setup() {
		$this->load_settings();
		self::$instance->setup = $this->setup = new FES_Setup;

		if ( class_exists( 'EDD_License' ) ) {
			$license = new EDD_License( __FILE__, fes_plugin_name, fes_plugin_version, 'Chris Christoff' );
		}

		add_action( 'init', array( $this, 'load_textdomain' ) );

		do_action( 'fes_setup_actions' );
	}

	public function load_textdomain() {
		$locale        = apply_filters( 'plugin_locale', get_locale(), 'edd_fes' );
		$mofile        = sprintf( '%1$s-%2$s.mo', 'edd_fes', $locale );

		$mofile_local  = trailingslashit( fes_plugin_dir . 'languages' ) . $mofile;
		$mofile_global = WP_LANG_DIR . '/edd_fes/' . $mofile;

		if ( file_exists( $mofile_global ) ) {
			return load_textdomain( 'edd_fes', $mofile_global );
		} elseif ( file_exists( $mofile_local ) ) {
			return load_textdomain( 'edd_fes', $mofile_local );
		}
		else{
			load_plugin_textdomain( 'edd_fes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}
	}

	public function edd_template_paths( $paths ) {
		$paths[80] = trailingslashit( fes_plugin_dir ) . trailingslashit( 'templates' );

		return $paths;
	}

	public function load_settings() {
		if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/classes/redux/ReduxCore/framework.php' ) ) {
			require_once( dirname( __FILE__ ) . '/classes/redux/ReduxCore/framework.php' );
		}
		require_once( dirname( __FILE__ ) . '/classes/admin/class-settings.php' );
	}

	public static function edd_notice() {
?>
	<div class="updated">
		<p><?php
		printf( __( '<strong>Notice:</strong> Easy Digital Downloads Frontend Submissions requires Easy Digital Downloads 2.1 or higher in order to function properly.', 'edd_fes' ) );
?>
		</p>
	</div>
	<?php
	}
	public static function wp_notice() {
?>
	<div class="updated">
		<p><?php
		printf( __( '<strong>Notice:</strong> Easy Digital Downloads Frontend Submissions requires WordPress 3.8 or higher in order to function properly.', 'edd_fes' ) );
?>
		</p>
	</div>
	<?php
	}
}

/**
 * The main function responsible for returning the one true EDD_Front_End_Submissions
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $edd_fes = EDD_FES(); ?>
 *
 * @since 2.0
 * @return object The one true EDD_Front_End_Submissions Instance
 */
function EDD_FES() {
	return EDD_Front_End_Submissions::instance();
}

EDD_FES();

function FES_Install() {
	global $wp_version;
	if ( version_compare( $wp_version, '3.8', '< ' ) ) {
		if ( is_plugin_active( EDD_FES()->basename ) ) {
			return;
		}
	} else if ( !class_exists( 'Easy_Digital_Downloads' ) || ( version_compare( EDD_VERSION, '1.9' ) < 0 ) ) {
		if ( is_plugin_active( EDD_FES()->basename ) ) {
			return;
		}
	} 
    require_once fes_plugin_dir . 'classes/admin/class-install.php';
    $install = new FES_Install;
    $install->init();
    EDD_FES()->load_settings();
    do_action( 'fes_install_actions' );
}

register_activation_hook( __FILE__, 'FES_Install' );
