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
    case 'add_member':
        $finaloutput = addMemberToDb();
        echo json_encode($finaloutput);
    break;
    case 'get_member_details':
    	$finaloutput = getMemberDetailsFromDb();
        echo json_encode($finaloutput);
    break;
    case 'update_member':
    	$finaloutput = updateMemberInDb();
        echo json_encode($finaloutput);
    break;
    case 'search_member':
    	$finaloutput = searchMembers();
        echo ($finaloutput);
    break;
    case 'delete_member':
    	$finaloutput = deleteMemberInDb();
        echo json_encode($finaloutput);
    break;
    default:
        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
}



function addMemberToDb(){
	global $dbc;
	$memberName = mysqli_real_escape_string($dbc, trim($_POST["memberName"]));
	$phoneNumber = mysqli_real_escape_string($dbc, trim($_POST["phoneNumber"]));
	$address = mysqli_real_escape_string($dbc, trim($_POST["address"]));
	$depositAmount = mysqli_real_escape_string($dbc, trim($_POST["depositAmount"]));
	$membershipAmount = mysqli_real_escape_string($dbc, trim($_POST["membershipAmount"]));
	$joiningDate = mysqli_real_escape_string($dbc, trim($_POST["joiningDate"]));
	$joiningDate =  date("Y-m-d", strtotime( $joiningDate ) );
	$renewalDate = mysqli_real_escape_string($dbc, trim($_POST["renewalDate"]));
	$renewalDate =  date("Y-m-d", strtotime( $renewalDate ) );
	
	$query = "INSERT INTO members (member_name, phone_number, address, deposit_amount, membership_amount, join_date, renewal_date) VALUES ('$memberName', '$phoneNumber', '$address', '$depositAmount', '$membershipAmount', '$joiningDate', '$renewalDate')";

	if(mysqli_query($dbc, $query)){
		$output = array("infocode" => "INSERTSUCCESS", "message" => "New member added successfully.");
	}else{
		$output = array("infocode" => "INSERTFAILURE", "message" => "New member not added!");
	}
	return $output;
} 

function searchMembers(){
	global $dbc;
	$memberName = mysqli_real_escape_string($dbc, trim($_POST["memberName"]));
	$memberId = intval($memberName);
	$query = "SELECT * FROM members WHERE member_name  LIKE '%{$memberName}%' OR member_id LIKE '%{$memberId}%' LIMIT 10";
	$result = mysqli_query($dbc, $query);
	$output = '';
	if(mysqli_num_rows($result) > 0){
		while ($row = mysqli_fetch_array($result)){
			$output .= '<tr>' 
			. '<td>' . str_pad($row['member_id'],4,0,STR_PAD_LEFT) . '</td>'
			. '<td>' . $row['member_name'] . '</td>'
			. '<td>' . $row['phone_number'] . '</td>'
			. '<td>' . $row['join_date'] . '</td>'
			. '<td>' . $row['renewal_date'] . '</td>'
			.  '<td>' . '<button type="button" onclick="viewMember(\''. $row['member_id'] .'\')" class="btn btn-warning"><i class="fa fa-edit"></i></button> <button type="button" onclick="deleteMember(\''. $row['member_id'] .'\')" class="btn btn-danger"><i class="fa fa-close"></i></button>' . '</td>'
			. '</tr>';
		}	
	} else {
		$output .= "<tr>" 
		. "<td colspan='5'>No results found.</td>"
		. "</tr>";
	}
	return $output;
}

function getMemberDetailsFromDb(){
	global $dbc;
	$memberId = mysqli_real_escape_string($dbc, trim($_POST["memberId"]));
	
	$query = "SELECT * FROM members WHERE member_id='$memberId'";
	$result = mysqli_query($dbc, $query);
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);
		$output = array("member_name" => $row['member_name'], "phone_number" => $row['phone_number'], "address" => $row['address'], "deposit_amount" => $row['deposit_amount'], "membership_amount" => $row['membership_amount'], "join_date" => $row['join_date'], "renewal_date" => $row['renewal_date']);
	}
	return $output;
}

function updateMemberInDb(){
	global $dbc;
	$memberId = mysqli_real_escape_string($dbc, trim($_POST["memberId"]));
	$memberName = mysqli_real_escape_string($dbc, trim($_POST["memberName"]));
	$phoneNumber = mysqli_real_escape_string($dbc, trim($_POST["phoneNumber"]));
	$address = mysqli_real_escape_string($dbc, trim($_POST["address"]));
	$depositAmount = mysqli_real_escape_string($dbc, trim($_POST["depositAmount"]));
	$membershipAmount = mysqli_real_escape_string($dbc, trim($_POST["membershipAmount"]));
	$joiningDate = mysqli_real_escape_string($dbc, trim($_POST["joiningDate"]));
	$joiningDate =  date("Y-m-d", strtotime( $joiningDate ) );
	$renewalDate = mysqli_real_escape_string($dbc, trim($_POST["renewalDate"]));
	$renewalDate =  date("Y-m-d", strtotime( $renewalDate ) );

	$query = "UPDATE members SET member_name='$memberName', phone_number='$phoneNumber', address='$address', deposit_amount='$depositAmount', membership_amount='$membershipAmount', join_date='$joiningDate', renewal_date = '$renewalDate' WHERE member_id='$memberId'";

	if(mysqli_query($dbc, $query)){
		$output = array("infocode" => "UPDATESUCCESS", "message" => "Member updated successfully.");
	}else{
		$output = array("infocode" => "UPDATEFAILURE", "message" => "Member not updated!");
	}
	return $output;
}

function deleteMemberInDb(){
	global $dbc;
	$memberId = mysqli_real_escape_string($dbc, trim($_POST["memberId"]));
	$query = "DELETE from members WHERE member_id='$memberId'";

	if(mysqli_query($dbc, $query)){
		$output = array("infocode" => "DELETESUCCESS", "message" => "Member deleted successfully.");
	}else{
		$output = array("infocode" => "DELETEFAILURE", "message" => "Member not deleted!");
	}
	return $output;
}

?>