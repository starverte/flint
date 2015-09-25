<?php
/**
 * The widget area that appears below the content.
 *
 * @package Flint
 * @since 1.1.0
 */

$type = get_post_type();
?>

<?php if ( is_active_sidebar( 'footer' ) ) { ?>
  <div class="fill-light widgets widgets-footer" role="complementary">
    <div class="container">
      <div class="row">
        <?php echo flint_post_margin(); ?>
        <div class="widget-area <?php echo flint_post_width_class(); ?>" >
          <?php do_action( 'before_sidebar' ); ?>
          <?php do_action( 'flint_widget_area_footer_'.$type ); ?>
          <?php dynamic_sidebar( 'footer' ); ?>
        </div><!-- .widget-area -->
        <?php echo flint_post_margin(); ?>
      </div><!-- .row -->
    </div><!-- .container -->
  </div><!-- .widgets.widgets-footer -->
<?php } ?>
<?php if ( is_active_sidebar( 'footer_left' ) || is_active_sidebar( 'footer_center' ) || is_active_sidebar( 'footer_right' ) ) { ?>
  <div class="fill-light widgets widgets-footer" role="complementary">
    <div class="container">
      <div class="row">
        <div class="widget-area col-md-4" >
          <?php do_action( 'before_sidebar' ); ?>
          <?php do_action( 'flint_widget_area_footer_left_'.$type ); ?>
          <?php dynamic_sidebar( 'footer_left' ); ?>
        </div><!-- .widget-area -->
        <div class="widget-area col-md-4" >
          <?php do_action( 'before_sidebar' ); ?>
          <?php do_action( 'flint_widget_area_footer_center_'.$type ); ?>
          <?php dynamic_sidebar( 'footer_center' ); ?>
        </div><!-- .widget-area -->
        <div class="widget-area col-md-4" >
          <?php do_action( 'before_sidebar' ); ?>
          <?php do_action( 'flint_widget_area_footer_right_'.$type ); ?>
          <?php dynamic_sidebar( 'footer_right' ); ?>
        </div><!-- .widget-area -->
      </div><!-- .row -->
    </div><!-- .container -->
  </div><!-- .widgets.widgets-footer -->
<?php } ?>
