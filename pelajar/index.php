<?php require_once('../Connections/localhost.php'); ?><?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = sprintf("SELECT * FROM pelajar WHERE NoMatrik = %s", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?><!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
 <link href="../css/bootstrap.min.css" rel="stylesheet">
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
 <link href="../css/js-image-slider.css" rel="stylesheet" type="text/css" />
 <link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
 <link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
 <link href="../jQueryAssets/jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
 <script src="../js/js-image-slider.js" type="text/javascript"></script>
<script src="../jQueryAssets/jquery-1.11.1.min.js" type="text/javascript"></script>
 <script src="../jQueryAssets/jquery.ui-1.10.4.datepicker.min.js" type="text/javascript"></script>
<title>Sistem Laporan Kerosakan</title>
</head>
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	left:301px;
	top:15px;
	width:577px;
	height:141px;
	z-index:1;
}
-->
</style>
<body style="background:#eee;">
<div class="container">
<br>
<center><IMG SRC="../gambar/banner.png" BORDER="0" WIDTH="1000" HEIGHT="188" ALT="Sistem Laporan"></center>
<br>
<nav class="navbar navbar-inverse">
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="../index.php">Halaman Utama <span class="sr-only">(current)</span></a></li>
        <li class="active"><a  href="#">Pelajar</a></li>
		<li><a href="<?php echo $logoutAction ?>">Log Keluar</a></li>
	  </ul>
	</div>
</nav>
 
    		<p><br/></p>
  		<div class="row">
  			<div class="col-xs-6 .col-sm-4"></div>
  				<div class="panel panel-default">
  					<div class="panel-body">
					<ol class="breadcrumb">
  <li><a href="#">Halaman utama</a></li>
  <li class="active">Pelajar</li>
</ol>
    						
				<div class="page-header">	
				<center>	
				<h2> Sila Pilih </h2>	
				</center>
				<br>
                              <center><a href="brg_aduan.php" class="btn-lg btn-success" >Laporan Baru</a> 
                              <a href="makl_aduan.php?no_matrik=<?php echo $row_Recordset1['NoMatrik']; ?>" class="btn-lg btn-info" >Maklumat Laporan</a>
                              </center>
                              <br>
					  </div>
            </div>
          </div>
</div>
</div>
</div>
</div>
</div>
</div>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>