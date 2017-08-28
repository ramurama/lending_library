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
    case 'books_due_today':
        $finaloutput = books_due_today();
    break;
    case 'books_due_week':
        $finaloutput = books_due_week();
    break;
    case 'members_due_today':
        $finaloutput = members_due_today();
    break;
    case 'members_due_week':
        $finaloutput = members_due_week();
    break;
    case 'books_lapsed_today':
        $finaloutput = books_lapsed_today();
    break;
    case 'members_lapsed_today':
        $finaloutput = members_lapsed_today();
    break;
    default:
        //$finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
    	$finaloutput = 'Invalid request';
}

echo $finaloutput;



function books_due_today(){
	global $dbc; $output = '';
	//$detail_type = mysqli_real_escape_string($dbc, trim($_POST["detail_type"]));

	//$q1 = "SELECT a.*,b.member_name, c.book_name FROM lend_booklist a, members b, english_books c WHERE a.due_date = CURDATE() AND a.member_id = b.member_id AND a.book_id = c.book_id AND a.book_language = 'english'";
	$query = "(SELECT a.*,b.member_name, c.book_name FROM lend_booklist a, members b, english_books c WHERE a.due_date = CURDATE() AND a.member_id = b.member_id AND a.book_id = c.book_id AND a.book_language = 'english')
			UNION (SELECT a.*,b.member_name, c.book_name FROM lend_booklist a, members b, tamil_books c WHERE a.due_date = CURDATE() AND a.member_id = b.member_id AND a.book_id = c.book_id AND a.book_language = 'tamil')";
	$result = mysqli_query($dbc, $query);
	if(mysqli_num_rows($result)>0){
		$output = '<table class="table table-bordered"><tr><th>Book Name</th><th>Taken By</th></tr>';
		while($row = mysqli_fetch_assoc($result)){
			$output .= '<tr><td>'.$row['book_name'].'</td><td>'.$row['member_name'].'</td></tr>';
	    }
	}else{
		$output = "No books pending today!";
	}
	return $output;
}

function books_due_week(){
	global $dbc; $output = '';
	//$detail_type = mysqli_real_escape_string($dbc, trim($_POST["detail_type"]));

	//$q1 = "SELECT a.*,b.member_name, c.book_name FROM lend_booklist a, members b, english_books c WHERE a.due_date = CURDATE() AND a.member_id = b.member_id AND a.book_id = c.book_id AND a.book_language = 'english'";
	$query = "(SELECT a.*,b.member_name, c.book_name FROM lend_booklist a, members b, english_books c WHERE a.due_date >= CURDATE() AND a.due_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) AND a.member_id = b.member_id AND a.book_id = c.book_id AND a.book_language = 'english')
			UNION (SELECT a.*,b.member_name, c.book_name FROM lend_booklist a, members b, tamil_books c WHERE a.due_date >= CURDATE() AND a.due_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) AND a.member_id = b.member_id AND a.book_id = c.book_id AND a.book_language = 'tamil')";
	$result = mysqli_query($dbc, $query);
	if(mysqli_num_rows($result)>0){
		$output = '<table class="table table-bordered"><tr><th>Book Name</th><th>Taken By</th><th>Due date</th></tr>';
		while($row = mysqli_fetch_assoc($result)){
			$output .= '<tr><td>'.$row['book_name'].'</td><td>'.$row['member_name'].'</td><td>'.$row['due_date'].'</td></tr>';
	    }
	}else{
		$output = "No books pending this week!";
	}
	return $output;
}

function members_due_today(){
	global $dbc; $output = '';
	//$detail_type = mysqli_real_escape_string($dbc, trim($_POST["detail_type"]));
	$query = "SELECT * FROM members WHERE renewal_date = CURDATE()";
	$result = mysqli_query($dbc, $query);
	if(mysqli_num_rows($result)>0){
		$output = '<table class="table table-bordered"><tr><th>Member Name</th><th>Renewal Date</th></tr>';
		while($row = mysqli_fetch_assoc($result)){
			$output .= '<tr><td>'.$row['member_name'].'</td><td>'.$row['renewal_date'].'</td></tr>';
	    }
	}else{
		$output = "No member renewal pending today!";
	}
	return $output;
}

function members_due_week(){
	global $dbc; $output = '';
	//$detail_type = mysqli_real_escape_string($dbc, trim($_POST["detail_type"]));
	$query = "SELECT * FROM members WHERE renewal_date >= CURDATE() AND renewal_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
	$result = mysqli_query($dbc, $query);
	if(mysqli_num_rows($result)>0){
		$output = '<table class="table table-bordered"><tr><th>Member Name</th><th>Renewal Date</th></tr>';
		while($row = mysqli_fetch_assoc($result)){
			$output .= '<tr><td>'.$row['member_name'].'</td><td>'.$row['renewal_date'].'</td></tr>';
	    }
	}else{
		$output = "No member renewal pending today!";
	}
	return $output;
}

function books_lapsed_today(){
	global $dbc; $output = '';
	//$detail_type = mysqli_real_escape_string($dbc, trim($_POST["detail_type"]));

	//$q1 = "SELECT a.*,b.member_name, c.book_name FROM lend_booklist a, members b, english_books c WHERE a.due_date = CURDATE() AND a.member_id = b.member_id AND a.book_id = c.book_id AND a.book_language = 'english'";
	$query = "(SELECT a.*,b.member_name, c.book_name FROM lend_booklist a, members b, english_books c WHERE a.due_date <= CURDATE() AND a.member_id = b.member_id AND a.book_id = c.book_id AND a.book_language = 'english')
			UNION (SELECT a.*,b.member_name, c.book_name FROM lend_booklist a, members b, tamil_books c WHERE a.due_date <= CURDATE() AND a.member_id = b.member_id AND a.book_id = c.book_id AND a.book_language = 'tamil')";
	$result = mysqli_query($dbc, $query);
	if(mysqli_num_rows($result)>0){
		$output = '<table class="table table-bordered"><tr><th>Book Name</th><th>Taken By</th><th>Due date</th></tr>';
		while($row = mysqli_fetch_assoc($result)){
			$output .= '<tr><td>'.$row['book_name'].'</td><td>'.$row['member_name'].'</td><td>'.$row['due_date'].'</td></tr>';
	    }
	}else{
		$output = "No books pending this week!";
	}
	return $output;
}

function members_lapsed_today(){
	global $dbc; $output = '';
	//$detail_type = mysqli_real_escape_string($dbc, trim($_POST["detail_type"]));
	$query = "SELECT * FROM members WHERE renewal_date <= CURDATE()";
	$result = mysqli_query($dbc, $query);
	if(mysqli_num_rows($result)>0){
		$output = '<table class="table table-bordered"><tr><th>Member Name</th><th>Renewal Date</th></tr>';
		while($row = mysqli_fetch_assoc($result)){
			$output .= '<tr><td>'.$row['member_name'].'</td><td>'.$row['renewal_date'].'</td></tr>';
	    }
	}else{
		$output = "No member renewal pending today!";
	}
	return $output;
}

?>