<?php



add_action('init', 'truckindia_banner_init', 99 );
function truckindia_banner_init(){


    global $kc;
    $kc->add_map(
        array(
            'truckindia_banner' => array(
                'name' => 'Home Page Slider',
                'description' => __('', 'kingcomposer'),
                'icon' => 'sc-icon sc-icon-slider',
                'category' => 'Truckindia',
                'preview_editable' => true,
                'is_container' => true,// this line works for the editor section. If it is not here. Content html editor will not work.
                'params' => array(
                    'General' => array( //if we did't give this option. The KC will generate an default General option
                      array(
                          'name' => 'title_1',
                          'label' => 'Banner Title',
                          'type' => 'text',
                          'value' => '',
                      ),
                      array(
                          'name' => 'title_2',
                          'label' => 'Banner Medium Title',
                          'type' => 'textarea',
                          'value' => '',
                      ),
                      array(
                          'name' => 'title_3',
                          'label' => 'Banner Sub Title',
                          'type' => 'text',
                          'value' => '',
                      ),
                      array(
                          'name' => 'images',
                          'label' => 'Upload Slider Images',
                          'type' => 'attach_images',
                          'admin_label' => true,
                      ),

                    )
                )
            )
        )
    );
}
// Register Before After Shortcode
function render_truckindia_banner($atts, $content = null){
    extract( shortcode_atts( array(
        'title_1' => '',
        'title_2' => '',
        'title_3' => '',
        'images' => '',


    ), $atts) );


    $images_gallery_markup = '';
    $images_collection = explode(",", $images);

    foreach ($images_collection as $images_item) {
      $img = wp_get_attachment_image_src( $images_item , 'full');
      $images_item_url = $img[0];
      $images_gallery_markup .= '<div class="slideshow-image" style="background-image: url('.esc_url($images_item_url).');"></div>';
    }

    $output= '
              <section class="banner">
                  <div class="banner-title-bg"></div>
                  <div class="slideshow owl-carousel owl-theme">
                    '.$images_gallery_markup.'
                  </div>
                  <div class="banner-text-wrap">
                    <p class="banner-title-1 uppercase white font-h font-weight-700 font-size-12">'.$title_1.'</p>
                    <p class="banner-title-2 font-m font-weight-300 uppercase font-size-10 white">'.$title_2.'</p>
                    <p class="banner-title-3 uppercase white font-m font-weight-300 font-size-2">'.$title_3.'</p>
                  </div>


                <div id="banner-tab-block">
                  <div class="banner-tabs">
                    <ul class="banner-tab-links">
                    <li class="active"><a href="#trucking-insurance">INSURANCE</a></li>
                    <li><a href="#trucking-finance">FINANCE</a></li>
                    <li><a href="#trucking-buy-sell">BUY/SELL</a></li>
                    </ul>
                    <div class="tab-content ease">
                      <div id="trucking-insurance" class="tab active">
                        <div class="mar-top-hhalf mar-bot-hhalf text-center">
                          <div class="banner-tab1-content display-inline font-weight-300 white font-size-4 font-r">Enter Truck Registration <span class="font-weight-700">Number</span></div>
                          <input name="vehicle-num" value="" class="banner-tab1-input white font-h font-weight-400 text-center uppercase"  placeholder="TN 55 AZ 1234" type="text">
                          <a class="banner-tab1-button white font-size-5 font-r font-weight-300 ease" href="#">GET A <span class="font-weight-700">QUOTE</span></a>
                        </div>
                      </div>
                      <div id="trucking-finance" class="tab">
                        <div class="mar-top-hhalf mar-bot-hhalf text-center">
                            <input name="name" value="" class="banner-tab2-input white font-h font-weight-400 text-center uppercase"  placeholder="Your Name" type="text">
                            <input name="mob" value="" class="banner-tab2-input white font-h font-weight-400 text-center uppercase"  placeholder="Mobile Number" type="text">
                            <a class="banner-tab1-button white font-size-5 font-r font-weight-300 ease" href="#">GET A <span class="font-weight-700">QUOTE</span></a>
                        </div>
                      </div>
                      <div id="trucking-buy-sell" class="tab">
                        <ul class="truck-search-list">
                          <a href="#">
                            <li class="ease">
                              <div class="truck-search-list-item">
                                <div class="truck-search-image">
                                  <img src="'.esc_url(get_template_directory_uri()).'/images/truck-search-icons/mini-trucks.svg" alt="Mini Trucks" />
                                </div>
                                <div class="truck-category uppercase font-h font-size-1 red font-weight-600">Mini Trucks</div>
                              </div>
                            </li>
                          </a>
                          <a href="#">
                            <li class="ease">
                              <div class="truck-search-list-item">
                                <div class="truck-search-image">
                                  <img src="'.esc_url(get_template_directory_uri()).'/images/truck-search-icons/pickup.svg" alt="Pickup" />
                                </div>
                                <div class="truck-category uppercase font-h red font-size-1 font-weight-600">Pickup</div>
                              </div>
                            </li>
                          </a>
                          <a href="#">
                            <li class="ease">
                              <div class="truck-search-list-item">
                                <div class="truck-search-image">
                                  <img src="'.esc_url(get_template_directory_uri()).'/images/truck-search-icons/tipper.svg" alt="Tipper" />
                                </div>
                                <div class="truck-category uppercase red font-h font-size-1 font-weight-600">Tipper</div>
                              </div>
                            </li>
                          </a>
                          <a href="#">
                            <li class="ease">
                              <div class="truck-search-list-item">
                                <div class="truck-search-image">
                                  <img src="'.esc_url(get_template_directory_uri()).'/images/truck-search-icons/trailer.svg" alt="Trailer" />
                                </div>
                                <div class="truck-category red uppercase font-h font-size-1 font-weight-600">Trailer</div>
                              </div>
                            </li>
                          </a>
                          <a href="#">
                            <li class="ease">
                              <div class="truck-search-list-item">
                                <div class="truck-search-image">
                                  <img src="'.esc_url(get_template_directory_uri()).'/images/truck-search-icons/tanker.svg" alt="Tanker" />
                                </div>
                                <div class="truck-category red uppercase font-h font-size-1 font-weight-600">Tanker</div>
                              </div>
                            </li>
                          </a>
                          <a href="#">
                            <li class="ease">
                              <div class="truck-search-list-item">
                                <div class="truck-search-image">
                                  <img src="'.esc_url(get_template_directory_uri()).'/images/truck-search-icons/flat-bed.svg" alt="Flat Bed" />
                                </div>
                                <div class="truck-category red uppercase font-h font-size-1 font-weight-600">Flat Bed</div>
                              </div>
                            </li>
                          </a>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </section>';


    return $output;
}

add_shortcode('truckindia_banner', 'render_truckindia_banner');
