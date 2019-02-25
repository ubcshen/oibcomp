<?php

/*-----------------------------------------------------------------------------------*/
/*  Register activities post type
/*-----------------------------------------------------------------------------------*/
add_action( 'init', 'activities_posttype_init' );
if ( !function_exists( 'activities_posttype_init' ) ) :
function activities_posttype_init() {
    $project_labels = array(
        'name' => _x('Activities', 'post type general name'),
        'singular_name' => _x('Activities', 'post type singular name'),
        'menu_name' => __('Activities')

    );
    $project_args = array(
        'labels' => $project_labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'exclude_from_search' => false,
        'menu_position' => 5,
        'rewrite' => array('slug' => 'activity'),
        //'taxonomies' => array('post_tag'),
        //'taxonomies' => array('category', 'post_tag'),
        'supports' => array( 'title', 'excerpt', 'thumbnail', 'editor', 'tags','author')
    );
    register_post_type( 'activities', $project_args );

}
endif;


/*-----------------------------------------------------------------------------------*/
/*  project custom taxonomies.
/*-----------------------------------------------------------------------------------*/
add_action( 'init', 'activities_taxonomies_init', 0 );
if ( !function_exists( 'activities_taxonomies_init' ) ) :
function activities_taxonomies_init() {
    // project Category

    $labels = array(
        'name' => _x( 'Categories', 'taxonomy general name'),
        'singular_name' => _x( 'activitiesfilter', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Categories' ),
        'all_items' => __( 'All Categories'),
        'parent_item' => __( 'Parent Category'),
        'parent_item_colon' => __( 'Parent Category:'),
        'edit_item' => __( 'Edit Category'),
        'update_item' => __( 'Update Category'),
        'add_new_item' => __( 'Add New Category'),
        'new_item_name' => __( 'New Category Name'),
        'menu_name' => __( 'Activities Filter'),
    );

    register_taxonomy('activities-filter',array('activities'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'activities_categories' ),
    ));

    // project Tags
    $labels = array(
        'name' => _x( 'Tags', 'taxonomy general name'),
        'singular_name' => _x( 'Tag', 'taxonomy singular name'),
        'search_items' =>  __( 'Search Tags'),
        'popular_items' => __( 'Popular Tags'),
        'all_items' => __( 'All Tags'),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Edit Tag'),
        'update_item' => __( 'Update Tag'),
        'add_new_item' => __( 'Add New Tag'),
        'new_item_name' => __( 'New Tag Name'),
        'separate_items_with_commas' => __( 'Separate tags with commas'),
        'add_or_remove_items' => __( 'Add or remove tags'),
        'choose_from_most_used' => __( 'Choose from the most used tags'),
        'menu_name' => __( 'Tags'),
    );

    register_taxonomy('activities-tag','activities',array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'activities-tag' ),
    ));
}
endif;
