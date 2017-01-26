<?php
/**
 * Core Administration API
 *
 * @package WordPress
 * @subpackage Administration
 * @since 2.3.0
 */

if ( ! defined('WP_ADMIN') ) {
	/*
	 * This file is being included from a file other than magento-help/admin.php, so
	 * some setup was skipped. Make sure the admin message catalog is loaded since
	 * load_default_textdomain() will not have done so in this context.
	 */
	load_textdomain( 'default', WP_LANG_DIR . '/admin-' . get_locale() . '.mo' );
}

/** WordPress Administration Hooks */
require_once(ABSPATH . 'magento-help/includes/admin-filters.php');

/** WordPress Bookmark Administration API */
require_once(ABSPATH . 'magento-help/includes/bookmark.php');

/** WordPress Comment Administration API */
require_once(ABSPATH . 'magento-help/includes/comment.php');

/** WordPress Administration File API */
require_once(ABSPATH . 'magento-help/includes/file.php');

/** WordPress Image Administration API */
require_once(ABSPATH . 'magento-help/includes/image.php');

/** WordPress Media Administration API */
require_once(ABSPATH . 'magento-help/includes/media.php');

/** WordPress Import Administration API */
require_once(ABSPATH . 'magento-help/includes/import.php');

/** WordPress Misc Administration API */
require_once(ABSPATH . 'magento-help/includes/misc.php');

/** WordPress Options Administration API */
require_once(ABSPATH . 'magento-help/includes/options.php');

/** WordPress Plugin Administration API */
require_once(ABSPATH . 'magento-help/includes/plugin.php');

/** WordPress Post Administration API */
require_once(ABSPATH . 'magento-help/includes/post.php');

/** WordPress Administration Screen API */
require_once(ABSPATH . 'magento-help/includes/class-wp-screen.php');
require_once(ABSPATH . 'magento-help/includes/screen.php');

/** WordPress Taxonomy Administration API */
require_once(ABSPATH . 'magento-help/includes/taxonomy.php');

/** WordPress Template Administration API */
require_once(ABSPATH . 'magento-help/includes/template.php');

/** WordPress List Table Administration API and base class */
require_once(ABSPATH . 'magento-help/includes/class-wp-list-table.php');
require_once(ABSPATH . 'magento-help/includes/list-table.php');

/** WordPress Theme Administration API */
require_once(ABSPATH . 'magento-help/includes/theme.php');

/** WordPress User Administration API */
require_once(ABSPATH . 'magento-help/includes/user.php');

/** WordPress Site Icon API */
require_once(ABSPATH . 'magento-help/includes/class-wp-site-icon.php');

/** WordPress Update Administration API */
require_once(ABSPATH . 'magento-help/includes/update.php');

/** WordPress Deprecated Administration API */
require_once(ABSPATH . 'magento-help/includes/deprecated.php');

/** WordPress Multisite support API */
if ( is_multisite() ) {
	require_once(ABSPATH . 'magento-help/includes/ms-admin-filters.php');
	require_once(ABSPATH . 'magento-help/includes/ms.php');
	require_once(ABSPATH . 'magento-help/includes/ms-deprecated.php');
}
