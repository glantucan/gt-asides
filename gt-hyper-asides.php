<?php
/**
 * Plugin Name: Gt-Hyper-Asides
 * Plugin URI: http://newbeforever.com/hyper-asides
 * Description: Add collapsible asides to your rant.
 * Version: 0.1
 * Author: Glantucan
 * Author URI: http://newbeforever.com
 * License: GPLv2 or later
 */

// Blocking direct access to this plugin PHP file
if (!defined( 'ABSPATH' )) {
   die;
}
/* defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
// And this works too:
if (!function_exists('add_action')) { echo 'Not allowed'; exit(); } */

define( 'GT_HASIDES_MIN_VERSION', '4.9' );

// Includes
require_once(plugin_dir_path( __FILE__ ) . 'debug/log.php');
require_once(plugin_dir_path( __FILE__ ) . 'inc/base/activate.php');
require_once(plugin_dir_path( __FILE__ ) . 'inc/base/deactivate.php');
require_once(plugin_dir_path( __FILE__ ) . 'inc/base/uninstall.php');
require_once(plugin_dir_path( __FILE__ ) . 'inc/base/init.php');
require_once(plugin_dir_path( __FILE__ ) . 'inc/admin/admin_init.php');

// Hooks
register_activation_hook( __FILE__, 'gt_asides_activate');
register_deactivation_hook( __FILE__, 'gt_asides_deactivate');

// actions (if in a class the following would go in the constructor.)
add_action('init', 'gt_asides_init');
add_action('admin_init', 'gt_asides_admin_init');
add_action('admin_menu', 'gt_asides_add_admin_pages');


function gt_asides_add_admin_pages() {
  add_menu_page('Gt-Hyper-Asides', 'Hyper-Asides', 'manage_options', 
    'gt_hyper_asides_admin', 'gt_asides_settings_page', 'dashicons-layout', 110);
}

function gt_asides_settings_page() {
  // require template
  
  require_once(plugin_dir_path( __FILE__ ) . 'inc/templates/settings.php');
  
}
