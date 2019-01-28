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
      touchEnabled: true,
      pagerCustom: '.slider-control',
    });
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};
