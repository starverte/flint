<?php
/**
 * The widget area that appears above the content.
 *
 * @package Flint
 * @since 1.2.0
 */

$type = get_post_type();
?>

<?php if ( is_active_sidebar( 'header' ) ) { ?>
  <div class="fill-light widgets widgets-header" role="complementary">
    <div class="container">
      <?php echo flint_post_margin(); ?>
      <div class="widget-area <?php echo flint_post_width_class(); ?>" >
        <?php do_action( 'before_sidebar' ); ?>
        <?php do_action( 'flint_widget_area_header_'.$type ); ?>
        <?php dynamic_sidebar( 'header' ); ?>
      </div><!-- .widget-area -->
      <?php echo flint_post_margin(); ?>
    </div>
  </div><!-- .widgets.widgets-header -->
<?php } ?>
