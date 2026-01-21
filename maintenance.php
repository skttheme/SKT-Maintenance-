<?php
/*
Plugin Name: SKT Maintenance
Plugin URI: https://www.sktthemes.org/product-category/wordpress-plugins/
Description: SKT Maintenance plugin created to put your website on maintenance mode. It will give a fully customizable maintenance page.
Version: 1.5
Author: SKT Themes
Author URI: https://sktthemes.org/
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: skt-maintenance
*/
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
// Set Constants
define( 'SKTM_MAINTENANCE_DIR', dirname( __FILE__ ) );
define( 'SKTM_MAINTENANCE_URI', plugins_url( '', __FILE__ ) );
/*
* Install plugin
*/

if ( ! function_exists ( 'sktm_maintenance_install_cart' ) ) {
  function sktm_maintenance_install_cart(){
    // our post type will be automatically removed, so no need to unregister it
    // clear the permalinks to remove our post type's rules
    flush_rewrite_rules();
    //Filter on by default

    if ( get_option( 'page_title') == '' ) {
        update_option( 'page_title', 'Maintenance Mode');
    }
    if ( get_option( 'site_title_color' ) == '' ) {
        update_option( 'site_title_color', '#ffffff');
    }
    if ( get_option( 'site_title_font_size' ) == '') {
        update_option( 'site_title_font_size', '38');
    }
    if ( get_option( 'heading' ) == '' ) {
        update_option( 'heading', 'Maintenance mode is on');
    }
    if ( get_option( 'heading_color' ) == '' ) {
        update_option( 'heading_color', '#ffffff');
    }
    if ( get_option( 'headingfont_size' ) == '' ) {
        update_option( 'headingfont_size', '40' );
    }
    if ( get_option( 'test-editor' ) == '' ) {
      update_option( 'test-editor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec non turpis eu felis gravida egestas. Duis at diam metus. Morbi commodo lacus risus, quis cursus leo tempus eu. Ut ultrices ut nunc sed sollicitudin. Quisque vehicula diam scelerisque felis bibendum, at rhoncus nulla gravida. Vivamus commodo magna nec purus tempus dignissim. Praesent iaculis iaculis dui, et maximus mauris posuere eu. Nam malesuada nisl vel semper accumsan.' );
    }
    if ( get_option( 'description_color' ) == '' ) {
        update_option( 'description_color', '#ffffff' );
    }
    if ( get_option( 'descriptionfont_size' ) == '') {
        update_option( 'descriptionfont_size', '16' );
    }
    if ( get_option( 'footer_text' ) == '') {
        update_option( 'footer_text', '© Maintenance Mode 2021' );
    }
    if ( get_option( 'footer_text_color' ) == '' ) {
        update_option( 'footer_text_color', '#ffffff' );
    }
    if ( get_option( 'footer_textfont_size' ) == '' ) {
        update_option( 'footer_textfont_size', '16' );
    }
    if ( get_option( 'fontfamily' ) == '') {
        update_option( 'fontfamily', 'Open Sans' );
    }
    if ( get_option( 'background_bodycss' ) == '' ) {
        update_option( 'background_bodycss', '#8224e3' );
    }
    if ( get_option( 'background_overlay_bodycss' ) == '' ) {
        update_option( 'background_overlay_bodycss', '#ffffff' );
    }
    if ( get_option( 'background_overlay_opc_bodycss' ) == '' ) {
        update_option( 'background_overlay_opc_bodycss', '0' );
    }

    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    $sktm_maintenance_excludepage = $wpdb->prefix .'skt_maintenance_excludepage';
      $sqlpage = "CREATE TABLE $sktm_maintenance_excludepage (
      ID bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      exclude_page_id  varchar(255) NOT NULL,
      exclude_post_id  varchar(255) NOT NULL
     ) $charset_collate;";
     dbDelta( $sqlpage );
     if( $sqlpage ){
      $result = $wpdb->get_results("SELECT * from $sktm_maintenance_excludepage"); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery,  WordPress.DB.PreparedSQL.InterpolatedNotPrepared
      if(count($result) == 0){
      $insert_query = $wpdb->query("INSERT INTO $sktm_maintenance_excludepage (ID, exclude_page_id, exclude_post_id) VALUES (1,'0','0');"); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery,  WordPress.DB.PreparedSQL.InterpolatedNotPrepared
      }
    }
  }
}
register_activation_hook( __FILE__, 'sktm_maintenance_install_cart' );
/*
* Deactivate plugin
*/
if ( ! function_exists ( 'sktm_maintenance_deactivation_cart' ) ) {
    function sktm_maintenance_deactivation_cart(){
        // our post type will be automatically removed, so no need to unregister it
        // clear the permalinks to remove our post type's rules
        flush_rewrite_rules();
    }
}

// Admin enqueue
add_action( 'admin_enqueue_scripts', 'sktm_maintenance_admin_enqueue' );
function sktm_maintenance_admin_enqueue() {
    wp_enqueue_script( 'skt-maintenance-admin-custom-script', SKTM_MAINTENANCE_URI . '/js/custom-admin.js', array( 'jquery' ), true );
    wp_enqueue_style( 'skt-maintenance-admin-stylesheet', SKTM_MAINTENANCE_URI . '/css/custom-admin.css', 'skt-maintenance-admin-stylesheet');
    load_plugin_textdomain( 'skt-maintenance', false, basename(dirname(__FILE__)).'/languages' );
}

add_action( 'admin_enqueue_scripts', 'sktm_maintenance_add_color_picker' );
function sktm_maintenance_add_color_picker( $hook ) {
    if( is_admin() ) { 
        // Add the color picker css file       
        wp_enqueue_style( 'wp-color-picker' ); 
        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'skt-maintenance-color-picker', SKTM_MAINTENANCE_URI . '/js/color-picker.js', array( 'wp-color-picker' ), false, true ); 
    }
}
include_once SKTM_MAINTENANCE_DIR . '/admin/maintenance-menu.php' ;
include_once SKTM_MAINTENANCE_DIR . '/admin/register-settings.php' ;

//hex to rgb function
function sktm_maintenance_hex2rgb( $hex ) {
    $hex = str_replace("#", "", $hex);
    if(strlen($hex) == 3) {
        $r = hexdec( substr( $hex,0,1 ).substr( $hex,0,1 ) );
        $g = hexdec( substr( $hex,1,1 ).substr( $hex,1,1 ) );
        $b = hexdec( substr( $hex,2,1 ).substr( $hex,2,1 ) );
    } else {
        $r = hexdec( substr( $hex,0,2 ) );
        $g = hexdec( substr( $hex,2,2 ) );
        $b = hexdec( substr( $hex,4,2 ) );
    }
    $rgb = array( $r, $g, $b );
    return implode( ",", $rgb ); // returns the rgb values separated by commas
   //return $rgb; // returns an array with the rgb values
}

function sktm_maintenance_mode_css() {
    if ( is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ||  ( defined( 'WP_CLI' ) && WP_CLI ) ) {
        return;
    }
    global $wpdb;
    global $pagenow, $skt_options;
    $maintenance          = get_option( 'is_maintenance_mode' );
    $skt_date             = get_option( 'maintenance_mode_expire_time' );
    $page_title           = get_option( 'page_title' );
    $heading              = get_option( 'heading' );
    $site_title_color     = get_option( 'site_title_color' );
    $site_title_font_size = get_option( 'site_title_font_size' );
    $heading_color        = get_option( 'heading_color' );
    $headingfont_size     = get_option( 'headingfont_size' );
    $testeditor           = get_option( 'test-editor' );
    $description_color    = get_option( 'description_color' );
    $descriptionfont_size = get_option( 'descriptionfont_size' );
    $footer_text          = get_option( 'footer_text' );
    $footer_text_color    = get_option( 'footer_text_color' );
    $footer_textfont_size = get_option( 'footer_textfont_size' );
    $maintenancemode      = get_option( 'maintenancemode' );
    $background_bodycss   = get_option( 'background_bodycss' );
    $custom_css           = get_option( 'custom_css' );
    $background_overlay_bodycss     = get_option( 'background_overlay_bodycss' );
    $background_overlay_opc_bodycss = get_option( 'background_overlay_opc_bodycss' );
    $logo_width       = get_option( 'logo_width' );
    $logo_height      = get_option( 'logo_height' );
    $logo_image       = get_option( 'header_logo' );
    $backgroundimage  = get_option( 'header_back' );
    $fontfamily       = get_option( 'fontfamily' );
    $skt_cur_page_url = sktm_maintenance_cur_page_url();
    if ( $pagenow !== 'wp-login.php' && !is_user_logged_in() && $maintenancemode=="1" ) {
    $sktm_maintenance_excludepage = $wpdb->prefix. 'skt_maintenance_excludepage';
    $exclude_page_id = "";
    $explode_post_id = "";
    $select_maintenancemode = $wpdb->get_row( "SELECT* FROM $sktm_maintenance_excludepage" ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery,  WordPress.DB.PreparedSQL.InterpolatedNotPrepared  
    $count_record = $wpdb->num_rows;
    $url          = '';
    if ( isset( $_SERVER['SERVER_PORT'], $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'] ) ) {
        $server_host = sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) );
        $request_uri = sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) );
        $url         = "http" . ( ( $_SERVER['SERVER_PORT'] == 443 ) ? "s" : "" ) . "://" . $server_host . $request_uri;
    }
    $currentpage_id  = url_to_postid( $url );
    $exclude_page_id = $select_maintenancemode->exclude_page_id;
    $explode_page_id = explode( ',', $exclude_page_id );
    $exclude_post_id = $select_maintenancemode->exclude_post_id;
    $explode_post_id = explode( ',', $exclude_post_id );
    $both_exclude    = array_merge( $explode_page_id, $explode_post_id );
    if ( !in_array( $currentpage_id, $both_exclude ) || $currentpage_id=="0" ){
    ?>
    <!DOCTYPE html>
    <html>
      <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo esc_attr( $page_title ); ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo esc_url( SKTM_MAINTENANCE_URI.'/css/style.css' ); // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet ?>">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=<?php echo esc_attr( $fontfamily ); // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet ?>">
        <style type="text/css">
            body{<?php if($backgroundimage !=''){ ?>background-image: url(<?php echo esc_url( $backgroundimage ); ?>);<?php } ?> background-color: <?php echo esc_attr( $background_bodycss ); ?>; font-family: <?php echo esc_attr( $fontfamily ); ?>;}
            .skt-maintenance-overlay{background-color: rgba(<?php echo  esc_attr( sktm_maintenance_hex2rgb( $background_overlay_bodycss ) ); ?>, <?php echo esc_attr( $background_overlay_opc_bodycss ); ?>);}
            .skt-maintenance-title{color: <?php echo esc_attr( $site_title_color ); ?>; font-family: <?php echo esc_attr( $fontfamily );?>; font-size: <?php echo esc_attr( $site_title_font_size ); ?>px;}
            .skt-maintenance-heading h2{color: <?php echo esc_attr( $heading_color ); ?>; font-family: <?php echo esc_attr( $fontfamily );?>; font-size: <?php echo esc_attr( $headingfont_size ); ?>px;}
            .skt-maintenance-description{color: <?php echo esc_attr( $description_color ); ?>; font-family: <?php echo esc_attr( $fontfamily );?>; font-size: <?php echo esc_attr( $descriptionfont_size ); ?>px;}
            .skt-maintenance-footer-text{color: <?php echo esc_attr( $footer_text_color ); ?>; font-family: <?php echo esc_attr( $fontfamily );?>; font-size: <?php echo esc_attr( $footer_textfont_size ); ?>px;}
        </style>
        <style type="text/css"><?php echo esc_attr( $custom_css ); ?></style>
    </head>
    <body>
        <a class="skt-maintenance-login" href="<?php echo esc_url ( wp_login_url() ); ?>"><img src="<?php echo esc_url( SKTM_MAINTENANCE_URI. '/images/lock-icon.png' ); ?>"></a>
        <div class="skt-maintenance-overlay"></div>
        <div class="skt-maintenance-wrap">
            <header class="skt-maintenance-header">
                <div class="skt-maintenance-container">
                    <?php
                    if( $logo_image !='' ){
                        ?>
                        <div class="skt-maintenance-logo">
                            <img src="<?php echo esc_url( $logo_image );?>" width="<?php echo esc_attr( $logo_width.'px' );?>" height="<?php echo esc_attr( $logo_height.'px' );?>">
                        </div>
                    <?php } else { ?>
                        <h1 class="skt-maintenance-title"><?php echo esc_attr( get_bloginfo( 'name' ) ); ?></h1>
                    <?php } ?>
                </div>
            </header>
            <div class="skt-maintenance-container">
                <div class="skt-maintenance-content">
                    <div class="skt-maintenance-heading">
                        <?php if( $heading !='' ) { ?>
                            <h2><?php echo wp_kses_post( $heading ); ?></h2>
                        <?php } ?>
                    </div>
                    <div class="skt-maintenance-description">
                        <?php if( $testeditor !='' ) { echo wp_kses_post( $testeditor ); } ?>
                    </div>
                </div>
            </div>
            <footer class="skt-maintenance-footer">
                <div class="skt-maintenance-container">
                    <?php if( $footer_text !='' ) { ?>
                        <div class="skt-maintenance-footer-text"><?php echo wp_kses_post( $footer_text ); ?></div>
                    <?php } ?>
                </div>
            </footer>
        </div>
    </body>
    </html> 
  <?php
  die();
  } }
}
add_action( 'wp_loaded', 'sktm_maintenance_mode_css', 5);

function sktm_maintenance_cur_page_url() {
    $page_url = 'http';
    if (isset($_SERVER['HTTPS'])) {
        $page_url .= 's';
    }
    $page_url .= '://';
    if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] !== '80') {
        $page_url .= sanitize_text_field( wp_unslash($_SERVER['SERVER_NAME'])) . ':' . sanitize_text_field( wp_unslash($_SERVER['SERVER_PORT']) ) . sanitize_text_field( wp_unslash($_SERVER['REQUEST_URI']) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated
    } else {
        $page_url .= sanitize_text_field( wp_unslash($_SERVER['SERVER_NAME']) ) . sanitize_text_field( wp_unslash($_SERVER['REQUEST_URI']) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated
    }
    return $page_url;
}

add_action( 'admin_enqueue_scripts', 'sktm_maintenance_include_js' );
function sktm_maintenance_include_js() {
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }
    wp_enqueue_script( 'myuploadscript', SKTM_MAINTENANCE_URI .'/js/customscript.js', array( 'jquery' ) );
}

function sktm_maintenance_sanitize_option_field( $input ){
    return $input;
}