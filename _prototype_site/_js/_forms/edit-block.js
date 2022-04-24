var editBlockForm = $('.edit-block-wrap');

$('.submit[data-form="edit-block"]').on('click', function(){
  var blockType = editBlockForm.find('.button.block-type.active').attr('data-value');
  var startDate = editBlockForm.find('input[name="date"]').val();
  var blockId = editBlockForm.find('input[name="block_id"]').val();
  var startTime = editBlockForm.find('input[name="start_time"]').val();
  var endTime = editBlockForm.find('input[name="end_time"]').val();


  var errorMsg = "";

  if (blockType == null || blockType == "" || startDate == null || startDate == "" || startTime == null || startTime == "" || endTime == null || endTime == "")
  {
    errorMsg = "All fields are required.";
  }

  setBlockForm.find('p.error-msg').html(errorMsg);

  $.ajax(
    {
      url: "_php/form_actions/edit_block.php",
      type: 'POST',
      data: {
        'block_type': blockType,
        'start_time': startTime,
        'end_time': endTime,
        'start_date': startDate,
        'block_id': blockId
      }
    }
  ).done(
    function(results){
      console.log(results);
      if(results == "nice"){
        $('.overlay-wrap.edit-block').removeClass('show');
        updatePersonalCalendar(this_users_id);
      }
      else{
      }
    }
  );

});
