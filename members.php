<?php 
include('header.php'); 
include('dbconfig.php'); 
$query = "SELECT * FROM members ORDER BY member_id DESC LIMIT 10";
$result = mysqli_query($dbc,$query);
if(mysqli_num_rows($result) > 0) {
  $membersData = array();
  while ($row = mysqli_fetch_array($result)) {
   $membersData[] = array (
     'member_name'=>$row['member_name'],
     'phone_number' => $row['phone_number'],
     'join_date'=> $row['join_date'],
     'member_id' => $row['member_id'],
     'renewal_date' => $row['renewal_date']
     );
 }
}
?>
<style type="text/css">
    /*for removing spin box arrows in input */
  input[type='date'] {
    -moz-appearance:textfield;
  }
  /*for removing spin box arrows in input */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
      -webkit-appearance: none;
  }
</style>
<div class="row">
	<div class="col-lg-8" style="padding-top:30px;">
        <button class="btn btn-success" data-toggle="modal" data-target="#addmember_modal">Add New Member</button>
        <input type="text" id="search_member_name" class="form-control" style="width:50%;display:inline;">
		<button class="btn btn-primary" onclick="searchMember()">Search</button>
	</div>
	<div class="col-lg-12" style="padding-top:30px;">
		<div class="panel panel-primary">
            <div class="panel-heading" id="members_table_title">
                Members List
            </div>
            <div class="panel-body">
                <div class="responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Member ID</th><th>Member Name</th><th>Phone Number</th><th>Member since</th><th>Renewal Date</th><th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="members_table">
                        <?php
                        foreach ($membersData as $value){
                            echo '<tr>';
                            echo '<td>' . str_pad($value['member_id'],4,0,STR_PAD_LEFT) . '</td>';
                            echo '<td>' . $value['member_name'] . '</td>';
                            echo '<td>' . $value['phone_number'] . '</td>';
                            echo '<td>' . $value['join_date'] . '</td>';
                            echo '<td>' . $value['renewal_date'] . '</td>';
                            echo '<td>' . '<button type="button" onclick="viewMember(\''. $value['member_id'] .'\')" class="btn btn-warning"><i class="fa fa-edit"></i></button> <button type="button" class="btn btn-danger" onclick="deleteMember(\''. $value['member_id'] .'\')"><i class="fa fa-close"></i>' . '</td>';
                            echo '</tr>';
                        }
                      ?>
                    </tbody>
                </table>
            </div>
            <!--div class="panel-footer"></div-->
        </div>
	</div>
</div>

<!-- Add member modal -->
<div class="modal fade" id="addmember_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel"> Add New Member</h2>
      </div>
      <div class="modal-body" id="div_jobdetails">
        <form name="member_form" id="member_form" method="post" action="" onsubmit="return false;">
            <div class="form-group col-lg-6">
                <label>Member name </label>
                <input type="text" class="form-control required" name="member_name" id="member_name" />
            </div>
            <div class="form-group col-lg-6">
                <label>Phone Number </label>
                <input type="text" class="form-control required" name="phone_number" id="phone_number" />
            </div>
            <div class="form-group col-lg-12">
                <label>Address</label>
                <input type="text" class="form-control required" name="address" id="address" />
            </div>
            <div class="form-group col-lg-6">
                <label>Deposit Amount </label>
                <input type="text" class="form-control required" name="deposit_amount" id="deposit_amount" />
            </div>
            <div class="form-group col-lg-6">
                <label>Membership Amount </label>
                <input type="text" class="form-control required" name="membership_amount" id="membership_amount" />
            </div>
            <div class="form-group col-lg-6">
                <label>Joining Date </label>
                <input type="text" class="form-control datepick required" name="joining_date" id="joining_date" />
            </div>
            <div class="form-group col-lg-6">
                <label>Renewal Date </label>
                <input type="text" class="form-control datepick required" name="renewal_date" id="renewal_date" />
            </div>
        </form>
      </div>
      <div class="clearfix"></div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" onclick="addMember()">Add Member</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit member modal -->
<div class="modal fade" id="editmember_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel"> Edit Member</h2>
      </div>
      <div class="modal-body" id="div_jobdetails">
        <form name="edit_member_form" id="edit_member_form" method="post" action="" onsubmit="return false;">
            <input type="hidden" id="edit_member_id" />
            <div class="form-group col-lg-6">
                <label>Member name </label>
                <input type="text" class="form-control required" name="edit_member_name" id="edit_member_name" />
            </div>
            <div class="form-group col-lg-6">
                <label>Phone Number </label>
                <input type="text" class="form-control required" name="edit_phone_number" id="edit_phone_number" />
            </div>
            <div class="form-group col-lg-12">
                <label>Address</label>
                <input type="text" class="form-control required" name="edit_address" id="edit_address" />
            </div>
            <div class="form-group col-lg-6">
                <label>Deposit Amount </label>
                <input type="text" class="form-control required" name="edit_deposit_amount" id="edit_deposit_amount" />
            </div>
            <div class="form-group col-lg-6">
                <label>Membership Amount </label>
                <input type="text" class="form-control required" name="edit_membership_amount" id="edit_membership_amount"  />
            </div>
            <div class="form-group col-lg-6">
                <label>Joining Date </label>
                <input type="text" class="form-control datepick required" name="edit_joining_date" id="edit_joining_date"  />
            </div>
            <div class="form-group col-lg-6">
                <label>Renewal Date </label>
                <input type="text" class="form-control datepick required" name="edit_renewal_date" id="edit_renewal_date" />
            </div>
        </form>
      </div>
      <div class="clearfix"></div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" onclick="updateMember()">Save Member</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php
include('footer_js.php');
?>
<script type="text/javascript" src="assets\js\members.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#li_members').addClass('active-link');
});
$('.datepick').datepicker({
    todayHighlight: 1,
    autoclose: 1,
    format: 'yyyy-mm-dd',
});

$(document).ready(function(){
    $("#member_form").validate();
    $("#edit_member_form").validate();
});

</script>
<?php
include('footer.php');
?>