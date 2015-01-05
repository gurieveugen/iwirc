<?php
/**
 * Template name: News + Events
 */

$args = array(
    'offset'           => 0,
    'category'         => 3,
    'orderby'          => 'post_date',
    'order'            => 'DESC',
    'include'          => '',
    'exclude'          => '',
    'meta_key'         => '',
    'meta_value'       => '',
    'post_type'        => 'post',
    'post_mime_type'   => '',
    'post_parent'      => '',
    'post_status'      => 'publish',
    'suppress_filters' => true );
$posts = get_posts($args);

$args_events = array(
    'offset'           => 0,
    'orderby'          => 'post_date',
    'order'            => 'DESC',
    'include'          => '',
    'exclude'          => '',
    'meta_key'         => '',
    'meta_value'       => '',
    'post_type'        => 'tribe_events',
    'post_mime_type'   => '',
    'post_parent'      => '',
    'post_status'      => 'publish',
    'suppress_filters' => true );

$events = get_posts($args_events);

$posts = array_merge($posts, $events);

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

    <?php

    ?>
    <?php query_posts('cat=3'); ?>	
	<div class="news-page cf">
        <?php
        if(count($posts))
        {
            foreach ($posts as $p) 
            {
                echo wrapContent($p);
            }
            twentythirteen_paging_nav();
        }
        else
        {
            get_template_part( 'content', 'none' );
        }
        ?>
		</div>

<?php get_footer(); ?>