$(document).ready(function(){                                    var setBlockForm = $('.set-block-wrap');

$('.block-type.button').on('click', function(){
  $('.block-type.button.active').removeClass('active');
  $(this).addClass('active');
});


$('.submit[data-form="new-block"]').on('click', function(){
  var blockType = setBlockForm.find('.button.block-type.active').attr('data-value');
  var startDate = setBlockForm.find('input[name="date"]').val();
  var startTime = setBlockForm.find('input[name="start_time"]').val();
  var endTime = setBlockForm.find('input[name="end_time"]').val();


  var errorMsg = "";

  if (blockType == null || blockType == "" || startDate == null || startDate == "" || startTime == null || startTime == "" || endTime == null || endTime == "")
  {
    errorMsg = "All fields are required.";
  }

  setBlockForm.find('p.error-msg').html(errorMsg);

  $.ajax(
    {
      url: "_php/form_actions/new_block.php",
      type: 'POST',
      data: {
        'block_type': blockType,
        'start_time': startTime,
        'end_time': endTime,
        'start_date': startDate
      }
    }
  ).done(
    function(results){
      console.log(results);
      if(results === "nice"){

      }
      else{
      }
    }
  );

});
$('.time-slot-wrap').on('click', function(){
  $('.overlay-wrap.new-block').addClass('show');

  var hour = $(this).attr('data-hour');
  var hourType = $(this).attr('data-hour-type');
  var currDate = $('input[name="curr_date"]').val();

  console.log('curr ' + currDate);

  hour = parseInt(hour);
  endHour = hour + 1;

  // the inputs takes 24 hour time so we need to add 12 if it's PM
  if (hourType == "PM")
  {
    hourType += 12;
  }

  // Convert back to string so we can add a leading zero if it's one digit
  hour = hour.toString();
  endHour = endHour.toString();

  if(hour.length == 1)
  {
    hour = "0" + hour;
  }
  if(endHour.length == 1)
  {
    endHour = "0" + endHour;
  }

  $('.overlay-wrap.new-block').find('input[name="start_time"]').val(hour + ':00:00');
  $('.overlay-wrap.new-block').find('input[name="end_time"]').val(endHour + ':00:00');
  $('.overlay-wrap.new-block').find('input[name="date"]').val(currDate);

});
// Close popup
$('.close-popup').on('click', function(){
  $('.overlay-wrap.show').removeClass('show');
  console.log('sweet');
});

console.log('nice');
});                                   