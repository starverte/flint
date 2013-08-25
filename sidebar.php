<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Flint
 */
?>
  <div id="secondary" role="complementary">
    <div class="container">
      <div class="col-lg-2 col-md-2 col-sm-2"></div>
      <div id="secondary-inner" class="widget-area col-lg-8 col-md-8 col-sm-8" >
        <?php do_action( 'before_sidebar' ); ?>
        <?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
        <?php endif; // end sidebar widget area ?>
      </div><!-- #secondary-inner -->
      <div class="col-lg-2 col-md-2 col-sm-2"></div>
    </div>
  </div><!-- #secondary -->
