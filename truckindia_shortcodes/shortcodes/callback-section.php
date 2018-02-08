<?php


add_action('init', 'truckindia_callback_init', 99 );
function truckindia_callback_init(){


    global $kc;
    $kc->add_map(
        array(
            'truckindia_callback' => array(
                'name' => 'Request a Call',
                'description' => __('', 'kingcomposer'),
                'icon' => 'sc-icon sc-icon-callback',
                'category' => 'Truckindia',
                'preview_editable' => true,
                'is_container' => true,// this line works for the editor section. If it is not here. Content html editor will not work.
                'params' => array(
                    'General' => array( //if we did't give this option. The KC will generate an default General option
                      array(
                          'name' => 'title',
                          'label' => 'Callback Title',
                          'type' => 'textarea',
                          'value' => '',
                          'admin_label' => true,
                      ),
                      array(
                          'name' => 'form_shortcode',
                          'label' => 'Form Shortcode',
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
function render_truckindia_callback($atts, $content = null){
    extract( shortcode_atts( array(
        'title' => '',
        'form_shortcode' => '',


    ), $atts) );



    $output= '<section class="callback-wrap">
                <div class="row">
                  <div class="col-md-7">
                    <h4 class="callback-title font-h font-weight-300 black">'.$title.'</h4>
                  </div>
                  <div class="col-md-5">
                    <div class="callback-form-wrap">'.do_shortcode($form_shortcode).'</div>
                  </div>
                </div>
              </section>';


    return $output;
}

add_shortcode('truckindia_callback', 'render_truckindia_callback');
