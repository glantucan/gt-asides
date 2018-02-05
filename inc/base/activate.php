<?php
/**
 * 
 */

function gt_asides_activate() {
    /* if ( version_compare( get_bloginfo('version'), GT_ASIDES_MIN_VERSION, '<') ) {
        wp_die( __( 'You must update Wordpress to use this plugin', 'gt-hyper-asides' ) );
    }  */
    $deps_check = check_dependencies();
    if(!$deps_check['result']){
        $error_message = implode("\n", $deps_check['messages']);
        wp_die( __( $error_message, 'gt-hyper-asides') );
    }
    else {
        //gt_asides_register_custom_posts_init();
        //add_post_type_support( 'post_with_asides', 'wpcom-markdown' );

        add_action('admin_enqueue_scripts', 'gt_asides_enqueue_assets');

        // add a link to the plugin entry(like activate, deactivate and  uninstall)
        add_filter( 'plugin_action_links_' . plugin_basename(__FILE__ ),
                    'gt_asides_settings_link');
        
        // Flush the rewrite rules (like flush the cache in drupal? Necessary every time there are changes in the database)
        flush_rewrite_rules();
    }
}

function check_dependencies() {
    $dependencies_check = array(
        'result' => true,
        'messages' => array(),
    );
    if ( version_compare( get_bloginfo('version'), GT_ASIDES_MIN_VERSION, '<') ) {
        $dependencies_check['result'] = false;
        $dependencies_check['messages'][] = 'You must update Wordpress to use this plugin';
    } 
    /* if ( !is_plugin_active( GT_ASIDES_FOLDER.'/../easy-markdown/easy-markdown.php') ) {
        $dependencies_check['result'] = false;
        $dependencies_check['messages'][] = 'You must have the easy-markdown plugin activated';
    } */
    return $dependencies_check;
}

function gt_asides_enqueue_assets() {
    //wp_enqueue_style('get-hyper-asides-style', plugins_url('/css/gt-hyper-asides.css', __FILE__));
    //wp_enqueue_scripts('get-hyper-asides-style', plugins_url('/js/gt-hyper-asides.js', __FILE__));
}



function gt_asides_settings_link() {
    $settings_link = '<a href="options-general.php?page=gt_hyper_asides_admin">Settings</a>';
    array_push( $links, $settings_link );
    return $links;
}

