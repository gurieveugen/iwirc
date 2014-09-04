<?php

add_action('init', 'home_slides_custom_init');
function home_slides_custom_init() 
{
  $labels = array(
    'name' => _x('Home Slides', 'post type general name'),
    'singular_name' => _x('Slide', 'post type singular name'),
    'add_new' => _x('Add New', 'Slide'),
    'add_new_item' => __('Add New Slide'),
    'edit_item' => __('Edit Slide'),
    'new_item' => __('New Slide'),
    'view_item' => __('View Slide'),
    'search_items' => __('Search Slide'),
    'not_found' =>  __('No Slide found'),
    'not_found_in_trash' => __('No Slide found in Trash'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'menu_icon' => 'dashicons-slides',
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,    
    'rewrite' => array('slug' => 'home-slide', 'with_front' => FALSE),
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => null,
    'exclude_from_search' => true,
    'supports' => array('title','thumbnail','page-attributes')
  ); 
  register_post_type('home-slide',$args);
}


//add filter to insure the text Slide, or Slide, is displayed when user updates a Slide 
add_filter('post_updated_messages', 'home_slides_updated_messages');
function home_slides_updated_messages( $messages ) {

  $messages['Slide'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Slide updated. <a href="%s">View Slide</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Slide updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Slide restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Slide published. <a href="%s">View Slide</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Slide saved.'),
    8 => sprintf( __('Slide submitted. <a target="_blank" href="%s">Preview Slide</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Slide scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Slide</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Slide draft updated. <a target="_blank" href="%s">Preview Slide</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

//display contextual help for Slide
add_action( 'contextual_help', 'add_home_slides_help_text', 10, 3 );

function add_home_slides_help_text($contextual_help, $screen_id, $screen) { 
  //$contextual_help = . var_dump($screen); // use this to help determine $screen->id
  if ('Slide' == $screen->id ) {
    $contextual_help =
      '<p>' . __('Things to remember when adding or editing a Slide:') . '</p>' .
      '<ul>' .
      '<li>' . __('Specify the correct genre such as Mystery, or Historic.') . '</li>' .
      '<li>' . __('Specify the correct writer of the Slide.  Remember that the Author module refers to you, the author of this Slide review.') . '</li>' .
      '</ul>' .
      '<p>' . __('If you want to schedule the Slide review to be published in the future:') . '</p>' .
      '<ul>' .
      '<li>' . __('Under the Publish module, click on the Edit link next to Publish.') . '</li>' .
      '<li>' . __('Change the date to the date to actual publish this article, then click on Ok.') . '</li>' .
      '</ul>' .
      '<p><strong>' . __('For more information:') . '</strong></p>' .
      '<p>' . __('<a href="http://codex.wordpress.org/Posts_Edit_SubPanel" target="_blank">Edit Posts Documentation</a>') . '</p>' .
      '<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>') . '</p>' ;
  } elseif ( 'edit-Slide' == $screen->id ) {
    $contextual_help = 
      '<p>' . __('This is the help screen displaying the table of Slide blah blah blah.') . '</p>' ;
  }
  return $contextual_help;
}

function adding_custom_meta_boxes( $post_type, $post ) { 
    add_meta_box("slide-link-box", "Slide Link", "home_slides_link_box", "home-slide", "normal", "high");
    
}
add_action( 'add_meta_boxes', 'adding_custom_meta_boxes', 10, 2 );

function home_slides_link_box(){
    
	global $post;
    	
	echo '<input type="hidden" name="home_slides_noncename" id="home_slides_noncename" value="' . 
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	$slide_link = get_post_meta($post->ID, 'slide_link', true);	
	echo '<input type="text" name="slide_link" value="'.$slide_link.'" style="width:98%;">';
    
}

add_action('save_post', 'home_slides_save');
function home_slides_save($post_id){
    
	global $post;
	
	if ( !wp_verify_nonce( $_POST['home_slides_noncename'], plugin_basename(__FILE__) ))
	    return $post_id;	
	
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
        return $post_id;
	
	if($post->post_type == 'home-slide' && $_SERVER['REQUEST_METHOD'] == 'POST')
		update_post_meta($post->ID, "slide_link", $_POST["slide_link"]);
        
}

// Adds featured image functionality for Slides	
add_action( 'after_setup_theme', 'slides_featured_image_array', '9999' );
function slides_featured_image_array() {	
	global $_wp_theme_features;
	if ( !isset( $_wp_theme_features['post-thumbnails'] ) ) {		
		$_wp_theme_features['post-thumbnails'] = array( array( 'home-slide' ) );			
	}
	elseif ( is_array( $_wp_theme_features['post-thumbnails'] ) ) {        
		$_wp_theme_features['post-thumbnails'][0][] = 'home-slide';			
	}		
}

// Customize and move featured image box to main column	
add_action( 'do_meta_boxes', 'veterans_slides_image_box' );	
function veterans_slides_image_box() {	
	remove_meta_box( 'postimagediv', 'home-slide', 'side' );	
	add_meta_box( 'postimagediv', __('Slide Image'), 'post_thumbnail_meta_box', 'home-slide', 'normal', 'high' );	
}

// Adds slide image and link to slides column view	
add_filter( 'manage_edit-home-slide_columns', 'veterans_slides_edit_columns' ); 
function veterans_slides_edit_columns( $columns ) {	
	$columns = array(		
		'cb'         => '<input type="checkbox" />',			
		'title'      => 'Slide Title',
		'home-slide' => 'Slide Image',
		'order'      => 'Slide Order',
		'date'       => 'Date'
	); 
	return $columns;  
}

add_image_size( 'featured-home-slide-thumb', 200, 9999, false );

add_action( 'manage_home-slide_posts_custom_column', 'slides_custom_columns' );	
function slides_custom_columns( $column ) {	
	global $post;
     
	switch ( $column ) {		
		case 'home-slide' :			
			echo the_post_thumbnail('featured-home-slide-thumb');			
		break;
		case 'order' :			
			echo $post->menu_order;			
		break;
	}	
}

function home_slide_admin_order($wp_query) {
  if (is_admin()) {

    // Get the post type from the query
    $post_type = $wp_query->query['post_type'];

    if ( $post_type == 'home-slide') {

      // 'orderby' value can be any column name
      $wp_query->set('orderby', 'menu_order');

      // 'order' value can be ASC or DESC
      $wp_query->set('order', 'ASC');
    }
  }
}
add_filter('pre_get_posts', 'home_slide_admin_order');



?>