<?php 
include('header.php');
include('dbconfig.php'); 
$query = "(SELECT * FROM tamil_books ORDER BY book_id DESC LIMIT 5) UNION (SELECT * FROM english_books ORDER BY book_id DESC LIMIT 5)";
$result = mysqli_query($dbc,$query);
if(mysqli_num_rows($result) > 0) {
  $booksData = array();
  while ($row = mysqli_fetch_array($result)) {
   $booksData[] = array (
     'book_name'=>$row['book_name'],
     'author_name' => $row['author_name'],
     'old_number'=> $row['old_number'],
     'language' => $row['book_language'],
     'book_id' => $row['book_id']
     );
 }
}
?>
<div class="row">
	<div class="col-lg-8" style="padding-top:30px;">
        <button class="btn btn-success" data-toggle="modal" data-target="#addbook_modal">Add New Book</button>
        <input type="text" id="search_book_name" class="form-control" style="width:50%;display:inline;">
		<button class="btn btn-primary" onclick="searchBook()">Search</button>
	</div>
	<div class="col-lg-12" style="padding-top:30px;">
		<div class="panel panel-primary">
            <div class="panel-heading" id="books_table_title">
                Recently Added Books
            </div>
            <div class="panel-body">
                <div class="responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>S.No</th><th>Book Name</th><th>Author Name</th><th>Book's Old Number</th><th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="books_table">
                    <?php
                        $count = 1; 
                        foreach ($booksData as $value){
                            echo '<tr>';
                            echo '<td>' . $count++ . '</td>';
                            echo '<td>' . $value['book_name'] . '</td>';
                            echo '<td>' . $value['author_name'] . '</td>';
                            echo '<td>' . $value['old_number'] . '</td>';
                            echo '<td>' . '<button type="button" onclick="viewBook(\''. $value['book_id'] .'\',\''. $value['language'] .'\')" class="btn btn-warning"><i class="fa fa-edit"></i></button> <button type="button" onclick="deleteBook(\''. $value['book_id'] .'\',\''. $value['language'] .'\')" class="btn btn-danger"><i class="fa fa-close"></i></button>' . '</td>';
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

<!-- Add book modal -->
<div class="modal fade" id="addbook_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel"> Add New Book</h2>
      </div>
      <div class="modal-body" id="div_addbook">
        <form name="book_form" id="book_form" method="post" action="" onsubmit="return false;">
            <div class="form-group col-lg-6">
                <label>Book name </label>
                <input type="text" class="form-control required" name="book_name" id="book_name" />
            </div>
            <div class="form-group col-lg-6">
                <label>Author Name </label>
                <input type="text" class="form-control required" name="author_name" id="author_name" />
            </div>
            <div class="form-group col-lg-6">
                <label>Language</label>
                <select class="form-control required" name="language" id="language" >
                    <option value="tamil">Tamil</option>
                    <option value="english">English</option>
                <select>
            </div>
            <div class="form-group col-lg-6">
                <label>Book Category </label>
                <select class="form-control required" name="category" id="category">
                    <option value="new">New</option>
                    <option value="old">Old</option>
                <select>
            </div>
            <div class="form-group col-lg-6">
                <label>Rate</label>
                <input type="text" class="form-control required" name="rate" id="rate" />
            </div>
            <div class="form-group col-lg-6">
                <label>Old Number </label>
                <input type="text" class="form-control" name="old_number" id="old_number" />
            </div>
            <div class="form-group col-lg-6">
                <label>Multiple </label><br />
                <input type="radio" name="is_multicopy" id="is_multicopy_yes" class="flat-red tadio-inline" value="yes" > Yes&nbsp;&nbsp;
                <input type="radio" name="is_multicopy" id="is_multicopy_no" class="flat-red tadio-inline" value="no"  checked="checked"> No
            </div>
        </form>
      </div>
      <div class="clearfix"></div>
      <div class="modal-footer">
        <button type="submit" onclick="addBook()" class="btn btn-success">Add Book</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit book modal -->
<div class="modal fade" id="editbook_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel"> Edit Book</h2>
      </div>
      <div class="modal-body" id="div_editbook">
        <form name="edit_book_form" id="edit_book_form" method="post" action="" onsubmit="return false;">
            <input type="hidden" id="edit_book_id" />
            <div class="form-group col-lg-6">
                <label>Book name </label>
                <input type="text" class="form-control required" name="edit_book_name" id="edit_book_name" />
            </div>
            <div class="form-group col-lg-6">
                <label>Author Name </label>
                <input type="text" class="form-control required" name="edit_author_name" id="edit_author_name" />
            </div>
            <div class="form-group col-lg-6">
                <label>Language</label>
                <select class="form-control required" name="edit_language" id="edit_language">
                    <option value="tamil">Tamil</option>
                    <option value="english">English</option>
                <select>
            </div>
            <div class="form-group col-lg-6">
                <label>Book Category </label>
                <select class="form-control required" name="edit_category" id="edit_category">
                    <option value="new">New</option>
                    <option value="old">Old</option>
                <select>
            </div>
            <div class="form-group col-lg-6">
                <label>Rate</label>
                <input type="text" class="form-control required" name="edit_rate" id="edit_rate" />
            </div>
            <div class="form-group col-lg-6">
                <label>Old Number </label>
                <input type="text" class="form-control required" name="edit_old_number" id="edit_old_number" />
            </div>
            <div class="form-group col-lg-6">
                <label>Multiple </label><br />
                <input type="radio" name="edit_is_multicopy" id="edit_is_multicopy_yes" class="flat-red tadio-inline" value="yes"> Yes&nbsp;&nbsp;
                <input type="radio" name="edit_is_multicopy" id="edit_is_multicopy_no" class="flat-red tadio-inline" value="no"> No
            </div>
        </form>
      </div>
      <div class="clearfix"></div>
      <div class="modal-footer">
        <button type="submit" onclick="updateBook()" class="btn btn-success">Save Book</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php
include('footer_js.php');
?>
<script type="text/javascript" src="assets/js/books.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#li_books').addClass('active-link');
});
$(document).ready(function(){
    $("#book_form").validate();
    $("#edit_book_form").validate();
});
</script>
<?php
include('footer.php');
?>