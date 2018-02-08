<?php



add_action('init', 'truckindia_listing_item_init', 99 );
function truckindia_listing_item_init(){


    global $kc;
    $kc->add_map(
        array(
            'truckindia_listing_item' => array(
                'name' => 'Listing Item',
                'description' => __('', 'kingcomposer'),
                'icon' => 'sc-icon sc-icon-listing',
                'category' => 'Truckindia',
                'preview_editable' => true,
                'is_container' => true,// this line works for the editor section. If it is not here. Content html editor will not work.
                'params' => array(
                    'General' => array( //if we did't give this option. The KC will generate an default General option
                      array(
                          'name' => 'title',
                          'label' => 'List Title',
                          'type' => 'text',
                          'value' => '',
                          'admin_label' => true,
                      ),
                      array(
                        'name' => 'title_color',
                        'label' => 'Select Title Color',
                        'type' => 'color_picker',
                        'value' => '#000',
                    ),
                    array(
                      'name' => 'list_color',
                      'label' => 'Select list Color',
                      'type' => 'color_picker',
                      'value' => '#000',
                  ),
                      array(
                        'type'			=> 'group',
                        'label'			=> __('List The Content', 'KingComposer'),
                        'name'			=> 'list_content',
                        'description'	=> __( '', 'KingComposer' ),
                        'options'		=> array('add_text' => __('Add new list', 'kingcomposer')),
                        'value' => base64_encode( json_encode(array(
                          "1" => array(
                            "list" => "sample text 1"
                          ),
                        ) ) ),
                        'params' => array(
                          array(
                              'name' => 'list_items',
                              'label' => 'add new list',
                              'type' => 'text',
                              'admin_label' => true,
                          ),

                        ),
                      ),//group ending section

                    )
                )
            )
        )
    );
}
// Register Before After Shortcode
function render_truckindia_listing_item($atts, $content = null){
    extract( shortcode_atts( array(
        'title' => '',
        'list_content' => '',
        'title_color' => '',
        'list_color' => '',


    ), $atts) );


    $listing_item ='';
    foreach ($atts['list_content'] as $key => $item) {
          $single_item = $item->list_items;
          $listing_item .= '<li class="font-h font-weight-300" style="color:'.$list_color.'">'.esc_html($single_item).'</li>';
      }


    $output= '<section class="listing-item-wrap">
                <div class="listing-item-title">
                  <div class="title-line" style="background-color: '.$title_color.';"></div>
                  <span class="listing-item-title-text font-r uppercase" style="color:'.$title_color.';">'.esc_html($title).'</span>
                </div>
                <div class="listing-item-content">
                  <ul>
                    '.$listing_item.'
                  </ul>
                </div>
              </section>';


    return $output;
}

add_shortcode('truckindia_listing_item', 'render_truckindia_listing_item');
