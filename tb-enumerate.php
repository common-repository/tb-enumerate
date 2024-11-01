<?php
/*
Plugin Name: tb-enumerate
Plugin URI: http://blog.bazzanella.org/numeration-en-ligne
Description: Learn the numbering system by position. Shortcode: [tbenumerate]
Version: 0.1.0
Author: Thierry Bazzanella
Author URI: http://blog.bazzanella.org
*/
define( 'ME_URL', plugins_url('/', __FILE__) );
define( 'ME_DIR', dirname(__FILE__) );
define( 'ME_VERSION', '1.0' );
define( 'ME_OPTION', 'me_ext' );

require_once( ME_DIR . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'class.client.php' );
require_once( ME_DIR . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'functions.plugin.php' );
require_once( ME_DIR . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'functions.tpl.php' );

// Activation, uninstall
register_activation_hook( __FILE__, 'TbEnumerate_Install' );
register_deactivation_hook ( __FILE__, 'TbEnumerate_Uninstall' );

add_shortcode('tbenumerate', 'short_tbenumerate');

function TbEnumerate_Init() {
	global $myExt;

	// Load translations
	load_plugin_textdomain ( 'tb-enumerate', false, basename(rtrim(dirname(__FILE__), '/')) . '/languages' );

	// Admin
	if ( is_admin() ) {
		require_once( ME_DIR . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'class.admin.php' );
		require_once( ME_DIR . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'class.admin.page.php' );
		$myExt['admin'] = new TbEnumerate_Admin();
		$myExt['admin_page'] = new TbEnumerate_Admin_Page();
	}
}

function short_tbenumerate() {
  	global $myExt;
  	TbEnumerate_Init();
  	// Load client
 	$myExt['client'] = new TbEnumerate_Client();
	$result=$myExt['client']->getView();
    return '
         <div class="tbenumerate">'.
           $result.
         '</div>';
}

?>
