<?php
/**
 * An init_hook implementation. Adds custom posts
 */
function gt_asides_register_custom_posts_init() {
    // all new post types must be registered after init
    
    // Post with asides
    $labels = array(
        'name'                  => __( 'Post with Asides', 'gt_post_w_asides' ),
        'singular_name'         => __( 'Post with Asides', 'gt_post_w_asides' ),
        'menu_name'             => __( 'Posts with Asides', 'gt_post_w_asides' ),
        'name_admin_bar'        => __( 'Post with Asides', 'gt_post_w_asides' ),
        'add_new'               => __( 'Add New', 'gt_post_w_asides' ),
        'add_new_item'          => __( 'Add New Post with Asides', 'gt_post_w_asides' ),
        'new_item'              => __( 'New Post+asides', 'gt_post_w_asides' ),
        'edit_item'             => __( 'Edit Post with Asides', 'gt_post_w_asides' ),
        'view_item'             => __( 'View Post with Asides', 'gt_post_w_asides' ),
        'all_items'             => __( 'All Posts+', 'gt_post_w_asides' ),
        'search_items'          => __( 'Search Posts+', 'gt_post_w_asides' ),
        'parent_item_colon'     => __( 'Parent Posts+:', 'gt_post_w_asides' ),
        'not_found'             => __( 'No posts+ found.', 'gt_post_w_asides' ),
        'not_found_in_trash'    => __( 'No posts+ found in Trash.', 'gt_post_w_asides' ),
        'featured_image'        => __( 'Post+ Cover Image', 'gt_post_w_asides' ),
        'set_featured_image'    => __( 'Set cover image', 'gt_post_w_asides' ),
        'remove_featured_image' => __( 'Remove cover image', 'gt_post_w_asides' ),
        'use_featured_image'    => __( 'Use as cover image', 'gt_post_w_asides' ),
        'archives'              => __( 'Post+asides archives', 'gt_post_w_asides' ),
        'insert_into_item'      => __( 'Insert into post with asides', 'gt_post_w_asides' ),
        'uploaded_to_this_item' => __( 'Uploaded to this post+', 'gt_post_w_asides' ),
        'filter_items_list'     => __( 'Filter post+asides list', 'gt_post_w_asides' ),
        'items_list_navigation' => __( 'Posts+ list navigation', 'gt_post_w_asides' ),
        'items_list'            => __( 'Posts+ list', 'gt_post_w_asides' ),
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __('A custom post type with asides', 'gt_post_w_asides'),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'can_export'         => true,
        'rewrite'            => array( 'slug' => 'gt_post_w_asides' ),
        'capability_type'    => 'post', // Controls the permission needed to publish
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 
                                'comments' ),
        'taxonomies'         => array('category', 'post_tag'),
    );
    register_post_type('gt_post_w_asides', $args);
    add_post_type_support( 'post_with_asides', 'wpcom-markdown' );
    // Aside post
    // TODO: Should I nest posts with asides or just make asides simple posts with some custom fields???
}
