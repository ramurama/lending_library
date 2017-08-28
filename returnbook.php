<?php
include('header.php'); ?>

<style>
/*.autoselect_container {  width:300px; height: 100px; overflow-y: scroll; }*/
/*.textbox{ width:100%; height:25px; padding:2px;}*/
</style>
<div class="row">
	<!--div class="col-lg-4" style="padding-top:30px;">
        <input type="text" name="search_book" id="search_book" class="form-control" style="display:inline;" placeholder="Search Book" onkeyup="book_search();">
		<div id="autoselect_book"></div>
    </div-->
    <div class="col-lg-4" style="padding-top:30px;">
        <input type="text" name="search_member" id="search_member" class="form-control" style="display:inline;" placeholder="Enter Member ID">
        <!--div id="autoselect_member"></div-->
	</div>
    <div class="col-lg-4" style="padding-top:30px;">
        <button type="button" class="btn btn-primary" style="display:block;" onclick="member_search_book();">Search Member Data</button>
        <div id="autoselect_member"></div>
    </div>
	<div class="col-lg-12" style="padding-top:30px;">
        <form id="returnbook_form" action="" onsubmit="return false;" method="POST">
		<div class="panel panel-primary">
            <div class="panel-heading">
                Return Book
            </div>
            <div class="panel-body">
                <div class="col-lg-6">
                    <span id="member_name_span"></span>
                </div>
                <div class="col-lg-6"></div>
                <div class="" style="display:table;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Book Details</th><th>Lending Rate</th><th>Lending Date</th><th>Due Date</th><th>Return Date</th><th>Penalty per day</th><th>Total Penalty</th><th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_selectedbooks">
                        <tr><td colspan="8"> Please select member to get the Lent book list</td></tr>
                    </tbody>
                </table>
            </div>
            <!--div class="panel-footer"></div-->
        </div>
        <div id="customer_info">
            <div class="col-lg-4" style="padding-top:30px;">
                <label> Amount to pay : </label><input type="text" name="total_amount" id="total_amount" class="form-control">
            </div>
            <div class="col-lg-4" style="padding-top:30px;">
                <label> Member Credit : </label><input type="text" name="member_credit" id="member_credit" class="form-control" value="0">
            </div>
            <div class="col-lg-4" style="padding-top:30px;">
                <label> Amount Paid : </label><input type="text" name="advance_amount" id="advance_amount" class="form-control" onkeyup="calcBalance();" value="0">
            </div>
            <div class="col-lg-4" style="padding-top:30px;">
                <label> Balance to be Paid : </label><input type="text" name="balance_amount" id="balance_amount" class="form-control">
            </div>
            <div class=" col-lg-4" style="padding-top:30px;">
                <label> Balance given : </label><input type="text" name="balance_given" id="balance_given" class="form-control" value="0">
            </div>
            <!--div class=" col-lg-4" style="padding-top:30px;"> </div-->
            <div class=" col-lg-4" style="padding-top:30px;">
                <label>&nbsp;</label>
                <input type="hidden" name="selected_member_id" id="selected_member_id" />
                <input type="hidden" name="action" id="action" value="return_book" />
                <button type="button" class="btn btn-primary" style="display:block;" onclick="return_book_process();">Return Book</button>
            </div>
        </div>
        </form>
	</div>
</div>

<?php
include('footer_js.php');
?>
<script type="text/javascript" src="assets/plugins/moment/moment.js"></script>
<script type="text/javascript" src="assets/js/config.js"></script>
<script type="text/javascript" src="assets/js/returnbook.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#li_returnbook').addClass('active-link');
});
</script>
<?php
include('footer.php');
?>
