<?php



add_action('init', 'truckindia_brand_sliding_tab_init', 99 );
function truckindia_brand_sliding_tab_init(){


    global $kc;
    $kc->add_map(
        array(
            'truckindia_brand_sliding_tab' => array(
                'name' => 'Brand Sliding',
                'description' => __('', 'kingcomposer'),
                'icon' => 'sc-icon sc-icon-carousel-icon',
                'category' => 'Truckindia',
                'preview_editable' => true,
                'is_container' => true,// this line works for the editor section. If it is not here. Content html editor will not work.
                'params' => array(
                    'General' => array( //if we did't give this option. The KC will generate an default General option

                      //group starting section
                      array(
                        'type'			=> 'group',
                        'label'			=> __('Brand Sliding Tabs', 'KingComposer'),
                        'name'			=> 'brand_group',
                        'description'	=> __( '', 'KingComposer' ),
                        'options'		=> array('add_text' => __('Add new brand group', 'kingcomposer')),
                        'value' => base64_encode( json_encode(array(
                          "1" => array(
                            "title" => "brand group name",
                            "brand_images" => ""
                          ),

                        ) ) ),
                        'params' => array(
                          array(
                              'name' => 'title',
                              'label' => 'Title',
                              'type' => 'text',
                              'value' => '',
                              'admin_label' => true,
                          ),
                          array(
                            'name' => 'brand_images',
                            'label' => 'Upload Images',
                            'type' => 'attach_images',
                            'description' => 'select the image 200 x 66',
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
function render_truckindia_brand_sliding_tab($atts, $content = null){
    extract( shortcode_atts( array(
        'brand_group' => '',


    ), $atts) );


        //used for group loops
        $brand_group ='';
        foreach ($atts['brand_group'] as $key => $item) {
            $brand_title = $item->title;
            $brand_image = $item->brand_images;

            //Image Looping
            $brand_image_gallery_markup = '';
            $brand_image_collection = explode(",", $brand_image);
            foreach ($brand_image_collection as $brand_image_item){
              $brand_img = wp_get_attachment_image_src( $brand_image_item , 'full');
              $brand_image_item_url = $brand_img[0];
              $brand_image_gallery_markup .= '<li><img src="'.esc_url($brand_image_item_url).'"></li>';
            }//Image Looping Code

              $brand_title_name = $brand_title;
              $brand_title_name = strtolower(str_replace(' ', '-', $brand_title_name));
              $brand_title_name = 'brand-'.$brand_title_name;
              //var_dump($brand_title_name);

            $brand_group .= '<li class="brand-slider-list-item"><a id="'.$brand_title_name.'" class="brand-title" href="javascript:void(0)">'.$brand_title.'</a>
                              <ul class="brand-image-display owl-carousel owl-theme">
                                '.$brand_image_gallery_markup.'
                              </ul>
                            </li>';
        }//Group Loop Ends


        $output= '<section class="brand-disply-block">
                    <div class="brand-display">
                      <ul class="brand-slider-list">
                        '.$brand_group.'
                      </ul>
                    </div>
                  </section>';

        return $output;
}

add_shortcode('truckindia_brand_sliding_tab', 'render_truckindia_brand_sliding_tab');
