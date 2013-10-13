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
  'footer_copyright' => '&copy; ' . date('Y') . ' ' . get_bloginfo('name'),
  'intro_text' => '',
  'featured_cat' => '',
);

$flint_layout = array(
  'layout_view' => 'fixed'
);

$flint_advanced = array(
  'author_credits' => true
);

if ( is_admin() ) : // Load only if we are viewing an admin page

function flint_register_settings() {
  // Register settings
  register_setting( 'flint_section_general', 'flint_general', 'flint_validate_general');
  register_setting( 'flint_section_staff', 'flint_staff', 'flint_validate_staff');
  register_setting( 'flint_section_sermons', 'flint_sermons', 'flint_validate_sermons');
  register_setting( 'flint_section_search_results', 'flint_search_results', 'flint_validate_search_results');
  register_setting( 'flint_section_podcast', 'flint_podcast', 'flint_validate_podcast');
}

add_action( 'admin_init', 'flint_register_settings' );

function flint_section_options() {
  // Add theme options page to the addmin menu
  add_theme_page( 'Theme Options', 'Theme Options', 'edit_theme_options', 'theme_options', 'flint_section_home_page' );
}

add_action( 'admin_menu', 'flint_section_options' );

function flint_admin_tabs( $current = 'general' ) { 
    $tabs = array( 'general' => 'General', 'staff' => 'Staff', 'sermons' => 'Sermon Archives', 'search_results' => 'Search Results', 'podcast' => 'Podcast' ); 
    $links = array(); 
    foreach( $tabs as $tab => $name ) : 
        $links[] = "<a class='nav-tab' href='?page=theme_options&tab=$tab'>$name</a>"; 
    endforeach; 
    echo '<h2>'; 
    foreach ( $links as $link ) 
        echo $link; 
    echo '</h2>'; 
}

// Function to generate options page
function flint_section_home_page() {
  global $pagenow;

  flint_admin_tabs();
  
  if ( $pagenow == 'themes.php' && $_GET['page'] == 'theme_options' ) : 
    if ( isset ( $_GET['tab'] ) ) : 
        $tab = $_GET['tab']; 
    else: 
        $tab = 'general'; 
    endif; 
    switch ( $tab ) : 
        case 'general' : 
            theme_general_options(); 
            break; 
        case 'staff' : 
            theme_staff_options(); 
            break;
    case 'sermons' : 
            theme_sermons_options(); 
            break;  
        case 'search_results' : 
            theme_search_results_options(); 
            break;
    case 'podcast' : 
            theme_podcast_options(); 
            break; 
    endswitch; 
  endif;
}

// Function to generate options page
function theme_general_options() {
  global $flint_general;

  if ( ! isset( $_REQUEST['updated'] ) )
    $_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>

  <div class="wrap">
    
  <?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options' ) . "</h2>";
  // This shows the page's name and an icon if one has been provided ?>

  <?php if ( false !== $_REQUEST['updated'] ) : ?>
  <div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
  <?php endif; // If the form has just been submitted, this shows the notification ?>

  <form method="post" action="options.php">
    
  <?php $settings = get_option( 'flint_general', $flint_general ); ?>
  
  <?php settings_fields( 'flint_section_general' );
  /* This function outputs some hidden fields required by the form,
  including a nonce, a unique number used to ensure the form has been submitted from the admin page
  and not somewhere else, very important for security */ ?>

  <table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->

  <?php
  /**
   * Asks for text to display in Search box
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'Text for search box', 'flint' ); ?></th>
    <td>
      <input type="text" id="flint_general[s_text]" class="regular-text" name="flint_general[s_text]" value="<?php esc_attr_e( $settings['s_text'] ); ?>" value="<?php esc_attr_e( $settings['s_text'] ); ?>"  />
      <label class="description" for="flint_general[s_text]"><?php _e( 'ex. Search', 'flint' ); ?></label>
    </td>
  </tr>

  <?php
  /**
   * Asks for Facebook profile URL
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'Facebook page', 'flint' ); ?></th>
    <td>
      <input id="flint_general[fb_url]" class="regular-text" type="text" name="flint_general[fb_url]" value="<?php esc_attr_e( $settings['fb_url'] ); ?>" />
      <label class="description" for="flint_general[fb_url]"><?php _e( 'ex. http://facebook.com/starverte', 'flint' ); ?></label>
    </td>
  </tr>

  <?php
  /**
   * Asks for Podcast URL
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'iTunes Podcast', 'flint' ); ?></th>
    <td>
      <input id="flint_general[pod_url]" class="regular-text" type="text" name="flint_general[pod_url]" value="<?php esc_attr_e( $settings['pod_url'] ); ?>" />
    </td>
  </tr>

  <?php
  /**
   * Asks for Contact Us Form slug
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'Contact Us Form', 'flint' ); ?></th>
    <td>
      <input id="flint_general[contact_slug]" class="regular-text" type="text" name="flint_general[contact_slug]" value="<?php esc_attr_e( $settings['contact_slug'] ); ?>" />
      <label class="description" for="flint_general[contact_slug]"><?php _e( 'ex. http://mbeall.yelp.com', 'flint' ); ?></label>
    </td>
  </tr>

  <?php
  /**
   * Asks for Prayer Form slug
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'Prayer Form', 'flint' ); ?></th>
    <td>
      <input id="flint_general[prayer_slug]" class="regular-text" type="text" name="flint_general[prayer_slug]" value="<?php esc_attr_e( $settings['prayer_slug'] ); ?>" />
      <label class="description" for="flint_general[prayer_slug]"><?php _e( 'ex. &copy 2011 Star Verte LLC', 'flint' ); ?></label>
    </td>
  </tr>
  
  <?php
  /**
   * Footer Heading
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'Footer Heading', 'flint' ); ?></th>
    <td>
      <input id="flint_general[footer_heading]" class="regular-text" type="text" name="flint_general[footer_heading]" value="<?php esc_attr_e( $settings['footer_heading'] ); ?>" />
    </td>
  </tr>
  
  <?php
  /**
   * Footer Text
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'Footer Text', 'flint' ); ?></th>
    <td>
      <textarea id="flint_general[footer_text]" class="text-field" name="flint_general[footer_text]" rows="8" style="width:80%;max-width:400px;"><?php echo stripslashes($settings['footer_text']); ?></textarea>
    </td>
  </tr>

  </table>

  <p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>

  </form>

  </div>

  <?php
}

// Function to generate options page
function theme_staff_options() {
  global $flint_staff;

  if ( ! isset( $_REQUEST['updated'] ) )
    $_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>

  <div class="wrap">

  <?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Staff Options' ) . "</h2>";
  // This shows the page's name and an icon if one has been provided ?>

  <?php if ( false !== $_REQUEST['updated'] ) : ?>
  <div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
  <?php endif; // If the form has just been submitted, this shows the notification ?>

  <form method="post" action="options.php">
    
    <?php $settings = get_option( 'flint_staff', $flint_staff ); ?>
  
  <?php settings_fields( 'flint_section_staff' );
  /* This function outputs some hidden fields required by the form,
  including a nonce, a unique number used to ensure the form has been submitted from the admin page
  and not somewhere else, very important for security */ ?>

  <table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->

  <?php
  /**
   * First Next Steps Post ID (staff page)
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'First Box', 'flint' ); ?></th>
    <td>
      <input id="flint_staff[staffns1]" class="regular-text" type="text" name="flint_staff[staffns1]" value="<?php esc_attr_e( $settings['staffns1'] ); ?>" />
    </td>
  </tr>

  <?php
  /**
   * Second Next Steps Post ID (staff page)
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'Second Box', 'flint' ); ?></th>
    <td>
      <input id="flint_staff[staffns2]" class="regular-text" type="text" name="flint_staff[staffns2]" value="<?php esc_attr_e( $settings['staffns2'] ); ?>" />
    </td>
  </tr>

  <?php
  /**
   * Third Next Steps Post ID (staff page)
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'Third Box', 'flint' ); ?></th>
    <td>
      <input id="flint_staff[staffns3]" class="regular-text" type="text" name="flint_staff[staffns3]" value="<?php esc_attr_e( $settings['staffns3'] ); ?>" />
    </td>
  </tr>

  </table>

  <p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>

  </form>

  </div>

  <?php
}

// Function to generate options page
function theme_sermons_options() {
  global $flint_sermon;

  if ( ! isset( $_REQUEST['updated'] ) )
    $_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>

  <div class="wrap">

  <?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Sermon Archive Options' ) . "</h2>";
  // This shows the page's name and an icon if one has been provided ?>

  <?php if ( false !== $_REQUEST['updated'] ) : ?>
  <div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
  <?php endif; // If the form has just been submitted, this shows the notification ?>

  <form method="post" action="options.php">
    
    <?php $settings = get_option( 'flint_sermons', $flint_sermon ); ?>
  
  <?php settings_fields( 'flint_section_sermons' );
  /* This function outputs some hidden fields required by the form,
  including a nonce, a unique number used to ensure the form has been submitted from the admin page
  and not somewhere else, very important for security */ ?>

  <table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->

  <?php
  /**
   * First Next Steps Post ID (sermon page)
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'First Box', 'flint' ); ?></th>
    <td>
      <input id="flint_sermons[sermonns1]" class="regular-text" type="text" name="flint_sermons[sermonns1]" value="<?php esc_attr_e( $settings['sermonns1'] ); ?>" />
    </td>
  </tr>

  <?php
  /**
   * Second Next Steps Post ID (sermon page)
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'Second Box', 'flint' ); ?></th>
    <td>
      <input id="flint_sermons[sermonns2]" class="regular-text" type="text" name="flint_sermons[sermonns2]" value="<?php esc_attr_e( $settings['sermonns2'] ); ?>" />
    </td>
  </tr>

  <?php
  /**
   * Third Next Steps Post ID (sermon page)
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'Third Box', 'flint' ); ?></th>
    <td>
      <input id="flint_sermons[sermonns3]" class="regular-text" type="text" name="flint_sermons[sermonns3]" value="<?php esc_attr_e( $settings['sermonns3'] ); ?>" />
    </td>
  </tr>

  </table>

  <p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>

  </form>

  </div>

  <?php
}


// Function to generate options page
function theme_search_results_options() {
  global $flint_search_results;

  if ( ! isset( $_REQUEST['updated'] ) )
    $_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>

  <div class="wrap">

  <?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Search Results Options' ) . "</h2>";
  // This shows the page's name and an icon if one has been provided ?>

  <?php if ( false !== $_REQUEST['updated'] ) : ?>
  <div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
  <?php endif; // If the form has just been submitted, this shows the notification ?>

  <form method="post" action="options.php">
    
    <?php $settings = get_option( 'flint_search_results', $flint_search_results ); ?>
  
  <?php settings_fields( 'flint_section_search_results' );
  /* This function outputs some hidden fields required by the form,
  including a nonce, a unique number used to ensure the form has been submitted from the admin page
  and not somewhere else, very important for security */ ?>

  <table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->

  <?php
  /**
   * First Next Steps Post ID (search results page)
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'First Box', 'flint' ); ?></th>
    <td>
      <input id="flint_search_results[searchns1]" class="regular-text" type="text" name="flint_search_results[searchns1]" value="<?php esc_attr_e( $settings['searchns1'] ); ?>" />
    </td>
  </tr>

  <?php
  /**
   * Second Next Steps Post ID (search results page)
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'Second Box', 'flint' ); ?></th>
    <td>
      <input id="flint_search_results[searchns2]" class="regular-text" type="text" name="flint_search_results[searchns2]" value="<?php esc_attr_e( $settings['searchns2'] ); ?>" />
    </td>
  </tr>

  <?php
  /**
   * Third Next Steps Post ID (search results page)
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'Third Box', 'flint' ); ?></th>
    <td>
      <input id="flint_search_results[searchns3]" class="regular-text" type="text" name="flint_search_results[searchns3]" value="<?php esc_attr_e( $settings['searchns3'] ); ?>" />
    </td>
  </tr>

  <?php
  /**
   * Fourth Next Steps Post ID (search results page)
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'Fourth Box', 'flint' ); ?></th>
    <td>
      <input id="flint_search_results[searchns4]" class="regular-text" type="text" name="flint_search_results[searchns4]" value="<?php esc_attr_e( $settings['searchns4'] ); ?>" />
    </td>
  </tr>

  <?php
  /**
   * Fifth Next Steps Post ID (search results page)
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'Fifth Box', 'flint' ); ?></th>
    <td>
      <input id="flint_search_results[searchns5]" class="regular-text" type="text" name="flint_search_results[searchns5]" value="<?php esc_attr_e( $settings['searchns5'] ); ?>" />
    </td>
  </tr>

  </table>

  <p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>

  </form>

  </div>

  <?php
}


// Function to generate options page
function theme_podcast_options() {
  global $flint_podcast;

  if ( ! isset( $_REQUEST['updated'] ) )
    $_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>

  <div class="wrap">

  <?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Podcast Options' ) . "</h2>";
  // This shows the page's name and an icon if one has been provided ?>

  <?php if ( false !== $_REQUEST['updated'] ) : ?>
  <div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
  <?php endif; // If the form has just been submitted, this shows the notification ?>

  <form method="post" action="options.php">
    
    <?php $settings = get_option( 'flint_podcast', $flint_podcast ); ?>
  
  <?php settings_fields( 'flint_section_podcast' );
  /* This function outputs some hidden fields required by the form,
  including a nonce, a unique number used to ensure the form has been submitted from the admin page
  and not somewhere else, very important for security */ ?>

  <table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->

  <?php
  /**
   * Podcast Title
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'Title', 'flint' ); ?></th>
    <td>
      <input id="flint_podcast[pod_title]" class="regular-text" type="text" name="flint_podcast[pod_title]" value="<?php esc_attr_e( $settings['pod_title'] ); ?>" />
      <label class="description" for="flint_podcast[pod_title]"><?php _e( 'i.e. LifePointe Sermon Podcast', 'flint' ); ?></label>
    </td>
  </tr>
  
  <?php
  /**
   * Podcast Sub-Title
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'Subtitle', 'flint' ); ?></th>
    <td>
      <input id="flint_podcast[pod_subtitle]" class="regular-text" type="text" name="flint_podcast[pod_subtitle]" value="<?php esc_attr_e( $settings['pod_subtitle'] ); ?>" />
      <label class="description" for="flint_podcast[pod_subtitle]"><?php _e( '(optional)', 'flint' ); ?></label>
    </td>
  </tr>
    
    <?php
  /**
   * Podcast Copyright Notice
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'Copyright Notice', 'flint' ); ?></th>
    <td>
      <input id="flint_podcast[pod_copy]" class="regular-text" type="text" name="flint_podcast[pod_copy]" value="<?php esc_attr_e( $settings['pod_copy'] ); ?>" />
      <label class="description" for="flint_podcast[pod_copy]"><?php _e( 'i.e. &#xA9;2012 LifePointe Church', 'flint' ); ?></label>
    </td>
  </tr>
  
  <?php
  /**
   * Podcast Author
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'Author', 'flint' ); ?></th>
    <td>
      <input id="flint_podcast[pod_author]" class="regular-text" type="text" name="flint_podcast[pod_author]" value="<?php esc_attr_e( $settings['pod_author'] ); ?>" />
      <label class="description" for="flint_podcast[pod_author]"><?php _e( 'i.e. LifePointe Church', 'flint' ); ?></label>
    </td>
  </tr>
  
  <?php
  /**
   * Podcast Summary
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'Summary', 'flint' ); ?></th>
    <td>
      <textarea id="flint_podcast[pod_summary]" class="text-field" name="flint_podcast[pod_summary]" rows="2" style="width:80%;max-width:400px;"><?php echo stripslashes($settings['pod_summary']); ?></textarea>
    </td>
  </tr>
  
  <?php
  /**
   * Podcast Description
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'Description', 'flint' ); ?></th>
    <td>
      <textarea id="flint_podcast[pod_desc]" class="text-field" name="flint_podcast[pod_desc]" rows="5" style="width:80%;max-width:400px;"><?php echo stripslashes($settings['pod_desc']); ?></textarea>
    </td>
  </tr>
  
  <tr valign="top"><th scope="row"><h3>Podcast Owner</h3></th></tr>
  
  <?php
  /**
   * Podcast Owner
   */
  ?>
  <tr valign="top"><th scope="row"><?php _e( 'Name', 'flint' ); ?></th>
    <td>
      <input id="flint_podcast[pod_owner]" class="regular-text" type="text" name="flint_podcast[pod_owner]" value="<?php esc_attr_e( $settings['pod_owner'] ); ?>" />
      <label class="description" for="flint_podcast[pod_owner]"><?php _e( 'i.e. Steve Paxton', 'flint' ); ?></label>
    </td>
  </tr>
  <tr valign="top"><th scope="row"><?php _e( 'Email', 'flint' ); ?></th>
    <td>
      <input id="flint_podcast[pod_owner_email]" class="regular-text" type="text" name="flint_podcast[pod_owner_email]" value="<?php esc_attr_e( $settings['pod_owner_email'] ); ?>" />
      <label class="description" for="flint_podcast[pod_owner_email]"><?php _e( 'i.e. stevepaxton@sharethelife.org', 'flint' ); ?></label>
    </td>
  </tr>

  </table>

  <p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>

  </form>

  </div>

  <?php
}

function flint_validate_general( $input ) {
  global $flint_general;

  $settings = get_option( 'flint_general', $flint_general );
	
	// Say our textarea option must be safe text with the allowed tags for posts
  $input['footer_text'] = wp_filter_post_kses( $input['footer_text'] );
  
  return $input;
}

function flint_validate_staff( $input ) {
  global $flint_staff;

  $settings = get_option( 'flint_staff', $flint_staff );
  
  return $input;
}

function flint_validate_sermons( $input ) {
  global $flint_sermons;

  $settings = get_option( 'flint_sermons', $flint_sermons );
  
  return $input;
}

function flint_validate_search_results( $input ) {
  global $flint_search_results;

  $settings = get_option( 'flint_search_results', $flint_search_results );
    
  return $input;
}

function flint_validate_podcast( $input ) {
  global $flint_podcast;

  $settings = get_option( 'flint_podcast', $flint_podcast );
  
  // Say our textarea option must be safe text with the allowed tags for posts
  $input['pod_summary'] = wp_filter_post_kses( $input['pod_summary'] );
  $input['pod_desc'] = wp_filter_post_kses( $input['pod_desc'] );
    
  return $input;
}

endif;  // EndIf is_admin()
