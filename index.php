<?php 
include('header.php'); ?>
<div class="row">
	<div class="col-lg-6" style="padding-top:30px;">
		<div class="panel panel-primary">
            <div class="panel-heading">
                Books Due
            </div>
            <div class="panel-body">
                <p>Today : 2</p>
                <p>This week : 14</p>
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
                <p>Today : 0</p>
                <p>This week : 1</p>
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
                <p>4 book(s) as on today</p>
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
                <p>1 member(s) as on today</p>
            </div>
            <!--div class="panel-footer"></div-->
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
</script>
<?php
include('footer.php');
?>