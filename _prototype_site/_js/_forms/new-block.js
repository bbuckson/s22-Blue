var setBlockForm = $('.set-block-wrap');

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
