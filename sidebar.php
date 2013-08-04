<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Flint
 */
?>
	<div id="secondary" role="complementary">
  	<div class="container">
      <div class="col-lg-2 col-sm-2"></div>
      <div id="secondary-inner" class="widget-area col-lg-8 col-sm-8" >
        <?php do_action( 'before_sidebar' ); ?>
        <?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
    
          <aside id="search" class="widget widget_search">
            <?php get_search_form(); ?>
          </aside>
    
          <aside id="archives" class="widget">
            <h1 class="widget-title"><?php _e( 'Archives', 'flint' ); ?></h1>
            <ul>
              <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
            </ul>
          </aside>
    
          <aside id="meta" class="widget">
            <h1 class="widget-title"><?php _e( 'Meta', 'flint' ); ?></h1>
            <ul>
              <?php wp_register(); ?>
              <li><?php wp_loginout(); ?></li>
              <?php wp_meta(); ?>
            </ul>
          </aside>
    
        <?php endif; // end sidebar widget area ?>
      </div><!-- #secondary-inner -->
      <div class="col-lg-2 col-sm-2"></div>
    </div>
  </div><!-- #secondary -->
