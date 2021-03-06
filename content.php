
<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 */
?>

			<article id="post-<?php the_ID(); ?>" class="blog-post <?php if ( is_single() ) : ?>single <?php endif; ?> cf">
            
                <?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
                    <figure><img src="<?php echo get_thumb(get_post_thumbnail_id(), 207, 99999, false); ?>" alt="Image"></figure>
                    <div class="txt">
                <?php endif; ?>
                
                <?php if ( is_single() ) : ?>
                						
                    <h1><?php the_title(); ?></h1>
                    <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentythirteen' ) ); ?>
		                <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
						
                <?php else : ?>
						
                    <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                    <div class="ex"><?php the_content(' '); ?></div>					
                    <a href="<?php the_permalink(); ?>" class="more">SEE MORE</a>
                    	
                <?php endif; // is_single() ?>

                <?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>			
                    </div>
                <?php endif; ?>
                
			</article>
