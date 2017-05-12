<?php
include ('../dbconfig.php'); 
$finaloutput = array();
if(!$_POST) {
	$action = $_GET['action'];
}
else {
	$action = $_POST['action'];
}
switch($action){
    case 'add_book':
        $finaloutput = addBookToDb();
        echo json_encode($finaloutput);
    break;
    case 'get_book_details':
    	$finaloutput = getBookDetailsFromDb();
    	echo json_encode($finaloutput);
    break;
    case 'update_book':
    	$finaloutput = updateBookInDb();
    	echo json_encode($finaloutput);
    break;
    case 'search_book':
    	$finaloutput = searchBooks();
    	echo $finaloutput;
    break;
    case 'delete_book':
    	$finaloutput = deleteBookInDb();
    	echo json_encode($finaloutput);
    break;
    default:
        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
}



function addBookToDb(){
	global $dbc;
	$table_name;
	$language = mysqli_real_escape_string($dbc, trim($_POST["language"]));
	if($language == 'tamil'){
		$table_name = 'tamil_books';
	} else if($language == 'english'){
		$table_name = 'english_books';
	}
	$bookName = mysqli_real_escape_string($dbc, trim($_POST["bookName"]));
	$authorName = mysqli_real_escape_string($dbc, trim($_POST["authorName"]));
	$category = mysqli_real_escape_string($dbc, trim($_POST["category"]));
	$rate = mysqli_real_escape_string($dbc, trim($_POST["rate"]));
	$oldNumber = mysqli_real_escape_string($dbc, trim($_POST["oldNumber"]));
	$isMultiple = mysqli_real_escape_string($dbc, trim($_POST["isMultiple"]));
	
	$query = "INSERT INTO $table_name (book_name, author_name, old_number, book_rate, is_multiple, book_category) VALUES ('$bookName', '$authorName', '$oldNumber', '$rate', '$isMultiple', '$category')";

	if(mysqli_query($dbc, $query)){
		$output = array("infocode" => "INSERTSUCCESS", "message" => "New book added successfully.");
	}else{
		$output = array("infocode" => "INSERTFAILURE", "message" => "New book not added!");
	}
	return $output;
}

function getBookDetailsFromDb(){
	global $dbc;
	$table_name;
	$language = mysqli_real_escape_string($dbc, trim($_POST["language"]));
	if($language == 'tamil'){
		$table_name = 'tamil_books';
	} else if($language == 'english'){
		$table_name = 'english_books';
	}
	$bookId = mysqli_real_escape_string($dbc, trim($_POST["bookId"]));

	$query = "SELECT * FROM $table_name WHERE book_id='$bookId'";
	$result = mysqli_query($dbc, $query);
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);
		$output = array("book_name" => $row['book_name'], "author_name" => $row['author_name'], "rate" => $row['book_rate'], "old_number" => $row['old_number'], "is_multiple" => $row['is_multiple'], "category" => $row['book_category']);
	}
	return $output;
}

function searchBooks(){
	global $dbc;
	$query = "(SELECT * FROM tamil_books WHERE book_name LIKE '%{$_POST['bookName']}%' ORDER BY book_id DESC LIMIT 5 ) UNION (SELECT * FROM english_books WHERE book_name LIKE '%{$_POST['bookName']}%' ORDER BY book_id DESC LIMIT 5)";
	$result = mysqli_query($dbc, $query);
	$output = '';
	if(mysqli_num_rows($result) > 0){
		$count = 1;
		while ($row = mysqli_fetch_array($result)){
			$output .= '<tr>' 
			. '<td>' . $count++ . '</td>'
			. '<td>' . $row['book_name'] . '</td>'
			. '<td>' . $row['author_name'] . '</td>'
			. '<td>' . $row['old_number'] . '</td>'
			.  '<td>' . '<button type="button" onclick="viewBook(\''. $row['book_id'] .'\',\''. $row['book_language'] .'\')" class="btn btn-warning"><i class="fa fa-edit"></i></button> <button type="button" onclick="deleteBook(\''. $row['book_id'] .'\',\''. $row['book_language'] .'\')" class="btn btn-danger"><i class="fa fa-close"></i></button>' . '</td>'
			. '</tr>';
		}	
	} else {
		$output .= "<tr>" 
		. "<td colspan='5'>No results found.</td>"
		. "</tr>";
	}
	return $output;
}

function updateBookInDb(){
	global $dbc;
	$table_name;
	$language = mysqli_real_escape_string($dbc, trim($_POST["language"]));
	if($language == 'tamil'){
		$table_name = 'tamil_books';
	} else if($language == 'english'){
		$table_name = 'english_books';
	}
	$bookId = mysqli_real_escape_string($dbc, trim($_POST["bookId"]));
	$bookName = mysqli_real_escape_string($dbc, trim($_POST["bookName"]));
	$authorName = mysqli_real_escape_string($dbc, trim($_POST["authorName"]));
	$category = mysqli_real_escape_string($dbc, trim($_POST["category"]));
	$rate = mysqli_real_escape_string($dbc, trim($_POST["rate"]));
	$oldNumber = mysqli_real_escape_string($dbc, trim($_POST["oldNumber"]));
	$isMultiple = mysqli_real_escape_string($dbc, trim($_POST["isMultiple"]));

	$query = "UPDATE $table_name SET book_name='$bookName', author_name='$authorName', book_category='$category', book_rate='$rate', old_number='$oldNumber', is_multiple='$isMultiple' WHERE book_id='$bookId'";

	if(mysqli_query($dbc, $query)){
		$output = array("infocode" => "UPDATESUCCESS", "message" => "Book updated successfully.");
	}else{
		$output = array("infocode" => "UPDATEFAILURE", "message" => "Book not updated!");
	}
	return $output;
}

function deleteBookInDb(){
	global $dbc;
	$table_name;
	$language = mysqli_real_escape_string($dbc, trim($_POST["language"]));
	if($language == 'tamil'){
		$table_name = 'tamil_books';
	} else if($language == 'english'){
		$table_name = 'english_books';
	}
	$bookId = mysqli_real_escape_string($dbc, trim($_POST["bookId"]));

	$query = "DELETE FROM $table_name WHERE book_id='$bookId'";

	if(mysqli_query($dbc, $query)){
		$output = array("infocode" => "DELETESUCCESS", "message" => "Book deleted successfully.");
	}else{
		$output = array("infocode" => "DELETEFAILURE", "message" => "Book not deleted!");
	}
	return $output;
}

?>