<?php
/**
 * 
 */

function gt_asides_admin_init() {
  require_once(plugin_dir_path( __FILE__ ) . 'create-metaboxes.php');
  add_action('add_meta_boxes', 'gt_asides_create_metaboxes');
}