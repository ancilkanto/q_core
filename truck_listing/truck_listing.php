<?php



function alter_menu_items() {
    remove_menu_page( 'stm_startup_vehicles_listing' );
    
    global $menu;
     
    $menu[26][0] = 'Trucks';
    $menu[26][6] = plugins_url('/images/truck-icon.png' , __FILE__ ) . '';

    
}
add_action( 'admin_menu', 'alter_menu_items' );

function register_truck_type_taxonomy(){
	$truck_listing_tax_labels = array(
		'name'              => __( 'Truck Types', 'taxonomy general name' ),
		'singular_name'     => __( 'Truck Type', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Truck Types' ),
		'all_items'         => __( 'All Truck Types' ),
		'parent_item'       => __( 'Parent Truck Type' ),
		'parent_item_colon' => __( 'Parent Truck Type:' ),
		'edit_item'         => __( 'Edit Truck Type' ),
		'update_item'       => __( 'Update Truck Type' ),
		'add_new_item'      => __( 'Add New Truck Type' ),
		'new_item_name'     => __( 'New Truck Type Name' ),
		'menu_name'         => __( 'Truck Types' ),
	);
	register_taxonomy( 'truck-type', array( 'listings' ),
	array( 'hierarchical' => true, 'labels' => $truck_listing_tax_labels,"singular_label" => __('Truck Types', 'oscarlang') ) );
}

add_action( 'init', 'register_truck_type_taxonomy', 1 );


add_action( 'cmb2_admin_init', 'truck_type_tax_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_init' hook.
 */
function truck_type_tax_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_truck_type_';
	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_truck_type = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Icon Image', 'qcore' ),
		'object_types'  => array( 'term' ),
		'taxonomies'    => array( 'truck-type' ),
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		'cmb_styles'    => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	$cmb_truck_type->add_field( array(
	    'name'    => esc_html__( 'Icon Image', 'qcore' ),
		'desc'    => esc_html__( 'Select image from media library/Upload new image. Use image of width 72px for better appearance in larger displays.', 'qcore' ),
		'id'      => $prefix . 'thumb',
		'type'    => 'file',
		'allow'   => array( 'attachment' ),
		"options" => array(
				        "url" => false
				     )
	    
	) );
	
}




add_action( 'cmb2_admin_init', 'truck_listings_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_init' hook.
 */
function truck_listings_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_truck_list_';
	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_truck_list = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Additional Options', 'qcore' ),
		'object_types'  => array( 'listings' ),
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		'cmb_styles'    => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	$cmb_truck_list->add_field( array(
	    'name'    => esc_html__( 'Thumbnail Image', 'qcore' ),
		'desc'    => esc_html__( 'Select image from media library/Upload new image. Use image of width 72px for better appearance in larger displays.', 'qcore' ),
		'id'      => $prefix . 'thumb',
		'type'    => 'file',
		'allow'   => array( 'attachment' ),
		"options" => array(
				        "url" => false
				     )
	    
	) );
	
}




// Register and load the widget
function latest_trucks_load_widget() {
    register_widget( 'latest_trucks_widget' );
}
add_action( 'widgets_init', 'latest_trucks_load_widget' );
 


// Creating the widget 
class latest_trucks_widget extends WP_Widget {
 
	function __construct() {
		parent::__construct(
		 
		// Base ID of your widget
		'latest_trucks_widget', 
		 
		// Widget name will appear in UI
		__('Latest Trucks', 'quadlang'), 
		 
		// Widget description
		array( 'description' => __( 'Widget displays latest Trucks', 'quadlang' ), ) 
		);
	}
	 
	// Creating widget front-end
	 
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		$count = $instance['count'];
		 
		// before and after widget arguments are defined by themes
		
		echo $args['before_widget'];


		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		
		$latest_trucks_list = '';

		$latest_trucks_loop = new WP_Query( 
			array( 
			  'post_type' => 'listings', 
			  'posts_per_page' => $count,
			  'orderby' => 'publish_date',
    		  'order' => 'DESC',
			) 
		);



	      
	    if ( $latest_trucks_loop->have_posts() ) 
	    	while ( $latest_trucks_loop->have_posts() ) : 
	    		$latest_trucks_loop->the_post();

	    		$thumb_image_url = get_post_meta(get_the_ID(), '_truck_list_thumb', true);

		        

		        $title = get_the_title();

		        $price = get_post_meta(get_the_ID(), 'price', true);
				

		        $latest_trucks_list .= '<li>
		        							<img src="'.esc_url($thumb_image_url).'" alt="'.$title.'"/ class="img-responsive img-fluid">
		        							<h3><a href="'.get_the_permalink().'">'.$title.'</a></h3>
		        							<h4>'.stm_listing_price_view($price).'</h4>
		        						</li>';
	      	endwhile;

        wp_reset_query();

        echo '<ul>'.$latest_trucks_list.'</ul>';
		
		// echo __( 'Hello, World! '.$count, 'wpb_widget_domain' );
		

		echo $args['after_widget'];
		
		
	}
	         
	// Widget Backend 
	public function form( $instance ) {

		$title = __( 'New title', 'quadlang' );
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		

		$count = __( '5', 'quadlang' );

		if ( isset( $instance[ 'count' ] ) ) {
			$count = $instance[ 'count' ];
		}
		
			
		// Widget admin form
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php esc_html_e( 'No. of Trucks to Display:', 'quadlang' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
		</p>
		
		<?php 
	}
	     
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
		
		return $instance;
	}
} // Class crypto_currency_price ends here
