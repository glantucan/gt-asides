<?php
/**
 * 
 */

// init hook callback
function gt_asides_init() {
  // all new post types mustbe registered after init
  register_post_types();
}


function register_post_types() {

  // Post with asides
  $labels = array(
    'name'                  => __( 'Post with Asides', 'gt_post_w_aside' ),
    'singular_name'         => __( 'Post with Asides', 'gt_post_w_aside' ),
    'menu_name'             => __( 'Posts with Asides', 'gt_post_w_aside' ),
    'name_admin_bar'        => __( 'Post with Asides', 'gt_post_w_aside' ),
    'add_new'               => __( 'Add New', 'gt_post_w_aside' ),
    'add_new_item'          => __( 'Add New Post with Asides', 'gt_post_w_aside' ),
    'new_item'              => __( 'New Post+asides', 'gt_post_w_aside' ),
    'edit_item'             => __( 'Edit Post with Asides', 'gt_post_w_aside' ),
    'view_item'             => __( 'View Post with Asides', 'gt_post_w_aside' ),
    'all_items'             => __( 'All Posts+', 'gt_post_w_aside' ),
    'search_items'          => __( 'Search Posts+', 'gt_post_w_aside' ),
    'parent_item_colon'     => __( 'Parent Posts+:', 'gt_post_w_aside' ),
    'not_found'             => __( 'No posts+ found.', 'gt_post_w_aside' ),
    'not_found_in_trash'    => __( 'No posts+ found in Trash.', 'gt_post_w_aside' ),
    'featured_image'        => __( 'Post+ Cover Image', 'gt_post_w_aside' ),
    'set_featured_image'    => __( 'Set cover image', 'gt_post_w_aside' ),
    'remove_featured_image' => __( 'Remove cover image', 'gt_post_w_aside' ),
    'use_featured_image'    => __( 'Use as cover image', 'gt_post_w_aside' ),
    'archives'              => __( 'Post+asides archives', 'gt_post_w_aside' ),
    'insert_into_item'      => __( 'Insert into post with asides', 'gt_post_w_aside' ),
    'uploaded_to_this_item' => __( 'Uploaded to this post+', 'gt_post_w_aside' ),
    'filter_items_list'     => __( 'Filter post+asides list', 'gt_post_w_aside' ),
    'items_list_navigation' => __( 'Posts+ list navigation', 'gt_post_w_aside' ),
    'items_list'            => __( 'Posts+ list', 'gt_post_w_aside' ),
  );

  $args = array(
      'labels'             => $labels,
      'description'        => __('A custom post type with asides', 'gt_post_w_aside'),
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'can_export'         => true,
      'rewrite'            => array( 'slug' => 'post_w_aside' ),
      'capability_type'    => 'post', // Controls the permission needed to publish
      'has_archive'        => true,
      'hierarchical'       => false,
      'menu_position'      => 20,
      'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 
                              'comments' ),
      'taxonomies'         => array('category', 'post_tag'),
  );
  register_post_type('gt_post_w_aside', $args);

  // Aside post
  // TODO: Should I nest posts with asides or just make asides simple posts with some custom fields???

}