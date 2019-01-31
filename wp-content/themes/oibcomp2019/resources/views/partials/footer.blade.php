<footer class="content-info">
  <div class="container">
      <?php $logo = get_field('footer_logo', 'option');  ?>
      <div class="footer-promo">
        <img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>" width="<?php echo $logo['width']; ?>" height="<?php echo $logo['height']; ?>" class="img-responsive logo" /><?php echo get_field('footer_content', 'option');  ?>
      </div>
      <div class="footer-info">
        <div class="fLeft leftpart">
          <?php echo get_field('footer_send_section', 'option');  ?>
        </div>
        <div class="fRight rightpart">
          <nav class="nav-primary">
            @if (has_nav_menu('primary_navigation'))
              {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'list']) !!}
            @endif
          </nav>
        </div>
      </div>
      <hr>
      <div class="footer-copyright">
        <div class="copyright fLeft">
          <?php echo get_field('copy_right', 'option');  ?>
        </div>
        <div class="social_medias fRight">
          <div class="inline boldMF">Follow us at</div>
          <div class="inline social_icons">
            <?php while(has_sub_field('social_medias', 'option')): $image = get_sub_field('social_media', 'option'); ?>
              <a class="social_icon inline" href="<?php echo get_sub_field("social_media_link", 'option'); ?>" target="_blank">
                <i class="<?php echo $image; ?>"></i>
              </a>
            <?php endwhile; ?>
          </div>
        </div>
      </div>
  </div>
</footer>
