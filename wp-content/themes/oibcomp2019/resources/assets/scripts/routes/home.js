export default {
  init() {
    // JavaScript to be fired on the home page
    $('.img-slider').bxSlider({
      adaptiveHeight: false,
      controls: true,
      auto: false,
      randomStart: false,
      hideControlOnEnd: true,
      infiniteLoop: true,
      mode: 'fade',
      touchEnabled: false,
      pagerCustom: '.slider-control',
      onSliderLoad: function() {
        $(this).find('.tagline.slider-banner').show();
      },
    });
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};
