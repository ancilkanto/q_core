<?php



add_action('init', 'truckindia_brand_name_init', 99 );
function truckindia_brand_name_init(){


    global $kc;
    $kc->add_map(
        array(
            'truckindia_brand_name' => array(
                'name' => 'Brand Name Listing',
                'description' => __('', 'kingcomposer'),
                'icon' => 'sc-icon sc-icon-name-listing',
                'category' => 'Truckindia',
                'preview_editable' => true,
                'is_container' => true,// this line works for the editor section. If it is not here. Content html editor will not work.
                'params' => array(
                    'General' => array( //if we did't give this option. The KC will generate an default General option

                      array(
                          'name' => 'el_class',
                          'label' => 'Custom Class',
                          'type' => 'text',
                          'value' => '',
                          'admin_label' => true,
                      ),
                    )
                )
            )
        )
    );
}
// Register Before After Shortcode
function render_truckindia_brand_name($atts, $content = null){
    extract( shortcode_atts( array(
        'el_class' => '',


    ), $atts) );



        $output= '<ul class="brand-name-trigger-list uppercase font-size-1 font-r font-weight-400 '.$el_class.'"></ul>';

        return $output;
}

add_shortcode('truckindia_brand_name', 'render_truckindia_brand_name');
