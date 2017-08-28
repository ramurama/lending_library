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
    case 'return_book':
        $finaloutput = return_book();
    break;
    case 'search_member_book':
        $finaloutput = search_member_book();
    break;
    
    default:
        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
}

echo json_encode($finaloutput);

function return_book(){
	global $dbc;
	$total_amount = mysqli_real_escape_string($dbc, trim($_POST["total_amount"]));
	$member_credit = mysqli_real_escape_string($dbc, trim($_POST["member_credit"]));
	$advance_amount = mysqli_real_escape_string($dbc, trim($_POST["advance_amount"]));
	$balance_amount = mysqli_real_escape_string($dbc, trim($_POST["balance_amount"]));
	$balance_given = mysqli_real_escape_string($dbc, trim($_POST["balance_given"]));
	$member_id = mysqli_real_escape_string($dbc, trim($_POST["selected_member_id"]));
	
	$current_member_credit = $balance_amount - $balance_given;
	//$query = "INSERT INTO lend_book (member_id, total_amount, advance_paid, balance_amount, balance_given) VALUES ('$member_id', '$total_amount', '$advance_amount', '$balance_amount', '$balance_given')";
	if(isset($_POST['check_return'])){
		$errcount = 0;
		foreach ($_POST['check_return'] as $key => $value) {
			$bookid = $_POST['bookid_'.$value];
			$booklang = $_POST['booklang_'.$value];
			$bookcat = $_POST['bookcat_'.$value];
			$bookrate = $_POST['bookrate_'.$value];
			$lendingrate = $_POST['lendingrate_'.$value];
			$lendingdate = $_POST['lendingdate_'.$value];
			$duedate = $_POST['duedate_'.$value];
			$returndate = $_POST['returndate_'.$value];
			$penaltyperday = $_POST['penaltyperday_'.$value];
			$totalpenalty = $_POST['totalpenalty_'.$value];
			$totalearned = $lendingrate + $totalpenalty;
			$remarks = $_POST['remarks_'.$value];
			$status = 'returned';
			$lb_query = "INSERT INTO booklist_history (member_id, book_id, book_language, book_category, book_rate, lending_rate, lending_date, due_date, return_date, penalty_perday, total_penalty, total_earned, remarks, status)
			VALUES ($member_id, $bookid, '$booklang', '$bookcat', $bookrate, $lendingrate, '$lendingdate', '$duedate', '$returndate', '$penaltyperday','$totalpenalty','$totalearned', '$remarks', '$status')";
			if(!mysqli_query($dbc, $lb_query)){
				$errcount++;
				file_put_contents('returnbookerr.log',"\nError while returning booklist, bookid & lang : $bookid , $booklang, for member : $member_id", FILE_APPEND | LOCK_EX);
			}
		}
		if($errcount){
			$output = array("infocode" => "RETURNBOOKLISTFAILED", "message" => "Return booklist process failed!");
		}else{
			$mq = "UPDATE members SET member_credit = $current_member_credit WHERE member_id = $member_id";
			if(mysqli_query($dbc, $mq)){
				$lbl_id = implode(',',$_POST['check_return']);
				$dq ="DELETE FROM lend_booklist WHERE lend_booklist_id IN ($lbl_id)";
				if(mysqli_query($dbc, $dq)){
					$output = array("infocode" => "RETURNBOOKSUCCESS", "message" => "Return Book success");
				}else{
					$output = array("infocode" => "RETURNBOOKPARTIAL", "message" => "Return Book success, unable to update entry data");
					file_put_contents('returnbookerr.log',"\nError while deleting lend booklist data for ids : $lbl_id", FILE_APPEND | LOCK_EX);
				}
			}else{
				$output = array("infocode" => "RETURNBOOKPARTIAL", "message" => "Return Book success, Member credit update failed");
				file_put_contents('returnbookerr.log',"\nError while updating member credit of amount : $current_member_credit for member id: $member_id", FILE_APPEND | LOCK_EX);
			}
		}
	}else{
	 	$output = array("infocode" => "NOBOOKSELECTED", "message" => "No books selected for returning!");
	}
	
	return $output;
}

function search_member_book()
{
	global $dbc;
	$output=array();
	
	$searchField=$_POST['searchField'];
	if($searchField==''){
		$output=array('infocode' => "NODATAFOUND");	
	} else {
		$query="SELECT * FROM lend_booklist WHERE member_id = {$_POST['searchField']}";	
		$result=mysqli_query($dbc,$query);
		if(mysqli_num_rows($result)>0)
		{
			$out = array();
			$c=0;
			while($row=mysqli_fetch_assoc($result)){
				$out[$c] = $row;
				$language = $row['book_language'];
				if($language == 'tamil'){
					$table_name = 'tamil_books';
				} else if($language == 'english'){
					$table_name = 'english_books';
				}
				$bq = "SELECT * FROM $table_name WHERE book_id = {$row['book_id']}";
				$bresult = mysqli_query($dbc, $bq);
				if(mysqli_num_rows($bresult)>0){
					$br = mysqli_fetch_assoc($bresult);
					$out[$c]['book_name'] = $br['book_name'];
					$out[$c]['author_name'] = $br['author_name'];
				}
				$c++;
			}
			//member data
			$query1="SELECT * FROM members WHERE member_id = {$_POST['searchField']}";	
			$result1=mysqli_query($dbc,$query1);
			if(mysqli_num_rows($result1)>0){
				$row1=mysqli_fetch_assoc($result1);
			}
			$output=array('infocode' => "SEARCHED",'data'=>$out, 'member_data'=>$row1);					
		}
		else
		{			
			$output=array('infocode' => "NODATAFOUND");				
		}
	}
	return $output;
}

?>