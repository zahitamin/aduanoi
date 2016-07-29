<?php require_once('../Connections/localhost.php'); ?>
<?php
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
mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = "SELECT * FROM aduan";
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
 <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/mystyle.css" rel="stylesheet">
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/tables.js"></script>
	<script src="../js/datatable.js"></script>
 <link href="../css/js-image-slider.css" rel="stylesheet" type="text/css" />
  	<script src="../js/js-image-slider.js" type="text/javascript"></script>

<title>Sistem Laporan Kerosakan</title>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css">
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" >
    $(document).ready(function() {
    $('#example').DataTable();
} );
    </script>
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
        <li class="active"><a href="#">Halaman Utama <span class="sr-only">(current)</span></a></li>
        <li><a href="tambah.php">Tambah Pelajar</a></li>
		<li><a href="<?php echo $logoutAction ?>">Log Keluar</a></li>
	  </ul>
	</div>
</nav>
 
    		<p><br/></p>
  		<div class="row">
  			<div class="col-xs-6 .col-sm-4"></div>
  				<div class="panel panel-default">
  					<div class="panel-body">
    						<div class="page-header">
							<ol class="breadcrumb">
  <li><a href="#">Halaman Utama</a></li>
  <li><a href="#">Administrator</a></li>
  <li class="active">Senarai Laporan Kerosakan</li>
</ol>
<div class="table-responsive">
							<table id="example" class="table table-hover" cellspacing="0" width="100%">
  <thead>
  <tr class="active">
    <th>JENIS ASET</th>
    <th>PERIHAL KEROSAKAN</th>
    <th>NO BILIK</th>
    <th>NAMA PENGADU</th>
    <th>NO MATRIK</th>
    <th>TARIKH LAPORAN</th>
	<th>STATUS</th>
	<th> </th>
	<th> </th>
		
	</tr>
  </thead>
  <?php do { ?>
    <tr>
      <th><?php echo $row_Recordset1['jenis_aset']; ?></th>
      <th><?php echo $row_Recordset1['perihal_laporan']; ?></th>
      <th><?php echo $row_Recordset1['no_bilik']; ?></th>
      <th><?php echo $row_Recordset1['nama_penggadu']; ?></th>
      <th><?php echo $row_Recordset1['no_matrik']; ?></th>
      <th><?php echo $row_Recordset1['tarikh_laporan']; ?></th>
	  <th><?php echo $row_Recordset1['status']; ?> <a href="javascript:window.open('status.php?aduan_id=<?php echo $row_Recordset1['aduan_id']; ?>','Preview','width=700,height=275')" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></th>
	  <th><a href="javascript:window.open('preview.php?aduan_id=<?php echo $row_Recordset1['aduan_id']; ?>','Preview','width=900,height=450')" class="btn btn-success">Print</a></th>
	  <th><a href="padam.php?aduan_id=<?php echo $row_Recordset1['aduan_id']; ?>" class="btn btn-danger" onClick="return confirm('Adakah Anda Ingin Memadam Data ini?');">Padam</a></th>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                            </table>

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
