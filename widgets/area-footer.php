<?php
/**
 * The "Sidebar" that appears below the content.
 *
 * @package Flint
 * @since 1.1.0
 */
?>
  <div class="canvas-light widgets widgets-footer" role="complementary">
    <div class="container">
      <?php flint_get_widgets_template('margins', 'footer'); ?>
      <div class="widget-area <?php flint_get_widgets_template('content', 'footer'); ?>" >
        <?php do_action( 'before_sidebar' ); ?>
        <?php if ( ! dynamic_sidebar( 'footer' ) ) : ?>
        <?php endif; ?>
      </div><!-- .widget-area -->
      <?php flint_get_widgets_template('margins', 'footer'); ?>
    </div>
  </div><!-- .widgets.widgets-footer -->
