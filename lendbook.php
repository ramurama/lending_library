<?php 
include('header.php'); ?>

<style>
.autoselect_container {  width:300px; height: 100px; overflow-y: scroll; }
/*.textbox{ width:100%; height:25px; padding:2px;}*/
</style>
<div class="row">
	<div class="col-lg-4" style="padding-top:30px;">    
        <input type="text" name="search_member" id="search_member" class="form-control" style="display:inline;" placeholder="Search Member" onkeyup="member_search();">
        <div id="autoselect_member"></div>
	</div>
    <div class="col-lg-4" style="padding-top:30px;">
        <input type="text" name="search_book" id="search_book" class="form-control" style="display:inline;" placeholder="Search Book" onkeyup="book_search();">
        <div id="autoselect_book"></div>
    </div>
	<div class="col-lg-12" style="padding-top:30px;">
        <form id="lendbook_form" action="" onsubmit="return false;" method="POST">
		<div class="panel panel-primary">
            <div class="panel-heading">
                Lend Book
            </div>
            <div class="panel-body">
                <div class="col-lg-6">
                    <span id="member_name_span"></span>
                </div>
                <div class="col-lg-6"></div><div class="clearfix"></div>
                <div class="" style="display:table;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Book ID</th><th>Book Name</th><th>Author Name</th><th>Rate</th><th>Lending Rate</th><th>Lending Date</th><th>Due Date</th><th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_selectedbooks">
                        <tr><td colspan="8"> Please select books to be Lent</td></tr>
                    </tbody>
                </table>
            </div>
            <!--div class="panel-footer"></div-->
        </div>
        <div id="customer_info">
            <div class="col-lg-4" style="padding-top:30px;">    
                <label> Total Amount : </label><input type="text" name="total_amount" id="total_amount" class="form-control">
            </div>
            <div class="col-lg-4" style="padding-top:30px;">    
                <label> Member Credit : </label><input type="text" name="member_credit" id="member_credit" class="form-control" value="0">
            </div>
            <div class="col-lg-4" style="padding-top:30px;">    
                <label> Advance Paid : </label><input type="text" name="advance_amount" id="advance_amount" class="form-control" onkeyup="calcBalance();" value="0">
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
                <input type="hidden" name="action" id="action" value="lend_book" />
                <button type="button" class="btn btn-primary" style="display:block;" onclick="lend_book_process();">Lend Book</button>
            </div>
        </div>
        </form>
	</div>
</div>

<?php
include('footer_js.php');
?>
<script type="text/javascript" src="assets/js/config.js"></script>
<script type="text/javascript" src="assets/js/lendbook.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#li_lendbook').addClass('active-link');
});
</script>
<?php
include('footer.php');
?>