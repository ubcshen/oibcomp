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

    $('.bxslider').bxSlider({
      adaptiveHeight: true,
      controls: true,
      auto: false,
      randomStart: false,
      hideControlOnEnd: true,
      infiniteLoop: true,
      mode: 'fade',
      touchEnabled: false,
      onSliderLoad: function() {
        $(".bxslider .tagline.slider-banner, .img-slider .tagline.slider-banner").show();
      },
      onSlideAfter: function() {
        $(".bx-viewport").height($(".bxslider .slider-content:first").height());
      },
    });

    $( 'p:empty' ).remove();

    $(window).load(function() {
      $('.bxslider').bxSlider({
        adaptiveHeight: true,
        controls: true,
        auto: false,
        randomStart: false,
        hideControlOnEnd: true,
        infiniteLoop: true,
        mode: 'fade',
        touchEnabled: false,
        onSliderLoad: function() {
          $(".bxslider .tagline.slider-banner, .img-slider .tagline.slider-banner").show();
        },
        onSlideAfter: function() {
        $(".bx-viewport").height($(".bxslider .slider-content:first").height());
      },
      });
      $(".section-tab-select").select2({
        minimumResultsForSearch: -1,
      });
      if($(".section-tab-select").length) {
        $(".section-tab-select").on('change', function() {
          $(".section-tab-select option:selected").each(function() {
            var url = $(this).attr("data-slide-link");
            //console.log("url: " + url);
            window.open(url,"_self");
          });
        });
      }
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

    $(".hide-desktop .nav li").click(function() {
      if($(this).hasClass("menu-item-has-children")) {
        if($(this).hasClass("open")) {
          $(this).removeClass("open");
        }
        else {
          $(".menu-item-has-children").removeClass("open");
          $(this).addClass("open");
        }
      }
    });

    if($(".mobile-primary").is(':visible')) {
      if(!$(".icon-menu").hasClass("close")) {
        $(".mobile-primary").click(function() {
          console.log("sds");
          $(".icon-menu").addClass("close");
          $(".hide-desktop").addClass("open");
          $("body").addClass("open");
        });
      }
    }


    $('.main-container').on('click touchstart', function() {
       if( $("body").hasClass("open") ){
        if($(".icon-menu").hasClass("close")) {
          $(".icon-menu").removeClass("close");
          $(".hide-desktop").removeClass("open");
          $("body").removeClass("open");
        }
      }
    }).on('click', '.mobile-primary', function(e) {
      e.stopPropagation();
    });

    /*var imgOpts = $.extend(true, {}, $.fancybox.defaults, {
      caption : function() {
        console.log("sds");
        return $(this).next('figcaption').html();
      },
    });


    $( '[data-fancybox]' ).fancybox(imgOpts);*/


    $( '[data-fancybox]' ).fancybox({
      smallBtn : true,
      buttons : [
        //'zoom',
        'close',
      ],
      btnTpl: {
        /*zoom:
          '<button data-fancybox-zoom class="fancybox-button fancybox-button--zoom" title="{{ZOOM}}">' +
          '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.7 17.3l-3-3a5.9 5.9 0 0 0-.6-7.6 5.9 5.9 0 0 0-8.4 0 5.9 5.9 0 0 0 0 8.4 5.9 5.9 0 0 0 7.7.7l3 3a1 1 0 0 0 1.3 0c.4-.5.4-1 0-1.5zM8.1 13.8a4 4 0 0 1 0-5.7 4 4 0 0 1 5.7 0 4 4 0 0 1 0 5.7 4 4 0 0 1-5.7 0z"/></svg>' +
          "</button>",*/

        close:
          '<button data-fancybox-close class="fancybox-button fancybox-button--close" title="{{CLOSE}}">' +
          '<i class="icon-cancel-circled-after fRight">Close</i>' +
          "</button>",
      },
      caption : function() {
        return $(this).next('figcaption').html();
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
        $('.homeLogo').addClass('hideHomeLogo');
        $('.forfix').addClass('showHomeLogo');
      }
      else {
        $('.banner').removeClass('fixed');
        $('.homeLogo').removeClass('hideHomeLogo');
        $('.forfix').removeClass('showHomeLogo');
      }
    });
  },
  finalize() {
    $(window).load(function() {
      if($(".tagline.col-tagline").length) {
        $(".tagline.col-tagline").each(function() {
          var $twidth = $(this).outerWidth();
          var $theight = $(this).outerHeight();
          //console.log("dsds");
          $(this).css("margin-top", -$theight/2);
          $(this).css("margin-right", -$twidth/2);
        });
      }

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

    $( window ).resize(function() {
      if($(".tagline.col-tagline").length) {
        $(".tagline.col-tagline").each(function() {
          var $twidth = $(this).outerWidth();
          var $theight = $(this).outerHeight();
          //console.log("dsds");
          $(this).css("margin-top", -$theight/2);
          $(this).css("margin-right", -$twidth/2);
        });
      }
    });
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};