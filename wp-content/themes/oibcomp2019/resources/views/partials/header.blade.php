<?php $detect = new Mobile_Detect; //if(!is_front_page()) { ?>
<header class="banner">
  <div class="container">
    <a class="brand inline" href="{{ home_url('/') }}">
      <?php $image = get_field('site_logo', 'option'); ?>
      <?php if(!is_front_page()) { ?>
        <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="246" height="110" class="img-responsive forLoaded" />
      <?php } else { $imageHome = get_field('home_page_site_logo', 'option'); ?>
        <img src="<?php echo $imageHome['url']; ?>" alt="<?php echo $imageHome['alt']; ?>" width="246" height="110" class="img-responsive forLoaded homeLogo" />
        <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="246" height="110" class="img-responsive forLoaded forfix" />
      <?php } ?>
    </a>
    <nav class="nav-primary inline">
      <div class="callinfo">
        <?php echo get_field('call_us', 'option'); ?> | 
        <?php
          while(has_sub_field('social_medias', 'option')):
            $image = get_sub_field('social_media', 'option');
            $link = get_sub_field('social_media_link', 'option');
          ?>
          <a class="social_icon inline" href="<?php echo $link; ?>" target="_blank">
            <i class="<?php echo $image; ?>"></i>
          </a>
        <?php endwhile; ?>
      </div>
      <hr>
      @if (has_nav_menu('primary_navigation'))
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
      @endif
    </nav>
    <nav class="mobile-primary inline <?php if($detect->isMobile()) { echo 'mobile-enable'; } ?>">
      <i class="icon-menu"></i>
    </nav>
  </div>
</header>
<?php //} ?>

