<?php



add_action('init', 'truckindia_iconised_title_init', 99 );
function truckindia_iconised_title_init(){


    global $kc;
    $kc->add_map(
        array(
            'truckindia_iconised_title' => array(
                'name' => 'Iconised Title',
                'description' => __('', 'kingcomposer'),
                'icon' => 'sc-icon sc-icon-iconised-title',
                'category' => 'Truckindia',
                'preview_editable' => true,
                'is_container' => true,// this line works for the editor section. If it is not here. Content html editor will not work.
                'params' => array(
                    'General' => array( //if we did't give this option. The KC will generate an default General option
                      array(
                          'name' => 'title',
                          'label' => 'Title',
                          'type' => 'text',
                          'value' => '',
                          'admin_label' => true,
                      ),
                      array(
                          'name' => 'image',
                          'label' => 'Image Icon',
                          'type' => 'attach_image',
                          'admin_label' => true,
                      ),
                    )
                )
            )
        )
    );
}
// Register Before After Shortcode
function render_truckindia_iconised_title($atts, $content = null){
    extract( shortcode_atts( array(
        'title' => '',
        'image' => '',


    ), $atts) );

    // Used For Title Separate
    $title = preg_split("/\s+/", $title);
    // Replace the first word.
    $title[0] = "<span>" . $title[0] . "</span><br />";
    // Re-create the string.
    $title = join(" ", $title);
    // End Used For Title Separate


    $image_markup = '';
    if($image != ''){
        $img = wp_get_attachment_image_src( $image , 'full');
        $image_url = $img[0];
        $image_markup = esc_url($image_url);
    }
//var_dump($image_markup);

    $output= '<section class="iconised-title-wrap">
                <div class="row">
                  <div class="col-md-4"></div>
                  <div class="col-md-8">
                    <div class="iconised-title-image" style="background-image: url('.$image_markup.');"></div>
                  </div>
                </div>
                <div class="iconised-title-text">
                  '.$title.'
                </div>
              </section>';


    return $output;
}

add_shortcode('truckindia_iconised_title', 'render_truckindia_iconised_title');
