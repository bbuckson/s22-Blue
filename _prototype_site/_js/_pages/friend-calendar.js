if(relationship_type == "friends")
{
  $('.time-slot-wrap').on('click', function(){
    var hour = $(this).attr('data-hour');
    var hourType = $(this).attr('data-hour-type');
    var currDate = $('input[name="curr_date"]').val();


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

    $('.overlay-wrap.new-event').find('input[name="start_time"]').val(hour + ':00:00');
    $('.overlay-wrap.new-event').find('input[name="end_time"]').val(endHour + ':00:00');
    $('.overlay-wrap.new-event').find('input[name="date"]').val(currDate);

  });
}
