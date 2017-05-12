function addMember() {
  if($("#member_form").valid()){
    var memberName = document.getElementById('member_name').value;
    var phoneNumber = document.getElementById('phone_number').value;
    var address = document.getElementById('address').value;
    var depositAmount = document.getElementById('deposit_amount').value;
    var membershipAmount = document.getElementById('membership_amount').value;
    var joiningDate = document.getElementById('joining_date').value;

    var data = "memberName=" + memberName + "&phoneNumber=" + phoneNumber + "&address=" + address + "&depositAmount=" + depositAmount + "&membershipAmount=" + membershipAmount + "&joiningDate=" + joiningDate + "&action=add_member"; 

    $.ajax({
      type: "POST",
      url: "services/member_services.php",
      data:  data,
      dataType: 'json',
      success: function(result){
        $('#addmember_modal').hide();
        if(result.infocode == 'INSERTSUCCESS'){
          bootbox.alert(result.message, function(){
              location.reload();
          });
        } else {
          bootbox.alert(result.message);
        }
      },
      error: function(result){
        bootbox.alert(result.message);
      }           
    });
  }
}

function viewMember(memberId){
  var data = "memberId=" + memberId +"&action=get_member_details";
  $.ajax({
      url: "services/member_services.php",
      type: "POST",
      data:  data,
      dataType: 'json',
      success: function(result){
          $('#edit_member_id').val(memberId);
          $('#edit_member_name').val(result.member_name);
          $('#edit_phone_number').val(result.phone_number);
          $('#edit_address').val(result.address);
          $('#edit_deposit_amount').val(result.deposit_amount);
          $('#edit_membership_amount').val(result.membership_amount);
          $('#edit_joining_date').val(result.join_date);
          $('#editmember_modal').modal('show');
      }         
  });
}

function searchMember(){
  var memberName = $('#search_member_name').val();
  var data = "memberName=" + memberName + "&action=search_member";
  $.ajax({
      url: "services/member_services.php",
      type: "POST",
      data:  data,
      dataType: 'html',
      success: function(result){
          $('#members_table_title').html("Search List");
          $('#members_table').html(result);
      }         
  });
}

function updateMember(){
  if($("#edit_member_form").valid()){
    var memberId = document.getElementById('edit_member_id').value;
    var memberName = document.getElementById('edit_member_name').value;
    var phoneNumber = document.getElementById('edit_phone_number').value;
    var address = document.getElementById('edit_address').value;
    var depositAmount = document.getElementById('edit_deposit_amount').value;
    var membershipAmount = document.getElementById('edit_membership_amount').value;
    var joiningDate = document.getElementById('edit_joining_date').value;

    var data = "memberId=" + memberId + "&memberName=" + memberName + "&phoneNumber=" + phoneNumber + "&address=" + address + "&depositAmount=" + depositAmount + "&membershipAmount=" + membershipAmount + "&joiningDate=" + joiningDate + "&action=update_member"; 

    $.ajax({
      url: "services/member_services.php",
      type: "POST",
      data:  data,
      dataType: 'json',
      success: function(result){
        $('#editmember_modal').hide();
        if(result.infocode == 'UPDATESUCCESS'){
          bootbox.alert(result.message, function(){
              location.reload();
          });
        } else {
          bootbox.alert(result.message);
        }
      }          
    });
  }
}

function deleteMember(memberId){
  bootbox.confirm('Are you sure you want to delete this member?',function(result){
    if(result){
      var data = "memberId=" + memberId +"&action=delete_member";
      $.ajax({
          url: "services/member_services.php",
          type: "POST",
          data:  data,
          dataType: 'json',
          success: function(result){
              if(result.infocode == 'DELETESUCCESS'){
                bootbox.alert(result.message, function(){
                    location.reload();
                });
              } else {
                bootbox.alert(result.message);
              }
          }         
      });
    }
  });
}