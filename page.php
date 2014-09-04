<?php
/**
 * The template for displaying all pages. 
 */

get_header(); ?>

    <div class="img-top-page cf">
        <?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>                        
            <?php
            $thumb_id = get_post_thumbnail_id( get_the_ID() );
            $thumb_url = wp_get_attachment_image_src($thumb_id,'full', true);
        	$large = $thumb_url[0];
            ?>
            <figure><img src="<?php echo $large; ?>" alt=" " /></figure>
        <?php else : ?>
            <figure><img src="<?php echo get_template_directory_uri(); ?>/images/uploads/header_about.jpg" alt=" "></figure>
        <?php endif; ?>
        <header>
            <h1><?php the_title(); ?></h1>
        </header>
    </div>
    
	<?php while ( have_posts() ) : the_post(); ?>
    
        <article id="post-<?php the_ID(); ?>" class="entry-page cf">
            <?php the_content(); ?>
            <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
        </article><!-- #post -->
        
    <?php endwhile; ?>

<?php get_footer(); ?>