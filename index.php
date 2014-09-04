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
            <?php if ( $pp_id ) : ?>
            <header>
                <h1><?php echo get_the_title( $pp_id ); ?></h1>
            </header>
            <?php endif; ?>
        </div>
    		
    	<div class="news-page cf">
            
            <?php include("loop.php"); ?>
            
        </div>
        
<?php get_footer(); ?>