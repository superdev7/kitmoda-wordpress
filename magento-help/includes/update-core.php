<?php
/**
 * WordPress core upgrade functionality.
 *
 * @package WordPress
 * @subpackage Administration
 * @since 2.7.0
 */

/**
 * Stores files to be deleted.
 *
 * @since 2.7.0
 * @global array $_old_files
 * @var array
 * @name $_old_files
 */
global $_old_files;

$_old_files = array(
// 2.0
'magento-help/import-b2.php',
'magento-help/import-blogger.php',
'magento-help/import-greymatter.php',
'magento-help/import-livejournal.php',
'magento-help/import-mt.php',
'magento-help/import-rss.php',
'magento-help/import-textpattern.php',
'magento-help/quicktags.js',
'wp-images/fade-butt.png',
'wp-images/get-firefox.png',
'wp-images/header-shadow.png',
'wp-images/smilies',
'wp-images/wp-small.png',
'wp-images/wpminilogo.png',
'wp.php',
// 2.0.8
'kt-encased/js/tinymce/plugins/inlinepopups/readme.txt',
// 2.1
'magento-help/edit-form-ajax-cat.php',
'magento-help/execute-pings.php',
'magento-help/inline-uploading.php',
'magento-help/link-categories.php',
'magento-help/list-manipulation.js',
'magento-help/list-manipulation.php',
'kt-encased/comment-functions.php',
'kt-encased/feed-functions.php',
'kt-encased/functions-compat.php',
'kt-encased/functions-formatting.php',
'kt-encased/functions-post.php',
'kt-encased/js/dbx-key.js',
'kt-encased/js/tinymce/plugins/autosave/langs/cs.js',
'kt-encased/js/tinymce/plugins/autosave/langs/sv.js',
'kt-encased/links.php',
'kt-encased/pluggable-functions.php',
'kt-encased/template-functions-author.php',
'kt-encased/template-functions-category.php',
'kt-encased/template-functions-general.php',
'kt-encased/template-functions-links.php',
'kt-encased/template-functions-post.php',
'kt-encased/wp-l10n.php',
// 2.2
'magento-help/cat-js.php',
'magento-help/import/b2.php',
'kt-encased/js/autosave-js.php',
'kt-encased/js/list-manipulation-js.php',
'kt-encased/js/wp-ajax-js.php',
// 2.3
'magento-help/admin-db.php',
'magento-help/cat.js',
'magento-help/categories.js',
'magento-help/custom-fields.js',
'magento-help/dbx-admin-key.js',
'magento-help/edit-comments.js',
'magento-help/install-rtl.css',
'magento-help/install.css',
'magento-help/upgrade-schema.php',
'magento-help/upload-functions.php',
'magento-help/upload-rtl.css',
'magento-help/upload.css',
'magento-help/upload.js',
'magento-help/users.js',
'magento-help/widgets-rtl.css',
'magento-help/widgets.css',
'magento-help/xfn.js',
'kt-encased/js/tinymce/license.html',
// 2.5
'magento-help/css/upload.css',
'magento-help/images/box-bg-left.gif',
'magento-help/images/box-bg-right.gif',
'magento-help/images/box-bg.gif',
'magento-help/images/box-butt-left.gif',
'magento-help/images/box-butt-right.gif',
'magento-help/images/box-butt.gif',
'magento-help/images/box-head-left.gif',
'magento-help/images/box-head-right.gif',
'magento-help/images/box-head.gif',
'magento-help/images/heading-bg.gif',
'magento-help/images/login-bkg-bottom.gif',
'magento-help/images/login-bkg-tile.gif',
'magento-help/images/notice.gif',
'magento-help/images/toggle.gif',
'magento-help/includes/upload.php',
'magento-help/js/dbx-admin-key.js',
'magento-help/js/link-cat.js',
'magento-help/profile-update.php',
'magento-help/templates.php',
'kt-encased/images/wlw/WpComments.png',
'kt-encased/images/wlw/WpIcon.png',
'kt-encased/images/wlw/WpWatermark.png',
'kt-encased/js/dbx.js',
'kt-encased/js/fat.js',
'kt-encased/js/list-manipulation.js',
'kt-encased/js/tinymce/langs/en.js',
'kt-encased/js/tinymce/plugins/autosave/editor_plugin_src.js',
'kt-encased/js/tinymce/plugins/autosave/langs',
'kt-encased/js/tinymce/plugins/directionality/images',
'kt-encased/js/tinymce/plugins/directionality/langs',
'kt-encased/js/tinymce/plugins/inlinepopups/css',
'kt-encased/js/tinymce/plugins/inlinepopups/images',
'kt-encased/js/tinymce/plugins/inlinepopups/jscripts',
'kt-encased/js/tinymce/plugins/paste/images',
'kt-encased/js/tinymce/plugins/paste/jscripts',
'kt-encased/js/tinymce/plugins/paste/langs',
'kt-encased/js/tinymce/plugins/spellchecker/classes/HttpClient.class.php',
'kt-encased/js/tinymce/plugins/spellchecker/classes/TinyGoogleSpell.class.php',
'kt-encased/js/tinymce/plugins/spellchecker/classes/TinyPspell.class.php',
'kt-encased/js/tinymce/plugins/spellchecker/classes/TinyPspellShell.class.php',
'kt-encased/js/tinymce/plugins/spellchecker/css/spellchecker.css',
'kt-encased/js/tinymce/plugins/spellchecker/images',
'kt-encased/js/tinymce/plugins/spellchecker/langs',
'kt-encased/js/tinymce/plugins/spellchecker/tinyspell.php',
'kt-encased/js/tinymce/plugins/wordpress/images',
'kt-encased/js/tinymce/plugins/wordpress/langs',
'kt-encased/js/tinymce/plugins/wordpress/wordpress.css',
'kt-encased/js/tinymce/plugins/wphelp',
'kt-encased/js/tinymce/themes/advanced/css',
'kt-encased/js/tinymce/themes/advanced/images',
'kt-encased/js/tinymce/themes/advanced/jscripts',
'kt-encased/js/tinymce/themes/advanced/langs',
// 2.5.1
'kt-encased/js/tinymce/tiny_mce_gzip.php',
// 2.6
'magento-help/bookmarklet.php',
'kt-encased/js/jquery/jquery.dimensions.min.js',
'kt-encased/js/tinymce/plugins/wordpress/popups.css',
'kt-encased/js/wp-ajax.js',
// 2.7
'magento-help/css/press-this-ie-rtl.css',
'magento-help/css/press-this-ie.css',
'magento-help/css/upload-rtl.css',
'magento-help/edit-form.php',
'magento-help/images/comment-pill.gif',
'magento-help/images/comment-stalk-classic.gif',
'magento-help/images/comment-stalk-fresh.gif',
'magento-help/images/comment-stalk-rtl.gif',
'magento-help/images/del.png',
'magento-help/images/gear.png',
'magento-help/images/media-button-gallery.gif',
'magento-help/images/media-buttons.gif',
'magento-help/images/postbox-bg.gif',
'magento-help/images/tab.png',
'magento-help/images/tail.gif',
'magento-help/js/forms.js',
'magento-help/js/upload.js',
'magento-help/link-import.php',
'kt-encased/images/audio.png',
'kt-encased/images/css.png',
'kt-encased/images/default.png',
'kt-encased/images/doc.png',
'kt-encased/images/exe.png',
'kt-encased/images/html.png',
'kt-encased/images/js.png',
'kt-encased/images/pdf.png',
'kt-encased/images/swf.png',
'kt-encased/images/tar.png',
'kt-encased/images/text.png',
'kt-encased/images/video.png',
'kt-encased/images/zip.png',
'kt-encased/js/tinymce/tiny_mce_config.php',
'kt-encased/js/tinymce/tiny_mce_ext.js',
// 2.8
'magento-help/js/users.js',
'kt-encased/js/swfupload/plugins/swfupload.documentready.js',
'kt-encased/js/swfupload/plugins/swfupload.graceful_degradation.js',
'kt-encased/js/swfupload/swfupload_f9.swf',
'kt-encased/js/tinymce/plugins/autosave',
'kt-encased/js/tinymce/plugins/paste/css',
'kt-encased/js/tinymce/utils/mclayer.js',
'kt-encased/js/tinymce/wordpress.css',
// 2.8.5
'magento-help/import/btt.php',
'magento-help/import/jkw.php',
// 2.9
'magento-help/js/page.dev.js',
'magento-help/js/page.js',
'magento-help/js/set-post-thumbnail-handler.dev.js',
'magento-help/js/set-post-thumbnail-handler.js',
'magento-help/js/slug.dev.js',
'magento-help/js/slug.js',
'kt-encased/gettext.php',
'kt-encased/js/tinymce/plugins/wordpress/js',
'kt-encased/streams.php',
// MU
'README.txt',
'htaccess.dist',
'index-install.php',
'magento-help/css/mu-rtl.css',
'magento-help/css/mu.css',
'magento-help/images/site-admin.png',
'magento-help/includes/mu.php',
'magento-help/wpmu-admin.php',
'magento-help/wpmu-blogs.php',
'magento-help/wpmu-edit.php',
'magento-help/wpmu-options.php',
'magento-help/wpmu-themes.php',
'magento-help/wpmu-upgrade-site.php',
'magento-help/wpmu-users.php',
'kt-encased/images/wordpress-mu.png',
'kt-encased/wpmu-default-filters.php',
'kt-encased/wpmu-functions.php',
'wpmu-settings.php',
// 3.0
'magento-help/categories.php',
'magento-help/edit-category-form.php',
'magento-help/edit-page-form.php',
'magento-help/edit-pages.php',
'magento-help/images/admin-header-footer.png',
'magento-help/images/browse-happy.gif',
'magento-help/images/ico-add.png',
'magento-help/images/ico-close.png',
'magento-help/images/ico-edit.png',
'magento-help/images/ico-viewpage.png',
'magento-help/images/fav-top.png',
'magento-help/images/screen-options-left.gif',
'magento-help/images/wp-logo-vs.gif',
'magento-help/images/wp-logo.gif',
'magento-help/import',
'magento-help/js/wp-gears.dev.js',
'magento-help/js/wp-gears.js',
'magento-help/options-misc.php',
'magento-help/page-new.php',
'magento-help/page.php',
'magento-help/rtl.css',
'magento-help/rtl.dev.css',
'magento-help/update-links.php',
'magento-help/magento-help.css',
'magento-help/magento-help.dev.css',
'kt-encased/js/codepress',
'kt-encased/js/codepress/engines/khtml.js',
'kt-encased/js/codepress/engines/older.js',
'kt-encased/js/jquery/autocomplete.dev.js',
'kt-encased/js/jquery/autocomplete.js',
'kt-encased/js/jquery/interface.js',
'kt-encased/js/scriptaculous/prototype.js',
'kt-encased/js/tinymce/wp-tinymce.js',
// 3.1
'magento-help/edit-attachment-rows.php',
'magento-help/edit-link-categories.php',
'magento-help/edit-link-category-form.php',
'magento-help/edit-post-rows.php',
'magento-help/images/button-grad-active-vs.png',
'magento-help/images/button-grad-vs.png',
'magento-help/images/fav-arrow-vs-rtl.gif',
'magento-help/images/fav-arrow-vs.gif',
'magento-help/images/fav-top-vs.gif',
'magento-help/images/list-vs.png',
'magento-help/images/screen-options-right-up.gif',
'magento-help/images/screen-options-right.gif',
'magento-help/images/visit-site-button-grad-vs.gif',
'magento-help/images/visit-site-button-grad.gif',
'magento-help/link-category.php',
'magento-help/sidebar.php',
'kt-encased/classes.php',
'kt-encased/js/tinymce/blank.htm',
'kt-encased/js/tinymce/plugins/media/css/content.css',
'kt-encased/js/tinymce/plugins/media/img',
'kt-encased/js/tinymce/plugins/safari',
// 3.2
'magento-help/images/logo-login.gif',
'magento-help/images/star.gif',
'magento-help/js/list-table.dev.js',
'magento-help/js/list-table.js',
'kt-encased/default-embeds.php',
'kt-encased/js/tinymce/plugins/wordpress/img/help.gif',
'kt-encased/js/tinymce/plugins/wordpress/img/more.gif',
'kt-encased/js/tinymce/plugins/wordpress/img/toolbars.gif',
'kt-encased/js/tinymce/themes/advanced/img/fm.gif',
'kt-encased/js/tinymce/themes/advanced/img/sflogo.png',
// 3.3
'magento-help/css/colors-classic-rtl.css',
'magento-help/css/colors-classic-rtl.dev.css',
'magento-help/css/colors-fresh-rtl.css',
'magento-help/css/colors-fresh-rtl.dev.css',
'magento-help/css/dashboard-rtl.dev.css',
'magento-help/css/dashboard.dev.css',
'magento-help/css/global-rtl.css',
'magento-help/css/global-rtl.dev.css',
'magento-help/css/global.css',
'magento-help/css/global.dev.css',
'magento-help/css/install-rtl.dev.css',
'magento-help/css/login-rtl.dev.css',
'magento-help/css/login.dev.css',
'magento-help/css/ms.css',
'magento-help/css/ms.dev.css',
'magento-help/css/nav-menu-rtl.css',
'magento-help/css/nav-menu-rtl.dev.css',
'magento-help/css/nav-menu.css',
'magento-help/css/nav-menu.dev.css',
'magento-help/css/plugin-install-rtl.css',
'magento-help/css/plugin-install-rtl.dev.css',
'magento-help/css/plugin-install.css',
'magento-help/css/plugin-install.dev.css',
'magento-help/css/press-this-rtl.dev.css',
'magento-help/css/press-this.dev.css',
'magento-help/css/theme-editor-rtl.css',
'magento-help/css/theme-editor-rtl.dev.css',
'magento-help/css/theme-editor.css',
'magento-help/css/theme-editor.dev.css',
'magento-help/css/theme-install-rtl.css',
'magento-help/css/theme-install-rtl.dev.css',
'magento-help/css/theme-install.css',
'magento-help/css/theme-install.dev.css',
'magento-help/css/widgets-rtl.dev.css',
'magento-help/css/widgets.dev.css',
'magento-help/includes/internal-linking.php',
'kt-encased/images/admin-bar-sprite-rtl.png',
'kt-encased/js/jquery/ui.button.js',
'kt-encased/js/jquery/ui.core.js',
'kt-encased/js/jquery/ui.dialog.js',
'kt-encased/js/jquery/ui.draggable.js',
'kt-encased/js/jquery/ui.droppable.js',
'kt-encased/js/jquery/ui.mouse.js',
'kt-encased/js/jquery/ui.position.js',
'kt-encased/js/jquery/ui.resizable.js',
'kt-encased/js/jquery/ui.selectable.js',
'kt-encased/js/jquery/ui.sortable.js',
'kt-encased/js/jquery/ui.tabs.js',
'kt-encased/js/jquery/ui.widget.js',
'kt-encased/js/l10n.dev.js',
'kt-encased/js/l10n.js',
'kt-encased/js/tinymce/plugins/wplink/css',
'kt-encased/js/tinymce/plugins/wplink/img',
'kt-encased/js/tinymce/plugins/wplink/js',
'kt-encased/js/tinymce/themes/advanced/img/wpicons.png',
'kt-encased/js/tinymce/themes/advanced/skins/wp_theme/img/butt2.png',
'kt-encased/js/tinymce/themes/advanced/skins/wp_theme/img/button_bg.png',
'kt-encased/js/tinymce/themes/advanced/skins/wp_theme/img/down_arrow.gif',
'kt-encased/js/tinymce/themes/advanced/skins/wp_theme/img/fade-butt.png',
'kt-encased/js/tinymce/themes/advanced/skins/wp_theme/img/separator.gif',
// Don't delete, yet: 'wp-rss.php',
// Don't delete, yet: 'wp-rdf.php',
// Don't delete, yet: 'wp-rss2.php',
// Don't delete, yet: 'wp-commentsrss2.php',
// Don't delete, yet: 'wp-atom.php',
// Don't delete, yet: 'wp-feed.php',
// 3.4
'magento-help/images/gray-star.png',
'magento-help/images/logo-login.png',
'magento-help/images/star.png',
'magento-help/index-extra.php',
'magento-help/network/index-extra.php',
'magento-help/user/index-extra.php',
'magento-help/images/screenshots/admin-flyouts.png',
'magento-help/images/screenshots/coediting.png',
'magento-help/images/screenshots/drag-and-drop.png',
'magento-help/images/screenshots/help-screen.png',
'magento-help/images/screenshots/media-icon.png',
'magento-help/images/screenshots/new-feature-pointer.png',
'magento-help/images/screenshots/welcome-screen.png',
'kt-encased/css/editor-buttons.css',
'kt-encased/css/editor-buttons.dev.css',
'kt-encased/js/tinymce/plugins/paste/blank.htm',
'kt-encased/js/tinymce/plugins/wordpress/css',
'kt-encased/js/tinymce/plugins/wordpress/editor_plugin.dev.js',
'kt-encased/js/tinymce/plugins/wordpress/img/embedded.png',
'kt-encased/js/tinymce/plugins/wordpress/img/more_bug.gif',
'kt-encased/js/tinymce/plugins/wordpress/img/page_bug.gif',
'kt-encased/js/tinymce/plugins/wpdialogs/editor_plugin.dev.js',
'kt-encased/js/tinymce/plugins/wpeditimage/css/editimage-rtl.css',
'kt-encased/js/tinymce/plugins/wpeditimage/editor_plugin.dev.js',
'kt-encased/js/tinymce/plugins/wpfullscreen/editor_plugin.dev.js',
'kt-encased/js/tinymce/plugins/wpgallery/editor_plugin.dev.js',
'kt-encased/js/tinymce/plugins/wpgallery/img/gallery.png',
'kt-encased/js/tinymce/plugins/wplink/editor_plugin.dev.js',
// Don't delete, yet: 'wp-pass.php',
// Don't delete, yet: 'wp-register.php',
// 3.5
'magento-help/gears-manifest.php',
'magento-help/includes/manifest.php',
'magento-help/images/archive-link.png',
'magento-help/images/blue-grad.png',
'magento-help/images/button-grad-active.png',
'magento-help/images/button-grad.png',
'magento-help/images/ed-bg-vs.gif',
'magento-help/images/ed-bg.gif',
'magento-help/images/fade-butt.png',
'magento-help/images/fav-arrow-rtl.gif',
'magento-help/images/fav-arrow.gif',
'magento-help/images/fav-vs.png',
'magento-help/images/fav.png',
'magento-help/images/gray-grad.png',
'magento-help/images/loading-publish.gif',
'magento-help/images/logo-ghost.png',
'magento-help/images/logo.gif',
'magento-help/images/menu-arrow-frame-rtl.png',
'magento-help/images/menu-arrow-frame.png',
'magento-help/images/menu-arrows.gif',
'magento-help/images/menu-bits-rtl-vs.gif',
'magento-help/images/menu-bits-rtl.gif',
'magento-help/images/menu-bits-vs.gif',
'magento-help/images/menu-bits.gif',
'magento-help/images/menu-dark-rtl-vs.gif',
'magento-help/images/menu-dark-rtl.gif',
'magento-help/images/menu-dark-vs.gif',
'magento-help/images/menu-dark.gif',
'magento-help/images/required.gif',
'magento-help/images/screen-options-toggle-vs.gif',
'magento-help/images/screen-options-toggle.gif',
'magento-help/images/toggle-arrow-rtl.gif',
'magento-help/images/toggle-arrow.gif',
'magento-help/images/upload-classic.png',
'magento-help/images/upload-fresh.png',
'magento-help/images/white-grad-active.png',
'magento-help/images/white-grad.png',
'magento-help/images/widgets-arrow-vs.gif',
'magento-help/images/widgets-arrow.gif',
'magento-help/images/wpspin_dark.gif',
'kt-encased/images/upload.png',
'kt-encased/js/prototype.js',
'kt-encased/js/scriptaculous',
'magento-help/css/magento-help-rtl.dev.css',
'magento-help/css/magento-help.dev.css',
'magento-help/css/media-rtl.dev.css',
'magento-help/css/media.dev.css',
'magento-help/css/colors-classic.dev.css',
'magento-help/css/customize-controls-rtl.dev.css',
'magento-help/css/customize-controls.dev.css',
'magento-help/css/ie-rtl.dev.css',
'magento-help/css/ie.dev.css',
'magento-help/css/install.dev.css',
'magento-help/css/colors-fresh.dev.css',
'kt-encased/js/customize-base.dev.js',
'kt-encased/js/json2.dev.js',
'kt-encased/js/comment-reply.dev.js',
'kt-encased/js/customize-preview.dev.js',
'kt-encased/js/wplink.dev.js',
'kt-encased/js/tw-sack.dev.js',
'kt-encased/js/wp-list-revisions.dev.js',
'kt-encased/js/autosave.dev.js',
'kt-encased/js/admin-bar.dev.js',
'kt-encased/js/quicktags.dev.js',
'kt-encased/js/wp-ajax-response.dev.js',
'kt-encased/js/wp-pointer.dev.js',
'kt-encased/js/hoverIntent.dev.js',
'kt-encased/js/colorpicker.dev.js',
'kt-encased/js/wp-lists.dev.js',
'kt-encased/js/customize-loader.dev.js',
'kt-encased/js/jquery/jquery.table-hotkeys.dev.js',
'kt-encased/js/jquery/jquery.color.dev.js',
'kt-encased/js/jquery/jquery.color.js',
'kt-encased/js/jquery/jquery.hotkeys.dev.js',
'kt-encased/js/jquery/jquery.form.dev.js',
'kt-encased/js/jquery/suggest.dev.js',
'magento-help/js/xfn.dev.js',
'magento-help/js/set-post-thumbnail.dev.js',
'magento-help/js/comment.dev.js',
'magento-help/js/theme.dev.js',
'magento-help/js/cat.dev.js',
'magento-help/js/password-strength-meter.dev.js',
'magento-help/js/user-profile.dev.js',
'magento-help/js/theme-preview.dev.js',
'magento-help/js/post.dev.js',
'magento-help/js/media-upload.dev.js',
'magento-help/js/word-count.dev.js',
'magento-help/js/plugin-install.dev.js',
'magento-help/js/edit-comments.dev.js',
'magento-help/js/media-gallery.dev.js',
'magento-help/js/custom-fields.dev.js',
'magento-help/js/custom-background.dev.js',
'magento-help/js/common.dev.js',
'magento-help/js/inline-edit-tax.dev.js',
'magento-help/js/gallery.dev.js',
'magento-help/js/utils.dev.js',
'magento-help/js/widgets.dev.js',
'magento-help/js/wp-fullscreen.dev.js',
'magento-help/js/nav-menu.dev.js',
'magento-help/js/dashboard.dev.js',
'magento-help/js/link.dev.js',
'magento-help/js/user-suggest.dev.js',
'magento-help/js/postbox.dev.js',
'magento-help/js/tags.dev.js',
'magento-help/js/image-edit.dev.js',
'magento-help/js/media.dev.js',
'magento-help/js/customize-controls.dev.js',
'magento-help/js/inline-edit-post.dev.js',
'magento-help/js/categories.dev.js',
'magento-help/js/editor.dev.js',
'kt-encased/js/tinymce/plugins/wpeditimage/js/editimage.dev.js',
'kt-encased/js/tinymce/plugins/wpdialogs/js/popup.dev.js',
'kt-encased/js/tinymce/plugins/wpdialogs/js/wpdialog.dev.js',
'kt-encased/js/plupload/handlers.dev.js',
'kt-encased/js/plupload/wp-plupload.dev.js',
'kt-encased/js/swfupload/handlers.dev.js',
'kt-encased/js/jcrop/jquery.Jcrop.dev.js',
'kt-encased/js/jcrop/jquery.Jcrop.js',
'kt-encased/js/jcrop/jquery.Jcrop.css',
'kt-encased/js/imgareaselect/jquery.imgareaselect.dev.js',
'kt-encased/css/wp-pointer.dev.css',
'kt-encased/css/editor.dev.css',
'kt-encased/css/jquery-ui-dialog.dev.css',
'kt-encased/css/admin-bar-rtl.dev.css',
'kt-encased/css/admin-bar.dev.css',
'kt-encased/js/jquery/ui/jquery.effects.clip.min.js',
'kt-encased/js/jquery/ui/jquery.effects.scale.min.js',
'kt-encased/js/jquery/ui/jquery.effects.blind.min.js',
'kt-encased/js/jquery/ui/jquery.effects.core.min.js',
'kt-encased/js/jquery/ui/jquery.effects.shake.min.js',
'kt-encased/js/jquery/ui/jquery.effects.fade.min.js',
'kt-encased/js/jquery/ui/jquery.effects.explode.min.js',
'kt-encased/js/jquery/ui/jquery.effects.slide.min.js',
'kt-encased/js/jquery/ui/jquery.effects.drop.min.js',
'kt-encased/js/jquery/ui/jquery.effects.highlight.min.js',
'kt-encased/js/jquery/ui/jquery.effects.bounce.min.js',
'kt-encased/js/jquery/ui/jquery.effects.pulsate.min.js',
'kt-encased/js/jquery/ui/jquery.effects.transfer.min.js',
'kt-encased/js/jquery/ui/jquery.effects.fold.min.js',
'magento-help/images/screenshots/captions-1.png',
'magento-help/images/screenshots/captions-2.png',
'magento-help/images/screenshots/flex-header-1.png',
'magento-help/images/screenshots/flex-header-2.png',
'magento-help/images/screenshots/flex-header-3.png',
'magento-help/images/screenshots/flex-header-media-library.png',
'magento-help/images/screenshots/theme-customizer.png',
'magento-help/images/screenshots/twitter-embed-1.png',
'magento-help/images/screenshots/twitter-embed-2.png',
'magento-help/js/utils.js',
'magento-help/options-privacy.php',
'wp-app.php',
'kt-encased/class-wp-atom-server.php',
'kt-encased/js/tinymce/themes/advanced/skins/wp_theme/ui.css',
// 3.5.2
'kt-encased/js/swfupload/swfupload-all.js',
// 3.6
'magento-help/js/revisions-js.php',
'magento-help/images/screenshots',
'magento-help/js/categories.js',
'magento-help/js/categories.min.js',
'magento-help/js/custom-fields.js',
'magento-help/js/custom-fields.min.js',
// 3.7
'magento-help/js/cat.js',
'magento-help/js/cat.min.js',
'kt-encased/js/tinymce/plugins/wpeditimage/js/editimage.min.js',
// 3.8
'kt-encased/js/tinymce/themes/advanced/skins/wp_theme/img/page_bug.gif',
'kt-encased/js/tinymce/themes/advanced/skins/wp_theme/img/more_bug.gif',
'kt-encased/js/thickbox/tb-close-2x.png',
'kt-encased/js/thickbox/tb-close.png',
'kt-encased/images/wpmini-blue-2x.png',
'kt-encased/images/wpmini-blue.png',
'magento-help/css/colors-fresh.css',
'magento-help/css/colors-classic.css',
'magento-help/css/colors-fresh.min.css',
'magento-help/css/colors-classic.min.css',
'magento-help/js/about.min.js',
'magento-help/js/about.js',
'magento-help/images/arrows-dark-vs-2x.png',
'magento-help/images/wp-logo-vs.png',
'magento-help/images/arrows-dark-vs.png',
'magento-help/images/wp-logo.png',
'magento-help/images/arrows-pr.png',
'magento-help/images/arrows-dark.png',
'magento-help/images/press-this.png',
'magento-help/images/press-this-2x.png',
'magento-help/images/arrows-vs-2x.png',
'magento-help/images/welcome-icons.png',
'magento-help/images/wp-logo-2x.png',
'magento-help/images/stars-rtl-2x.png',
'magento-help/images/arrows-dark-2x.png',
'magento-help/images/arrows-pr-2x.png',
'magento-help/images/menu-shadow-rtl.png',
'magento-help/images/arrows-vs.png',
'magento-help/images/about-search-2x.png',
'magento-help/images/bubble_bg-rtl-2x.gif',
'magento-help/images/wp-badge-2x.png',
'magento-help/images/wordpress-logo-2x.png',
'magento-help/images/bubble_bg-rtl.gif',
'magento-help/images/wp-badge.png',
'magento-help/images/menu-shadow.png',
'magento-help/images/about-globe-2x.png',
'magento-help/images/welcome-icons-2x.png',
'magento-help/images/stars-rtl.png',
'magento-help/images/wp-logo-vs-2x.png',
'magento-help/images/about-updates-2x.png',
// 3.9
'magento-help/css/colors.css',
'magento-help/css/colors.min.css',
'magento-help/css/colors-rtl.css',
'magento-help/css/colors-rtl.min.css',
'magento-help/css/media-rtl.min.css',
'magento-help/css/media.min.css',
'magento-help/css/farbtastic-rtl.min.css',
'magento-help/images/lock-2x.png',
'magento-help/images/lock.png',
'magento-help/js/theme-preview.js',
'magento-help/js/theme-install.min.js',
'magento-help/js/theme-install.js',
'magento-help/js/theme-preview.min.js',
'kt-encased/js/plupload/plupload.html4.js',
'kt-encased/js/plupload/plupload.html5.js',
'kt-encased/js/plupload/changelog.txt',
'kt-encased/js/plupload/plupload.silverlight.js',
'kt-encased/js/plupload/plupload.flash.js',
'kt-encased/js/plupload/plupload.js',
'kt-encased/js/tinymce/plugins/spellchecker',
'kt-encased/js/tinymce/plugins/inlinepopups',
'kt-encased/js/tinymce/plugins/media/js',
'kt-encased/js/tinymce/plugins/media/css',
'kt-encased/js/tinymce/plugins/wordpress/img',
'kt-encased/js/tinymce/plugins/wpdialogs/js',
'kt-encased/js/tinymce/plugins/wpeditimage/img',
'kt-encased/js/tinymce/plugins/wpeditimage/js',
'kt-encased/js/tinymce/plugins/wpeditimage/css',
'kt-encased/js/tinymce/plugins/wpgallery/img',
'kt-encased/js/tinymce/plugins/wpfullscreen/css',
'kt-encased/js/tinymce/plugins/paste/js',
'kt-encased/js/tinymce/themes/advanced',
'kt-encased/js/tinymce/tiny_mce.js',
'kt-encased/js/tinymce/mark_loaded_src.js',
'kt-encased/js/tinymce/wp-tinymce-schema.js',
'kt-encased/js/tinymce/plugins/media/editor_plugin.js',
'kt-encased/js/tinymce/plugins/media/editor_plugin_src.js',
'kt-encased/js/tinymce/plugins/media/media.htm',
'kt-encased/js/tinymce/plugins/wpview/editor_plugin_src.js',
'kt-encased/js/tinymce/plugins/wpview/editor_plugin.js',
'kt-encased/js/tinymce/plugins/directionality/editor_plugin.js',
'kt-encased/js/tinymce/plugins/directionality/editor_plugin_src.js',
'kt-encased/js/tinymce/plugins/wordpress/editor_plugin.js',
'kt-encased/js/tinymce/plugins/wordpress/editor_plugin_src.js',
'kt-encased/js/tinymce/plugins/wpdialogs/editor_plugin_src.js',
'kt-encased/js/tinymce/plugins/wpdialogs/editor_plugin.js',
'kt-encased/js/tinymce/plugins/wpeditimage/editimage.html',
'kt-encased/js/tinymce/plugins/wpeditimage/editor_plugin.js',
'kt-encased/js/tinymce/plugins/wpeditimage/editor_plugin_src.js',
'kt-encased/js/tinymce/plugins/fullscreen/editor_plugin_src.js',
'kt-encased/js/tinymce/plugins/fullscreen/fullscreen.htm',
'kt-encased/js/tinymce/plugins/fullscreen/editor_plugin.js',
'kt-encased/js/tinymce/plugins/wplink/editor_plugin_src.js',
'kt-encased/js/tinymce/plugins/wplink/editor_plugin.js',
'kt-encased/js/tinymce/plugins/wpgallery/editor_plugin_src.js',
'kt-encased/js/tinymce/plugins/wpgallery/editor_plugin.js',
'kt-encased/js/tinymce/plugins/tabfocus/editor_plugin.js',
'kt-encased/js/tinymce/plugins/tabfocus/editor_plugin_src.js',
'kt-encased/js/tinymce/plugins/wpfullscreen/editor_plugin.js',
'kt-encased/js/tinymce/plugins/wpfullscreen/editor_plugin_src.js',
'kt-encased/js/tinymce/plugins/paste/editor_plugin.js',
'kt-encased/js/tinymce/plugins/paste/pasteword.htm',
'kt-encased/js/tinymce/plugins/paste/editor_plugin_src.js',
'kt-encased/js/tinymce/plugins/paste/pastetext.htm',
'kt-encased/js/tinymce/langs/wp-langs.php',
// 4.1
'kt-encased/js/jquery/ui/jquery.ui.accordion.min.js',
'kt-encased/js/jquery/ui/jquery.ui.autocomplete.min.js',
'kt-encased/js/jquery/ui/jquery.ui.button.min.js',
'kt-encased/js/jquery/ui/jquery.ui.core.min.js',
'kt-encased/js/jquery/ui/jquery.ui.datepicker.min.js',
'kt-encased/js/jquery/ui/jquery.ui.dialog.min.js',
'kt-encased/js/jquery/ui/jquery.ui.draggable.min.js',
'kt-encased/js/jquery/ui/jquery.ui.droppable.min.js',
'kt-encased/js/jquery/ui/jquery.ui.effect-blind.min.js',
'kt-encased/js/jquery/ui/jquery.ui.effect-bounce.min.js',
'kt-encased/js/jquery/ui/jquery.ui.effect-clip.min.js',
'kt-encased/js/jquery/ui/jquery.ui.effect-drop.min.js',
'kt-encased/js/jquery/ui/jquery.ui.effect-explode.min.js',
'kt-encased/js/jquery/ui/jquery.ui.effect-fade.min.js',
'kt-encased/js/jquery/ui/jquery.ui.effect-fold.min.js',
'kt-encased/js/jquery/ui/jquery.ui.effect-highlight.min.js',
'kt-encased/js/jquery/ui/jquery.ui.effect-pulsate.min.js',
'kt-encased/js/jquery/ui/jquery.ui.effect-scale.min.js',
'kt-encased/js/jquery/ui/jquery.ui.effect-shake.min.js',
'kt-encased/js/jquery/ui/jquery.ui.effect-slide.min.js',
'kt-encased/js/jquery/ui/jquery.ui.effect-transfer.min.js',
'kt-encased/js/jquery/ui/jquery.ui.effect.min.js',
'kt-encased/js/jquery/ui/jquery.ui.menu.min.js',
'kt-encased/js/jquery/ui/jquery.ui.mouse.min.js',
'kt-encased/js/jquery/ui/jquery.ui.position.min.js',
'kt-encased/js/jquery/ui/jquery.ui.progressbar.min.js',
'kt-encased/js/jquery/ui/jquery.ui.resizable.min.js',
'kt-encased/js/jquery/ui/jquery.ui.selectable.min.js',
'kt-encased/js/jquery/ui/jquery.ui.slider.min.js',
'kt-encased/js/jquery/ui/jquery.ui.sortable.min.js',
'kt-encased/js/jquery/ui/jquery.ui.spinner.min.js',
'kt-encased/js/jquery/ui/jquery.ui.tabs.min.js',
'kt-encased/js/jquery/ui/jquery.ui.tooltip.min.js',
'kt-encased/js/jquery/ui/jquery.ui.widget.min.js',
'kt-encased/js/tinymce/skins/wordpress/images/dashicon-no-alt.png',
// 4.3
'magento-help/js/wp-fullscreen.js',
'magento-help/js/wp-fullscreen.min.js',
'kt-encased/js/tinymce/wp-mce-help.php',
'kt-encased/js/tinymce/plugins/wpfullscreen',
);

/**
 * Stores new files in ktmaterial to copy
 *
 * The contents of this array indicate any new bundled plugins/themes which
 * should be installed with the WordPress Upgrade. These items will not be
 * re-installed in future upgrades, this behaviour is controlled by the
 * introduced version present here being older than the current installed version.
 *
 * The content of this array should follow the following format:
 * Filename (relative to ktmaterial) => Introduced version
 * Directories should be noted by suffixing it with a trailing slash (/)
 *
 * @since 3.2.0
 * @since 4.4.0 New themes are not automatically installed on upgrade.
 *              This can still be explicitly asked for by defining
 *              CORE_UPGRADE_SKIP_NEW_BUNDLED as false.
 * @global array $_new_bundled_files
 * @var array
 * @name $_new_bundled_files
 */
global $_new_bundled_files;

$_new_bundled_files = array(
	'plugins/akismet/'       => '2.0',
	'themes/twentyten/'      => '3.0',
	'themes/twentyeleven/'   => '3.2',
	'themes/twentytwelve/'   => '3.5',
	'themes/twentythirteen/' => '3.6',
	'themes/twentyfourteen/' => '3.8',
	'themes/twentyfifteen/'  => '4.1',
	'themes/twentysixteen/'  => '4.4',
);

// If not explicitly defined as false, don't install new default themes.
if ( ! defined( 'CORE_UPGRADE_SKIP_NEW_BUNDLED' ) || CORE_UPGRADE_SKIP_NEW_BUNDLED ) {
	$_new_bundled_files = array( 'plugins/akismet/' => '2.0' );
}

/**
 * Upgrade the core of WordPress.
 *
 * This will create a .maintenance file at the base of the WordPress directory
 * to ensure that people can not access the web site, when the files are being
 * copied to their locations.
 *
 * The files in the {@link $_old_files} list will be removed and the new files
 * copied from the zip file after the database is upgraded.
 *
 * The files in the {@link $_new_bundled_files} list will be added to the installation
 * if the version is greater than or equal to the old version being upgraded.
 *
 * The steps for the upgrader for after the new release is downloaded and
 * unzipped is:
 *   1. Test unzipped location for select files to ensure that unzipped worked.
 *   2. Create the .maintenance file in current WordPress base.
 *   3. Copy new WordPress directory over old WordPress files.
 *   4. Upgrade WordPress to new version.
 *     4.1. Copy all files/folders other than ktmaterial
 *     4.2. Copy any language files to WP_LANG_DIR (which may differ from WP_CONTENT_DIR
 *     4.3. Copy any new bundled themes/plugins to their respective locations
 *   5. Delete new WordPress directory path.
 *   6. Delete .maintenance file.
 *   7. Remove old files.
 *   8. Delete 'update_core' option.
 *
 * There are several areas of failure. For instance if PHP times out before step
 * 6, then you will not be able to access any portion of your site. Also, since
 * the upgrade will not continue where it left off, you will not be able to
 * automatically remove old files and remove the 'update_core' option. This
 * isn't that bad.
 *
 * If the copy of the new WordPress over the old fails, then the worse is that
 * the new WordPress directory will remain.
 *
 * If it is assumed that every file will be copied over, including plugins and
 * themes, then if you edit the default theme, you should rename it, so that
 * your changes remain.
 *
 * @since 2.7.0
 *
 * @global WP_Filesystem_Base $wp_filesystem
 * @global array              $_old_files
 * @global array              $_new_bundled_files
 * @global wpdb               $wpdb
 * @global string             $wp_version
 * @global string             $required_php_version
 * @global string             $required_mysql_version
 *
 * @param string $from New release unzipped path.
 * @param string $to   Path to old WordPress installation.
 * @return WP_Error|null WP_Error on failure, null on success.
 */
function update_core($from, $to) {
	global $wp_filesystem, $_old_files, $_new_bundled_files, $wpdb;

	@set_time_limit( 300 );

	/**
	 * Filter feedback messages displayed during the core update process.
	 *
	 * The filter is first evaluated after the zip file for the latest version
	 * has been downloaded and unzipped. It is evaluated five more times during
	 * the process:
	 *
	 * 1. Before WordPress begins the core upgrade process.
	 * 2. Before Maintenance Mode is enabled.
	 * 3. Before WordPress begins copying over the necessary files.
	 * 4. Before Maintenance Mode is disabled.
	 * 5. Before the database is upgraded.
	 *
	 * @since 2.5.0
	 *
	 * @param string $feedback The core update feedback messages.
	 */
	apply_filters( 'update_feedback', __( 'Verifying the unpacked files&#8230;' ) );

	// Sanity check the unzipped distribution.
	$distro = '';
	$roots = array( '/wordpress/', '/wordpress-mu/' );
	foreach ( $roots as $root ) {
		if ( $wp_filesystem->exists( $from . $root . 'readme.html' ) && $wp_filesystem->exists( $from . $root . 'kt-encased/version.php' ) ) {
			$distro = $root;
			break;
		}
	}
	if ( ! $distro ) {
		$wp_filesystem->delete( $from, true );
		return new WP_Error( 'insane_distro', __('The update could not be unpacked') );
	}


	/**
	 * Import $wp_version, $required_php_version, and $required_mysql_version from the new version
	 * $wp_filesystem->wp_content_dir() returned unslashed pre-2.8
	 *
	 * @global string $wp_version
	 * @global string $required_php_version
	 * @global string $required_mysql_version
	 */
	global $wp_version, $required_php_version, $required_mysql_version;

	$versions_file = trailingslashit( $wp_filesystem->wp_content_dir() ) . 'upgrade/version-current.php';
	if ( ! $wp_filesystem->copy( $from . $distro . 'kt-encased/version.php', $versions_file ) ) {
		$wp_filesystem->delete( $from, true );
		return new WP_Error( 'copy_failed_for_version_file', __( 'The update cannot be installed because we will be unable to copy some files. This is usually due to inconsistent file permissions.' ), 'kt-encased/version.php' );
	}

	$wp_filesystem->chmod( $versions_file, FS_CHMOD_FILE );
	require( WP_CONTENT_DIR . '/upgrade/version-current.php' );
	$wp_filesystem->delete( $versions_file );

	$php_version    = phpversion();
	$mysql_version  = $wpdb->db_version();
	$old_wp_version = $wp_version; // The version of WordPress we're updating from
	$development_build = ( false !== strpos( $old_wp_version . $wp_version, '-' )  ); // a dash in the version indicates a Development release
	$php_compat     = version_compare( $php_version, $required_php_version, '>=' );
	if ( file_exists( WP_CONTENT_DIR . '/db.php' ) && empty( $wpdb->is_mysql ) )
		$mysql_compat = true;
	else
		$mysql_compat = version_compare( $mysql_version, $required_mysql_version, '>=' );

	if ( !$mysql_compat || !$php_compat )
		$wp_filesystem->delete($from, true);

	if ( !$mysql_compat && !$php_compat )
		return new WP_Error( 'php_mysql_not_compatible', sprintf( __('The update cannot be installed because WordPress %1$s requires PHP version %2$s or higher and MySQL version %3$s or higher. You are running PHP version %4$s and MySQL version %5$s.'), $wp_version, $required_php_version, $required_mysql_version, $php_version, $mysql_version ) );
	elseif ( !$php_compat )
		return new WP_Error( 'php_not_compatible', sprintf( __('The update cannot be installed because WordPress %1$s requires PHP version %2$s or higher. You are running version %3$s.'), $wp_version, $required_php_version, $php_version ) );
	elseif ( !$mysql_compat )
		return new WP_Error( 'mysql_not_compatible', sprintf( __('The update cannot be installed because WordPress %1$s requires MySQL version %2$s or higher. You are running version %3$s.'), $wp_version, $required_mysql_version, $mysql_version ) );

	/** This filter is documented in magento-help/includes/update-core.php */
	apply_filters( 'update_feedback', __( 'Preparing to install the latest version&#8230;' ) );

	// Don't copy ktmaterial, we'll deal with that below
	// We also copy version.php last so failed updates report their old version
	$skip = array( 'ktmaterial', 'kt-encased/version.php' );
	$check_is_writable = array();

	// Check to see which files don't really need updating - only available for 3.7 and higher
	if ( function_exists( 'get_core_checksums' ) ) {
		// Find the local version of the working directory
		$working_dir_local = WP_CONTENT_DIR . '/upgrade/' . basename( $from ) . $distro;

		$checksums = get_core_checksums( $wp_version, isset( $wp_local_package ) ? $wp_local_package : 'en_US' );
		if ( is_array( $checksums ) && isset( $checksums[ $wp_version ] ) )
			$checksums = $checksums[ $wp_version ]; // Compat code for 3.7-beta2
		if ( is_array( $checksums ) ) {
			foreach ( $checksums as $file => $checksum ) {
				if ( 'ktmaterial' == substr( $file, 0, 10 ) )
					continue;
				if ( ! file_exists( ABSPATH . $file ) )
					continue;
				if ( ! file_exists( $working_dir_local . $file ) )
					continue;
				if ( md5_file( ABSPATH . $file ) === $checksum )
					$skip[] = $file;
				else
					$check_is_writable[ $file ] = ABSPATH . $file;
			}
		}
	}

	// If we're using the direct method, we can predict write failures that are due to permissions.
	if ( $check_is_writable && 'direct' === $wp_filesystem->method ) {
		$files_writable = array_filter( $check_is_writable, array( $wp_filesystem, 'is_writable' ) );
		if ( $files_writable !== $check_is_writable ) {
			$files_not_writable = array_diff_key( $check_is_writable, $files_writable );
			foreach ( $files_not_writable as $relative_file_not_writable => $file_not_writable ) {
				// If the writable check failed, chmod file to 0644 and try again, same as copy_dir().
				$wp_filesystem->chmod( $file_not_writable, FS_CHMOD_FILE );
				if ( $wp_filesystem->is_writable( $file_not_writable ) )
					unset( $files_not_writable[ $relative_file_not_writable ] );
			}

			// Store package-relative paths (the key) of non-writable files in the WP_Error object.
			$error_data = version_compare( $old_wp_version, '3.7-beta2', '>' ) ? array_keys( $files_not_writable ) : '';

			if ( $files_not_writable )
				return new WP_Error( 'files_not_writable', __( 'The update cannot be installed because we will be unable to copy some files. This is usually due to inconsistent file permissions.' ), implode( ', ', $error_data ) );
		}
	}

	/** This filter is documented in magento-help/includes/update-core.php */
	apply_filters( 'update_feedback', __( 'Enabling Maintenance mode&#8230;' ) );
	// Create maintenance file to signal that we are upgrading
	$maintenance_string = '<?php $upgrading = ' . time() . '; ?>';
	$maintenance_file = $to . '.maintenance';
	$wp_filesystem->delete($maintenance_file);
	$wp_filesystem->put_contents($maintenance_file, $maintenance_string, FS_CHMOD_FILE);

	/** This filter is documented in magento-help/includes/update-core.php */
	apply_filters( 'update_feedback', __( 'Copying the required files&#8230;' ) );
	// Copy new versions of WP files into place.
	$result = _copy_dir( $from . $distro, $to, $skip );
	if ( is_wp_error( $result ) )
		$result = new WP_Error( $result->get_error_code(), $result->get_error_message(), substr( $result->get_error_data(), strlen( $to ) ) );

	// Since we know the core files have copied over, we can now copy the version file
	if ( ! is_wp_error( $result ) ) {
		if ( ! $wp_filesystem->copy( $from . $distro . 'kt-encased/version.php', $to . 'kt-encased/version.php', true /* overwrite */ ) ) {
			$wp_filesystem->delete( $from, true );
			$result = new WP_Error( 'copy_failed_for_version_file', __( 'The update cannot be installed because we will be unable to copy some files. This is usually due to inconsistent file permissions.' ), 'kt-encased/version.php' );
		}
		$wp_filesystem->chmod( $to . 'kt-encased/version.php', FS_CHMOD_FILE );
	}

	// Check to make sure everything copied correctly, ignoring the contents of ktmaterial
	$skip = array( 'ktmaterial' );
	$failed = array();
	if ( isset( $checksums ) && is_array( $checksums ) ) {
		foreach ( $checksums as $file => $checksum ) {
			if ( 'ktmaterial' == substr( $file, 0, 10 ) )
				continue;
			if ( ! file_exists( $working_dir_local . $file ) )
				continue;
			if ( file_exists( ABSPATH . $file ) && md5_file( ABSPATH . $file ) == $checksum )
				$skip[] = $file;
			else
				$failed[] = $file;
		}
	}

	// Some files didn't copy properly
	if ( ! empty( $failed ) ) {
		$total_size = 0;
		foreach ( $failed as $file ) {
			if ( file_exists( $working_dir_local . $file ) )
				$total_size += filesize( $working_dir_local . $file );
		}

		// If we don't have enough free space, it isn't worth trying again.
		// Unlikely to be hit due to the check in unzip_file().
		$available_space = @disk_free_space( ABSPATH );
		if ( $available_space && $total_size >= $available_space ) {
			$result = new WP_Error( 'disk_full', __( 'There is not enough free disk space to complete the update.' ) );
		} else {
			$result = _copy_dir( $from . $distro, $to, $skip );
			if ( is_wp_error( $result ) )
				$result = new WP_Error( $result->get_error_code() . '_retry', $result->get_error_message(), substr( $result->get_error_data(), strlen( $to ) ) );
		}
	}

	// Custom Content Directory needs updating now.
	// Copy Languages
	if ( !is_wp_error($result) && $wp_filesystem->is_dir($from . $distro . 'ktmaterial/languages') ) {
		if ( WP_LANG_DIR != ABSPATH . WPINC . '/languages' || @is_dir(WP_LANG_DIR) )
			$lang_dir = WP_LANG_DIR;
		else
			$lang_dir = WP_CONTENT_DIR . '/languages';

		if ( !@is_dir($lang_dir) && 0 === strpos($lang_dir, ABSPATH) ) { // Check the language directory exists first
			$wp_filesystem->mkdir($to . str_replace(ABSPATH, '', $lang_dir), FS_CHMOD_DIR); // If it's within the ABSPATH we can handle it here, otherwise they're out of luck.
			clearstatcache(); // for FTP, Need to clear the stat cache
		}

		if ( @is_dir($lang_dir) ) {
			$wp_lang_dir = $wp_filesystem->find_folder($lang_dir);
			if ( $wp_lang_dir ) {
				$result = copy_dir($from . $distro . 'ktmaterial/languages/', $wp_lang_dir);
				if ( is_wp_error( $result ) )
					$result = new WP_Error( $result->get_error_code() . '_languages', $result->get_error_message(), substr( $result->get_error_data(), strlen( $wp_lang_dir ) ) );
			}
		}
	}

	/** This filter is documented in magento-help/includes/update-core.php */
	apply_filters( 'update_feedback', __( 'Disabling Maintenance mode&#8230;' ) );
	// Remove maintenance file, we're done with potential site-breaking changes
	$wp_filesystem->delete( $maintenance_file );

	// 3.5 -> 3.5+ - an empty twentytwelve directory was created upon upgrade to 3.5 for some users, preventing installation of Twenty Twelve.
	if ( '3.5' == $old_wp_version ) {
		if ( is_dir( WP_CONTENT_DIR . '/themes/twentytwelve' ) && ! file_exists( WP_CONTENT_DIR . '/themes/twentytwelve/style.css' )  ) {
			$wp_filesystem->delete( $wp_filesystem->wp_themes_dir() . 'twentytwelve/' );
		}
	}

	// Copy New bundled plugins & themes
	// This gives us the ability to install new plugins & themes bundled with future versions of WordPress whilst avoiding the re-install upon upgrade issue.
	// $development_build controls us overwriting bundled themes and plugins when a non-stable release is being updated
	if ( !is_wp_error($result) && ( ! defined('CORE_UPGRADE_SKIP_NEW_BUNDLED') || ! CORE_UPGRADE_SKIP_NEW_BUNDLED ) ) {
		foreach ( (array) $_new_bundled_files as $file => $introduced_version ) {
			// If a $development_build or if $introduced version is greater than what the site was previously running
			if ( $development_build || version_compare( $introduced_version, $old_wp_version, '>' ) ) {
				$directory = ('/' == $file[ strlen($file)-1 ]);
				list($type, $filename) = explode('/', $file, 2);

				// Check to see if the bundled items exist before attempting to copy them
				if ( ! $wp_filesystem->exists( $from . $distro . 'ktmaterial/' . $file ) )
					continue;

				if ( 'plugins' == $type )
					$dest = $wp_filesystem->wp_plugins_dir();
				elseif ( 'themes' == $type )
					$dest = trailingslashit($wp_filesystem->wp_themes_dir()); // Back-compat, ::wp_themes_dir() did not return trailingslash'd pre-3.2
				else
					continue;

				if ( ! $directory ) {
					if ( ! $development_build && $wp_filesystem->exists( $dest . $filename ) )
						continue;

					if ( ! $wp_filesystem->copy($from . $distro . 'ktmaterial/' . $file, $dest . $filename, FS_CHMOD_FILE) )
						$result = new WP_Error( "copy_failed_for_new_bundled_$type", __( 'Could not copy file.' ), $dest . $filename );
				} else {
					if ( ! $development_build && $wp_filesystem->is_dir( $dest . $filename ) )
						continue;

					$wp_filesystem->mkdir($dest . $filename, FS_CHMOD_DIR);
					$_result = copy_dir( $from . $distro . 'ktmaterial/' . $file, $dest . $filename);

					// If a error occurs partway through this final step, keep the error flowing through, but keep process going.
					if ( is_wp_error( $_result ) ) {
						if ( ! is_wp_error( $result ) )
							$result = new WP_Error;
						$result->add( $_result->get_error_code() . "_$type", $_result->get_error_message(), substr( $_result->get_error_data(), strlen( $dest ) ) );
					}
				}
			}
		} //end foreach
	}

	// Handle $result error from the above blocks
	if ( is_wp_error($result) ) {
		$wp_filesystem->delete($from, true);
		return $result;
	}

	// Remove old files
	foreach ( $_old_files as $old_file ) {
		$old_file = $to . $old_file;
		if ( !$wp_filesystem->exists($old_file) )
			continue;
		$wp_filesystem->delete($old_file, true);
	}

	// Remove any Genericons example.html's from the filesystem
	_upgrade_422_remove_genericons();

	// Remove the REST API plugin if its version is Beta 4 or lower
	_upgrade_440_force_deactivate_incompatible_plugins();

	// Upgrade DB with separate request
	/** This filter is documented in magento-help/includes/update-core.php */
	apply_filters( 'update_feedback', __( 'Upgrading database&#8230;' ) );
	$db_upgrade_url = admin_url('upgrade.php?step=upgrade_db');
	wp_remote_post($db_upgrade_url, array('timeout' => 60));

	// Clear the cache to prevent an update_option() from saving a stale db_version to the cache
	wp_cache_flush();
	// (Not all cache backends listen to 'flush')
	wp_cache_delete( 'alloptions', 'options' );

	// Remove working directory
	$wp_filesystem->delete($from, true);

	// Force refresh of update information
	if ( function_exists('delete_site_transient') )
		delete_site_transient('update_core');
	else
		delete_option('update_core');

	/**
	 * Fires after WordPress core has been successfully updated.
	 *
	 * @since 3.3.0
	 *
	 * @param string $wp_version The current WordPress version.
	 */
	do_action( '_core_updated_successfully', $wp_version );

	// Clear the option that blocks auto updates after failures, now that we've been successful.
	if ( function_exists( 'delete_site_option' ) )
		delete_site_option( 'auto_core_update_failed' );

	return $wp_version;
}

/**
 * Copies a directory from one location to another via the WordPress Filesystem Abstraction.
 * Assumes that WP_Filesystem() has already been called and setup.
 *
 * This is a temporary function for the 3.1 -> 3.2 upgrade, as well as for those upgrading to
 * 3.7+
 *
 * @ignore
 * @since 3.2.0
 * @since 3.7.0 Updated not to use a regular expression for the skip list
 * @see copy_dir()
 *
 * @global WP_Filesystem_Base $wp_filesystem
 *
 * @param string $from     source directory
 * @param string $to       destination directory
 * @param array $skip_list a list of files/folders to skip copying
 * @return mixed WP_Error on failure, True on success.
 */
function _copy_dir($from, $to, $skip_list = array() ) {
	global $wp_filesystem;

	$dirlist = $wp_filesystem->dirlist($from);

	$from = trailingslashit($from);
	$to = trailingslashit($to);

	foreach ( (array) $dirlist as $filename => $fileinfo ) {
		if ( in_array( $filename, $skip_list ) )
			continue;

		if ( 'f' == $fileinfo['type'] ) {
			if ( ! $wp_filesystem->copy($from . $filename, $to . $filename, true, FS_CHMOD_FILE) ) {
				// If copy failed, chmod file to 0644 and try again.
				$wp_filesystem->chmod( $to . $filename, FS_CHMOD_FILE );
				if ( ! $wp_filesystem->copy($from . $filename, $to . $filename, true, FS_CHMOD_FILE) )
					return new WP_Error( 'copy_failed__copy_dir', __( 'Could not copy file.' ), $to . $filename );
			}
		} elseif ( 'd' == $fileinfo['type'] ) {
			if ( !$wp_filesystem->is_dir($to . $filename) ) {
				if ( !$wp_filesystem->mkdir($to . $filename, FS_CHMOD_DIR) )
					return new WP_Error( 'mkdir_failed__copy_dir', __( 'Could not create directory.' ), $to . $filename );
			}

			/*
			 * Generate the $sub_skip_list for the subdirectory as a sub-set
			 * of the existing $skip_list.
			 */
			$sub_skip_list = array();
			foreach ( $skip_list as $skip_item ) {
				if ( 0 === strpos( $skip_item, $filename . '/' ) )
					$sub_skip_list[] = preg_replace( '!^' . preg_quote( $filename, '!' ) . '/!i', '', $skip_item );
			}

			$result = _copy_dir($from . $filename, $to . $filename, $sub_skip_list);
			if ( is_wp_error($result) )
				return $result;
		}
	}
	return true;
}

/**
 * Redirect to the About WordPress page after a successful upgrade.
 *
 * This function is only needed when the existing install is older than 3.4.0.
 *
 * @since 3.3.0
 *
 * @global string $wp_version
 * @global string $pagenow
 * @global string $action
 *
 * @param string $new_version
 */
function _redirect_to_about_wordpress( $new_version ) {
	global $wp_version, $pagenow, $action;

	if ( version_compare( $wp_version, '3.4-RC1', '>=' ) )
		return;

	// Ensure we only run this on the update-core.php page. The Core_Upgrader may be used in other contexts.
	if ( 'update-core.php' != $pagenow )
		return;

 	if ( 'do-core-upgrade' != $action && 'do-core-reinstall' != $action )
 		return;

	// Load the updated default text localization domain for new strings.
	load_default_textdomain();

	// See do_core_upgrade()
	show_message( __('WordPress updated successfully') );

	// self_admin_url() won't exist when upgrading from <= 3.0, so relative URLs are intentional.
	show_message( '<span class="hide-if-no-js">' . sprintf( __( 'Welcome to WordPress %1$s. You will be redirected to the About WordPress screen. If not, click <a href="%2$s">here</a>.' ), $new_version, 'about.php?updated' ) . '</span>' );
	show_message( '<span class="hide-if-js">' . sprintf( __( 'Welcome to WordPress %1$s. <a href="%2$s">Learn more</a>.' ), $new_version, 'about.php?updated' ) . '</span>' );
	echo '</div>';
	?>
<script type="text/javascript">
window.location = 'about.php?updated';
</script>
	<?php

	// Include admin-footer.php and exit.
	include(ABSPATH . 'magento-help/admin-footer.php');
	exit();
}

/**
 * Cleans up Genericons example files.
 *
 * @since 4.2.2
 *
 * @global array              $wp_theme_directories
 * @global WP_Filesystem_Base $wp_filesystem
 */
function _upgrade_422_remove_genericons() {
	global $wp_theme_directories, $wp_filesystem;

	// A list of the affected files using the filesystem absolute paths.
	$affected_files = array();

	// Themes
	foreach ( $wp_theme_directories as $directory ) {
		$affected_theme_files = _upgrade_422_find_genericons_files_in_folder( $directory );
		$affected_files       = array_merge( $affected_files, $affected_theme_files );
	}

	// Plugins
	$affected_plugin_files = _upgrade_422_find_genericons_files_in_folder( WP_PLUGIN_DIR );
	$affected_files        = array_merge( $affected_files, $affected_plugin_files );

	foreach ( $affected_files as $file ) {
		$gen_dir = $wp_filesystem->find_folder( trailingslashit( dirname( $file ) ) );
		if ( empty( $gen_dir ) ) {
			continue;
		}

		// The path when the file is accessed via WP_Filesystem may differ in the case of FTP
		$remote_file = $gen_dir . basename( $file );

		if ( ! $wp_filesystem->exists( $remote_file ) ) {
			continue;
		}

		if ( ! $wp_filesystem->delete( $remote_file, false, 'f' ) ) {
			$wp_filesystem->put_contents( $remote_file, '' );
		}
	}
}

/**
 * Recursively find Genericons example files in a given folder.
 *
 * @ignore
 * @since 4.2.2
 *
 * @param string $directory Directory path. Expects trailingslashed.
 * @return array
 */
function _upgrade_422_find_genericons_files_in_folder( $directory ) {
	$directory = trailingslashit( $directory );
	$files     = array();

	if ( file_exists( "{$directory}example.html" ) && false !== strpos( file_get_contents( "{$directory}example.html" ), '<title>Genericons</title>' ) ) {
		$files[] = "{$directory}example.html";
	}

	$dirs = glob( $directory . '*', GLOB_ONLYDIR );
	if ( $dirs ) {
		foreach ( $dirs as $dir ) {
			$files = array_merge( $files, _upgrade_422_find_genericons_files_in_folder( $dir ) );
		}
	}

	return $files;
}

/**
 * @ignore
 * @since 4.4.0
 */
function _upgrade_440_force_deactivate_incompatible_plugins() {
	if ( defined( 'REST_API_VERSION' ) && version_compare( REST_API_VERSION, '2.0-beta4', '<=' ) ) {
		deactivate_plugins( array( 'rest-api/plugin.php' ), true );
	}
}
