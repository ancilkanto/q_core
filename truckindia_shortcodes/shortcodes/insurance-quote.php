<?php



add_action('init', 'truckindia_insurance_quote_init', 99 );
function truckindia_insurance_quote_init(){


    global $kc;
    $kc->add_map(
        array(
            'truckindia_insurance_quote' => array(
                'name' => 'Insurance Quote',
                'description' => __('', 'kingcomposer'),
                'icon' => 'sc-icon sc-icon-insurance',
                'category' => 'Truckindia',
                'preview_editable' => true,
                'is_container' => true,// this line works for the editor section. If it is not here. Content html editor will not work.
                'params' => array(
                    'General' => array( //if we did't give this option. The KC will generate an default General option
                      array(
                          'name' => 'title',
                          'label' => 'Title',
                          'type' => 'textarea',
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
                          'name' => 'cf7_code',
                          'label' => 'Contact Form Shortcode Here',
                          'type' => 'textarea',
                          'value' => '',
                      ),
                    )
                )
            )
        )
    );
}
// Register Before After Shortcode
function render_truckindia_insurance_quote($atts, $content = null){
    extract( shortcode_atts( array(
        'title' => '',
        'cf7_code' => '',
        'title_color' => '',


    ), $atts) );




    $output= '<section class="insurance-quote-wrap">
                <div class="insurance-quote-bg"></div>
                <div class="insurance-quote-form-wrap">
                  <div class="insurance-quote-title">
                    <div class="font-h pad-bot-hhalf font-size-5 font-weight-700 uppercase" style="color: '.$title_color.';">'.$title.'</div>
                  </div>
                  <div class="insurance-quote-form">'.do_shortcode($cf7_code).'</div>
                </div>
              </section>';


    return $output;
}

add_shortcode('truckindia_insurance_quote', 'render_truckindia_insurance_quote');
