<?php



add_action('init', 'truckindia_news_scroll_init', 99 );
function truckindia_news_scroll_init(){


    global $kc;
    $kc->add_map(
        array(
            'truckindia_news_scroll' => array(
                'name' => 'Trucking News',
                'description' => __('', 'kingcomposer'),
                'icon' => 'sc-icon sc-icon-news',
                'category' => 'Truckindia',
                'preview_editable' => true,
                'is_container' => true,// this line works for the editor section. If it is not here. Content html editor will not work.
                'params' => array(
                    'General' => array( //if we did't give this option. The KC will generate an default General option
                      array(
                          'name' => 'title',
                          'label' => 'News Button Title',
                          'type' => 'text',
                          'value' => '',
                          'admin_label' => true,
                      ),
                      array(
                        'name' => 'news_scroll_post',
                        'label' => 'Select Post',
                        'type' => 'post_taxonomy',
                        'description' => 'select your category listed above',
                      ),
                      array(
                        'name' => 'display_full',
                        'label' => 'Show Complete News Items',
                        'type' => 'toggle',
                      ),
                      array(
                          'name' => 'count',
                          'label' => 'Specify Number of News item to be display',
                          'type' => 'text',
                          'value' => '5',
                          'relation' => array(
                            'parent' => 'display_full',
                            'hide_when' => 'yes',
                          )
                      ),
                    )
                )
            )
        )
    );
}
// Register Before After Shortcode
function render_truckindia_news_scroll($atts, $content = null){
    extract( shortcode_atts( array(
        'title' => '',
        'news_scroll_post' => '',
        'display_full' => '',
        'count' => '',


    ), $atts) );


// Used For Title Separate
$title = preg_split("/\s+/", $title);
// Replace the first word.
$title[0] = "<span>" . $title[0] . "</span>";
// Re-create the string.
$title = join(" ", $title);
// End Used For Title Separate


        $news_items = '';
        $item_count = $count;
        $news_scroll_post = str_replace("post:","",$news_scroll_post);
        if($display_full == 'yes')
            $item_count = '-1';

            $news_loop = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => $item_count, 'tax_query' => array(
        array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => array( $news_scroll_post )
        ),
    ), ) );

            while ( $news_loop->have_posts() )
                {
                    $news_loop->the_post();
                    $news_title = get_the_title();
                    $link = get_permalink();;

                    $news_items .= '<div class="news-view">
                                      <div class="news-view-details">
                                        <img src="'.esc_url(get_template_directory_uri()).'/images/news/truck-news.svg" alt="news truck" />
                                        <a href="'.esc_url($link).'"><span class="white font-r uppercase font-weight-400 font-size-5">'.esc_html($news_title).'</span></a>
                                      </div>
                                    </div>';

                }


    $output= '<section class="trucking-news">
                <div class="trucking-news-wrap">
                  <div class="trucking-news-button">
                    <p class="white font-size-5 font-h uppercase font-weight-700">'.$title.'</p>
                  </div>

                  <div class="makeMeScrollable news-blocks">
                    '.$news_items.'
                  </div>

                </div>
              </section>';

    return $output;
}

add_shortcode('truckindia_news_scroll', 'render_truckindia_news_scroll');
