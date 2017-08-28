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
    case 'lend_book':
        $finaloutput = lend_book();
    break;
    case 'book_available':
        $finaloutput = book_available();
    break;
    case 'update_bookrate':
        $finaloutput = update_bookrate();
    break;
    default:
        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
}

echo json_encode($finaloutput);

function lend_book(){
	global $dbc;
	$total_amount = mysqli_real_escape_string($dbc, trim($_POST["total_amount"]));
	$member_credit = mysqli_real_escape_string($dbc, trim($_POST["member_credit"]));
	$advance_amount = mysqli_real_escape_string($dbc, trim($_POST["advance_amount"]));
	$balance_amount = mysqli_real_escape_string($dbc, trim($_POST["balance_amount"]));
	$balance_given = mysqli_real_escape_string($dbc, trim($_POST["balance_given"]));
	$member_id = mysqli_real_escape_string($dbc, trim($_POST["selected_member_id"]));
	
	$current_member_credit = $balance_amount - $balance_given;
	$query = "INSERT INTO lend_book (member_id, total_amount, advance_paid, balance_amount, balance_given) VALUES ('$member_id', '$total_amount', '$advance_amount', '$balance_amount', '$balance_given')";
	if(mysqli_query($dbc, $query)){
		$lb_id = mysqli_insert_id($dbc); $errcount = 0;
		foreach ($_POST['book_key'] as $key => $value) {
			$bookid = $_POST['bookid_'.$value];
			$booklang = $_POST['booklang_'.$value];
			$bookcat = $_POST['bookcat_'.$value];
			$bookrate = $_POST['bookrate_'.$value];
			$lendingrate = $_POST['lendingrate_'.$value];
			$lendingdate = $_POST['lendingdate_'.$value];
			$duedate = $_POST['duedate_'.$value];
			$remarks = $_POST['remarks_'.$value];
			$status = 'lend';
			$lb_query = "INSERT INTO lend_booklist (lendbook_id, member_id, book_id, book_language, book_category, book_rate, lending_rate, lending_date, due_date, remarks, status)
			VALUES ($lb_id, $member_id, $bookid, '$booklang', '$bookcat', $bookrate, $lendingrate, '$lendingdate', '$duedate', '$remarks', '$status')";
			if(!mysqli_query($dbc, $lb_query)){
				$errcount++;
				file_put_contents('lendbookerr.log',"\nError while lending booklist : $lb_id , bookid & lang : $bookid , $booklang", FILE_APPEND | LOCK_EX);
			}
		}
		if($errcount){
			$output = array("infocode" => "LENDBOOKLISTFAILED", "message" => "Lend booklist process failed!");
		}else{
			$mq = "UPDATE members SET member_credit = $current_member_credit WHERE member_id = $member_id";
			if(mysqli_query($dbc, $mq)){
				$output = array("infocode" => "LENDBOOKSUCCESS", "message" => "Lend Book success");
			}else{
				$output = array("infocode" => "LENDBOOKPARTIAL", "message" => "Lend Book success, Member credit update failed");
				file_put_contents('lendbookerr.log',"\nError while updating member credit of amount : $current_member_credit for member id: $member_id", FILE_APPEND | LOCK_EX);
			}
		}
	}else{
		$output = array("infocode" => "LENDBOOKFAILED", "message" => "Lend book process failed!");
	}
	
	return $output;
}

function book_available(){
	global $dbc;
	$book_id = mysqli_real_escape_string($dbc, trim($_POST["book_id"]));
	$book_language = mysqli_real_escape_string($dbc, trim($_POST["book_language"]));
	
	$query = "SELECT * FROM lend_booklist WHERE book_id = $book_id AND book_language = '$book_language'";
	$result = mysqli_query($dbc, $query);
	if(mysqli_num_rows($result)>0){
		$output = array("infocode" => "BOOKTAKEN", "message" => "This book is already taken by another member");
	}else{
		$output = array("infocode" => "BOOKAVAILABLE", "message" => "This book is available for lending");
	}
	
	return $output;
}

function update_bookrate(){
	global $dbc;
	$book_id = mysqli_real_escape_string($dbc, trim($_POST["book_id"]));
	$book_language = mysqli_real_escape_string($dbc, trim($_POST["book_language"]));
	$book_rate = mysqli_real_escape_string($dbc, trim($_POST["book_rate"]));
	$tablename = $book_language.'_books';
	$query = "UPDATE $tablename SET book_rate = $book_rate WHERE book_id = $book_id";
	if(mysqli_query($dbc, $query)){
		$output = array("infocode" => "BOOKUPDATED", "message" => "Book rate updated");
	}else{
		$output = array("infocode" => "BOOKUPDATEFAILED", "message" => "Unable to update book rate");
	}
	
	return $output;
}
?>