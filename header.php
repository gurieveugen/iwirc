<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <section id="content-section" class="cf">
 */
?>
<?php global $iwirc_options; ?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title><?php echo (wp_title( ' ', false, 'right' ) == '') ? get_bloginfo('name') : wp_title( ' ', false, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">	
    <!--[if IE]>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/ie.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style-des.css" type="text/css" media="screen" />
    <![endif]-->
    <!--[if !IE]>-->
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/style320.css" />
    <link rel="stylesheet" type="text/css" media="only screen and (min-width:768px)" href="<?php echo get_template_directory_uri(); ?>/css/style-des.css" /> 
    <!--<![endif]-->
    <?php wp_head(); ?>
    <!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
    <script charset="utf-8" type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/css_browser_selector.js"></script>
</head>

<body <?php body_class(); ?>>
<div class="global-box cf">
    <header id="header" class="cf">
        <div class="top-header cf">
            <div class="center-box">			  
                <ul class="share-header">
                    <?php if ( $iwirc_options['facebook'] ) : ?>                
				    <li class="facebook"><a href="<?php echo $iwirc_options['facebook']; ?>" target="_blank" title="Facebook" >facebok</a></li>
                    <?php endif; ?>
                    <?php if ( $iwirc_options['twitter'] ) : ?>
					<li class="tweet"><a href="<?php echo $iwirc_options['twitter']; ?>" target="_blank" title="Twitter">tweet</a></li>
                    <?php endif; ?>
                    <?php if ( $iwirc_options['google-plus'] ) : ?>
					<li class="google"><a href="<?php echo $iwirc_options['google-plus']; ?>" target="_blank" title="Google+">google</a></li>
                    <?php endif; ?>
                    <?php if ( $iwirc_options['linkedin'] ) : ?>
					<li class="in"><a href="<?php echo $iwirc_options['linkedin']; ?>" target="_blank" title="LinkedIn">in</a></li>
                    <?php endif; ?>
                    <?php if ( $iwirc_options['youtube'] ) : ?>
					<li class="youtube"><a href="<?php echo $iwirc_options['youtube']; ?>" target="_blank" title="YouTube">youtube</a></li>
                    <?php endif; ?>
				</ul>
            </div>
        </div>
		
        <div class="center-box">
            <header class="logo">
                <?php if ( $iwirc_options['logo'] ) : ?>
                <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><img src="<?php echo $iwirc_options['logo']; ?>" alt=" "></a></h1>
                <?php endif; ?>                
                <?php if ( $iwirc_options['tagline1'] ) : ?>
				<h2><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo $iwirc_options['tagline1']; ?></a></h2>
                <?php endif; ?>
                <?php if ( $iwirc_options['tagline2'] ) : ?>
				<h3><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo $iwirc_options['tagline2']; ?></a></h3>
                <?php endif; ?>
			</header>
            <?php if ( is_active_sidebar( 'sidebar-header' ) ) : ?>
                <?php dynamic_sidebar( 'sidebar-header' ); ?>
            <?php endif; ?>			
        </div>
	</header>
	
	<nav class="main-menu cf">
	  <div class="mob-menu">Menu</div>
	  <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'walker'=> new IWIRC_Arrow_Walker_Nav_Menu() ) ); ?>
	</nav>
	
	<section id="content-section" class="cf">
	
	

