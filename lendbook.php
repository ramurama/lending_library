<?php 
include('header.php'); ?>

<style>
.autoselect_container {  width:300px; height: 100px; overflow-y: scroll; }
/*.textbox{ width:100%; height:25px; padding:2px;}*/
</style>
<div class="row">
	<div class="col-lg-4" style="padding-top:30px;">
        <input type="text" name="search_book" id="search_book" class="form-control" style="display:inline;" placeholder="Search Book" onkeyup="book_search();">
		<div id="autoselect_book"></div>
    </div>
    <div class="col-lg-4" style="padding-top:30px;">    
        <input type="text" name="search_member" id="search_member" class="form-control" style="display:inline;" placeholder="Search Member" onkeyup="member_search();">
        <div id="autoselect_member"></div>
	</div>
	<div class="col-lg-12" style="padding-top:30px;">
		<div class="panel panel-primary">
            <div class="panel-heading">
                Lend Book
            </div>
            <div class="panel-body">
                <div class="col-lg-6">
                    <span id="member_name_span"></span>
                </div>
                <div class="" style="display:table;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Book ID</th><th>Book Name</th><th>Author Name</th><th>Rate</th><th>Lending Rate</th><th>Lending Date</th><th>Due Date</th><th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_selectedbooks">
                        <!--tr>
                            <td>1</td><td>Ponniyin Selvan</td><td>Kalki</td><td>123</td><td>TA001</td><td><button type="button" class="btn btn-warning"><i class="fa fa-edit"></i></button> <button type="button" class="btn btn-danger"><i class="fa fa-close"></i></button></td>
                        </tr>
                        <tr>
                            <td>2</td><td>Penne Nee Vazhga</td><td>Prema Subramanian</td><td>392</td><td>TA023</td><td><button type="button" class="btn btn-warning"><i class="fa fa-edit"></i></button> <button type="button" class="btn btn-danger"><i class="fa fa-close"></i></button></td>
                        </tr-->
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
            <!--div class="col-lg-4" style="padding-top:30px;">    
                <label> Carry Forward Balance : </label><input type="text" name="carry_forward" id="carry_forward" class="form-control">
            </div-->
            <div class="col-lg-4" style="padding-top:30px;">    
                <label> Advance Paid : </label><input type="text" name="advance_amount" id="advance_amount" class="form-control" onkeyup="calcBalance();">
            </div>
            <div class="col-lg-4" style="padding-top:30px;">    
                <label> Balance to be Paid : </label><input type="text" name="balance_amount" id="balance_amount" class="form-control">
            </div>
            <div class=" col-lg-4" style="padding-top:30px;">
                <label> Balance given : </label><input type="text" name="balance_given" id="balance_given" class="form-control">
            </div>
            <div class=" col-lg-4" style="padding-top:30px;"> </div>  
            <div class=" col-lg-4" style="padding-top:30px;">   
                <label>&nbsp;</label> 
                <button type="button" class="btn btn-primary" style="display:block;">Lend Book</button>
            </div>
        </div>
	</div>
</div>

<!-- Add member modal -->
<div class="modal fade" id="addmember_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel"> Add New Book</h2>
      </div>
      <div class="modal-body" id="div_jobdetails">
        <form>
            <div class="form-group col-lg-6">
                <label>Book name </label>
                <input type="text" class="form-control"/>
            </div>
            <div class="form-group col-lg-6">
                <label>Author Name </label>
                <input type="text" class="form-control"/>
            </div>
            <div class="form-group col-lg-6">
                <label>Language</label>
                <select class="form-control">
                    <option>Tamil</option>
                    <option>English</option>
                <select>
            </div>
            <div class="form-group col-lg-6">
                <label>Book Category </label>
                <select class="form-control">
                    <option>New</option>
                    <option>Old</option>
                <select>
            </div>
            <div class="form-group col-lg-6">
                <label>Rate</label>
                <input type="text" class="form-control"/>
            </div>
            <div class="form-group col-lg-6">
                <label>Old Number </label>
                <input type="text" class="form-control"/>
            </div>
        </form>
      </div>
      <div class="clearfix"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success">Add Book</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php
include('footer_js.php');
?>
<script type="text/javascript" src="assets/js/lendbook.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#li_lendbook').addClass('active-link');
});
</script>
<?php
include('footer.php');
?>