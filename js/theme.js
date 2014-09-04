jQuery(document).ready(function() {
    
    // mobile menu
    mobile_navigation();
    
    jQuery('.sponsor-slider').bxSlider({
        speed: 800,
        controls: false,
        pager: false,        
        slideWidth: 200,
        minSlides: 2,
        maxSlides: 6,
        slideMargin: 10,
        auto: true,
        pause: 7000,
        onSliderLoad: function(){
            jQuery( ".sponsor-slider li" ).each(function( index ) {
                li_width = jQuery(this).width();
                img_width = jQuery(this).find('img').width();
                jQuery(this).find('img').css('margin-left', (li_width-img_width)/2 );                
            });
        }
    });
});

function mobile_navigation(){
	var ul_obj = jQuery('#menu-main-menu');
	jQuery(".main-menu .mob-menu").click(function () {
        jQuery('#menu-main-menu').toggle();
	});
    jQuery('#menu-main-menu li .mob-sub-opened').click(function () {
        jQuery(this).parent().find('ul.sub-menu').toggle();        
	});	
}