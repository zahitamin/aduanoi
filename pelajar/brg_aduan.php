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
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO aduan (jenis_aset, perihal_laporan, tarikh_laporan, no_bilik, nama_penggadu, no_matrik, status) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['jenis_aset'], "text"),
                       GetSQLValueString($_POST['perihal_laporan'], "text"),
                       GetSQLValueString($_POST['tarikh_laporan'], "text"),
                       GetSQLValueString($_POST['no_bilik'], "text"),
                       GetSQLValueString($_POST['nama_penggadu'], "text"),
                       GetSQLValueString($_POST['no_matrik'], "int"),
					   GetSQLValueString($_POST['status'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "brg_aduan.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo '<script type="text/javascript">
alert("Laporan Berjaya Dihantar!");
window.location.href = "index.php";
</script>';
}

mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = "SELECT * FROM aduan";
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_datapelajar = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_datapelajar = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_localhost, $localhost);
$query_datapelajar = sprintf("SELECT * FROM pelajar WHERE NoMatrik = %s", $colname_datapelajar);
$datapelajar = mysql_query($query_datapelajar, $localhost) or die(mysql_error());
$row_datapelajar = mysql_fetch_assoc($datapelajar);
$totalRows_datapelajar = mysql_num_rows($datapelajar);
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
        <li><a href="index.php">Halaman Utama <span class="sr-only">(current)</span></a></li>
        <li class="active"><a  href="#">Pelajar</a></li>
		<li><a href="<?php echo $logoutAction ?>">Log Keluar</a></li>
	  </ul>
	</div>
</nav>
 
    		<p><br/></p>
  		<div class="row">
  				<div class="panel panel-default">
  					<div class="panel-body">
					<ol class="breadcrumb">
  <li><a href="../index.php">Halaman utama</a></li>
  <li><a href="index.php">pelajar</a></li>
  <li class="active">Borang Laporan</li>
</ol>
<div class="row">
<div class="col-xs-4"></div>
  			<div class="col-xs-4">
  				<div class="panel panel-primary">
  					<div class="panel-body">
    						<div class="page-header">
							
<center>
  							<h3>Borang Laporan</h3>
					  </div>
                  <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                    <div class="form-group">
    								<label for="exampleInputEmail1">Jenis Aset</label>
    								<select name="jenis_aset" class="form-control">
                            <option value="SILA PILIH">SILA PILIH</option>
                            <option value="KIPAS">KIPAS</option>
                            <option value="ALMARI">ALMARI</option>
                            <option value="KATIL">KATIL</option>
                            <option value="MEJA">MEJA</option>
                            <option value="TINGKAP">TINGKAP</option>
                            <option value="LAMPU">LAMPU</option>
                            <option value="TANDAS">TANDAS</option>
                            <option value="KERUSI">KERUSI</option>
                            <option value="TILAM">TILAM</option>
                            <option value="BANTAL">BANTAL</option>
                            <option value="PINTU">PINTU</option>
						  
                          </select>
                    </div>
				  
                       <div class="form-group">
    								<label for="exampleInputEmail1">Perihal Kerosakan</label>
    								<input type="text" name="perihal_laporan" class="form-control" value="">
                      
					  </div>
                       <div class="form-group">
    								<label for="exampleInputEmail1">Tarikh Laporan</label>
    								<input type="text" name="tarikh_laporan" class="form-control" id="Datepicker1" value="">
                      </div>
					 
                       <div class="form-group">
    								<label for="exampleInputEmail1">No Bilik</label>
    								<input type="text" name="no_bilik" class="form-control" value="">
                      </div>
                       <div class="form-group">
    								<label for="exampleInputEmail1">Nama Penggadu</label>
    								<input type="text" name="nama_penggadu" class="form-control" value="<?php echo $row_datapelajar['FirstName']; ?> <?php echo $row_datapelajar['LastName']; ?>">
                      </div>
                       <div class="form-group">
    								<label for="exampleInputEmail1">No Matrik</label>
    								<input type="text" name="no_matrik" class="form-control" value="<?php echo $row_datapelajar['NoMatrik']; ?>">
                      </div>
					  <div class="hidden">
    								<label for="exampleInputEmail1">status</label>
    								<input type="text" name="status" class="form-control" value="Diproses">
                      </div>
                       <div class="form-group">
    								
                        <input type="submit" class="btn btn-success" value="LAPORKAN">
                      </div>
                    <input type="hidden" name="MM_insert" value="form1">
                  </form>
                  </div>
					</center>
				</div>
  			</div>
		</div>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
$(function() {
	$( "#Datepicker1" ).datepicker(); 
});
$(function() {
	$( "#Datepicker1" ).datepicker(); 
});
</script>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($datapelajar);
?>