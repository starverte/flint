<?php
/**
 * Flint Options
 * WordPress Options API
 *
 * @package Flint
 * @since 1.3.0
 */

/**
 * Get option defaults
 *
 * @since 1.5.0
 */
function flint_options_defaults() {
  $defaults = array(
    'text_color'                 => '#404040',
    'body_bg'                    => '#ffffff',
    'fill_color'                 => '#ffffff',
    'fill'                       => '#222222',
    'link_color'                 => '#428bca',

    'font_family_base'           => 'Native',
    'headings_font_family'       => 'Native',

    'org'                        => '',
    'org_address'                => '',
    'org_locality'               => '',
    'org_postal_code'            => '',
    'org_tel'                    => '',
    'org_fax'                    => '',
    'org_email'                  => '',

    'clear_nav'                  => 'breadcrumbs',
    'clear_width'                => 'full',

    'footer_content'             => '',

    'page_featured_image'        => 'always',
    'page_default_width'         => 'full',

    'post_featured_image'        => 'always',
    'post_default_width'         => 'full',

    'minimal_nav'                => 'navbar',
    'minimal_widget_area'        => 'none',
    'minimal_width'              => 'full',

    'widget_areas_above'         => '1',
    'widget_areas_below'         => '1',
  );

  return apply_filters( 'flint_option_defaults', $defaults );
}

/**
 * Gets array of theme options
 * For backwards compatibility, can also get single value
 *
 * @since 1.5.0
 *
 * @param string $option Deprecated. The single option to return.
 */
function flint_options( $option = null ) {
  $defaults = flint_options_defaults();

  $defaults['body_bg']    = get_theme_mod( 'background_color', $defaults['body_bg'] );
  $defaults['fill_color'] = get_theme_mod( 'header_textcolor', $defaults['fill_color'] );
  $flint_options = wp_parse_args( get_option( 'flint_options' ), $defaults );

  if ( ! empty( $option ) ) {
    $search = array(
      'canvas-text',
      'canvas',
      'link',
      'body_font',
      'heading_font',
      'company',
      'address',
      'locality',
      'postal_code',
      'tel',
      'fax',
      'email',
      'text',
      'pages_image',
      'default_width',
      'posts_image',
      'default_post_width',
      'header',
      'footer',
    );

    $replace = array(
      'fill_color',
      'fill',
      'link_color',
      'font_family_base',
      'headings_font_family',
      'org',
      'org_address',
      'org_locality',
      'org_postal_code',
      'org_tel',
      'org_fax',
      'org_email',
      'footer_content',
      'page_featured_image',
      'page_default_width',
      'post_featured_image',
      'post_default_width',
      'widget_areas_above',
      'widget_areas_below',
    );

    $_option = str_replace( $search, $replace, $option );
    flint_deprecated_parameter( __FUNCTION__, '$option', '1.4.0' );
    return $flint_options[ $_option ];
  } else {
    return $flint_options;
  }
}

/**
 * Get color option values
 *
 * @since 1.5.0
 */
function flint_options_colors() {
  $options = flint_options();
  $calc = array(
    'link_hover_color' => flint_color_darken( $options['link_color'], 15 ),
    'blockquote_border_color' => flint_color_lighten( $options['fill'], 15 ),
    'fill_darker' => flint_color_darken( $options['fill'], 20 ),
    'fill_light' => flint_color_lighten( $options['fill'], 15 ),
  );
  return wp_parse_args( $options, $calc );
}

/**
 * Get address from options
 *
 * @since 1.3.0
 *
 * @param bool  $schema If true, return address with schema.org microdata.
 * @param array $args Array of address return arguments.
 */
function flint_get_address( $schema = true, $args = array() ) {
  $options = flint_options();

  $defaults = array(
    'before' => '<span id="street" itemprop="streetAddress">',
    'item1'  => $options['org_address'],
    'sep1'   => '</span>, <span id="locality" itemprop="addressLocality">',
    'item2'  => $options['org_locality'],
    'sep2'   => '</span> <span id="postal-code" itemprop="postalCode">',
    'item3'  => $options['org_postal_code'],
    'after'  => '</span>',
    'open'   => '<div id="org" itemscope itemtype="http://schema.org/Organization"><span id="address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">',
    'close'  => '</span></div>',
  );

  $alts = array(
    'before' => '',
    'item1'  => $options['org_address'],
    'sep1'   => ', ',
    'item2'  => $options['org_locality'],
    'sep2'   => ' ',
    'item3'  => $options['org_postal_code'],
    'after'  => '',
    'open'   => '',
    'close'  => '',
  );

  $args = true == $schema ? wp_parse_args( $args, $defaults ) : wp_parse_args( $args, $alts );
  $output = $args['open'] . $args['before'] . $args['item1'] . $args['sep1'] . $args['item2'] . $args['sep2'] . $args['item3'] . $args['after'] . $args['close'];
  echo $output;
}

