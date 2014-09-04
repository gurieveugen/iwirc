<?php
add_action('widgets_init', create_function('', 'return register_widget("IWIRC_Recent_Posts_Widget");'));
class IWIRC_Recent_Posts_Widget extends WP_Widget {
    
    function __construct() {
        
        $widget_options = array(
            'classname'     => 'widget-posts-home',
            'description'   => __( 'Your recent posts.' )
        );
        
        $control_options = array(
			'width'  => 250,
			'height' => 350
		);
        
        $this->WP_Widget(
			'iwirc_latest_posts',
			__( 'IWIRC Recent Posts Widget' ),
			$widget_options,
			$control_options
		);
        
    }
    
    function widget( $args, $instance ) {
        
        extract( $args, EXTR_SKIP );
        
        $title              = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );        
        $limit              = (int)( $instance['limit'] );        
        $excerpt_lenght     = (int)$instance['excerpt_lenght'];
        
        echo $before_widget;
        
        if ( $title ) echo $before_title . $title . $after_title;
        
        $lposts = new WP_Query('post_type=post&post_status=publish&cat=3&posts_per_page='.$limit);
        if ( $lposts->have_posts() ) :
            echo "<ul>";
                while ( $lposts->have_posts() ) : $lposts->the_post(); ?>
                    <li>                        
						<article class="cf">
                        
							<?php if ( has_post_thumbnail() ) : ?>
                            <figure><img src="<?php echo get_thumb( get_featured_image_id( get_the_ID() ), 107, 93, 1 ); ?>" alt=" " /></figure>
                            <?php endif; ?>
							
							<div class="txt">
								<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<p><?php echo short_content( get_the_content(), $excerpt_lenght, '' ); ?></p>
								<a href="<?php the_permalink(); ?>" class="more">SEE MORE</a>
                            </div>
                            
						</article>
                    </li> 
                <?php endwhile;
            echo "</ul>";
            $pp_id = get_option( 'page_for_posts' );
            if ( $pp_id ) 
                echo '<a href="'. get_permalink( $pp_id ) .'" class="see-all">SEE ALL NEWS</a>';
        endif; 
        
        echo $after_widget;
        
    }
    
    function update( $new_instance, $old_instance ) {
        
        $instance                       = $old_instance;
        $instance['title']              = strip_tags( $new_instance['title'] );        
        $instance['limit']              = (int)( $new_instance['limit'] );        
        $instance['excerpt_lenght']     = (int)$new_instance['excerpt_lenght'];        
        
        return $instance;
        
    }
    
    function form( $instance ) {
        
        $defaults = array(
			'title'             => '',						
			'limit'             => 3,
            'excerpt_lenght'    => 60
		);
        
        $instance         = wp_parse_args( (array) $instance, $defaults );
        $title            = strip_tags( $instance['title'] );				
		$limit            = (int)( $instance['limit'] );
		$excerpt_lenght   = (int)($instance['excerpt_lenght']);
        
        ?>        
                            
        <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $title; ?>"/>
		</p>
        <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Posts Limit:' ); ?></label>
			<input class="vwrpw-numb" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="text" value="<?php echo $limit; ?>"/>
		</p>            
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'excerpt_lenght' ) ); ?>"><?php _e( 'Excerpt Length:' ); ?></label>
			<input class="vwrpw-numb" id="<?php echo esc_attr( $this->get_field_id( 'excerpt_lenght' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt_lenght' ) ); ?>" type="text" value="<?php echo $excerpt_lenght; ?>"/>
		</p>
        
        <div class="clear"></div>
        
        <?php
        
    }
    
}






















