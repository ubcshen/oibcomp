<?php

/**
 * Custom functions
 */

// Remove Open Sans that WP adds from frontend
if (!function_exists('remove_wp_open_sans')) :
function remove_wp_open_sans() {
wp_deregister_style( 'open-sans' );
wp_register_style( 'open-sans', false );
}
add_action('wp_enqueue_scripts', 'remove_wp_open_sans');
endif;

add_filter( 'rest_endpoints', function( $endpoints ){
    if ( isset( $endpoints['/wp/v2/users'] ) ) {
        unset( $endpoints['/wp/v2/users'] );
    }
    if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
        unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
    }
    return $endpoints;
});

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

add_action( 'init', function() {
  // Remove the REST API endpoint.
  remove_action('rest_api_init', 'wp_oembed_register_route');
  // Turn off oEmbed auto discovery.
  // Don't filter oEmbed results.
  remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
  // Remove oEmbed discovery links.
  remove_action('wp_head', 'wp_oembed_add_discovery_links');
  // Remove oEmbed-specific JavaScript from the front-end and back-end.
  remove_action('wp_head', 'wp_oembed_add_host_js');
}, PHP_INT_MAX - 1 );  // remove the wp-embed.min.js file from the frontend completely

function multiexplode ($delimiters,$string) {

    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

//remove wordpress dns-prefetch
function remove_dns_prefetch( $hints, $relation_type ) {
    if ( 'dns-prefetch' === $relation_type ) {
        return array_diff( wp_dependencies_unique_hosts(), $hints );
    }

    return $hints;
}

add_filter( 'wp_resource_hints', 'remove_dns_prefetch', 10, 2 );

function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

if( !defined('OIB_PAGE_PATH') ){
    define('OIB_PAGE_PATH', get_template_directory() .'/' );
}
require_once OIB_PAGE_PATH . 'mobiledetect/Mobile_Detect.php';

if( function_exists('acf_add_options_page') ) {
  // add parent
  $parent = acf_add_options_page(array(
    'page_title'  => 'N’kmip Campground Settings',
    'menu_title'  => 'N’kmip Campground Settings',
    'redirect'    => false
  ));

  acf_add_options_sub_page(array(
    'page_title'  => 'Footer CopyRight',
    'menu_title'  => 'Footer CopyRight',
    'menu_slug'   => 'footer-copyright',
    'parent_slug'   => $parent['menu_slug'],
    'capability'  => 'activate_plugins',
    'redirect'    => false
  ));

  acf_add_options_sub_page(array(
    'page_title'  => 'Header Setting',
    'menu_title'  => 'Header Setting',
    'menu_slug'   => 'header_setting',
    'parent_slug'   => $parent['menu_slug'],
    'capability'  => 'activate_plugins',
    'redirect'    => false
  ));

  /*acf_add_options_sub_page(array(
    'page_title'  => 'News Archives Page Setting',
    'menu_title'  => 'News Archives Page Setting',
    'menu_slug'   => 'news_archives_page_setting',
    'parent_slug'   => $parent['menu_slug'],
    'capability'  => 'activate_plugins',
    'redirect'    => false
  ));

  acf_add_options_sub_page(array(
    'page_title'  => 'Social Media Sidebar Setting',
    'menu_title'  => 'Social Media Sidebar Setting',
    'menu_slug'   => 'social_media_sidebar_setting',
    'parent_slug'   => $parent['menu_slug'],
    'capability'  => 'activate_plugins',
    'redirect'    => false
  ));*/
}

if ( function_exists( 'add_theme_support' ) ) {
  add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 150, 150 ); // default Post Thumbnail dimensions
}

if ( function_exists( 'add_image_size' ) ) {
    add_image_size('news-thumbnail', 390, 240,  array( 'center', 'top' ));
    add_image_size('member-thumbnail', 780, 780,  array( 'center', 'top' ));
    add_image_size('member-lightbox-thumbnail', 600, 340,  array( 'center', 'top' ));
}

//get primary category name in Wordpress
if ( ! function_exists( 'get_primary_taxonomy_id' ) ) {
  function get_primary_taxonomy_id( $post_id, $taxonomy ) {
      $prm_term = '';
      if (class_exists('WPSEO_Primary_Term')) {
          $wpseo_primary_term = new WPSEO_Primary_Term( $taxonomy, $post_id );
          $prm_term = $wpseo_primary_term->get_primary_term();
      }
      if ( !is_object($wpseo_primary_term) && empty( $prm_term ) ) {
          $term = wp_get_post_terms( $post_id, $taxonomy );
          if (isset( $term ) && !empty( $term ) ) {
              return wp_get_post_terms( $post_id, $taxonomy )[0]->term_id;
          } else {
              return '';
          }
      }
      return $wpseo_primary_term->get_primary_term();
  }
}

function load_Img($className, $fieldName) { ?>

    <!--[if lt IE 9]>
    <script>
        $(document).ready(function() {
            $("<?php print $className ?>").backstretch("<?php $img=wp_get_attachment_image_src(get_sub_field($fieldName), "full"); echo $img[0];  ?>");
        });
    </script>
    <![endif]-->

  <style scoped>
  <?php echo $className; ?> {
    background-image: url(<?php $img=wp_get_attachment_image_src(get_sub_field($fieldName), "full"); echo $img[0];  ?>);
        background-repeat:no-repeat;
        background-position: center center;
        background-size: cover;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
  }
  @media only screen and (max-width: 1024px) {
    <?php echo $className; ?> {
      background-image: url(<?php $img=wp_get_attachment_image_src(get_sub_field($fieldName), "large"); echo $img[0];  ?>);
    }
  }
  </style>
  <?php
    $detect = new Mobile_Detect;
    $css_code = "<style scoped>";
    if ( $detect->isMobile() )
    {
      $css_code .= $className . ' {background-attachment: scroll;}';
    }
    $css_code .= "</style>";
    echo $css_code;
}

function load_Tax_Img($className, $fieldName, $hasTerm) { ?>

    <!--[if lt IE 9]>
    <script>
        $(document).ready(function() {
            $("<?php print $className ?>").backstretch("<?php $img=wp_get_attachment_image_src(get_field($fieldName, $hasTerm), "full"); echo $img[0];  ?>");
        });
    </script>
    <![endif]-->

  <style scoped>
  <?php echo $className; ?> {
    background-image: url(<?php $img=wp_get_attachment_image_src(get_field($fieldName, $hasTerm), "full"); echo $img[0];  ?>);
        background-repeat:no-repeat;
        background-position: center center;
        background-size: cover;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
  }
  @media only screen and (max-width: 1024px) {
    <?php echo $className; ?> {
      background-image: url(<?php $img=wp_get_attachment_image_src(get_field($fieldName, $hasTerm), "large"); echo $img[0];  ?>);
    }
  }
  </style>
  <?php
    $detect = new Mobile_Detect;
    $css_code = "<style scoped>";
    if ( $detect->isMobile() )
    {
      $css_code .= $className . ' {background-attachment: scroll;}';
    }
    $css_code .= "</style>";
    echo $css_code;
}

function load_Feature_Img($className, $fieldName) { ?>

  <style scoped>
  <?php echo $className; ?> {
    background-image: url(<?php $img=wp_get_attachment_image_src( get_post_thumbnail_id( $fieldName ), "full" ); echo $img[0];  ?>);
        background-repeat:no-repeat;
        background-position: center center;
        background-size: cover;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
  }
  @media only screen and (max-width: 1024px) {
    <?php echo $className; ?> {
      background-image: url(<?php $img=wp_get_attachment_image_src( get_post_thumbnail_id( $fieldName ),  "large"); echo $img[0];  ?>);
    }
  }
  </style>
  <?php
    $detect = new Mobile_Detect;
    $css_code = "<style scoped>";
    if ( $detect->isMobile() )
    {
      $css_code .= $className . ' {background-attachment: scroll;}';
    }
    $css_code .= "</style>";
    echo $css_code;
}

function load_Feature_Img_Item($className, $fieldName, $size) { ?>

  <style scoped>
  <?php echo $className; ?> {
    background-image: url(<?php $img=wp_get_attachment_image_src( get_post_thumbnail_id( $fieldName ), $size ); echo $img[0];  ?>);
        background-repeat:no-repeat;
        background-position: center center;
        background-size: cover;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
  }
  </style>
  <?php
    $detect = new Mobile_Detect;
    $css_code = "<style scoped>";
    if ( $detect->isMobile() )
    {
      $css_code .= $className . ' {background-attachment: scroll;}';
    }
    $css_code .= "</style>";
    echo $css_code;
}

function load_Img_no_mobile_not_sub($className, $fieldName) { ?>
  <style>
  <?php echo $className; ?> {
    background-image: url(<?php $img=wp_get_attachment_image_src(get_field($fieldName), "full"); echo $img[0];  ?>);
  }
  @media only screen and (max-width: 1024px) {
    <?php echo $className; ?> {
      background-image: url(<?php $img=wp_get_attachment_image_src(get_field($fieldName), "large"); echo $img[0];  ?>);
    }
  }
  @media only screen and (max-width: 640px) {
    <?php echo $className; ?> {
      background: none;
    }
  }
  </style>
  <?php
}

// GET SECTION BUILDER
function build_sections()
{
    $question_count = 1;
    $detect = new Mobile_Detect;

    if( get_field('section_builder') )
    {
        while( has_sub_field("section_builder") )
        {
            if( get_row_layout() == "section_html" ) // layout: Section Html
            { 
              $fullWidth = get_sub_field("enable_full_width");
              $cssClass = get_sub_field("section_html_class");
            ?>
                <section class="<?php if(!$fullWidth) { echo 'container'; } ?> section-html <?php echo $cssClass; ?>">
                    <?php if(!$fullWidth) { ?><div class="container"><?php } ?>
                        <?php echo get_sub_field("html_field"); ?>
                    <?php if(!$fullWidth) { ?></div><?php } ?>
                </section>
            <?php }
            elseif( get_row_layout() == "section_image_with_text" ) // layout: Section image with text
            {
                $imageAlignment = get_sub_field("image_alignment");
                $textAlignement = ($imageAlignment == 'Left') ? "Right" : "Left";
                $image = get_sub_field('section_image');
            ?>
            <section class="container section-image-with-text">
                <div class="inner-container">
                    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" class="img-responsive f<?php echo $imageAlignment; ?>" />
                    <div class="content f<?php echo $textAlignement; ?>">
                        <?php echo get_sub_field("section_content"); ?>
                    </div>
                </div>
            </section>
            <?php }
            elseif( get_row_layout() == "section_multi_images_with_content" ) // layout: Section Multi Images with content
            {
                $imageAlignment = get_sub_field("section_alignment");
                $textAlignement = ($imageAlignment == 'Left') ? "Right" : "Left";
                //$image = get_sub_field('section_image');
            ?>
                <section class="container section-multi-image-with-content">
                    <div class="container">
                        <div class="multiImages f<?php echo $imageAlignment; ?>">
                          <?php
                            while(has_sub_field('section_multi_images_with_content_images')):
                            $image = get_sub_field('section_multi_images_with_content_image');
                          ?>
                          <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" class="img-responsive" />
                        <?php endwhile; ?>
                        </div>
                        <div class="content f<?php echo $textAlignement; ?>">
                            <?php echo get_sub_field("section_multi_images_with_content_title"); ?>
                            <?php echo get_sub_field("section_multi_images_with_content_content"); ?>
                        </div>
                    </div>
                </section>
            <?php }
            elseif( get_row_layout() == "section_banner" ) // layout: Section Banner
            { ?>
                <section class="section-banner">
                    <div class="bxslider">
                      <?php
                        while(has_sub_field('section_banner_slider')):
                          $image = get_sub_field('section_banner_slider_image');
                      ?>
                      <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" class="img-responsive" />
                      <?php endwhile; ?>
                    </div>
                    <div class="section-banner-content">
                      <?php echo get_sub_field("section_banner_content"); ?>
                    </div>
                </section>
            <?php }
            elseif( get_row_layout() == "section_subscribe" ) // layout: Section Subscribe
            {
                load_Img(".section-subscribe", "section_subscribe_background_image");
                $image = get_sub_field('section_subscribe_book_image');
                $enableDownload = get_sub_field('enable_download');
            ?>
                <section class="container section-subscribe" id="section-subscribe">
                    <div class="sub_container">
                        <h2><?php echo get_sub_field("section_subscribe_title"); ?></h2>
                        <div class="section-content"><?php echo get_sub_field("section_subscribe_content"); ?></div>
                        <?php if($enableDownload) { ?>
                            <a href="<?php echo get_sub_field("download_file")['url']; ?>" class="btn white-btn" target="_blank"><?php echo get_sub_field("download_btn"); ?></a>
                        <?php } ?>
                    </div>
                    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" class="img-responsive sub-img" />
                </section>
            <?php }
            elseif( get_row_layout() == "section_tab_system" ) // layout: Section Tabs
            {
                $tabAlignment = get_sub_field("tab_position");
                $hasDouble = get_sub_field("enable_double_filters");
                if($detect->isMobile()&&!$detect->isTablet()) { ?>
                    <?php if(!$hasDouble) { ?>
                        <?php if(!$tabAlignment=="vertical") { ?>
                            <section class="container section-tabs-system mobile-container">
                                <div class="fliter-btns-group">
                                    <?php
                                        $i = 0;
                                        while(has_sub_field('section_tabs')):
                                            $tab = strtolower(get_sub_field("tab"));
                                            $tab = preg_replace('/\s+/', '_', $tab);
                                    ?>
                                        <div class="inline tab mobile-tab"><?php echo get_sub_field("tab");?></div>
                                        <div class="grid section-content mobile-content">
                                            <div class="inner-container"><?php echo get_sub_field("tab_section"); ?></div>
                                            <?php if(get_sub_field("has_slider")) { ?>
                                                <div class="testimonials bxslider">
                                                    <?php
                                                      while(has_sub_field('tab_testimonial_system')):
                                                        $image = get_sub_field('tab_testimonial_image');
                                                        $link = get_sub_field('tab_testimonial_company_link');
                                                    ?>
                                                    <div class="testimonial">
                                                        <div class="testimonial-bg-image" style="background-image: url('<?php echo $image['url']; ?>');">
                                                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" class="img-responsive testimonial-image" />
                                                        </div>
                                                        <div class="item-content hasBg">
                                                            <div class="hasBg-content">
                                                                <div class="hasBg-content-padding">
                                                                    <p class="testimonial-content"><?php echo get_sub_field("tab_testimonial"); ?></p>
                                                                    <p class="testimonial-author"><?php echo get_sub_field("tab_testimonial_author_info"); ?></p>
                                                                    <p class="testimonial-author">
                                                                        <?php
                                                                            echo get_sub_field("tab_testimonial_company");
                                                                            if($link) {
                                                                                echo "<span> | </span><a href='http://" . $link . "' target='_blank'>" . $link . "</a>";
                                                                            }
                                                                        ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endwhile; ?>
                                                 </div>
                                            <?php } ?>
                                        </div>
                                    <?php $i++; endwhile; ?>
                                </div>
                            </section>
                        <?php } else { ?>
                            <section class="container section-tabs-system mobile-container hasTopbar">
                                <div class="inner-container">
                                    <h3><?php echo get_sub_field("tab_vertical_headline"); ?></h3>
                                    <select class='filter-div-select'>
                                        <?php
                                            while(has_sub_field('section_tabs')):
                                                $tab = strtolower(get_sub_field("tab"));
                                                $tab = preg_replace('/\s+/', '_', $tab);
                                        ?>
                                        <option class='filter-list filter-list-item' value='#<?php echo $tab; ?>'><?php echo get_sub_field("tab"); ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="grid section-content grid-alignV mobileV-container">
                                    <?php
                                      while(has_sub_field('section_tabs')):
                                        $tab = strtolower(get_sub_field("tab"));
                                        $tab = preg_replace('/\s+/', '_', $tab);
                                    ?>
                                    <div class="<?php echo $tab; ?> element-item" id="<?php echo $tab; ?>">
                                        <div class="inner-container"><?php echo get_sub_field("tab_section"); ?></div>
                                        <?php if(get_sub_field("has_slider")) { ?>
                                        <div class="testimonials bxslider">
                                            <?php
                                              while(has_sub_field('tab_testimonial_system')):
                                                $image = get_sub_field('tab_testimonial_image');
                                                $link = get_sub_field('tab_testimonial_company_link');
                                            ?>
                                            <div class="testimonial">
                                                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" class="img-responsive testimonial-image" />
                                                <div class="item-content hasBg">
                                                    <div class="hasBg-content">
                                                        <div class="hasBg-content-padding">
                                                            <p class="testimonial-content"><?php echo get_sub_field("tab_testimonial"); ?></p>
                                                            <p class="testimonial-author"><?php echo get_sub_field("tab_testimonial_author_info"); ?></p>
                                                            <p class="testimonial-author">
                                                                <?php
                                                                    echo get_sub_field("tab_testimonial_company");
                                                                    if($link) {
                                                                        echo "<span> | </span><a href='http://" . $link . "' target='_blank'>" . $link . "</a>";
                                                                    }
                                                                ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <?php endwhile; ?>
                                         </div>
                                        <?php } ?>
                                    </div>
                                    <?php endwhile; ?>
                                </div>
                            </section>
                        <?php } ?>
                    <?php } else { ?>
                        <section class="container section-tabs-system mobile-container double-filters-mobile-layout">
                            <div class="fliter-btns-group">
                                <?php $i = 0;
                                while(has_sub_field('double_filters_layout')):
                                    $tab = strtolower(get_sub_field("horizontal_tab"));
                                    $tab = preg_replace('/\s+/', '_', $tab);
                                ?>
                                <div class="inline tab mobile-tab"><?php echo get_sub_field("horizontal_tab"); ?></div>
                                <div class="grid section-content mobile-content">
                                    <div class="<?php echo $tab; ?> inner-tabs element-item">
                                        <div class="inner-container">
                                            <h3><?php echo get_sub_field("vertical_tab_headline"); ?></h3>
                                            <select class='filter-div-select'>
                                                <?php
                                                    $j = 0;
                                                    while(has_sub_field('horizontal_tab_content')):
                                                        $tabV = strtolower(get_sub_field("vertical_tab"));
                                                        $tabV = preg_replace('/\s+/', '_', $tabV);
                                                ?>
                                                <option class='filter-list filter-list-item' value='#<?php echo preg_replace("/[^A-Za-z0-9 ]/", '', $tabV); ?>'><?php echo get_sub_field("vertical_tab"); ?></option>
                                                <?php $j++; endwhile; ?>
                                            </select>
                                            <div class="grid-inner section-content grid-alignV mobileV-container">
                                                <?php
                                                  while(has_sub_field('horizontal_tab_content')):
                                                    $tabV = strtolower(get_sub_field("vertical_tab"));
                                                    $tabV = preg_replace('/\s+/', '_', $tabV);
                                                ?>
                                                <div class="<?php echo $tab; ?> <?php echo preg_replace("/[^A-Za-z0-9 ]/", '', $tabV); ?> element-item-inner" id="<?php echo $tabV; ?>">
                                                    <div class="inner-container"><?php echo get_sub_field("vertical_tab_content"); ?></div>
                                                </div>
                                                <?php endwhile; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              <?php $i++; endwhile; ?>
                        </section>
                    <?php } ?>
                <?php } else {
                    if(!$hasDouble) {
                ?>
                    <section class="container section-tabs-system <?php if($tabAlignment=="vertical") echo "hasBorder"; ?>">
                        <?php if($tabAlignment=="vertical") {?><div class="inner-container"><?php } ?>
                            <div class="fliter-btns-group <?php if($tabAlignment=="vertical") echo "fliter-btns-group-alignV fLeft"; ?>">
                                <?php if($tabAlignment=="vertical") {?>
                                <h3><?php echo get_sub_field("tab_vertical_headline"); ?></h3>
                              <?php } $i = 0;
                                while(has_sub_field('section_tabs')):
                                    $tab = strtolower(get_sub_field("tab"));
                                    $tab = preg_replace('/\s+/', '_', $tab);
                              ?>
                              <div class="inline tab <?php if($i==0) { echo "tab-active"; } ?> desktop-tab" data-filter=".<?php echo preg_replace("/[^A-Za-z0-9 ]/", '', $tab); ?>"><?php echo get_sub_field("tab"); ?></div>
                              <?php $i++; endwhile; ?>
                            </div>
                            <div class="grid section-content <?php if($tabAlignment=="vertical") echo "grid-alignV fRight"; ?>">
                                <?php
                                  while(has_sub_field('section_tabs')):
                                    $tab = strtolower(get_sub_field("tab"));
                                    $tab = preg_replace('/\s+/', '_', $tab);
                                ?>
                                <div class="<?php echo preg_replace("/[^A-Za-z0-9 ]/", '', $tab); ?> element-item">
                                    <div class="inner-container"><?php echo get_sub_field("tab_section"); ?></div>
                                    <?php if(get_sub_field("has_slider")) { ?>
                                    <div class="testimonials bxslider">
                                        <?php
                                          while(has_sub_field('tab_testimonial_system')):
                                            $image = get_sub_field('tab_testimonial_image');
                                            $link = get_sub_field('tab_testimonial_company_link');
                                        ?>
                                        <div class="testimonial">
                                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" class="img-responsive testimonial-image" />
                                            <div class="item-content hasBg">
                                                <div class="hasBg-content">
                                                    <div class="hasBg-content-padding">
                                                        <p class="testimonial-content"><?php echo get_sub_field("tab_testimonial"); ?></p>
                                                        <p class="testimonial-author"><?php echo get_sub_field("tab_testimonial_author_info"); ?></p>
                                                        <p class="testimonial-author">
                                                            <?php
                                                                echo get_sub_field("tab_testimonial_company");
                                                                if($link) {
                                                                    echo "<span> | </span><a href='http://" . $link . "' target='_blank'>" . $link . "</a>";
                                                                }
                                                            ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            <?php endwhile; ?>
                                     </div>
                                    <?php } ?>
                                </div>
                                <?php endwhile; ?>
                            </div>
                        <?php if($tabAlignment=="vertical") {?></div><?php } ?>
                    </section>
                    <?php } else { ?>
                    <section class="container section-tabs-system">
                            <div class="fliter-btns-group">
                              <?php $i = 0;
                                while(has_sub_field('double_filters_layout')):
                                    $tab = strtolower(get_sub_field("horizontal_tab"));
                                    $tab = preg_replace('/\s+/', '_', $tab);
                              ?>
                              <div class="inline tab <?php if($i==0) { echo "tab-active"; } ?>" data-filter=".<?php echo $tab; ?>"><?php echo get_sub_field("horizontal_tab"); ?></div>
                              <?php $i++; endwhile; ?>
                            </div>
                            <div class="grid section-content inner-container">
                                <?php while(has_sub_field('double_filters_layout')):
                                    $tab = strtolower(get_sub_field("horizontal_tab"));
                                    $tab = preg_replace('/\s+/', '_', $tab);
                                ?>
                                <div class="<?php echo $tab; ?> inner-tabs element-item">
                                    <div class="fliter-btns-group-inner fliter-btns-group-alignV fLeft">
                                        <h3><?php echo get_sub_field("vertical_tab_headline"); ?></h3>
                                        <?php $j = 0;
                                          while(has_sub_field('horizontal_tab_content')):
                                            $tabV = strtolower(get_sub_field("vertical_tab"));
                                            $tabV = preg_replace('/\s+/', '_', $tabV);
                                        ?>
                                        <div class="inline inner-tab <?php if($j==0) { echo "tab-active"; } ?>" data-filter=".<?php echo preg_replace("/[^A-Za-z0-9 ]/", '', $tabV); ?>"><?php echo get_sub_field("vertical_tab"); ?></div>
                                        <?php $j++; endwhile; ?>
                                    </div>
                                    <div class="grid-inner section-content grid-alignV fRight">
                                        <?php
                                          while(has_sub_field('horizontal_tab_content')):
                                            $tabV = strtolower(get_sub_field("vertical_tab"));
                                            $tabV = preg_replace('/\s+/', '_', $tabV);
                                        ?>
                                        <div class="<?php echo $tab; ?> <?php echo preg_replace("/[^A-Za-z0-9 ]/", '', $tabV); ?> element-item-inner">
                                            <div class="inner-container"><?php echo get_sub_field("vertical_tab_content"); ?></div>
                                        </div>
                                        <?php endwhile; ?>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                            </div>
                    </section>
                <?php } } ?>
            <?php }
            elseif( get_row_layout() == "section_banner_1" ) // layout: Section Banner
            { ?>
                <?php load_Img(".section-banner", "banner_background_image"); ?>
                <?php if(is_front_page()&&($detect->isMobile())) { ?>
                    <header class="banner">
                      <div class="container">
                        <a class="brand inline" href="/">
                            <?php
                              $image = get_field('header_mobile_logo', 'option');
                              $imageFixed = get_field('header_mobile_logo', 'option');
                            ?>
                            <img src="<?php echo $imageFixed['url']; ?>" alt="<?php echo $imageFixed['alt']; ?>" width="90" height="41" class="img-responsive forFixed" />
                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="90" height="41" class="img-responsive forLoaded" />
                        </a>
                        <nav class="mobile-primary inline mobile-enable">
                          <i class="icon-menu"></i>
                        </nav>
                      </div>
                    </header>
                <?php } ?>
                <section class="section-banner normalHeight <?php if(!is_front_page()) { echo 'valign-center'; } ?>">
                    <?php if(is_front_page()&&!$detect->isMobile()) { ?>
                        <header class="banner">
                          <div class="container">
                            <div class="inner-container">
                                <a class="brand inline" href="/">
                                  <?php
                                    $image = get_field('header_logo_home_page', 'option');
                                    $imageFixed = get_field('header_mobile_logo', 'option');
                                    ?>
                                  <img src="<?php echo $imageFixed['url']; ?>" alt="<?php echo $imageFixed['alt']; ?>" width="90" height="41" class="img-responsive forFixed" />
                                  <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="90" height="41" class="img-responsive forLoaded" />
                                </a>
                                <nav class="nav-primary inline">
                                  <?php if (has_nav_menu('primary_navigation'))
                                    { wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']); }
                                  ?>
                                </nav>
                                <nav class="mobile-primary inline mobile-enable">
                                  <i class="icon-menu"></i>
                                </nav>
                            </div>
                          </div>
                        </header>
                        <?php  if(get_sub_field("banner_background_video") && !$detect->isMobile()) { ?>
                        <?php
                            $startTime = get_sub_field("banner_background_video_start_time");
                            $stopTime = get_sub_field("banner_background_video_stop_time");
                        ?>
                        <div class="video-background">
                            <div class="video-foreground">
                                <?php
                                    if($startTime) {
                                ?>
                                    <iframe src="https://www.youtube.com/embed/<?php echo get_sub_field("banner_background_video"); ?>?autohide=1&loop=1&autoplay=1&controls=0&showinfo=0&rel=0&playlist=<?php echo get_sub_field("banner_background_video"); ?>&mute=1&start=<?php echo $startTime; ?>" frameborder="0" allowfullscreen allow="autoplay; fullscreen"></iframe>
                                <?php } else { ?>
                                    <iframe src="https://www.youtube.com/embed/<?php echo get_sub_field("banner_background_video"); ?>?autohide=1&loop=1&autoplay=1&controls=0&showinfo=0&playlist=<?php echo get_sub_field("banner_background_video"); ?>&rel=0&&mute=1" frameborder="0" allowfullscreen allow="autoplay; fullscreen"></iframe>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                    <?php } ?>
                    <?php if(is_front_page()) { ?>
                    </style><div class="valign-center"><?php } ?>
                    <div class="container">
                        <div class="inner-container">
                            <div class="fLeft banner-content">
                                <?php if(get_sub_field("banner_lightbox_video")) { ?>
                                    <div class="video-btn">
                                        <a class="various fancyboxVideo fancybox.iframe" href="https://www.youtube.com/embed/<?php echo get_sub_field("banner_lightbox_video"); ?>?autoplay=1&showinfo=0&rel=0">Watch Video</a>
                                    </div>
                                <?php } ?>
                                <h1><?php echo get_sub_field("banner_header"); ?></h1>
                                <div class="section-banner-content"><?php echo get_sub_field("banner_subheader"); ?></div>
                                <?php if(get_sub_field("photo_credit")) { ?>
                                    <div class="credit"><?php echo get_sub_field("photo_credit"); ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php if(is_front_page()) { ?></div><?php } ?>
                </section>
            <?php }
            elseif( get_row_layout() == "section_intro" ) // layout: Section Intro
            { ?>
                <section class="section-intro">
                    <div class="hasCrossLine">
                        <div class="container">
                            <div class="inner-container">
                                <div class="hasCrossLine-topic"><?php echo get_sub_field("section_intro_topic"); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="inner-container">
                            <div class="fLeft intro-topic">
                                <h2><?php echo get_sub_field("section_intro_headline"); ?></h2>
                                <?php if(get_sub_field("section_intro_headline_additional_content")) { ?><h3><?php echo get_sub_field("section_intro_headline_additional_content"); ?></h3><?php } ?>
                            </div>
                            <div class="fRight intro-content">
                                <div><?php echo get_sub_field("section_intro_content"); ?></div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php }
            elseif( get_row_layout() == "section_cols" ) // layout: Section Cols
            {
                $colNo = get_sub_field("col_number"); // only 2 right now
                $className = get_sub_field("section_cols_class");
                $textAlignment = get_sub_field("section_text_alignment");
                ?>
                <section class="section-cols section-cols-<?php echo $colNo; ?> <?php echo $className . ' txt' . $textAlignment; ?>">
                    <div class="cols container">
                        <?php
                          while(has_sub_field('section_cols_container')):
                            $image = get_sub_field('col_image');
                            $colContent = get_sub_field('col_content');
                        ?>
                        <div class="colItem inline">
                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" class="img-responsive col--<?php echo $colNo; ?>" />
                            <?php echo $colContent; ?>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </section>
            <?php }
            elseif( get_row_layout() == "section_testimonials" ) // layout: Section Testimonials
            { ?>
                <section class="container section-testimonials">
                    <div class="inner-container"><?php echo get_sub_field("section_testimonials_headline"); ?></div>
                    <div class="section-content bxslider">
                        <?php
                          while(has_sub_field('testimonials')):
                            $image = get_sub_field('testimonial_image');
                            $link = get_sub_field('testimonial_company_link');
                        ?>
                        <div class="testimonial">
                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" class="img-responsive testimonial-image" />
                            <div class="item-content hasBg">
                                <p class="oib-member <?php if(!get_sub_field("oib_member_info")) { echo 'tran'; } ?>"><?php if(get_sub_field("oib_member_info")) { ?><?php echo get_sub_field("oib_member_info"); ?><?php } else { echo '&nbsp;'; } ?></p>
                                <div class="hasBg-content hasBg-content<?php echo $i; ?>">
                                    <div class="hasBg-content-padding">
                                        <p class="testimonial-content"><?php echo get_sub_field("testimonial"); ?></p>
                                        <p class="testimonial-author"><?php echo get_sub_field("testimonial_author_info"); ?></p>
                                        <p class="testimonial-author">
                                            <?php
                                                echo get_sub_field("testimonial_company");
                                                if($link) {
                                                    echo "<span> | </span><a href='http://" . get_sub_field("testimonial_company_link") . "' target='_blank'>" . get_sub_field("testimonial_company_link") . "</a>";
                                                }
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </section>
            <?php }
            elseif( get_row_layout() == "section_select_members" ) // layout: Section Select Members
            {
                $enableLightbox = get_sub_field("enable_lightbox");
                ?>
                <section class="container section-select-members <?php if(get_sub_field("has_topborder")) { echo 'hasTopbar'; } ?>">
                    <h2><?php echo get_sub_field("section_select_members_title"); ?></h2>
                    <div class="members">
                    <?php
                          $post_objects = get_sub_field('members');
                          if( $post_objects ): $i = 0;
                            foreach( $post_objects as $post):
                                $image = wp_get_attachment_image_src(get_field('member_pic',$post->ID), "member-thumbnail");
                                $imageFull = wp_get_attachment_image_src(get_field('member_lightbox_pic',$post->ID), "full");
                                $memberGovernmentMember = get_field("member_governance_title",$post->ID);
                        ?>
                        <div class="member <?php if($enableLightbox) { echo "member-fancybox"; } ?>" <?php if($enableLightbox) { echo "data-lightbox='.member-profile-" . $i . "'"; } ?>>
                            <img src="<?php echo $image[0]; ?>" alt="<?php echo get_the_title($post->ID); ?>" width="390" height="390" class="img-responsive team-member" />
                            <div class="item-content">
                                <h4><?php echo get_the_title($post->ID); ?></h4>
                                <?php if($memberGovernmentMember&&is_page("governance")) { ?>
                                <p class="person-title"><?php echo $memberGovernmentMember; ?></p>
                                <?php } else { ?>
                                <p class="person-title"><?php echo get_field("member_job",$post->ID); ?></p>
                                <?php } ?>
                            </div>
                            <div class="hidden">
                                <div class="member-profile member-profile-<?php echo $i; ?>">
                                    <h5><?php echo get_the_title($post->ID); ?></h5>
                                    <?php if($memberGovernmentMember&&is_page("governance")) { ?>
                                    <p class="person-title"><?php echo $memberGovernmentMember; ?></p>
                                    <?php } else { ?>
                                    <p class="person-title"><?php echo get_field("member_job",$post->ID); ?></p>
                                    <?php } ?>
                                    <img src="<?php echo $imageFull[0]; ?>" alt="<?php echo get_the_title($post->ID); ?>" width="<?php echo $imageFull[1]; ?>" height="<?php echo $imageFull[2]; ?>" class="img-responsive team-member" />
                                    <p class="pic-credit"><?php echo get_field("pic_credit", $post->ID); ?></p>
                                    <p class="profile"><?php echo get_field("member_profile",$post->ID); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php $i++; endforeach; wp_reset_postdata(); endif; ?>
                    </div>
                </section>
            <?php }
            elseif( get_row_layout() == "section_news" && get_sub_field("load_news")) // layout: Section Intro
            { ?>
                <section class="section-news container">
                  <div class="tabs">
                    <?php
                      wp_reset_query();
                      global $paged;
                      if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } else if ( get_query_var('page') ) {$paged = get_query_var('page'); } else {$paged = 1; }
                      $args = array(
                        'post_type'=>'news',
                        'post_status' => 'publish',
                        'posts_per_page'=>6,
                        'orderby'=>'date',
                      );
                      $the_query = new WP_Query( $args );
                      if( $the_query->have_posts() ) {
                    ?>
                    <div class="grid grid-tax">
                      <?php $i = 0;
                        while ( $the_query->have_posts() ): $the_query->the_post();
                          //foreach (get_the_terms(get_the_ID(), 'news-filter') as $cat) {
                          $cat = get_the_terms(get_the_ID(), 'news-filter')[0];
                            //$img=wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'news-thumbnail' );
                      ?>
                        <div class="inline element-item <?php echo $cat->slug; ?>">
                          <?php load_Feature_Img_Item(".item-" . $i, get_the_ID(), "news-thumbnail"); ?>
                          <div class="item item-<?php echo $i; ?> newsitem" data-url="<?php echo get_permalink(); ?>"></div>
                          <!--<img src="<?php echo $img[0]; ?>" width="<?php echo $img[1]; ?>" height="<?php echo $img[2]; ?>" alt="news featured image" class="img-responsive featured-image" /> -->
                          <?php
                            $categories = get_the_terms( get_the_ID(), 'news-filter' );
                            $category = 'news';
                            if ( ! empty( $categories ) ) {
                              $category = esc_html( $categories[0]->name );
                              $categorySlug = esc_html( $categories[0]->slug );
                            }
                            $iid = get_primary_taxonomy_id(get_the_ID(), 'news-filter');

                            if($iid!=null) $category = get_the_category_by_ID($iid);
                          ?>
                          <div class="item-content">
                            <h4><a href="/news_categories/<?php echo strtolower($categorySlug); ?>" class="cta-brown"><?php echo $category; ?></a></h4>
                            <a href="<?php echo get_permalink(); ?>" class="cta-brown"><?php echo get_the_title(); ?></a>
                            <p><?php echo get_the_excerpt(); ?></p>
                            <?php if(get_field("display_author", 'option')) { ?>
                            <p class="author-info-item"><?php echo get_the_author_meta( 'first_name') . ' ' . get_the_author_meta( 'last_name'); ?></p>
                            <?php } ?>
                          </div>
                        </div>
                      <?php $i++; endwhile; wp_reset_postdata(); } //} ?>
                    </div>
                  </div>
                  <div class="find_more"><a href="<?php echo get_sub_field("find_more_link"); ?>" class="btn"><?php echo get_sub_field("find_more_btn"); ?> <i class="icon-right-big"></i></a></div>
                </section>
            <?php }
        }
    }
}
