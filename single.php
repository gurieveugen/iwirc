<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

        <?php
        $pp_id = get_option( 'page_for_posts' );
        if ( $pp_id )
            $img_id = get_featured_image_id( $pp_id );
        ?>

        <div class="img-top-page cf">
            <?php if ( $img_id ) : ?>
            <figure><img src="<?php echo get_thumb( $img_id, 1363, 694, 1); ?>" alt=" "></figure>
            <?php endif; ?>
            <?php if ( $pp_id ) : ?>
            <header>
                <h1><?php echo get_the_title( $pp_id ); ?></h1>
            </header>
            <?php endif; ?>
        </div>
		
		<div class="news-page cf">

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>

				<?php // comments_template(); ?>

			<?php endwhile; ?>
			<nav class="nav-posts cf">                
                <?php previous_post_link('<div class="prev">%link</div>', 'PREVIOUS PAGE', TRUE); ?>
                <?php if ( $pp_id ) : ?>
				    <div class="back"><a href="<?php echo get_permalink( $pp_id ); ?>">BACK</a></div>
                <?php endif; ?>
                <?php next_post_link('<div class="next">%link</div>', 'NEXT PAGE', TRUE); ?>				
			</nav>
		</div>
<?php get_footer(); ?>