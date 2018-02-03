<?php
/**
 * 
 */

function gt_asides_create_metaboxes() {
  add_meta_box(
    'gt_asides_options_mb',
    __('Asides options', 'gt_post_w_aside'),
    'gt_asides_options_mb_callback', /* function to call when mb is shown */
    'gt_post_w_aside', /* post type */
    'normal', /* Position with respect to the editor: normal, advance, side */
    'high' /* Position priority w. respect to other metaboxes: high, core, low, default */
  );
}


function gt_asides_options_mb_callback() {
  gt_log('Rendering meta box');
  echo 'aside options test';
}

