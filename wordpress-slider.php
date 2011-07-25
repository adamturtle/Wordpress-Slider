<?php
/*
Plugin Name: Wordpress Slider
Description: Add a slider to your site. This plugin also requires the <a href="http://plugins.elliotcondon.com/advanced-custom-fields/">Advanced Custom Fields</a> plugin.
Version: 1.0
Author: Adam Turtle
Author URI: http://www.adamturtle.com/
License: GPL
Copyright: Adam Turtle
*/

/*
ini_set('display_errors',1);
error_reporting(E_ALL);
*/

define('WS_PLUGIN_URL', WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) );
define('WS_PLUGIN_DIR', WP_PLUGIN_DIR.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) );


/*	CHECK DEPENDENCIES
------------------------------------*/

function ws_check_for_acf_plugin(){
	
  $plugins = get_option('active_plugins');
  $required_plugin = 'advanced-custom-fields/acf.php';

  if ( in_array( $required_plugin , $plugins ) ) {
  
		// Create the 'Slide' post type
		require_once( 'slide-post-type.php');

  }
	// If ACF is not activated or not installed
	else {

		add_action('admin_notices','ws_error_acf_deactivated');
			
	}
	
}
add_action('init','ws_check_for_acf_plugin', 1);



/*	ADMIN MESSAGES
------------------------------------*/

function ws_error($content){
	$message = "<div class='error'><p><strong>Wordpress Slider Error: </strong> $content</p></div>";
	return $message;	
}

function ws_notice($content){
	$message = "<div class='updated'><p>$content</p></div>";
	return $message;
}

function ws_error_acf_deactivated(){
	$message = "<div class='error'><p><strong>Wordpress Slider Error: </strong> Advanced Custom Fields is either deactivated or not installed. Please either activate the plugin or <a href='". get_bloginfo('url') ."/wp-admin/plugin-install.php?tab=search&type=term&s=advanced+custom+fields&plugin-search-input=Search+Plugins'>install it.</a></p></div>";
	echo $message;	
}


/*	SLIDER ACTIONS
------------------------------------*/

function ws_slider($options){
	
	// If no options passed, create blank array
	if(!$options) $options = array();
	
  // Set defaults
  $defaults = array( 
  	"container_id" 			=> "ws-slider",
    "show_images" 			=> 1,
		"show_titles" 			=> 1,
		"show_links" 				=> 1,
		"images_field_name"	=> "slide_image",
		"titles_field_name" => "slide_title",
		"links_field_name" 	=> "slide_link"
	);

  // Merge the defaults with the $options:
  $options = array_merge($defaults, $options);	
	
	// Get posts
	$args = array(
	  'orderby'         => 'post_date',
	  'order'           => 'DESC',
	  'post_type'       => 'slide',
	  'post_status'     => 'publish' 
	);
	query_posts( $args ); 
						
	if(have_posts()) :
		// Check the necessary plugin is enabled
			if( !function_exists(get_fields) ){
				echo ws_error('Please activate/install Advanced Custom Fields plugin to enable slider');
			} else { 
			
			// Output slider HTML	?>

			<section id="homepage_banner">						
				<div id="<?php echo $options['container_id']; ?>">
				  <div class="slides_container">	
					<?php while (have_posts()) : the_post(); ?>
				    <div class="slide"<?php if( $options['show_images'] == TRUE && get_field($options['images_field_name']) ) { echo ' style="background: url(\''. get_field($options['images_field_name']) .'\') no-repeat 0 0"'; } ?>>
				      <?php if( $options['show_titles'] == TRUE && get_field($options['titles_field_name']) ){ ?>
				      	<p class="text">
				      		<?php if( get_field($options['show_links'] == TRUE) ){ ?>
				      			<a href="<?php the_field($options['links_field_name']) ?>" title="<?php the_field($options['titles_field_name']) ?>">
				      		<?php } ?>
				      		
				      		<?php the_field($options['titles_field_name']) ?>
				      		
				      		<?php if( get_field($options['show_links']) == TRUE ){ ?>
				      			</a>
				      		<?php } ?>							      		
				      	</p>
				      <?php } ?>
				    </div>
				   	<?php endwhile; ?> 			   	
				  </div>
				</div>			
		<?php	}// end else ?>
		<script type="text/javascript">
			$(function(){
		    $("<?php echo $options['container_id']; ?>").slides({
		    	'generateNextPrev':0,
		    	'play':4000,
		    	'slideSpeed': 1000,
		    	'slideEasing': 'easeOutExpo'
		    });
		  });
		</script>					
		
		<?php endif; 	
		wp_reset_query(); ?>

	</section>
	<?php
}


/*	FRONT END
------------------------------------*/

function ws_load_js_css(){
		
	// Slides JS
	wp_register_script('slides-js', WS_PLUGIN_URL . 'js/slides.min.jquery.js');
	wp_enqueue_script('slides-js');
	
	// CSS
	wp_register_style('ws-css', WS_PLUGIN_URL . 'css/ws-slider.css');
	wp_enqueue_style('ws-css');
	
}
add_action('init', 'ws_load_js_css');























