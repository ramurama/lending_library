<?php
session_start();

include ('../dbconfig.php');
include ('PHPExcel.php');
include 'PHPExcel/Writer/Excel2007.php';

$phpExcelObj = new PHPExcel();

function setExcelProperties($reportType){
  global $phpExcelObj;
  $phpExcelObj->getProperties()->setCreator("Lending Library Management");
  $phpExcelObj->getProperties()->setLastModifiedBy("Lending Library Management");
  $phpExcelObj->getProperties()->setTitle($reportType);
  $phpExcelObj->getProperties()->setSubject($reportType);
  $phpExcelObj->getProperties()->setDescription($reportType);
}

$finaloutput = array();
$action = $_POST['action'];

switch($action){
	case 'generateReport':
        $finaloutput = generateReport();
    break;
	default:
    	$finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
}
echo json_encode($finaloutput);

function generateReport(){
  $selectedReportType = $_POST['selected_val'];
  switch ($selectedReportType) {
    case 1:
      return generateOverallMonthlyReport();
    case 2:
      return generateDailyIncomeReport();
    case 3:
      return generateOverallBooksReport();
    case 4:
       return generateOverallCustomersReport();
    case 5:
       return generateCustomReport();
    default:
      return array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
  }
}

function generateOverallMonthlyReport(){
  global $dbc, $phpExcelObj;
  $reportType = 'Overall Monthly Report';
  setExcelProperties($reportType);
  $todaysDate = date("Y-m-d");
  $splitDate = explode('-', $todaysDate);
  $thisMonth = $splitDate[1];
  $thisYear =  $splitDate[0];
  $query = "SELECT @a:=@a+1 serial_number, member_id, book_id, book_language, book_category, book_rate, lending_rate, lending_date, due_date, return_date, penalty_perday, total_penalty, total_earned FROM (SELECT @a:= 0) AS a, booklist_history WHERE YEAR(return_date)='$thisYear' AND MONTH(return_date)='$thisMonth'";
  //file_put_contents("formlog.log", print_r($query, true ));
  $result = mysqli_query($dbc,$query);
  if(mysqli_num_rows($result) > 0){
    $dataRows = array();
    while($row = mysqli_fetch_assoc($result)){
      $dataRows[] = $row;
    }

    //file_put_contents("formlog.log", print_r($dataRows, true ));
    //Header Writing
    $excelRow = 1;
    $excelCol = 0;
    foreach ($dataRows[0] as $key => $value) {
      $headerVal = ucfirst(str_replace('_', ' ', $key));
      $phpExcelObj->getActiveSheet()->getStyle($excelCol . ':' . $excelRow)->getFont()->setBold(true);
      $phpExcelObj->getActiveSheet()->setCellValueByColumnAndRow($excelCol, $excelRow, $headerVal);
      $excelCol++;
    }
    //Header writing ends

    $totalEarnings = 0;
    $excelRow = 2;
    foreach($dataRows as $dataRow) {
				$excelCol = 0;
        $totalEarnings += $dataRow['total_earned'];
        foreach ($dataRow as $key => $value) {
          $phpExcelObj->getActiveSheet()->setCellValueByColumnAndRow($excelCol, $excelRow, $value);
          $excelCol++;
        }
        $excelRow++;
		}

    //total earning
    $col = 12; // column numer of total_earnings
    $row = $excelRow;
    $prevCol = $col - 1;
    $phpExcelObj->getActiveSheet()->getStyle($prevCol . ':' . $row)->getFont()->setBold(true);
    $phpExcelObj->getActiveSheet()->setCellValueByColumnAndRow($prevCol, $row, 'Total Earnings');
    $phpExcelObj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $totalEarnings);
    $reportType = 'Overall Monthly Report';
    setExcelProperties($reportType);
    $phpExcelObj->getActiveSheet()->setTitle($reportType);
    writeExcel($phpExcelObj, $reportType);
    return array('infocode' => 'success', 'message' => 'Report generated successfully.' );
  } else {
    return array('infocode' => 'success', 'message' => 'No records found.' );
  }
}

function generateDailyIncomeReport(){
  global $dbc, $phpExcelObj;
  $reportType = 'Daily Income';
  setExcelProperties($reportType);
  $todaysDate = date("Y-m-d");
  $query = "SELECT @a:=@a+1 serial_number, member_id, book_id, book_language, book_category, book_rate, lending_rate, lending_date, due_date, return_date, penalty_perday, total_penalty, total_earned FROM (SELECT @a:= 0) AS a, booklist_history WHERE return_date ='" . $todaysDate . "'";
  //file_put_contents("formlog.log", print_r($query, true ));

  $result = mysqli_query($dbc,$query);
  if(mysqli_num_rows($result) > 0){
    $dataRows = array();
    while($row = mysqli_fetch_assoc($result)){
      $dataRows[] = $row;
    }

    //file_put_contents("formlog.log", print_r($dataRows, true ));
    //Header Writing
    $excelRow = 1;
    $excelCol = 0;
    foreach ($dataRows[0] as $key => $value) {
      $headerVal = ucfirst(str_replace('_', ' ', $key));
      $phpExcelObj->getActiveSheet()->getStyle($excelCol . ':' . $excelRow)->getFont()->setBold(true);
      $phpExcelObj->getActiveSheet()->setCellValueByColumnAndRow($excelCol, $excelRow, $headerVal);
      $excelCol++;
    }
    //Header writing ends

    $totalEarnings = 0;
    $excelRow = 2;
    foreach($dataRows as $dataRow) {
				$excelCol = 0;
        $totalEarnings += $dataRow['total_earned'];
        foreach ($dataRow as $key => $value) {
          $phpExcelObj->getActiveSheet()->setCellValueByColumnAndRow($excelCol, $excelRow, $value);
          $excelCol++;
        }
        $excelRow++;
		}

    //total earning
    $col = 12; // column numer of total_earnings
    $row = $excelRow;
    $prevCol = $col - 1;
    $phpExcelObj->getActiveSheet()->getStyle($prevCol . ':' . $row)->getFont()->setBold(true);
    $phpExcelObj->getActiveSheet()->setCellValueByColumnAndRow($prevCol, $row, 'Total Earnings');
    $phpExcelObj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $totalEarnings);
    $reportType = 'Daily Income';
    setExcelProperties($reportType);
    $phpExcelObj->getActiveSheet()->setTitle($reportType);
    writeExcel($phpExcelObj, $reportType);
    return array('infocode' => 'success', 'message' => 'Report generated successfully.' );
  } else {
    return array('infocode' => 'success', 'message' => 'No records found.' );
  }
}

function generateOverallBooksReport(){
  global $dbc, $phpExcelObj;
  $reportType = 'Overall Books Report';
  setExcelProperties($reportType);
  $bookCategoryVal = $_POST['book_category'];
  switch ($bookCategoryVal) {
    case 1:
      $query = "SELECT @a:=@a+1 serial_number, book_id, book_name, author_name, old_number, book_rate, book_language, book_category FROM (SELECT @a:= 0) AS a, english_books WHERE book_category='old'";
      break;
    case 2:
      $query = "SELECT @a:=@a+1 serial_number, book_id, book_name, author_name, old_number, book_rate, book_language, book_category FROM (SELECT @a:= 0) AS a, english_books WHERE book_category='new'";
      break;
    case 3:
      $query = "SELECT @a:=@a+1 serial_number, book_id, book_name, author_name, old_number, book_rate, book_language, book_category FROM (SELECT @a:= 0) AS a, english_books WHERE book_category='magazine'";
      break;
    case 4:
      $query = "SELECT @a:=@a+1 serial_number, book_id, book_name, author_name, old_number, book_rate, book_language, book_category FROM (SELECT @a:= 0) AS a, english_books";
      break;
    case 5:
      $query = "SELECT @a:=@a+1 serial_number, book_id, book_name, author_name, old_number, book_rate, book_language, book_category FROM (SELECT @a:= 0) AS a, tamil_books WHERE book_category='old'";
      break;
    case 6:
      $query = "SELECT @a:=@a+1 serial_number, book_id, book_name, author_name, old_number, book_rate, book_language, book_category FROM (SELECT @a:= 0) AS a, tamil_books WHERE book_category='new'";
      break;
    case 7:
      $query = "SELECT @a:=@a+1 serial_number, book_id, book_name, author_name, old_number, book_rate, book_language, book_category FROM (SELECT @a:= 0) AS a, tamil_books WHERE book_category='magazine'";
      break;
    case 8:
      $query = "SELECT book_id, book_name, author_name, old_number, book_rate, book_language, book_category FROM tamil_books";
      break;
    case 9:
      $query = "SELECT book_id, book_name, author_name, old_number, book_rate, book_language, book_category FROM english_books WHERE book_category='old' UNION SELECT book_id, book_name, author_name, old_number, book_rate, book_language, book_category FROM tamil_books WHERE book_category='old'";
      break;
    case 10:
      $query = "SELECT book_id, book_name, author_name, old_number, book_rate, book_language, book_category FROM english_books WHERE book_category='new' UNION SELECT book_id, book_name, author_name, old_number, book_rate, book_language, book_category FROM tamil_books WHERE book_category='new'";
      break;
    case 11:
      $query = "SELECT book_id, book_name, author_name, old_number, book_rate, book_language, book_category FROM english_books WHERE book_category='magazine' UNION SELECT book_id, book_name, author_name, old_number, book_rate, book_language, book_category FROM tamil_books WHERE book_category='magazine'";
      break;
    case 12:
      $query = "SELECT book_id, book_name, author_name, old_number, book_rate, book_language, book_category FROM english_books UNION SELECT book_id, book_name, author_name, old_number, book_rate, book_language, book_category FROM tamil_books";
      break;
  }

  $result = mysqli_query($dbc,$query);
  if(mysqli_num_rows($result) > 0){
    $dataRows = array();
    while($row = mysqli_fetch_assoc($result)){
      $dataRows[] = $row;
    }

    //file_put_contents("formlog.log", print_r($dataRows, true ));
    //Header Writing
    $excelRow = 1;
    $excelCol = 0;
    foreach ($dataRows[0] as $key => $value) {
      $headerVal = ucfirst(str_replace('_', ' ', $key));
      $phpExcelObj->getActiveSheet()->getStyle($excelCol . ':' . $excelRow)->getFont()->setBold(true);
      $phpExcelObj->getActiveSheet()->setCellValueByColumnAndRow($excelCol, $excelRow, $headerVal);
      $excelCol++;
    }
    //Header writing ends

    $excelRow = 2;
    foreach($dataRows as $dataRow) {
				$excelCol = 0;
        foreach ($dataRow as $key => $value) {
          $phpExcelObj->getActiveSheet()->setCellValueByColumnAndRow($excelCol, $excelRow, $value);
          $excelCol++;
        }
        $excelRow++;
		}
    $reportType = 'Overall Books Report';
    setExcelProperties($reportType);
    $phpExcelObj->getActiveSheet()->setTitle($reportType);
    writeExcel($phpExcelObj, $reportType);
    return array('infocode' => 'success', 'message' => 'Report generated successfully.' );
  } else {
    return array('infocode' => 'success', 'message' => 'No records found.' );
  }
}

function generateOverallCustomersReport(){
  global $dbc, $phpExcelObj;
  $reportType = 'Overall Customers Report';
  setExcelProperties($reportType);

  $query = "SELECT @a:=@a+1 serial_number, member_id, member_name, phone_number, nick_name, address, deposit_amount, membership_amount, member_credit, join_date, renewal_date, status FROM (SELECT @a:= 0) AS a, members";
  $result = mysqli_query($dbc,$query);
  if(mysqli_num_rows($result) > 0){
    $dataRows = array();
    while($row = mysqli_fetch_assoc($result)){
      $dataRows[] = $row;
    }

    //file_put_contents("formlog.log", print_r($dataRows, true ));
    //Header Writing
    $excelRow = 1;
    $excelCol = 0;
    foreach ($dataRows[0] as $key => $value) {
      $headerVal = ucfirst(str_replace('_', ' ', $key));
      $phpExcelObj->getActiveSheet()->getStyle($excelCol . ':' . $excelRow)->getFont()->setBold(true);
      $phpExcelObj->getActiveSheet()->setCellValueByColumnAndRow($excelCol, $excelRow, $headerVal);
      $excelCol++;
    }
    //Header writing ends

    $excelRow = 2;
    foreach($dataRows as $dataRow) {
				$excelCol = 0;
        foreach ($dataRow as $key => $value) {
          $phpExcelObj->getActiveSheet()->setCellValueByColumnAndRow($excelCol, $excelRow, $value);
          $excelCol++;
        }
        $excelRow++;
		}
    $reportType = 'Overall Customers Report';
    setExcelProperties($reportType);
    $phpExcelObj->getActiveSheet()->setTitle($reportType);
    writeExcel($phpExcelObj, $reportType);
    return array('infocode' => 'success', 'message' => 'Report generated successfully.' );
  } else {
    return array('infocode' => 'success', 'message' => 'No records found.' );
  }

}

function generateCustomReport(){
  global $dbc, $phpExcelObj;
  $fromDate = $_POST['from_date'];
  $toDate = $_POST['to_date'];
  //$reportType = 'From Date: ' . $fromDate . ' To Date: ' . $toDate;

  $query = "SELECT @a:=@a+1 serial_number, member_id, book_id, book_language, book_category, book_rate, lending_rate, lending_date, due_date, return_date, penalty_perday, total_penalty, total_earned FROM (SELECT @a:= 0) AS a, booklist_history WHERE return_date >='" . $fromDate . "' AND return_date <='" . $toDate ."'";
  $result = mysqli_query($dbc,$query);
  if(mysqli_num_rows($result) > 0){
    $dataRows = array();
    while($row = mysqli_fetch_assoc($result)){
      $dataRows[] = $row;
    }

    //file_put_contents("formlog.log", print_r($dataRows, true ));
    //Header Writing
    $excelRow = 1;
    $excelCol = 0;
    foreach ($dataRows[0] as $key => $value) {
      $headerVal = ucfirst(str_replace('_', ' ', $key));
      $phpExcelObj->getActiveSheet()->getStyle($excelCol . ':' . $excelRow)->getFont()->setBold(true);
      $phpExcelObj->getActiveSheet()->setCellValueByColumnAndRow($excelCol, $excelRow, $headerVal);
      $excelCol++;
    }
    //Header writing ends

    $totalEarnings = 0;
    $excelRow = 2;
    foreach($dataRows as $dataRow) {
				$excelCol = 0;
        $totalEarnings += $dataRow['total_earned'];
        foreach ($dataRow as $key => $value) {
          $phpExcelObj->getActiveSheet()->setCellValueByColumnAndRow($excelCol, $excelRow, $value);
          $excelCol++;
        }
        $excelRow++;
		}

    //total earning
    $col = 12; // column numer of total_earnings
    $row = $excelRow;
    $prevCol = $col - 1;
    $phpExcelObj->getActiveSheet()->getStyle($prevCol . ':' . $row)->getFont()->setBold(true);
    $phpExcelObj->getActiveSheet()->setCellValueByColumnAndRow($prevCol, $row, 'Total Earnings');
    $phpExcelObj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $totalEarnings);
    $reportType = 'Custom Report';
    setExcelProperties($reportType);
    $phpExcelObj->getActiveSheet()->setTitle($reportType);
    writeExcel($phpExcelObj, $reportType);
    return array('infocode' => 'success', 'message' => 'Report generated successfully.' );
  } else {
    return array('infocode' => 'success', 'message' => 'No records found.' );
  }
}

function writeExcel($phpExcelObj, $reportType){
  $writerObj = new PHPExcel_Writer_Excel2007($phpExcelObj);
  $filename = $reportType . '.xlsx';
  $writerObj->save(str_replace('report_services.php', $filename, __FILE__));
  $_SESSION['filename'] = $filename;

  //header('Location: downloadfile.php');

  // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  // header("Content-Disposition: attachment;filename={$filename}");
  // header('Cache-Control: max-age=0');
  //$writerObj->save('php://output');
}

?>
