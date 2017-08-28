<?php
  include('header.php');
?>

<style>
/*.autoselect_container {  width:300px; height: 100px; overflow-y: scroll; }*/
/*.textbox{ width:100%; height:25px; padding:2px;}*/
</style>
<div>
  <!-- <input type="text" name="search_member" id="search_member" class="form-control" style="display:inline;" placeholder="Enter Member ID"> -->
  <div class="">
    <form class="" action="#" onsubmit="return false;" method="post">
      <div class="row">
        <div class="col-lg-4">
          <label for="report_type">Report Type:</label>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8">
          <input type="radio" name="report_type" value="1" checked="checked"> Overall monthly report &nbsp;
          <input type="radio" name="report_type" value="2"> Daily income &nbsp;
          <input type="radio" name="report_type" value="3"> Overall books &nbsp;
          <input type="radio" name="report_type" value="4"> Overall customers &nbsp;
          <input type="radio" id="custom_dates_radio" name="report_type" value="5"> Custom date <br />
        </div>
      </div>
      <p></p>
      <div class="row" id="date_fields">
        <div class="col-md-4">
          <label for="from_date">From Date:</label>
          <input type="text" name="from_date" id="from_date" class="form-control" style="display:inline;" placeholder="">
        </div>
        <div class="col-md-4">
          <label for="to_date">To Date:</label>
          <input type="text" name="to_date" id="to_date" class="form-control" style="display:inline;" placeholder="">
        </div>
      </div>
      <div class="row" id="book_category_select">
        <div class="col-lg-4">
          <label for="book_category">Book Category:</label>
          <select class="form-control" name="book_category" id="book_category">
            <option value="1">English - OLD</option>
            <option value="2">English - NEW</option>
            <option value="3">Englsh - MAGAZINE</option>
            <option value="4">English - ALL</option>
            <option value="5">Tamil - OLD</option>
            <option value="6">Tamil - NEW</option>
            <option value="7">Tamil - MAGAZINE</option>
            <option value="8">Tamil - ALL</option>
            <option value="9">All - OLD</option>
            <option value="10">All - NEW</option>
            <option value="11">All - MAGAZINE</option>
            <option value="12">ALL</option>
          </select>
        </div>
      </div>
      <p></p>
      <input type="button" name="generate_report_button" value="Generate Report" class="btn btn-primary" style="display:block;" onclick="generateReport()">
    </form>
  </div>

</div>

<?php
  include('footer_js.php');
?>

<script type="text/javascript" src="assets/plugins/moment/moment.js"></script>
<script type="text/javascript" src="assets/js/config.js"></script>
<script type="text/javascript" src="assets/js/reports.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
      $('#li_reports').addClass('active-link');

      showHideDateFields();
      showHideBookCategory();

      $("input[name='report_type']").change(function(){
        showHideDateFields();
        showHideBookCategory();
      });

      $('#from_date').datepicker({
        dateFormat: "yy-mm-dd",
        autoclose: true
      });
      $('#to_date').datepicker({
        autoclose: true,
        dateFormat: "yy-mm-dd"
      });
  });
</script>
<?php
  include('footer.php');
?>
