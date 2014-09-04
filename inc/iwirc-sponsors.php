<?php
add_action('init', 'sponsors_custom_init');
function sponsors_custom_init() 
{
  $labels = array(
    'name' => __('Sponsors', 'post type general name'),
    'singular_name' => __('Sponsor', 'post type singular name'),
    'add_new' => __('Add New', 'Sponsor'),
    'add_new_item' => __('Add New Sponsor'),
    'edit_item' => __('Edit Sponsor'),
    'new_item' => __('New Sponsor'),
    'view_item' => __('View Sponsor'),
    'search_items' => __('Search Sponsor'),
    'not_found' =>  __('No Sponsor found'),
    'not_found_in_trash' => __('No Sponsor found in Trash'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'menu_icon' => 'dashicons-groups',
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    /*'rewrite' => true,*/
	'rewrite' => array('slug' => 'sponsor', 'with_front' => FALSE),
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_position' => null,
    'supports' => array('title','thumbnail','page-attributes')
  ); 
  register_post_type('sponsor',$args);
  
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}


//add filter to insure the text Sponsor, or Sponsor, is displayed when user updates a Sponsor 
add_filter('post_updated_messages', 'sponsors_updated_messages');
function sponsors_updated_messages( $messages ) {

  $messages['Sponsor'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Sponsor updated. <a href="%s">View Sponsor</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Sponsor updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Sponsor restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Sponsor published. <a href="%s">View Sponsor</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Sponsor saved.'),
    8 => sprintf( __('Sponsor submitted. <a target="_blank" href="%s">Preview Sponsor</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Sponsor scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Sponsor</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Sponsor draft updated. <a target="_blank" href="%s">Preview Sponsor</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

//display contextual help for Sponsor
add_action( 'contextual_help', 'add_sponsors_help_text', 10, 3 );

function add_sponsors_help_text($contextual_help, $screen_id, $screen) { 
  //$contextual_help = . var_dump($screen); // use this to help determine $screen->id
  if ('Sponsor' == $screen->id ) {
    $contextual_help =
      '<p>' . __('Things to remember when adding or editing a Sponsor:') . '</p>' .
      '<ul>' .
      '<li>' . __('Specify the correct genre such as Mystery, or Historic.') . '</li>' .
      '<li>' . __('Specify the correct writer of the Sponsor.  Remember that the Author module refers to you, the author of this Sponsor review.') . '</li>' .
      '</ul>' .
      '<p>' . __('If you want to schedule the Sponsor review to be published in the future:') . '</p>' .
      '<ul>' .
      '<li>' . __('Under the Publish module, click on the Edit link next to Publish.') . '</li>' .
      '<li>' . __('Change the date to the date to actual publish this article, then click on Ok.') . '</li>' .
      '</ul>' .
      '<p><strong>' . __('For more information:') . '</strong></p>' .
      '<p>' . __('<a href="http://codex.wordpress.org/Posts_Edit_SubPanel" target="_blank">Edit Posts Documentation</a>') . '</p>' .
      '<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>') . '</p>' ;
  } elseif ( 'edit-Sponsor' == $screen->id ) {
    $contextual_help = 
      '<p>' . __('This is the help screen displaying the table of Sponsor blah blah blah.') . '</p>' ;
  }
  return $contextual_help;
}

add_action( 'add_meta_boxes', 'adding_sponsor_custom_meta_boxes', 10, 2 );
function adding_sponsor_custom_meta_boxes( $post_type, $post ) { 
    add_meta_box("sponsor-link-box", "Sponsor Link", "sponsor_link_box", "sponsor", "normal", "high");
    
}

function sponsor_link_box(){
    
	global $post;
    	
	echo '<input type="hidden" name="sponsor_noncename" id="sponsor_noncename" value="' . 
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	$sponsor_link = get_post_meta($post->ID, 'sponsor_link', true);	
	echo '<input type="text" name="sponsor_link" value="'.$sponsor_link.'" style="width:98%;">';
    
}

add_action('save_post', 'sponsor_save');
function sponsor_save($post_id){
    
	global $post;
	
	if ( !wp_verify_nonce( $_POST['sponsor_noncename'], plugin_basename(__FILE__) ))
	    return $post_id;	
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
        return $post_id;	
	if($post->post_type == 'sponsor' && $_SERVER['REQUEST_METHOD'] == 'POST')
		update_post_meta($post->ID, "sponsor_link", $_POST["sponsor_link"]);
        
}

// Adds featured image functionality for sponsors	
add_action( 'after_setup_theme', 'sponsors_featured_image_array', '9999' );
function sponsors_featured_image_array() {	
	global $_wp_theme_features;
	if ( !isset( $_wp_theme_features['post-thumbnails'] ) ) {		
		$_wp_theme_features['post-thumbnails'] = array( array( 'sponsor' ) );			
	}
	elseif ( is_array( $_wp_theme_features['post-thumbnails'] ) ) {        
		$_wp_theme_features['post-thumbnails'][0][] = 'sponsor';			
	}		
}

// Customize and move featured image box to main column	
add_action( 'do_meta_boxes', 'sponsor_image_box' );	
function sponsor_image_box() {	
	remove_meta_box( 'postimagediv', 'sponsor', 'side' );	
	add_meta_box( 'postimagediv', __('Sponsor Logo'), 'post_thumbnail_meta_box', 'sponsor', 'normal', 'high' );	
}

// Adds slide image and link to slides column view	
add_filter( 'manage_edit-sponsor_columns', 'sponsor_edit_columns' ); 
function sponsor_edit_columns( $columns ) {	
	$columns = array(		
		'cb'              => '<input type="checkbox" />',			
		'title'           => 'Title',
		'sponsor-logo'    => 'Sponsor Logo',
		'sponsor-order'   => 'Order',
		'date'            => 'Date'
	); 
	return $columns;  
}

add_image_size( 'featured-sponsor-logo-thumb', 150, 9999, false );

add_action( 'manage_sponsor_posts_custom_column', 'sponsor_custom_columns' );	
function sponsor_custom_columns( $column ) {	
	global $post;    
            
	switch ( $column ) {		
		case 'sponsor-logo' :                	
			echo the_post_thumbnail('featured-sponsor-logo-thumb');			
		break;
		case 'sponsor-order' :			
			echo $post->menu_order;			
		break;
	}
}

add_filter('pre_get_posts', 'sponsors_admin_order');
function sponsors_admin_order($wp_query) {
  if (is_admin()) {

    // Get the post type from the query
    $post_type = $wp_query->query['post_type'];

    if ( $post_type == 'sponsor') {

      // 'orderby' value can be any column name
      $wp_query->set('orderby', 'menu_order');

      // 'order' value can be ASC or DESC
      $wp_query->set('order', 'ASC');
    }
  }
}

add_action( 'admin_menu', 'register_sponsors_options_submenu_page_init' );
function register_sponsors_options_submenu_page_init() {
	$options_page = add_submenu_page(
        'edit.php?post_type=sponsor',
        'Sponsors Options',
        'Sponsors Options',
        'manage_options',
        'sponsors-options',
        'sponsors_options_submenu_page_callback'
    );
	add_action( "load-{$options_page}", 'sponsors_options_load_page' );
}

function sponsors_options_load_page() {	
	if ( $_POST["sponsors-options-form-submit"] == 'save' ) {
		check_admin_referer( "sponsors-options-page" );
		save_sponsors_options();
		$redirect_url = '&updated=true';
		wp_redirect(admin_url('edit.php?post_type=sponsor&page=sponsors-options'.$redirect_url));
		exit;
	}
}

function save_sponsors_options() {
	global $pagenow;
	$sponsors_options = get_option( "iwirc_sponsors_options" );
	
	if ( $pagenow == 'edit.php' && $_GET['post_type'] == 'sponsor' && $_GET['page'] == 'sponsors-options' ){
        $except_POST = array("_wpnonce", "_wp_http_referer", "Submit", "theme-options-form-submit");
		
        foreach($_POST as $post_key => $post_value) {
            if ( !in_array($post_key, $except_POST) ) {                    
                $sponsors_options[$post_key] = $post_value;                        
            }					
        }		
	}    
	update_option( "iwirc_sponsors_options", $sponsors_options );
}

function sponsors_options_submenu_page_callback() {
    $sponsors_options = get_option( "iwirc_sponsors_options" );
    $action_url = 'edit.php?post_type=sponsor&page=sponsors-options';
    ?>
    <div class="wrap">
		<h2>Sponsors Options</h2>
        <div id="poststuff">
			<form method="post" action="<?php echo $action_url; ?>">
                <?php wp_nonce_field( "sponsors-options-page" ); ?>
                <table class="form-table">
                    <tr>
                        <th><label for="title">Title:</label></th>
                        <td>
                            <input id="title" name="title" type="text" value="<?php echo htmlspecialchars($sponsors_options['title']); ?>" style="width:600px;" /> 
                            <span class="description"></span>
                        </td>
                    </tr>
                </table>
                <p class="submit" style="clear: both;">
					<input type="submit" name="Submit"  class="button-primary" value="Save" />
					<input type="hidden" name="sponsors-options-form-submit" value="save" />
				</p>
            </form>
        </div>
    </div>
    
<?php
}

?>