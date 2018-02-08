<?php


add_action('init', 'truckindia_blog_block_init', 99 );
function truckindia_blog_block_init(){


    global $kc;
    $kc->add_map(
        array(
            'truckindia_blog_block' => array(
                'name' => 'Blog Block',
                'description' => __('', 'kingcomposer'),
                'icon' => 'sc-icon sc-icon-blog',
                'category' => 'Truckindia',
                'preview_editable' => true,
                'is_container' => true,// this line works for the editor section. If it is not here. Content html editor will not work.
                'params' => array(
                    'General' => array( //if we did't give this option. The KC will generate an default General option
                      array(
                        'name' => 'blog_post',
                        'label' => 'Select Post',
                        'type' => 'post_taxonomy',
                        'description' => 'select your blog category listed above',
                        'admin_label' => true,
                      ),
                      array(
                        'name' => 'blog_button_link',
                        'label' => 'Read More News Button Link',
                        'type' => 'text',
                        'value' => 'http://',
                        'description' => '',
                    ),
                    )
                )
            )
        )
    );
}
// Register Before After Shortcode
function render_truckindia_blog_block($atts, $content = null){
    extract( shortcode_atts( array(
        'blog_post' => '',
        'blog_button_link' => '',

    ), $atts) );


    $blog_items_first = '';
    $blog_item_rest ='';
    $blog_post = str_replace("post:","",$blog_post);

        $blog_loop = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => '-1', 'tax_query' => array(
    array(
        'taxonomy' => 'category',
        'field' => 'slug',
        'terms' => array( $blog_post )
    ),
    ), ) );

$blog_num = 0;


while ( $blog_loop->have_posts() )
  {
      $blog_loop->the_post();

        $blog_num++;

      if($blog_num < 4) {

        $blog_title = get_the_title();
        $blog_content = wp_strip_all_tags(get_the_excerpt());
        $blog_img_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
        $blog_date = get_the_date();
        $blog_link = get_permalink();;


        if($blog_num > 1) {
          $blog_item_rest .= '<div class="blog-right-wrap">
                                <div class="row">
                                  <div class="col-md-8 col-sm-12">
                                    <div class="blog-right-content-wrap">
                                      <div class="blog-right-date">
                                        <img class="font-size-1 black" src="'.esc_url(get_template_directory_uri()).'/images/blog-date-icon.png" alt="blog date icon" />
                                        <span class="font-h font-size-1 font-weight-400 gray-l">'.$blog_date.'</span>
                                      </div>
                                      <div class="blog-right-title">
                                        <span class="font-r font-weight-700 font-size-3 black uppercase"><a class="black ease" href="'.$blog_link.'">'.$blog_title.'</a></span>
                                      </div>
                                      <div class="blog-right-content">
                                        <span class="font-h gray-l font-size-1 font-weight-400">'.esc_html(truckindia_clean($blog_content, 90)).'</span>
                                      </div>
                                      <div class="blog-right-read-more">
                                        <a class="uppercase font-r font-weight-400" href="'.$blog_link.'" style="color: #FF001F;">Read <span>More</span></a>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4 col-sm-12">
                                    <div class="blog-right-image" style="background-image: url('.$blog_img_url.');"></div>
                                  </div>
                                </div>
                              </div>';
        }else{


          $blog_items_first .= '<div class="blog-left-wrap">
                                  <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                      <div class="blog-left-content-wrap">
                                        <div class="blog-left-date">
                                          <img class="font-size-1 black" src="'.esc_url(get_template_directory_uri()).'/images/blog-date-icon.png" alt="blog date icon" />
                                          <span class="font-h font-size-1 gray-l font-weight-400">'.$blog_date.'</span>
                                        </div>
                                        <div class="blog-left-title">
                                          <span class="font-r font-weight-700 font-size-4 black uppercase"><a class="ease black" href="'.$blog_link.'">'.$blog_title.'</a></span>
                                        </div>
                                        <div class="blog-left-content">
                                          <span class="font-h gray-l font-size-1 font-weight-400">'.esc_html(truckindia_clean($blog_content, 290)).'</span>
                                        </div>
                                        <div class="blog-left-read-more">
                                          <a class="uppercase font-r font-weight-400" href="'.$blog_link.'" style="color: #FF001F;">Read <span>More</span></a>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                      <div class="blog-left-image" style="background-image: url('.$blog_img_url.');"></div>
                                    </div>
                                  </div>
                                </div>';
        }
      }
  }



      $output= '<section class="blog-block-wrap">
                  <div class="row">
                    <div class="col-md-6 col-sm-12">
                      '.$blog_items_first.'
                    </div>
                    <div class="col-md-6 col-sm-12">
                      '.$blog_item_rest.'
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                      <div class="blog-block-button">
                        <a class=" ease blog-block-button-text uppercase" href="'.$blog_button_link.'">read all news <img class="font-size-1" src="'.esc_url(get_template_directory_uri()).'/images/read-all-news.png" alt="read news" /></a>
                      </div>
                    </div>
                    <div class="col-md-4"></div>
                  </div>
                </section>';


      return $output;
}

add_shortcode('truckindia_blog_block', 'render_truckindia_blog_block');
