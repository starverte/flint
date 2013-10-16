<?php
/**
 * Theme Options Page
 * Source: http://digitalraindrops.net/2011/02/tabbed-options-page/
 *
 * @package Flint
 * @since 1.1.0
 */

// Default options values
$flint_general = array(
  'font' => 'Open Sans'
);

$flint_footer = array(
  'company' => '',
  'address' => '',
  'locality' => '',
  'postal_code' => '',
  'tel' => '',
  'fax' => '',
  'email' => '',
  'text' => '',
);

if ( is_admin() ) {

  add_action( 'admin_menu', 'flint_section_options' );
  function flint_section_options() {
    add_theme_page( 'Flint Options', 'Flint Options', 'edit_theme_options', 'theme_options', 'flint_options_page' );
  }
  function flint_options_page() {
    global $pagenow;
    
    flint_admin_tabs();
    
    if ( $pagenow == 'themes.php' && $_GET['page'] == 'theme_options' ) {
      if ( isset ( $_GET['tab'] ) ) { $tab = $_GET['tab']; }
      else { $tab = 'general'; }
      switch ( $tab ) : 
        case 'general' : 
          flint_general_options(); 
          break;
        case 'footer' : 
          flint_footer_options(); 
          break; 
      endswitch; 
    }
  }
  function flint_admin_tabs( $current = 'general' ) {
    echo '<div class="wrap"><img style="float: left;height: 34px;margin: 7px 8px 0 0;width: 34px;" src="' . get_template_directory_uri() . '/img/sparks.png"><h2 class="nav-tab-wrapper">';
    if ( isset ( $_GET['tab'] ) ) { $tab = $_GET['tab']; }
    else { $tab = 'general'; }
    $flint_tabs = array( 'general' => 'Flint Options', 'footer' => 'Footer' ); 
    $links = array(); 
    foreach( $flint_tabs as $flint_tab => $name ) { $links[] = $flint_tab == $tab ? '<a class="nav-tab nav-tab-active" href="?page=theme_options&tab=' . $flint_tab . '">' . $name . '</a>' : '<a class="nav-tab" href="?page=theme_options&tab=' . $flint_tab . '">' . $name . '</a>'; }
    foreach ( $links as $link ) { echo $link; }
    echo '</h2>'; 
  }
  
  add_action( 'admin_init', 'flint_register_settings' );
  function flint_register_settings() {
    register_setting( 'flint_section_general', 'flint_general', 'flint_validate_general');
    register_setting( 'flint_section_footer', 'flint_footer', 'flint_validate_footer');
  }
  
  function flint_general_options() {
    global $flint_general;
    
    if ( ! isset( $_REQUEST['updated'] ) ) { $_REQUEST['updated'] = false; }
    if ( false !== $_REQUEST['updated'] ) { ?>
      <div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div><?php
    } ?>
    
    <form method="post" action="options.php">
    
      <?php $options = get_option( 'flint_general', $flint_general ); ?>
      
      <?php settings_fields( 'flint_section_general' ); ?>
      
      <p>Currently, there are no general theme options. But check out the Footer tab.</p>
      
      <table class="form-table">
      
        <tr valign="top"><th scope="row"><?php _e( 'Font', 'flint' ); ?></th>
          <td>
            <select name="flint_general[font]">
              <option value="open-sans"  <?php selected( $options['font'], 'open-sans'  ); ?>>Open Sans</option>
              <option value="oswald"     <?php selected( $options['font'], 'oswald'     ); ?>>Oswald</option>
              <option value="roboto"     <?php selected( $options['font'], 'roboto'     ); ?>>Roboto</option>
              <option value="droid-sans" <?php selected( $options['font'], 'droid-sans' ); ?>>Droid Sans</option>
              <option value="lato"       <?php selected( $options['font'], 'lato'       ); ?>>Lato</option>
            </select>
          </td>
        </tr>
      
      </table>
      
      <p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>
    
    </form>
    
    </div><?php
  }
  
  function flint_footer_options() {
    global $flint_footer;
    
    if ( ! isset( $_REQUEST['updated'] ) ) { $_REQUEST['updated'] = false; }
    if ( false !== $_REQUEST['updated'] ) { ?>
      <div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div><?php
    } ?>
    
    <form method="post" action="options.php">
    
      <?php $options = get_option( 'flint_footer', $flint_footer ); ?>
      
      <?php settings_fields( 'flint_section_footer' ); ?>
  
      <p>Customize the footer using template tags. For example, type in <code>ABC Company</code> in as "Company Name" and then in "Footer Text" type <code>Copyright {company}</code> and the Footer will output as <code>Copyright ABC Company</code>.</p>
      <p>Available tags: <code>{site title}</code>, <code>{site description}</code>, <code>{year}</code>, <code>{company}</code>, <code>{address}</code>, <code>{telephone}</code>, <code>{email}</code>, and <code>{fax}</code></p>
      
      <table class="form-table">
      
        <tr valign="top"><th scope="row"><?php _e( 'Company Name', 'flint' ); ?></th>
          <td><input id="flint_footer[company]" class="regular-text" type="text" name="flint_footer[company]" value="<?php esc_attr_e( $options['company'] ); ?>" /></td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Street Address', 'flint' ); ?></th>
          <td><input id="flint_footer[address]" class="regular-text" type="text" name="flint_footer[address]" value="<?php esc_attr_e( $options['address'] ); ?>" /></td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'City, State', 'flint' ); ?></th>
          <td><input id="flint_footer[locality]" class="regular-text" type="text" name="flint_footer[locality]" value="<?php esc_attr_e( $options['locality'] ); ?>" /></td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Zip Code', 'flint' ); ?></th>
          <td><input id="flint_footer[postal_code]" class="regular-text" type="text" name="flint_footer[postal_code]" value="<?php esc_attr_e( $options['postal_code'] ); ?>" /></td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Telephone Number', 'flint' ); ?></th>
          <td><input id="flint_footer[tel]" class="regular-text" type="text" name="flint_footer[tel]" value="<?php esc_attr_e( $options['tel'] ); ?>" /></td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Fax Number', 'flint' ); ?></th>
          <td><input id="flint_footer[fax]" class="regular-text" type="text" name="flint_footer[fax]" value="<?php esc_attr_e( $options['fax'] ); ?>" /></td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Email Address', 'flint' ); ?></th>
          <td><input id="flint_footer[email]" class="regular-text" type="text" name="flint_footer[email]" value="<?php esc_attr_e( $options['email'] ); ?>" /></td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Footer Text', 'flint' ); ?></th>
          <td><textarea id="flint_footer[text]" class="text-field" name="flint_footer[text]" rows="5" style="width:80%;max-width:400px;"><?php echo stripslashes($options['text']); ?></textarea></td>
        </tr>
      
      </table>
      
      <p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>
  
    </form>
  
    </div><?php
  }
  
  function flint_validate_general( $input ) {
    global $flint_general;
    $options = get_option( 'flint_general', $flint_general );  
    return $input;
  }
  
  function flint_validate_footer( $input ) {
    global $flint_footer;
    $options = get_option( 'flint_footer', $flint_footer );
    
    $input['text'] = wp_filter_post_kses( $input['text'] );
    return $input;
  }

}
