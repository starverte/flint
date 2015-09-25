<?php
/**
 * Functions related to changing colors
 *
 * @package Flint
 * @since 1.1.0
 */

/**
 * Converts Hex to HSL
 *
 * @since 1.5.0
 *
 * @param string $color_hex A color, in hexadecimal i.e. 'ffffff'.
 *
 * @return array Hue, saturation, and luminance of the color
 */
function flint_color_hsl( $color_hex ) {
  $color_hex = str_replace( '#', '', $color_hex );

  if ( strlen( $color_hex ) < 3 ) { str_pad( $color_hex, 3 - strlen( $color_hex ), '0' ); }

  $bound  = strlen( $color_hex ) == 6 ? 2 : 1;
  $addend = 0;
  $factor = 1 == $bound ? ( $addend = 16 - 1 ) + 1 : 1;

  $red   = round( ( hexdec( substr( $color_hex, 0, $bound ) ) * $factor + $addend ) / 255, 6 );
  $green = round( ( hexdec( substr( $color_hex, $bound, $bound ) ) * $factor + $addend ) / 255, 6 );
  $blue  = round( ( hexdec( substr( $color_hex, ( $bound + $bound ) , $bound ) ) * $factor + $addend ) / 255, 6 );

  $color_hsl = array( 'hue' => 0, 'sat' => 0, 'lum' => 0 );

  $min = min( $red, $green, $blue );
  $max = max( $red, $green, $blue );

  $range = $max - $min;

  $color_hsl['lum'] = ( $min + $max ) / 2;

  if ( 0 == $range ) {
    $color_hsl['lum'] = round( $color_hsl['lum'], 3 );
    return $color_hsl;
  }

  $chroma = $range * 6;

  if ( $color_hsl['lum'] <= 0.5 ) {
    $color_hsl['sat'] = $range / ( $color_hsl['lum'] * 2 );
  } else {
    $color_hsl['sat'] = $range / ( 2 - ( $color_hsl['lum'] * 2 ) );
  }

  if ( $red <= 0.004 || $green <= 0.004 || $blue <= 0.004 ) {
    $color_hsl['sat'] = 1;
  }

  if ( $max == $red ) {
    if ( $blue > $green ) {
      $color_hsl['hue'] = 1 - ( abs( $green - $blue ) / $chroma );
    } else {
      $color_hsl['hue'] = ( $green - $blue ) / $chroma;
    }
  } else if ( $max == $green ) {
    if ( $red > $blue ) {
      $color_hsl['hue'] = abs( 1 - ( 4 / 3 ) + ( abs( $blue - $red ) / $chroma ) );
    } else {
      $color_hsl['hue'] = ( 1 / 3 ) + ( $blue - $red ) / $chroma;
    }
  } else {
    if ( $green < $red ) {
      $color_hsl['hue'] = 1 - 2 / 3 + abs( $red - $green ) / $chroma;
    } else {
      $color_hsl['hue'] = 2 / 3 + ( $red - $green ) / $chroma;
    }
  }

  $color_hsl['hue'] = round( $color_hsl['hue'], 3 );
  $color_hsl['sat'] = round( $color_hsl['sat'], 3 );
  $color_hsl['lum'] = round( $color_hsl['lum'], 3 );

  return $color_hsl;
}

/**
 * Converts HSL to Hex (or RGB array)
 *
 * @since 1.5.0
 *
 * @param double $hue The hue of the color.
 * @param double $sat The saturation of the hue.
 * @param double $lum The brightness of the hue.
 *
 * @return string A color, in hexadecimal i.e. 'ffffff'
 */
function flint_color_hex( $hue = 0, $sat = 0, $lum = 0 ) {

  $color_hsl = array( 'hue' => $hue, 'sat' => $sat, 'lum' => $lum );
  $color_rgb = array( 'red' => 0, 'green' => 0, 'blue' => 0 );

  foreach ( $color_hsl as $name => $value ) {
    if ( is_string( $value ) && strpos( $value, '%' ) !== false ) {
      $value = round( round( (int) str_replace( '%', '', $value ) / 100, 2 ) * 255, 0 );
    } else if ( is_float( $value ) ) {
      $value = round( $value * 255, 0 );
    }

    $value = (int) $value * 1;
    $value = $value > 255 ? 255 : ( $value < 0 ? 0 : $value );
    ${'v'.$name} = round( $value / 255, 6 );
  }

  $color_rgb['red'] = $vlum;
  $color_rgb['green'] = $vlum;
  $color_rgb['blue'] = $vlum;

  $wheel = $vlum <= 0.5 ? $vlum * ( 1.0 + $vsat ) : $vlum + $vsat - ( $vlum * $vsat );

  if ( $wheel > 0 ) {
    $alpha = $vlum + ( $vlum - $wheel );
    $sigma = round( ( $wheel - $alpha ) / $wheel, 6 );
    $pivot = floor( $vhue * 6 );
    $kappa = $vhue * 6 - $pivot;
    $theta = $wheel * $sigma * $kappa;
    $gamma = $alpha + $theta;
    $delta = $wheel - $theta;

    if ( 1 == $pivot ) {
      $color_rgb['red'] = $delta;
      $color_rgb['green'] = $wheel;
      $color_rgb['blue'] = $alpha;
    } else if ( 2 == $pivot ) {
      $color_rgb['red'] = $alpha;
      $color_rgb['green'] = $wheel;
      $color_rgb['blue'] = $gamma;
    } else if ( 3 == $pivot ) {
      $color_rgb['red'] = $alpha;
      $color_rgb['green'] = $delta;
      $color_rgb['blue'] = $wheel;
    } else if ( 4 == $pivot ) {
      $color_rgb['red'] = $gamma;
      $color_rgb['green'] = $alpha;
      $color_rgb['blue'] = $wheel;
    } else if ( 5 == $pivot ) {
      $color_rgb['red'] = $wheel;
      $color_rgb['green'] = $alpha;
      $color_rgb['blue'] = $delta;
    } else {
      $color_rgb['red'] = $wheel;
      $color_rgb['green'] = $gamma;
      $color_rgb['blue'] = $alpha;
    }
  }

  $color_rgb['red'] = round( $color_rgb['red'] * 255, 0 );
  $color_rgb['green'] = round( $color_rgb['green'] * 255, 0 );
  $color_rgb['blue'] = round( $color_rgb['blue'] * 255, 0 );

  $color_hex = '';
  $color_hex .= $color_rgb['red'] < 15 ? '0' . dechex( $color_rgb['red'] ) : dechex( $color_rgb['red'] );
  $color_hex .= $color_rgb['green'] < 15 ? '0' . dechex( $color_rgb['green'] ) : dechex( $color_rgb['green'] );
  $color_hex .= $color_rgb['blue'] < 15 ? '0' . dechex( $color_rgb['blue'] ) : dechex( $color_rgb['blue'] );

  return $color_hex;
}

/**
 * Darkens Hex color by defined percentage
 *
 * @since 1.5.0
 *
 * @param string $color_hex A color, in hexadecimal i.e. 'ffffff'.
 * @param double $percent The percentage to darken the color.
 *
 * @return string A hexadecimal color, a darker color than $color_hex
 */
function flint_color_darken( $color_hex, $percent ) {
  $color_hsl = flint_color_hsl( $color_hex );
  $color_hsl['lum'] = $color_hsl['lum'] - ( $percent / 100 );
  $color_hsl['lum'] = max( 0, $color_hsl['lum'] );
  $color_hex = flint_color_hex( $color_hsl['hue'], $color_hsl['sat'], $color_hsl['lum'] );
  return '#' . $color_hex;
}

/**
 * Lightens Hex color by defined percentage
 *
 * @since 1.5.0
 *
 * @param string $color_hex A color, in hexadecimal i.e. 'ffffff'.
 * @param double $percent The percentage to lighten the color.
 *
 * @return string A hexadecimal color, a lighter color than $color_hex
 */
function flint_color_lighten( $color_hex, $percent ) {
  $color_hsl = flint_color_hsl( $color_hex );
  $color_hsl['lum'] = $color_hsl['lum'] + ( $percent / 100 );
  $color_hsl['lum'] = max( 0, $color_hsl['lum'] );
  $color_hex = flint_color_hex( $color_hsl['hue'], $color_hsl['sat'], $color_hsl['lum'] );
  return '#' . $color_hex;
}
