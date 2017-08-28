<?php
session_start();
include ('../dbconfig.php');
$finaloutput = array();
$action = $_POST['action'];

switch($action){
	case 'customeridsession':
        $finaloutput = customeridsession();
    break;
    case 'search_member':
		$finaloutput=search_member();
	break;	
	case 'search_book':
		$finaloutput=search_book();
	break;	
	default:
    	$finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");	
}
echo json_encode($finaloutput);

function search_member()
{
	global $dbc;
	$output=array();
	
	$searchField=$_POST['searchField'];
	if($searchField==''){
		$output=array('infocode' => "NODATAFOUND");	
	} else {
		$memberName = mysqli_real_escape_string($dbc, trim($_POST["searchField"]));
		$memberId = intval($memberName);
		$query = "SELECT * FROM members WHERE member_name  LIKE '%{$memberName}%' OR member_id LIKE '%{$memberId}%' LIMIT 10";
		//$query="SELECT * FROM members WHERE member_id LIKE '%{$_POST['searchField']}%' LIMIT 10";	
		$result=mysqli_query($dbc,$query);
		if(mysqli_num_rows($result)>0)
		{
			$out = array();
			while($row=mysqli_fetch_assoc($result)){
				$out[] = $row;
			}
			$output=array('infocode' => "SEARCHED",'data'=>$out);					
		}
		else
		{			
			$output=array('infocode' => "NODATAFOUND");				
		}
	}
	return $output;
}


function search_book()
{
	global $dbc;
	$output=array();
	
	$searchField=$_POST['searchField'];
	if($searchField==''){
		$output=array('infocode' => "NODATAFOUND");	
	} else {
		$input_data = mysqli_real_escape_string($dbc, trim($_POST["searchField"]));
		$query="(SELECT * FROM english_books WHERE book_id LIKE '%{$input_data}%' OR book_name LIKE '%{$input_data}%' OR old_number LIKE '%{$input_data}%' LIMIT 5) 
				UNION (SELECT * FROM tamil_books WHERE book_id LIKE '%{$input_data}%' OR book_name LIKE '%{$input_data}%' OR old_number LIKE '%{$input_data}%' LIMIT 5)";	
		$result=mysqli_query($dbc,$query);
		if(mysqli_num_rows($result)>0)
		{
			$out = array();
			while($row=mysqli_fetch_assoc($result)){
				$out[] = $row;
			}
			$output=array('infocode' => "SEARCHED",'data'=>$out);					
		}
		else
		{			
			$output=array('infocode' => "NODATAFOUND");				
		}
	}
	return $output;
}


