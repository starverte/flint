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
  'company'     => '',
  'address'     => '',
  'locality'    => '',
  'postal_code' => '',
  'tel'         => '',
  'fax'         => '',
  'email'       => '',
  'text'        => '',
);

$flint_templates = array(
  'default_width'        => 'full',
  'widgets_footer_width' => 'match',
  'clear_nav'            => 'breadcrumbs',
  'clear_width'          => 'full',
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
        case 'templates' : 
          flint_templates_options(); 
          break;
      endswitch; 
    }
  }
  function flint_admin_tabs( $current = 'general' ) {
    echo '<div class="wrap"><img style="float: left;height: 34px;margin: 7px 8px 0 0;width: 34px;" src="' . get_template_directory_uri() . '/img/sparks.png"><h2 class="nav-tab-wrapper">';
    if ( isset ( $_GET['tab'] ) ) { $tab = $_GET['tab']; }
    else { $tab = 'general'; }
    $flint_tabs = array( 'general' => 'Flint Options', 'templates' => 'Page Templates' ); 
    $links = array(); 
    foreach( $flint_tabs as $flint_tab => $name ) { $links[] = $flint_tab == $tab ? '<a class="nav-tab nav-tab-active" href="?page=theme_options&tab=' . $flint_tab . '">' . $name . '</a>' : '<a class="nav-tab" href="?page=theme_options&tab=' . $flint_tab . '">' . $name . '</a>'; }
    foreach ( $links as $link ) { echo $link; }
    echo '</h2>'; 
  }
  
  add_action( 'admin_init', 'flint_register_settings' );
  function flint_register_settings() {
    register_setting( 'flint_section_general', 'flint_general', 'flint_validate_general');
    register_setting( 'flint_section_templates', 'flint_templates', 'flint_validate_templates');
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
  
      
      
      <table class="form-table">
      
        <tr valign="top"><th scope="row"><?php _e( 'Company Name', 'flint' ); ?></th>
          <td><input id="flint_general[company]" class="regular-text" type="text" name="flint_general[company]" value="<?php esc_attr_e( $options['company'] ); ?>" /></td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Street Address', 'flint' ); ?></th>
          <td><input id="flint_general[address]" class="regular-text" type="text" name="flint_general[address]" value="<?php esc_attr_e( $options['address'] ); ?>" /></td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'City, State', 'flint' ); ?></th>
          <td><input id="flint_general[locality]" class="regular-text" type="text" name="flint_general[locality]" value="<?php esc_attr_e( $options['locality'] ); ?>" /></td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Zip Code', 'flint' ); ?></th>
          <td><input id="flint_general[postal_code]" class="regular-text" type="text" name="flint_general[postal_code]" value="<?php esc_attr_e( $options['postal_code'] ); ?>" /></td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Phone Number', 'flint' ); ?></th>
          <td><input id="flint_general[tel]" class="regular-text" type="text" name="flint_general[tel]" value="<?php esc_attr_e( $options['tel'] ); ?>" /></td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Fax Number', 'flint' ); ?></th>
          <td><input id="flint_general[fax]" class="regular-text" type="text" name="flint_general[fax]" value="<?php esc_attr_e( $options['fax'] ); ?>" /></td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Email Address', 'flint' ); ?></th>
          <td><input id="flint_general[email]" class="regular-text" type="text" name="flint_general[email]" value="<?php esc_attr_e( $options['email'] ); ?>" /></td>
        </tr>
        
       </table>
        
      <p>Customize the footer using template tags. For example, type in <code>ABC Company</code> in as "Company Name" and then in "Footer Text" type <code><?php _e( '&<span></span>copy;'); ?> {year} {company}</code> and the Footer will output as <code>&copy; <?php echo date('Y'); ?> ABC Company</code>.</p>
      <p>Available tags: <code>{site title}</code>, <code>{site description}</code>, <code>{year}</code>, <code>{company}</code>, <code>{address}</code>, <code>{phone}</code>, <code>{email}</code>, and <code>{fax}</code></p>
      
      <table class="form-table">
        
        <tr valign="top"><th scope="row"><?php _e( 'Footer Text', 'flint' ); ?></th>
          <td><textarea id="flint_general[text]" class="text-field" name="flint_general[text]" rows="5" style="width:80%;max-width:400px;"><?php echo stripslashes($options['text']); ?></textarea></td>
        </tr>
      
      </table>
      
      <p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>
  
    </form>
  
    </div><?php
  }
  
  function flint_templates_options() {
    global $flint_templates;
    
    if ( ! isset( $_REQUEST['updated'] ) ) { $_REQUEST['updated'] = false; }
    if ( false !== $_REQUEST['updated'] ) { ?>
      <div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div><?php
    } ?>
    
    <form method="post" action="options.php">
    
      <?php $options = get_option( 'flint_templates', $flint_templates ); ?>
      
      <?php settings_fields( 'flint_section_templates' ); ?>
      
      <table class="form-table">
      
        <tr valign="top"><th scope="row"><h3>Default Page Template</h3></th></tr>
      
        <tr valign="top"><th scope="row"><?php _e( 'Page Width', 'flint' ); ?></th>
          <td>
            <select name="flint_templates[default_width]">
              <option value="full"   <?php selected( $options['default_width'], 'full'   ); ?>>Full</option>
              <option value="slim"   <?php selected( $options['default_width'], 'slim'   ); ?>>Slim</option>
              <option value="narrow" <?php selected( $options['default_width'], 'narrow' ); ?>>Narrow</option>
              <option value="wide"   <?php selected( $options['default_width'], 'wide'   ); ?>>Wide</option>
            </select>
          </td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Footer Widget Area Width', 'flint' ); ?></th>
          <td>
            <select name="flint_templates[widgets_footer_width]">
              <option value="match"  <?php selected( $options['widgets_footer_width'], 'match'  ); ?>>Match Page Width</option>
              <option value="slim"   <?php selected( $options['widgets_footer_width'], 'slim'   ); ?>>Slim</option>
              <option value="narrow" <?php selected( $options['widgets_footer_width'], 'narrow' ); ?>>Narrow</option>
              <option value="full"   <?php selected( $options['widgets_footer_width'], 'full'   ); ?>>Full</option>
              <option value="wide"   <?php selected( $options['widgets_footer_width'], 'wide'   ); ?>>Wide</option>
            </select>
          </td>
        </tr>
      
        <tr valign="top"><th scope="row"><h3>Clear</h3></th></tr>
      
        <tr valign="top"><th scope="row"><?php _e( 'Navigation', 'flint' ); ?></th>
          <td>
            <select name="flint_templates[clear_nav]">
              <option value="breadcrumbs" <?php selected( $options['clear_nav'], 'breadcrumbs' ); ?>>Breadcrumbs</option>
              <option value="navbar"      <?php selected( $options['clear_nav'], 'navbar'      ); ?>>Navigation Bar</option>
            </select>
          </td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Page Width', 'flint' ); ?></th>
          <td>
            <select name="flint_templates[clear_width]">
              <option value="full"   <?php selected( $options['clear_width'], 'full'   ); ?>>Full</option>
              <option value="slim"   <?php selected( $options['clear_width'], 'slim'   ); ?>>Slim</option>
              <option value="narrow" <?php selected( $options['clear_width'], 'narrow' ); ?>>Narrow</option>
              <option value="wide"   <?php selected( $options['clear_width'], 'wide'   ); ?>>Wide</option>
            </select>
          </td>
        </tr>
      
      </table>
      
      <p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>
    
    </form>
  
    </div><?php
  }
  
  function flint_validate_general( $input ) {
    global $flint_general;
    $options = get_option( 'flint_general', $flint_general );
    
    $input['text'] = wp_filter_post_kses( $input['text'] );
    return $input;
  }
  
  function flint_validate_templates( $input ) {
    global $flint_templates;
    $options = get_option( 'flint_templates', $flint_templates );  
    return $input;
  }

}
