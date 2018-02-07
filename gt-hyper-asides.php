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
define( 'GT_ASIDES_URL',  plugin_dir_url( __FILE__ ) );

$GT_ASIDES_CONF_DEFAULTS = array(
    'css_classes' => array(
        'base' => array(
            'class' => 'gt-aside',
            'label' => 'Leer más ... ',
        ),
        'collapsed' => array(
            'class' => 'gt-aside-collapse',
            'label' => 'Leer más sobre: ',
        ),
        'button' => array(
            'class' => 'gt_asides-toggle-btn'
        ),
        'types' => array(
            'more' => array(
                'class' => 'gt-aside-more',
                'label' => '',
            ),
            'example' => array(
                'class' => 'gt-aside-example',
                'label' => '',
            ),
            'definition' => array(
                'class' => 'gt-aside-definition',
                'label' => '',
            ),
            'background' => array(
                'class' => 'gt-aside-background',
                'label' => '',
            ),
            'in-depth' => array(
                'class' => 'gt-aside-in-depth',
                'label' => '',
            ),
            'story' => array(
                'class' => 'gt-aside-story',
                'label' => '',
            ),
        ),
    ),
    'markdown_parser' => WPCom_Markdown::get_instance(),
);


// Includes
require_once( GT_ASIDES_FOLDER . 'debug/log.php' );
require_once( GT_ASIDES_FOLDER . 'inc/base/activate.php' );
require_once( GT_ASIDES_FOLDER . 'inc/base/deactivate.php' );
require_once( GT_ASIDES_FOLDER . 'inc/base/uninstall.php' );
require_once( GT_ASIDES_FOLDER . 'inc/shortcodes/aside_sc.php' );

// Registration Hooks
register_activation_hook( __FILE__ , 'gt_asides_activate' );
register_deactivation_hook( __FILE__ , 'gt_asides_deactivate' );


// Registering new post types requires registering support for markdown on them and probably even more convoluted things. LET'S STICK WITH NORMAL POSTS for now.  
// require_once( plugin_dir_path( __FILE__ ) . 'inc/post_types/custom_posts.php' );
// require_once( plugin_dir_path( __FILE__ ) . 'inc/post_types/posts_edit_extras.php' );
//add_action( 'init', 'gt_asides_register_custom_posts_init' );
//add_action( 'admin_init', 'gt_asides_posts_edit_extras_admin_init' );


// [aside] shortcode actions and filters
add_shortcode('aside', 'gt_asides_aside_shortcode_renderer');

// Workaround: Ensure wordpress doesn't mess up the rendered aside
add_filter( 'no_texturize_shortcodes', function($shortcodes) {
    $shortcodes[] = 'aside';
    return $shortcodes;
});
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 12);

add_action('the_post', 'gt_asides_enqueue_assets_for_posts');
//add_action('enqueue_scripts', 'gt_asides_enqueue_assets');

/**
 * the_post hook implementation. Enqueue css and js for the asides
 *
 * @param [type] $post the post we are loading
 * @return void
 */
function gt_asides_enqueue_assets_for_posts($post) {
    // Assume that we don't want to load assets for asides unles on a single post page or page
    global $GT_ASIDES_CONF_DEFAULTS;
    // This ought to be on a child theme
    wp_enqueue_style( 'gt-animations-css', GT_ASIDES_URL . 'css/gt-animations.css' );
    wp_enqueue_style( 'gt-style-css', GT_ASIDES_URL . 'css/gt-style.css' );

    if ( is_single() || is_page() ) {
        // Check whether we do have [aside ...] or not in the post before loading css and scripts
        if ( stripos($post->post_content, '[aside') ) {
            wp_enqueue_style( 'gt-asides-css', GT_ASIDES_URL . 'css/gt-asides.css' );
            wp_enqueue_script( 'gt-asides-js', GT_ASIDES_URL . 'js/gt-asides.js', array(), null, true );
            wp_localize_script('gt-asides-js', 'wp_gtAsidesData', array(
                'postId' => 'post-' . $post->ID,
                'mainAsideClass' => $GT_ASIDES_CONF_DEFAULTS['css_classes']['base']['class'],
                'asideClasses' => $GT_ASIDES_CONF_DEFAULTS['css_classes']['types'],
                'buttonClass' => $GT_ASIDES_CONF_DEFAULTS['css_classes']['button']['class'],
            ));
        }
        
    } 
     
    
}

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

