<?php
add_action( 'admin_menu', 'theme_options_page_init' );
function theme_options_page_init() {
	$options_page = add_theme_page(
		'Theme Options',
		'Theme Options',
		8,
		'theme-options',
		'theme_options_page'
	);
	add_action( "load-{$options_page}", 'theme_options_load_page' );
}

function theme_options_load_page() {	
	if ( $_POST["theme-options-form-submit"] == 'save' ) {
		check_admin_referer( "theme-options-page" );
		save_theme_options();
		$redirect_url = isset( $_GET['tab'] ) ? '&updated=true&tab='. $_GET['tab'] : '&updated=true';
		wp_redirect(admin_url('themes.php?page=theme-options'.$redirect_url));
		exit;
	}
}

function save_theme_options() {
	global $pagenow;
	$theme_options = get_option( "iwirc_theme_options" );
	
	if ( $pagenow == 'themes.php' && $_GET['page'] == 'theme-options' ){ 
		if ( isset ( $_GET['tab'] ) )
	        $tab = $_GET['tab']; 
	    else
	        $tab = 'general';        
        $except_POST = array("_wpnonce", "_wp_http_referer", "Submit", "theme-options-form-submit"); 

	    switch ( $tab ){ 
			case 'general' :
				foreach($_POST as $post_key => $post_value) {
                    if ( !in_array($post_key, $except_POST) ) {                    
						$theme_options[$post_key] = $post_value;                        
                    }					
				}
			break; 
	        case 'socials' :
				foreach($_POST as $post_key => $post_value) {				    
					if ( !in_array($post_key, $except_POST) ) {                         
						$theme_options[$post_key] = $post_value;                        
                    }
				}
			break; 
	        case 'footer' : 
				foreach($_POST as $post_key => $post_value) {
					if ( !in_array($post_key, $except_POST) ) {                    
						$theme_options[$post_key] = $post_value;                        
                    }
				}
			break;			
	    }
	}    
	update_option( "iwirc_theme_options", $theme_options );
}

function theme_options_admin_tabs( $current = 'general' ) {
    $tabs = array( 'general' => 'General', 'socials' => 'Socials', 'footer' => 'Footer' );
    
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
		if ( $tab == $current ) {
			echo "<a class='nav-tab$class' href='?page=theme-options'>$name</a>";
		} else {
			echo "<a class='nav-tab$class' href='?page=theme-options&tab=$tab'>$name</a>";
		}
    }
    echo '</h2>';
}

function theme_options_page() {
	global $pagenow;
	$theme_options = get_option( "iwirc_theme_options" );
    $sitepages = get_pages();    
	?>
	
	<div class="wrap">
		<h2>Theme Settings</h2>
		
		<?php
			if ( 'true' == esc_attr( $_GET['updated'] ) ) echo '<div class="updated" ><p>Theme options saved.</p></div>';			
			if ( isset ( $_GET['tab'] ) ) {
				$action_url = admin_url( 'themes.php?page=theme-options&tab='.$_GET['tab'] );
				theme_options_admin_tabs($_GET['tab']);
			} else {
				$action_url = admin_url( 'themes.php?page=theme-options' );
				theme_options_admin_tabs();
			}
		?>

		<div id="poststuff">
			<form method="post" action="<?php echo $action_url; ?>">				
				<?php
				wp_nonce_field( "theme-options-page" );                
				
				if ( $pagenow == 'themes.php' && $_GET['page'] == 'theme-options' ){ 
				
					if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab']; 
					else $tab = 'general'; 
					
					echo '<table class="form-table">';
					switch ( $tab ){						
						case 'general' : 
							?>
                            <tr>
                                <th><label for="logo">Logo Image</label></th>
                                <td>                                        
                                        <input id="logo" type="text" name="logo" value="<?php echo $theme_options['logo']; ?>" style="width:600px;" />                                        
                                        <span class="description">Enter an URL of image</span>
                                        <?php if (strlen($theme_options['logo'])) : ?>
                                            <br /><br /><img src="<?php echo $theme_options['logo']; ?>" />
                                        <?php endif; ?>                                
                                </td>
                            </tr>
                            <tr>
								<th><label for="tagline1">Tagline1:</label></th>
								<td>
									<input id="tagline1" name="tagline1" type="text" value="<?php echo htmlspecialchars($theme_options['tagline1']); ?>" style="width:600px;" /> 
									<span class="description"></span>
								</td>
							</tr>
                            <tr>
								<th><label for="tagline2">Tagline2:</label></th>
								<td>
									<input id="tagline2" name="tagline2" type="text" value="<?php echo htmlspecialchars($theme_options['tagline2']); ?>" style="width:600px;" /> 
									<span class="description"></span>
								</td>
							</tr>
                        <?php
						break;
                        
                        case 'socials' :
							?>
                            <tr>
								<th><label for="facebook">Facebook:</label></th>
								<td>
									<input id="facebook" name="facebook" type="text" value="<?php echo htmlspecialchars($theme_options['facebook']); ?>" style="width:400px;" /> 
									<span class="description"></span>
								</td>
							</tr>
                            <tr>
								<th><label for="twitter">Twitter:</label></th>
								<td>
									<input id="twitter" name="twitter" type="text" value="<?php echo htmlspecialchars($theme_options['twitter']); ?>" style="width:400px;" /> 
									<span class="description"></span>
								</td>
							</tr>
                            <tr>
								<th><label for="google-plus">Google+:</label></th>
								<td>
									<input id="google-plus" name="google-plus" type="text" value="<?php echo htmlspecialchars($theme_options['google-plus']); ?>" style="width:400px;" /> 
									<span class="description"></span>
								</td>
							</tr>
                            <tr>
								<th><label for="linkedin">LinkedIn:</label></th>
								<td>
									<input id="linkedin" name="linkedin" type="text" value="<?php echo htmlspecialchars($theme_options['linkedin']); ?>" style="width:400px;" /> 
									<span class="description"></span>
								</td>
							</tr>
                            <tr>
								<th><label for="youtube">Youtube:</label></th>
								<td>
									<input id="youtube" name="youtube" type="text" value="<?php echo htmlspecialchars($theme_options['youtube']); ?>" style="width:400px;" /> 
									<span class="description"></span>
								</td>
							</tr>
							<?php
						break;
                        
						case 'footer' :                         
							?>                            
                            <tr>
								<th><label for="footer-copyright">Footer Copyright:</label></th>
								<td>
									<input id="footer-copyright" name="footer-copyright" type="text" value="<?php echo htmlspecialchars($theme_options['footer-copyright']); ?>" style="width:400px;" /> 
									<span class="description"></span>
								</td>
							</tr>					
							<?php
						break;						
					}
					echo '</table>';
				}
				?>
				<p class="submit" style="clear: both;">
					<input type="submit" name="Submit"  class="button-primary" value="Save" />
					<input type="hidden" name="theme-options-form-submit" value="save" />
				</p>
			</form>			
			
		</div>

	</div>
<?php } ?>