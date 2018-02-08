<?php



add_action('init', 'truckindia_title_block_init', 99 );
function truckindia_title_block_init(){


    global $kc;
    $kc->add_map(
        array(
            'truckindia_title_block' => array(
                'name' => 'Title Block',
                'description' => __('', 'kingcomposer'),
                'icon' => 'sc-icon sc-icon-title',
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
                    )
                )
            )
        )
    );
}
// Register Before After Shortcode
function render_truckindia_title_block($atts, $content = null){
    extract( shortcode_atts( array(
        'title' => '',


    ), $atts) );

    // Used For Title Separate
    $title = preg_split("/\s+/", $title);
    // Replace the first word.
    $title[0] = "<span>" . $title[0] . "</span>";
    // Re-create the string.
    $title = join(" ", $title);
    // End Used For Title Separate



    $output= '<section class="title-block-wrap">
                <div class="title-block-line1"></div>
                <div class="title-block-line2"></div>
                <div class="title-block-content">
                  <p class="uppercase font-h font-weight-300" style="letter-spacing: 0.45px; font-size: 24px; color: red;">'.$title.'</p>
                </div>
              </section>';


    return $output;
}

add_shortcode('truckindia_title_block', 'render_truckindia_title_block');
