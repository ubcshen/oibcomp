export default {
  init() {
    // JavaScript to be fired on all pages
    if($('#contactlist').length) {
      $('#contactlist').select2({
        selectOnClose: true,
        minimumResultsForSearch: -1,
      });
    }

    $( 'p:empty' ).remove();

    $('.bxslider').bxSlider({
      adaptiveHeight: false,
      controls: true,
      auto: false,
      randomStart: false,
      hideControlOnEnd: true,
      infiniteLoop: true,
      mode: 'fade',
      touchEnabled: true,
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
