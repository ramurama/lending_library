<?php 
include('dbconfig.php');

$op1 = $op2 = $op3 = $op4 = $op5 = $op6 = 0;
$q1 = "SELECT COUNT(lend_booklist_id) AS somecount FROM lend_booklist WHERE due_date = CURDATE()";
$r1 = mysqli_query($dbc, $q1);
if(mysqli_num_rows($r1)>0){
    $rw1 = mysqli_fetch_assoc($r1);
    $op1 = $rw1['somecount'];
}

$q2 = "SELECT COUNT(lend_booklist_id) AS somecount FROM lend_booklist WHERE due_date >= CURDATE() AND due_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
$r2 = mysqli_query($dbc, $q2);
if(mysqli_num_rows($r2)>0){
    $rw2 = mysqli_fetch_assoc($r2);
    $op2 = $rw2['somecount'];
}

$q3 = "SELECT COUNT(member_id) AS somecount FROM members WHERE renewal_date = CURDATE()";
$r3 = mysqli_query($dbc, $q3);
if(mysqli_num_rows($r3)>0){
    $rw3 = mysqli_fetch_assoc($r3);
    $op3 = $rw3['somecount'];
}

$q4 = "SELECT COUNT(member_id) AS somecount FROM members WHERE renewal_date >= CURDATE() AND renewal_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
$r4 = mysqli_query($dbc, $q4);
if(mysqli_num_rows($r4)>0){
    $rw4 = mysqli_fetch_assoc($r4);
    $op4 = $rw4['somecount'];
}

$q5 = "SELECT COUNT(lend_booklist_id) AS somecount FROM lend_booklist WHERE due_date <= CURDATE()";
$r5 = mysqli_query($dbc, $q5);
if(mysqli_num_rows($r5)>0){
    $rw5 = mysqli_fetch_assoc($r5);
    $op5 = $rw5['somecount'];
}

$q6 = "SELECT COUNT(member_id) AS somecount FROM members WHERE renewal_date <= CURDATE()";
$r6 = mysqli_query($dbc, $q6);
if(mysqli_num_rows($r6)>0){
    $rw6 = mysqli_fetch_assoc($r6);
    $op6 = $rw6['somecount'];
}

include('header.php'); ?>
<div class="row">
	<div class="col-lg-6" style="padding-top:30px;">
		<div class="panel panel-primary">
            <div class="panel-heading">
                Books Due
            </div>
            <div class="panel-body">
                <p>Today : <a href="javascript:display_details('books_due_today');" > <?php echo $op1; ?></a></p>
                <p>This week : <a href="javascript:display_details('books_due_week');" ><?php echo $op2; ?></a></p>
            </div>
            <!--div class="panel-footer"></div-->
        </div>
	</div>
	<div class="col-lg-6" style="padding-top:30px;">
		<div class="panel panel-primary">
            <div class="panel-heading">
                Membership Due
            </div>
            <div class="panel-body">
                <p>Today : <a href="javascript:display_details('members_due_today');" > <?php echo $op3; ?></a></p>
                <p>This week : <a href="javascript:display_details('members_due_week');" > <?php echo $op4; ?></a></p>
            </div>
            <!--div class="panel-footer"></div-->
        </div>
	</div>
</div>
<div class="row">
	<div class="col-lg-6" style="padding-top:30px;">
		<div class="panel panel-danger">
            <div class="panel-heading">
                Lapsed books
            </div>
            <div class="panel-body">
                <p><a href="javascript:display_details('books_lapsed_today');" ><?php echo $op5; ?></a> book(s) as on today</p>
            </div>
            <!--div class="panel-footer"></div-->
        </div>
	</div>
	<div class="col-lg-6" style="padding-top:30px;">
		<div class="panel panel-danger">
            <div class="panel-heading">
                Lapsed Membership 
            </div>
            <div class="panel-body">
                <p><a href="javascript:display_details('members_lapsed_today');" ><?php echo $op6; ?> </a> member(s) as on today</p>
            </div>
            <!--div class="panel-footer"></div-->
        </div>
	</div>
</div>

<!-- Add member modal -->
<div class="modal fade" id="dashboard_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="modal_title_h2"> Details</h2>
      </div>
      <div class="modal-body" id="div_dashboarddetails">
        
      </div>
      <div class="clearfix"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php
include('footer_js.php');
?>
<script type="text/javascript">
$(document).ready(function(){
    $('#li_dashboard').addClass('active-link');
});

function display_details(detail_type){
    $('#div_dashboarddetails').html('');
    $.ajax({
        type: "POST",
        url: "services/dashboard_services.php", // 
        data: "detail_type="+detail_type+"&action="+detail_type, 
        success: function(result){
            $('#div_dashboarddetails').html(result);
            $('#dashboard_modal').modal('show');
        }
    });
}
</script>
<?php
include('footer.php');
?>