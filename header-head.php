<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <header>
 *
 * @package Flint
 * @since 1.1.0
 */
?>
<!DOCTYPE html>
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
  <?php flint_options_css(); ?>
</head>
<body <?php flint_body_class(); ?>>
  <?php if ( function_exists( 'steel_open' ) ) { steel_open(); } ?>
  <div id="page" class="hfeed site">
    <div id="top-pad"></div>
    <?php do_action( 'before' ); ?>
