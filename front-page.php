<?php
/**
 * The template for displaying front page.  
 */

get_header(); ?>
    
    <?php $slides = new WP_Query('post_type=home-slide&post_status=publish&posts_per_page=-1&orderby=menu_order&order=ASC'); ?>
    <?php if ( $slides->have_posts() ) : ?>
    <div class="slider-home cf">
        <aside class="flexslider">
            <ul class="slides">
                <?php while ( $slides->have_posts() ) : $slides->the_post(); ?>
                    <?php
                    if ( has_post_thumbnail() ) : 
                    $img_id = get_featured_image_id( get_the_ID() );
                    $link = get_post_meta($post->ID, 'slide_link', true);
                    ?>
                    <li>
                        <figure>
                            <img src="<?php echo get_thumb( $img_id, 1365, 512, 1); ?>" alt=" ">
        					<figcaption>
                                <p><?php the_title(); ?></p>
                                <?php if ( $link ) : ?>
                                <a href="<?php echo $link; ?>" class="more">SEE MORE</a>
                                <?php endif; ?>
        					</figcaption>
        				</figure>
        			</li>
                    <?php endif; ?>
                <?php endwhile; ?>
            </ul>
        </aside>
    </div>
    <script type="text/javascript">
    	(function($){
    		$(function(){
    			$('.flexslider').flexslider({
    				animation: "fade",
    				slideshowSpeed: 7000,
    				animationSpeed: 600,
                    directionNav: false,
    				controlNav: false    				
    			});
    		});
    	})(jQuery);
    </script>
    <?php endif; ?>
    <?php wp_reset_postdata(); 	?>
		
        <aside class="sidebar-home cf">
            <div class="column">
            
                <?php if ( is_active_sidebar( 'sidebar-home-right' ) ) : ?>
                    <?php dynamic_sidebar( 'sidebar-home-right' ); ?>
                <?php endif; ?>
                
			</div>			
            <div class="column">
            
                <?php if ( is_active_sidebar( 'sidebar-home-left' ) ) : ?>
                    <?php dynamic_sidebar( 'sidebar-home-left' ); ?>
                <?php endif; ?>
                				
			</div>
			
			<div class="column">
            
                <?php if ( is_active_sidebar( 'sidebar-home-center' ) ) : ?>
                    <?php dynamic_sidebar( 'sidebar-home-center' ); ?>
                <?php endif; ?>	
				
			</div>
		</aside>
<?php get_footer(); ?>