<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if(!function_exists('is_plugin_active')){
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

//add a css that works for admin side. Which menas workd on the KC editor page
function truckindia_shortcode_icon() {

    wp_enqueue_style('truckindia_shortcode_icon_css', plugins_url( 'css/icon.css' , __FILE__ ) );
    wp_enqueue_style('truckindia_shortcode_admin_css', plugins_url( 'css/admin.css' , __FILE__ ) );
}
add_action( 'admin_enqueue_scripts', 'truckindia_shortcode_icon' );


//add a css that works only if not an admin. which means works on front end page
function truckindia_shortcode_style() {
    wp_enqueue_style('truckindia_shortcode_main_css', plugins_url( 'css/main.css' , __FILE__ ) );
}
  if (!is_admin())
  {
      add_action( 'wp_enqueue_scripts', 'truckindia_shortcode_style' );
  }


//remove the <p> tag
remove_filter( 'the_content', 'wpautop' );
$br = false;
add_filter( 'the_content', function( $content ) use ( $br ) {
    return wpautop( $content, $br );
}, 10 );


if ( is_plugin_active( 'kingcomposer/kingcomposer.php' ) ){

    require_once ('shortcodes/home-slider.php');
    require_once ('shortcodes/truckindia-news.php');
    require_once ('shortcodes/callback-section.php');
    require_once ('shortcodes/listing-item.php');
    require_once ('shortcodes/insurance-quote.php');
    require_once ('shortcodes/title-block.php');
    require_once ('shortcodes/blog-block.php');
    require_once ('shortcodes/brand-sliding-tab.php');
    require_once ('shortcodes/brand-sliding-name.php');
    require_once ('shortcodes/iconised-title.php');

}

// Check If King Composer is activate
function truckindia_user_required_plugin() {
    if ( is_admin() && current_user_can( 'activate_plugins' ) &&  !is_plugin_active( 'kingcomposer/kingcomposer.php' ) ) {
        add_action( 'admin_notices', 'truckindia_user_required_plugin_notice' );

        deactivate_plugins( plugin_basename( __FILE__ ) );

        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
    }

}
add_action( 'admin_init', 'truckindia_user_required_plugin' );

function truckindia_user_required_plugin_notice(){
    ?><div class="error"><p>Error! you need to install or activate the <a href="https://wordpress.org/plugins/kingcomposer/">King Composer</a> plugin to run this plugin.</p></div><?php
}
?>
