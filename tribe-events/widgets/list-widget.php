<?php
/**
 * Events List Widget Template
 * This is the template for the output of the events list widget. 
 * All the items are turned on and off through the widget admin.
 * There is currently no default styling, which is needed.
 *
 * This view contains the filters required to create an effective events list widget view.
 *
 * You can recreate an ENTIRELY new events list widget view by doing a template override,
 * and placing a list-widget.php file in a tribe-events/widgets/ directory 
 * within your theme directory, which will override the /views/widgets/list-widget.php.
 *
 * You can use any or all filters included in this file or create your own filters in 
 * your functions.php. In order to modify or extend a single filter, please see our
 * readme on templates hooks and filters (TO-DO)
 *
 * @return string
 *
 * @package TribeEventsCalendar
 *
 */
if ( !defined('ABSPATH') ) { die('-1'); } 

//Check if any posts were found
if ( $posts ) {
?>

<ul class="hfeed vcalendar">
<?php
	foreach( $posts as $post ) :
		setup_postdata( $post );
?>
    <li>
        <article class="cf">
            <?php if ( has_post_thumbnail() ) : ?>
            <figure><?php the_post_thumbnail( array(107, 93) ); ?></figure>
            <?php endif; ?>			
            <div class="txt">
                <h2><a href="<?php echo tribe_get_event_link(); ?>"><?php the_title(); ?></a></h2>                
                <p><?php echo short_content( $post->post_content, 60, '' ); ?></p>
                <a href="<?php echo tribe_get_event_link(); ?>" class="more">SEE MORE</a>
            </div>
		</article>
	</li>	
<?php
	endforeach;
?>
</ul><!-- .hfeed -->

<a href="<?php echo tribe_get_events_link(); ?>" class="see-all" rel="bookmark"><?php echo __( 'SEE ALL EVENTS' );	?></a>

<?php
//No Events were Found
} else {
?>
	<p><?php _e( 'There are no upcoming events at this time.', 'tribe-events-calendar' ); ?></p>
<?php
}
?>
