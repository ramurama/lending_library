<?php
/*$la_time = new DateTimeZone('America/Toronto');
$datetime = new DateTime();
$datetime->setTimezone($la_time);
$cdate=$datetime->format('Y-m-d');
$ctime=$datetime->format('Y-m-d H:i:s');*/


$db['db_host']='localhost';
$db['db_user']='root';
$db['db_pass']='root';
$db['db_name']='lending_library';

foreach($db as $key=>$value){
	define(strtoupper($key),$value);
}

// Connect to MySQL:
$dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

// Confirm the connection and select the database:

if (mysqli_connect_errno()) {
    echo "Could not establish database connection!<br>";
    exit();
}

?>