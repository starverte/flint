<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Flint
 */
?>
  <div class="widgets widgets-footer" role="complementary">
    <div class="container">
      <div class="col-lg-2 col-md-2 col-sm-2"></div>
      <div class="widget-area col-lg-8 col-md-8 col-sm-8" >
        <?php do_action( 'before_sidebar' ); ?>
        <?php if ( ! dynamic_sidebar( 'footer' ) ) : ?>
        <?php endif; ?>
      </div><!-- .widget-area -->
      <div class="col-lg-2 col-md-2 col-sm-2"></div>
    </div>
  </div><!-- .widgets.widgets-footer -->
