<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lending Library Management System</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
   <!-- <link href="assets/plugins/datepicker/datepicker3.css" rel="stylesheet" /> -->
   <link rel="stylesheet" href="assets/plugins/jQueryUI/jquery-ui.min.css">

</head>
<body>

    <div id="wrapper">
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="adjust-nav">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">
                        <!--img src="assets/img/logo.png" /-->
                        <h3 style="color:#fff;">LENDING LIBRARY MANAGEMENT</h3>
                    </a>

                </div>

                <span class="logout-spn" >
                  <a href="#" style="color:#fff;"></a>

                </span>
            </div>
        </div>
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li class="" id="li_dashboard">
                        <a href="index.php" ><i class="fa fa-desktop "></i>Dashboard</a>
                    </li>
                    <li id="li_members">
                        <a href="members.php"><i class="fa fa-user "></i>Members  </a>
                    </li>
                    <li id="li_books">
                        <a href="books.php"><i class="fa fa-book "></i>Books </a>
                    </li>
                    <li id="li_lendbook">
                        <a href="lendbook.php"><i class="fa fa-calculator "></i>Lend Book </a>
                    </li>
                    <li id="li_returnbook">
                        <a href="returnbook.php"><i class="fa fa-calculator "></i>Return Book </a>
                    </li>
                    <li id="li_reports">
                        <a href="reports.php"><i class="fa fa-pie-chart "></i>Reports </a>
                    </li>
                </ul>
            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
