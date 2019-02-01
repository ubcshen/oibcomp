export default {
  init() {
    // JavaScript to be fired on all pages
    //var $grid = '';

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

    $('.fancybox').fancybox({
      smallBtn : true,
      buttons : [
        'zoom',
        'close',
      ],
      btnTpl: {
        zoom:
          '<button data-fancybox-zoom class="fancybox-button fancybox-button--zoom" title="{{ZOOM}}">' +
          '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.7 17.3l-3-3a5.9 5.9 0 0 0-.6-7.6 5.9 5.9 0 0 0-8.4 0 5.9 5.9 0 0 0 0 8.4 5.9 5.9 0 0 0 7.7.7l3 3a1 1 0 0 0 1.3 0c.4-.5.4-1 0-1.5zM8.1 13.8a4 4 0 0 1 0-5.7 4 4 0 0 1 5.7 0 4 4 0 0 1 0 5.7 4 4 0 0 1-5.7 0z"/></svg>' +
          "</button>",

        close:
          '<button data-fancybox-close class="fancybox-button fancybox-button--close" title="{{CLOSE}}">' +
          '<i class="icon-cancel-circled-after fRight">Close</i>' +
          "</button>",
      },
    });

    if($(".section-image-tabs").length) {
      $(".section-tab").each(function() {
        $(this).click(function() {
          var url = $(this).attr("data-link");
          window.open(url, "_self");
        });
      });
    }

    $(window).scroll(function () {
      var scroll = $(window).scrollTop();
      if(scroll>118) {
        $('.banner').addClass('fixed');
      }
      else {
        $('.banner').removeClass('fixed');
      }
    });
  },
  finalize() {
    $(window).load(function() {
      $('.grid').isotope({
        itemSelector: '.grid-item',
        percentPosition: true,
        masonry: {
          // use element for option
          gutter: 10,
          columnWidth: '.grid-sizer',
        },
      });
    });
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
