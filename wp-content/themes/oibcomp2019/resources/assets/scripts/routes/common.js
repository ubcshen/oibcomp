export default {
  init() {
    // JavaScript to be fired on all pages
    if($('#contactlist').length) {
      $('#contactlist').select2({
        selectOnClose: true,
        minimumResultsForSearch: -1,
      });
    }
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
