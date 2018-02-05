<?php
/**
 * admin_int hook implementation. It adds Options to the custom post types publishing and edit
 * forms
 * @return void
 */
function gt_asides_posts_edit_extras_admin_init() {
    add_action('add_meta_boxes', function () {

        // Add metabox to edit form of Posts with aside.
        add_meta_box(
            'gt_post_with_asides_options_mb',                   /* Metabox id */
            __('Post with Asides Options', 'gt_post_w_aside'),  /* Metabox title */
            function () {                                       /* function to call when mb is shown */
                echo 'Here be options';
            },    
            'gt_post_w_asides',     /* post type */
            'normal',       /* Position with respect to the editor: normal, advance, side */
            'high',         /* Position priority respect to other metaboxes: high, core, low, default */
            array()         /* Array of arguments to be passed to the callback */
        );

        // TODO: Add metabox to edit form of asides if needed
    });
}

