<?php

// let's create the function for the custom type
function slides_post_type() { 
	// creating (registering) the custom type 
	register_post_type( 'slide', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Slides', 'post type general name'), /* This is the Title of the Group */
			'singular_name' => __('Slide', 'post type singular name'), /* This is the individual type */
			'add_new' => __('Add New', 'custom post type item'), /* The add new menu item */
			'add_new_item' => __('Add New Slide'), /* Add New Display Title */
			'edit' => __( 'Edit' ), /* Edit Dialog */
			'edit_item' => __('Edit Slides'), /* Edit Display Title */
			'new_item' => __('New Slide'), /* New Display Title */
			'view_item' => __('View Slide'), /* View Display Title */
			'search_items' => __('Search Slides'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'A custom post type for adding slides to the slider' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => WS_PLUGIN_URL . 'img/slides-stack.png', /* the icon for the custom post type menu */
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
	 	) /* end of options */
	); /* end of register post type */
		
} 

	// adding the function to the Wordpress init
	add_action( 'init', 'slides_post_type');
	
	// now let's add custom categories (http://codex.wordpress.org/Function_Reference/register_taxonomy)
    register_taxonomy( 'custom_cat', 
    	array('custom_type'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
    	array('hierarchical' => true,                    
    		'labels' => array(
    			'name' => __( 'Custom Categories' ), /* name of the custom taxonomy */
    			'singular_name' => __( 'Custom Category' ), /* single taxonomy name */
    			'search_items' =>  __( 'Search Custom Categories' ), /* search title for taxomony */
    			'all_items' => __( 'All Custom Categories' ), /* all title for taxonomies */
    			'parent_item' => __( 'Parent Custom Category' ), /* parent title for taxonomy */
    			'parent_item_colon' => __( 'Parent Custom Category:' ), /* parent taxonomy title */
    			'edit_item' => __( 'Edit Custom Category' ), /* edit custom taxonomy title */
    			'update_item' => __( 'Update Custom Category' ), /* update title for taxonomy */
    			'add_new_item' => __( 'Add New Custom Category' ), /* add new title for taxonomy */
    			'new_item_name' => __( 'New Custom Category Name' ) /* name title for taxonomy */
    		),
    		'show_ui' => true,
    		'query_var' => true,
    	)
    );   