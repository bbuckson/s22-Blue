/*
 * This handles opening things when any item with 'data-open-pane' attribute is clicked on
 *
 * The value of the attribute is the class of the item it's supposed to open.
 *
 * It toggles class 'open' on it
 *
 */

$('*[data-open-pane]').on('click', function(){
  console.log('sweet');
  $('.' + $(this).attr('data-open-pane')).toggleClass('open');
});
