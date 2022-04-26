// Open popup
$('*[data-open-popup]').on('click', function(){
  // open popup
  $('.overlay-wrap.' + $(this).attr('data-open-popup')).addClass('show');

  // Close any open menus
  $('.menu.open').removeClass('open');
});

// Close popup
$('.overlay-wrap').on('click', '.close-popup', function(){
  $('.overlay-wrap.show').removeClass('show');
});
