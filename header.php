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
  <?php if ( function_exists( 'steel_open' ) ) { steel_open(); } ?>
  <div id="page" class="hfeed site">
    <?php do_action( 'before' ); ?>
    <header id="masthead" class="site-header" role="banner">
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <h1 class="screen-reader-text"><?php _e( 'Menu', 'flint' ); ?></h1>
        <div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'flint' ); ?>"><?php _e( 'Skip to content', 'flint' ); ?></a></div>
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand visible-xs" href="<?php echo esc_url( home_url() ); ?>"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></a>
          </div><!-- .navbar-header -->
          
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse navbar-ex1-collapse">
            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav navbar-nav', 'fallback_cb' => false, 'walker' => new Flint_Bootstrap_Menu ) ); ?>
            <form method="get" class="navbar-form navbar-right" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
              <div class="form-group">
                <input type="text" class="form-control" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="Search" style="width: 200px;">
              </div>
            </form>
          </div><!-- .navbar-collapse -->
        </div><!-- .container -->
      </nav><!-- .navbar -->
      <?php if (current_theme_supports('custom-header')) { ?>
        <div class="container hidden-xs">
          <?php $header_image = get_header_image();
          if ( ! empty( $header_image ) ) { ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" <?php if ( display_header_text() ) { ?> class="col-lg-2 col-md-2 visible-lg visible-md"<?php } ?>>
              <img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
            </a>
          <?php } /* if ( ! empty( $header_image ) ) */
          if ( display_header_text() ) { ?>
            <div class="site-branding <?php if ( ! empty( $header_image ) ) { ?>col-lg-1 col-lg-10 col-md-10<?php } ?>">
              <h1 class="site-title hidden-xs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
              <h2 class="site-description hidden-xs"><?php bloginfo( 'description' ); ?></h2>
            </div><!-- .site-branding -->
          <?php } /* if ( display_header_text() ) */ ?>
        </div><!-- .container -->
      <?php } /* if (current_theme_supports('custom-header')) */ ?>
    </header><!-- #masthead -->
