<?php



function alter_menu_items() {
    remove_menu_page( 'stm_startup_vehicles_listing' );
    
    global $menu;
     
    $menu[26][0] = 'Trucks';
    $menu[26][6] = plugins_url('/images/truck-icon.png' , __FILE__ ) . '';

    
}
add_action( 'admin_menu', 'alter_menu_items' );
