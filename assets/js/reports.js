function showHideDateFields(){
  if($("input[name='report_type']:checked").val() == 5){
      $('#date_fields').show();
  } else {
    $('#date_fields').hide();
  }
}

function showHideBookCategory(){
  if($("input[name='report_type']:checked").val() == 3){
      $('#book_category_select').show();
  } else {
    $('#book_category_select').hide();
  }
}


function generateReport(){
  var selectedVal = $('input[name=report_type]:checked').val();
  var fromDate = $('#from_date').val();
  var toDate = $('#to_date').val();
  var bookCategory = $('#book_category').val();
  var data = 'selected_val=' + selectedVal + '&from_date=' + fromDate + '&to_date=' + toDate + '&book_category=' + bookCategory + '&action=generateReport';
  $.ajax({
    type : 'POST',
    url : 'services/report_services.php',
    data : data,
    dataType: 'json',
    success : function(result) {
      if(result.infocode == 'success'){
        bootbox.alert(result.message);
      } else {
        bootbox.alert(result.message);
      }
    },
    error : function(result){
      bootbox.alert("Failure");
    }
  });
}
