<?php
/**
 * Flint_Customize_Control_Textarea class
 *
 * @package Flint
 * @since 1.5.0
 */

/**
 * Customize Textarea Control class.
 *
 * Customize control for textarea tag.
 *
 * @since 1.5.0
 * @see WordPress 4.3.1 WP_Customize_Control
 *
 * @uses WP_Customize_Control
 */
class Flint_Customize_Control_Textarea extends WP_Customize_Control {

  /**
   * Type of control
   *
   * @access public
   * @var string
   */
  public $type = 'textarea';

  /**
   * Description text for control
   *
   * @access public
   * @var string
   */
  public $description;

  /**
   * Render the control's content.
   *
   * Allows the content to be overriden without having to rewrite the wrapper in $this->render().
   *
   * Control content can alternately be rendered in JS. See {@see WP_Customize_Control::print_template()}.
   */
  public function render_content() {
    ?>
    <label>
      <?php if ( ! empty( $this->label ) ) : ?>
        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
      <?php endif;
      if ( ! empty( $this->description ) ) : ?>
        <span class="description customize-control-description"><?php echo $this->description; ?></span>
      <?php endif; ?>
      <textarea rows="5" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
    </label>
    <?php
  }
}
