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
		$query="SELECT * FROM members WHERE member_name LIKE '%{$_POST['searchField']}%' LIMIT 10";	
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
		$query="(SELECT * FROM english_books WHERE book_name LIKE '%{$_POST['searchField']}%' LIMIT 5) 
				UNION (SELECT * FROM tamil_books WHERE book_name LIKE '%{$_POST['searchField']}%' LIMIT 5)";	
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

function customeridsession()
{
	global $dbc;
    $output = array();
	
	$customer_id=$_POST['customer_id'];
	$_SESSION['customer_id']=$customer_id;	
	
	$query="SELECT first_name,last_name FROM customer WHERE customer_id='".$_SESSION['customer_id']."'";
	$result=mysqli_query($dbc,$query);
	$row=mysqli_fetch_assoc($result);
	
	$_SESSION['firstname'] = $row['first_name']." ".$row['last_name'];	
	
	$output=array('infocode'=>'SETTED');	
	
	return $output;
}

