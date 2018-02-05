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

define( 'GT_ASIDES_MIN_VERSION', '4.9' );
define( 'GT_ASIDES_FOLDER',  plugin_dir_path( __FILE__ ) );

// Includes
require_once( GT_ASIDES_FOLDER . 'debug/log.php' );
require_once( GT_ASIDES_FOLDER . 'inc/base/activate.php' );
require_once( GT_ASIDES_FOLDER . 'inc/base/deactivate.php' );
require_once( GT_ASIDES_FOLDER . 'inc/base/uninstall.php' );
require_once( GT_ASIDES_FOLDER . 'inc/shortcodes/aside_sc.php' );

// Registration Hooks
register_activation_hook( __FILE__ , 'gt_asides_activate' );
register_deactivation_hook( __FILE__ , 'gt_asides_deactivate' );

// Get the instance of the markdown processor
$gt_asides_markdown = WPCom_Markdown::get_instance();

// Registering new post types requires registering support for markdown on them and probably even more convoluted things. LET'S STICK WITH NORMAL POSTS for now.  
// require_once( plugin_dir_path( __FILE__ ) . 'inc/post_types/custom_posts.php' );
// require_once( plugin_dir_path( __FILE__ ) . 'inc/post_types/posts_edit_extras.php' );
//add_action( 'init', 'gt_asides_register_custom_posts_init' );
//add_action( 'admin_init', 'gt_asides_posts_edit_extras_admin_init' );


// [aside] shortcode actions and filters
add_shortcode('aside', 'aside_shortcode_parser');
add_filter( 'no_texturize_shortcodes', function($shortcodes) {
    $shortcodes[] = 'aside';
    return $shortcodes;
});
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 12);



add_action( 'admin_menu', 'gt_asides_add_admin_pages' );



/**
 * Creates an admin page for the plugin
 * FIXME: Do we need an admin page?
 *
 * @return void
 */
function gt_asides_add_admin_pages() {
    add_menu_page('Gt-Hyper-Asides', 'Hyper-Asides', 'manage_options', 'gt_hyper_asides_admin',
        function () {
            // require template
            require_once(plugin_dir_path( __FILE__ ) . 'inc/templates/settings.php');
        }
        , 'dashicons-layout', 110);
}

