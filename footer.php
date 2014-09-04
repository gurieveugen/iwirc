<?php
/**
 * The template for displaying the footer. 
 */
?>
<?php global $iwirc_sponsors_options, $iwirc_options; ?>
	</section>
	
    <footer id="footer" class="cf">
        <div class="sponsors-footer cf">
            <?php if ( $iwirc_sponsors_options['title'] ) : ?>        
            <div class="tit-sponsors cf">
                <h3><?php echo $iwirc_sponsors_options['title']; ?></h3>
			</div>
            <?php endif; ?>
			<ul class="sponsor-slider">
                <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/uploads/logo_01.png" alt=" "></a></li>
				<li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/uploads/logo_02.png" alt=" "></a></li>
				<li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/uploads/logo_03.png" alt=" "></a></li>
				<li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/uploads/logo_04.png" alt=" "></a></li>
				<li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/uploads/logo_05.png" alt=" "></a></li>
				<li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/uploads/logo_06.png" alt=" "></a></li>
				<li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/uploads/logo_07.png" alt=" "></a></li>
			</ul>
		</div>
		<aside class="sidebar-footer cf">
            <div class="center-box cf">
                <?php if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>            
                    <?php dynamic_sidebar( 'sidebar-footer' ); ?>
                <?php endif; ?>
                <?php if ( $iwirc_options['footer-copyright'] ) : ?>
                <div class="copyright-box cf">
                    <p><?php echo $iwirc_options['footer-copyright']; ?></p>
                </div>
                <?php endif; ?>
            </div>
        </aside>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>