<?php
/**
 * The template for displaying Tag pages.
 */
?>

<?php get_header(); ?>

        <?php
        $pp_id = get_option( 'page_for_posts' );
        if ( $pp_id )
            $img_id = get_featured_image_id( $pp_id );
        ?>

        <div class="img-top-page cf">
            <?php if ( $img_id ) : ?>
            <figure><img src="<?php echo get_thumb( $img_id, 1363, 694, 1); ?>" alt=" "></figure>
            <?php endif; ?>
            
            <header>
                <h1><?php printf( __( 'Tag Archives: %s', 'twentythirteen' ), single_tag_title( '', false ) ); ?></h1>
            </header>
            
        </div>
		
		<div class="news-page cf">

		<?php if ( have_posts() ) : ?>

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php twentythirteen_paging_nav(); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div>
<?php get_footer(); ?>