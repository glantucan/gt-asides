<?php
/**
 * 
 */

function gt_asides_activate() {
  if ( version_compare( get_bloginfo('version'), GT_HASIDES_MIN_VERSION, '<') ) {
    wp_die( __('You must update Wordpress to use this plugin', 'gt-hyper-asides') );
  } 
  else {
    add_action('admin_enqueue_scripts', 'gt_asides_enqueue_assets');
   
    
    // add a link to the plugin entry(like activate, deactivate and  uninstall)
    add_filter('plugin_action_links_' . plugin_basename(__FILE__),
      'gt_asides_settings_link');
    
      // Flush the rewrite rules (like flush the cache in drupal? Necessary every time there are changes in the database)
    flush_rewrite_rules();
  }
}


function gt_asides_enqueue_assets() {
  //wp_enqueue_style('get-hyper-asides-style', plugins_url('/css/gt-hyper-asides.css', __FILE__));
  //wp_enqueue_scripts('get-hyper-asides-style', plugins_url('/js/gt-hyper-asides.js', __FILE__));
}



function gt_asides_settings_link() {
  $settings_link = '<a href="options-general.php?page=gt_hyper_asides_admin">Settings</a>';
    array_push($links, $settings_link);
    return $links;
}

