<?php
/**
 * Theme Options Page
 * Source: http://digitalraindrops.net/2011/02/tabbed-options-page/
 *
 * @package Flint
 * @since 1.2.0
 */

$flint_general = array();

$flint_layout = array();

$flint_templates = array();

if ( is_admin() ) {

  add_action( 'admin_menu', 'flint_admin_menu' );
  function flint_admin_menu() {
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
        case 'layout' : 
          flint_layout_options(); 
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
    $flint_tabs = array( 'general' => 'Flint Options', 'layout' => 'Layout Options', 'templates' => 'Page Templates' ); 
    $links = array(); 
    foreach( $flint_tabs as $flint_tab => $name ) { $links[] = $flint_tab == $tab ? '<a class="nav-tab nav-tab-active" href="?page=theme_options&tab=' . $flint_tab . '">' . $name . '</a>' : '<a class="nav-tab" href="?page=theme_options&tab=' . $flint_tab . '">' . $name . '</a>'; }
    foreach ( $links as $link ) { echo $link; }
    echo '</h2>'; 
  }
  
  add_action( 'admin_init', 'flint_admin_init' );
  function flint_admin_init() {
    register_setting( 'flint_section_general'  , 'flint_general'  , 'flint_validate_general'  );
    register_setting( 'flint_section_layout'   , 'flint_layout'   , 'flint_validate_layout'   );
    register_setting( 'flint_section_templates', 'flint_templates', 'flint_validate_templates');
  }
  
  function flint_general_options() {
    global $flint_general;
    
    if ( ! isset( $_REQUEST['updated'] ) ) { $_REQUEST['updated'] = false; }
    if ( false !== $_REQUEST['updated'] ) { ?>
      <div class="updated fade"><p><strong><?php _e( 'Options saved', 'flint' ); ?></strong></p></div><?php
    } ?>
    
    <form method="post" action="options.php">
    
      <?php
        $options = get_option( 'flint_general', $flint_general );
        $company     = !empty($options['company'])     ? $options['company']            : '';
        $tel         = !empty($options['tel'])         ? $options['tel']                : '';
        $email       = !empty($options['email'])       ? $options['email']              : '';
        $fax         = !empty($options['fax'])         ? $options['fax']                : '';
        $address     = !empty($options['address'])     ? $options['address']            : '';
        $locality    = !empty($options['locality'])    ? $options['locality']           : '';
        $postal_code = !empty($options['postal_code']) ? $options['postal_code']        : '';
        $footer      = !empty($options['text'])        ? stripslashes($options['text']) : '';
      ?>
      
      <?php settings_fields( 'flint_section_general' ); ?>
      
      <table class="form-table">
      
        <tr valign="top"><th scope="row"><?php _e( 'Company Name', 'flint' ); ?></th>
          <td><input id="flint_general[company]" class="regular-text" type="text" name="flint_general[company]" value="<?php esc_attr( $company ); ?>" /></td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Street Address', 'flint' ); ?></th>
          <td><input id="flint_general[address]" class="regular-text" type="text" name="flint_general[address]" value="<?php esc_attr( $address ); ?>" /></td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'City, State', 'flint' ); ?></th>
          <td><input id="flint_general[locality]" class="regular-text" type="text" name="flint_general[locality]" value="<?php esc_attr( $locality ); ?>" /></td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Zip Code', 'flint' ); ?></th>
          <td><input id="flint_general[postal_code]" class="regular-text" type="text" name="flint_general[postal_code]" value="<?php esc_attr( $postal_code ); ?>" /></td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Phone Number', 'flint' ); ?></th>
          <td><input id="flint_general[tel]" class="regular-text" type="text" name="flint_general[tel]" value="<?php esc_attr( $tel ); ?>" /></td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Fax Number', 'flint' ); ?></th>
          <td><input id="flint_general[fax]" class="regular-text" type="text" name="flint_general[fax]" value="<?php esc_attr( $fax ); ?>" /></td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Email Address', 'flint' ); ?></th>
          <td><input id="flint_general[email]" class="regular-text" type="text" name="flint_general[email]" value="<?php esc_attr( $email ); ?>" /></td>
        </tr>
        
       </table>
        
      <p>Customize the footer using template tags. For example, type in <code>ABC Company</code> in as "Company Name" and then in "Footer Text" type <code>&amp;copy; {year} {company}</code> and the Footer will output as <code>&copy; <?php echo date('Y'); ?> ABC Company</code>.</p>
      <p>Available tags: <code>{site title}</code>, <code>{site description}</code>, <code>{year}</code>, <code>{company}</code>, <code>{address}</code>, <code>{phone}</code>, <code>{email}</code>, and <code>{fax}</code></p>
      
      <table class="form-table">
        
        <tr valign="top"><th scope="row"><?php _e( 'Footer Text', 'flint' ); ?></th>
          <td><textarea id="flint_general[text]" class="text-field" name="flint_general[text]" rows="5" style="width:80%;max-width:400px;"><?php echo $footer; ?></textarea></td>
        </tr>
      
      </table>
      
      <p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>
  
    </form>
  
    </div><?php
  }
  
  function flint_layout_options() {
    global $flint_layout;
    
    if ( ! isset( $_REQUEST['updated'] ) ) { $_REQUEST['updated'] = false; }
    if ( false !== $_REQUEST['updated'] ) { ?>
      <div class="updated fade"><p><strong><?php _e( 'Options saved', 'flint' ); ?></strong></p></div><?php
    } ?>
    
    <form method="post" action="options.php">
    
      <?php
        $options = get_option( 'flint_layout', $flint_layout );
        
        $posts_image = !empty($options['posts_image']) ? $options['posts_image'] : 'always';
        $pages_image = !empty($options['pages_image']) ? $options['pages_image'] : 'always';
      ?>
      
      <?php settings_fields( 'flint_section_layout' ); ?>
      
      <table class="form-table">
      
        <tr valign="top"><th scope="row"><h3>Featured Images</h3><p>These settings do not apply to the Wide Template.</p></th></tr>
      
        <tr valign="top"><th scope="row"><?php _e( 'Show for Posts', 'flint' ); ?></th>
          <td>
            <select name="flint_layout[posts_image]">
              <option value="always"   <?php selected( $posts_image, 'always'   ); ?>>Always</option>
              <option value="archives" <?php selected( $posts_image, 'archives' ); ?>>Archives/Search Only</option>
              <option value="never"    <?php selected( $posts_image, 'never'    ); ?>>Never</option>
            </select>
          </td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Show for Pages', 'flint' ); ?></th>
          <td>
            <select name="flint_layout[pages_image]">
              <option value="always"   <?php selected( $pages_image, 'always'   ); ?>>Always</option>
              <option value="archives" <?php selected( $pages_image, 'archives' ); ?>>Archives/Search Only</option>
              <option value="never"    <?php selected( $pages_image, 'never'    ); ?>>Never</option>
            </select>
          </td>
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
      <div class="updated fade"><p><strong><?php _e( 'Options saved', 'flint' ); ?></strong></p></div><?php
    } ?>
    
    <form method="post" action="options.php">
    
      <?php
        $options = get_option( 'flint_templates', $flint_templates );
        
        $default_width        = !empty($options['default_width'])        ? $options['default_width']        : 'full';
        $widgets_footer_width = !empty($options['widgets_footer_width']) ? $options['widgets_footer_width'] : 'match';
        $clear_nav            = !empty($options['clear_nav'])            ? $options['clear_nav']            : 'breadcrumbs';
        $clear_width          = !empty($options['clear_width'])          ? $options['clear_width']          : 'full';
        $minimal_nav          = !empty($options['minimal_nav'])          ? $options['minimal_nav']          : 'navbar';
        $minimal_width        = !empty($options['minimal_width'])        ? $options['minimal_width']        : 'full';
        $minimal_widget_area  = !empty($options['minimal_widget_area'])  ? $options['minimal_widget_area']  : 'none';
      ?>
      
      <?php settings_fields( 'flint_section_templates' ); ?>
      
      <table class="form-table">
      
        <tr valign="top"><th scope="row"><h3>Default Page Template</h3></th></tr>
      
        <tr valign="top"><th scope="row"><?php _e( 'Page Width', 'flint' ); ?></th>
          <td>
            <select name="flint_templates[default_width]">
              <option value="slim"   <?php selected( $default_width, 'slim'   ); ?>>Slim</option>
              <option value="narrow" <?php selected( $default_width, 'narrow' ); ?>>Narrow</option>
              <option value="full"   <?php selected( $default_width, 'full'   ); ?>>Full</option>
              <option value="wide"   <?php selected( $default_width, 'wide'   ); ?>>Wide</option>
            </select>
          </td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Footer Widget Area Width', 'flint' ); ?></th>
          <td>
            <select name="flint_templates[widgets_footer_width]">
              <option value="match"  <?php selected( $widgets_footer_width, 'match'  ); ?>>Match Page Width</option>
              <option value="slim"   <?php selected( $widgets_footer_width, 'slim'   ); ?>>Slim</option>
              <option value="narrow" <?php selected( $widgets_footer_width, 'narrow' ); ?>>Narrow</option>
              <option value="full"   <?php selected( $widgets_footer_width, 'full'   ); ?>>Full</option>
              <option value="wide"   <?php selected( $widgets_footer_width, 'wide'   ); ?>>Wide</option>
            </select>
          </td>
        </tr>
      
        <tr valign="top"><th scope="row"><h3>Clear</h3></th></tr>
      
        <tr valign="top"><th scope="row"><?php _e( 'Navigation', 'flint' ); ?></th>
          <td>
            <select name="flint_templates[clear_nav]">
              <option value="breadcrumbs" <?php selected( $clear_nav, 'breadcrumbs' ); ?>>Breadcrumbs</option>
              <option value="navbar"      <?php selected( $clear_nav, 'navbar'      ); ?>>Navigation Bar</option>
            </select>
          </td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Page Width', 'flint' ); ?></th>
          <td>
            <select name="flint_templates[clear_width]">
              <option value="slim"   <?php selected( $clear_width, 'slim'   ); ?>>Slim</option>
              <option value="narrow" <?php selected( $clear_width, 'narrow' ); ?>>Narrow</option>
              <option value="full"   <?php selected( $clear_width, 'full'   ); ?>>Full</option>
              <option value="wide"   <?php selected( $clear_width, 'wide'   ); ?>>Wide</option>
            </select>
          </td>
        </tr>
        
        <tr valign="top"><th scope="row"><h3>Minimal</h3></th></tr>
      
        <tr valign="top"><th scope="row"><?php _e( 'Navigation', 'flint' ); ?></th>
          <td>
            <select name="flint_templates[minimal_nav]">
              <option value="breadcrumbs" <?php selected( $minimal_nav, 'breadcrumbs' ); ?>>Breadcrumbs</option>
              <option value="navbar"      <?php selected( $minimal_nav, 'navbar'      ); ?>>Navigation Bar</option>
            </select>
          </td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Page Width', 'flint' ); ?></th>
          <td>
            <select name="flint_templates[minimal_width]">
              <option value="slim"   <?php selected( $minimal_width, 'slim'   ); ?>>Slim</option>
              <option value="narrow" <?php selected( $minimal_width, 'narrow' ); ?>>Narrow</option>
              <option value="full"   <?php selected( $minimal_width, 'full'   ); ?>>Full</option>
              <option value="wide"   <?php selected( $minimal_width, 'wide'   ); ?>>Wide</option>
            </select>
          </td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e( 'Widget Area', 'flint' ); ?></th>
          <td>
            <select name="flint_templates[minimal_widget_area]">
              <option value="none"   <?php selected( $minimal_widget_area, 'none'   ); ?>>None</option>
              <option value="header" <?php selected( $minimal_widget_area, 'header' ); ?>>Header</option>
              <option value="footer" <?php selected( $minimal_widget_area, 'footer' ); ?>>Footer</option>
              <option value="left" <?php selected( $minimal_widget_area, 'left'   ); ?>>Left</option>
              <option value="right" <?php selected( $minimal_widget_area, 'right'  ); ?>>Right</option>
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
  
  function flint_validate_layout( $input ) {
    global $flint_layout;
    $options = get_option( 'flint_layout', $flint_layout );  
    return $input;
  }
  
  function flint_validate_templates( $input ) {
    global $flint_templates;
    $options = get_option( 'flint_templates', $flint_templates );  
    return $input;
  }

}