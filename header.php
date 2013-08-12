<?php
/**
* The Header for our theme.
*
* Displays all of the <head> section and everything up till <div id="main">
*
* @package Flint
*/
?><!DOCTYPE html>
<!--[if lt IE 9]><html <?php language_attributes(); ?> class="ie"><![endif]-->
<!--[if gte IE 9]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php wp_title( '|', true, 'right' ); ?></title>
  <link rel="profile" href="http://gmpg.org/xfn/11" />
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
  <!--[if lt IE 9]>
  <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
  <![endif]-->
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); if (is_plugin_active('steel/steel.php')) { steel_open(); } ?>
  <div id="page" class="hfeed site">
    <?php do_action( 'before' ); ?>
    <header id="masthead" class="site-header" role="banner">
      <nav role="navigation" class="navbar navbar-inverse navbar-fixed-top">
        <h1 class="screen-reader-text"><?php _e( 'Menu', 'flint' ); ?></h1>
        <div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'flint' ); ?>"><?php _e( 'Skip to content', 'flint' ); ?></a></div>
        <div class="container">
        
          <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          </button>
          
          <!-- Be sure to leave the brand out there if you want it shown -->
          <a class="navbar-brand visible-sm" href="<?php echo esc_url( home_url() ); ?>"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></a>
          
          <div class="nav-collapse collapse navbar-responsive-collapse">
            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav navbar-nav', 'fallback_cb' => false, 'walker' => new Flint_Bootstrap_Menu ) ); ?>
            <form method="get" class="navbar-form pull-right" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
              <input type="text" class="form-control" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="Search" style="width: 200px;">
            </form>
          </div><!-- .nav-collapse -->
        </div><!-- .container -->
      </nav><!-- .navbar -->
      <?php if (current_theme_supports('custom-header')) { ?>
        <div class="container hidden-sm">
          <?php $header_image = get_header_image();
          if ( ! empty( $header_image ) ) { ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" <?php if ( display_header_text() ) { ?> class="col-lg-2 visible-lg"<?php } ?>>
              <img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
            </a>
          <?php } /* if ( ! empty( $header_image ) ) */
          if ( display_header_text() ) { ?>
            <div class="site-branding <?php if ( ! empty( $header_image ) ) { ?>col-lg-10<?php } ?>">
              <h1 class="site-title hidden-sm"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
              <h2 class="site-description hidden-sm"><?php bloginfo( 'description' ); ?></h2>
            </div><!-- .site-branding -->
          <?php } /* if ( display_header_text() ) */ ?>
        </div><!-- .container -->
      <?php } /* if (current_theme_supports('custom-header')) */ ?>
    </header><!-- #masthead -->