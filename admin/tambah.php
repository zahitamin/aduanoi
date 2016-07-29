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
  $insertSQL = sprintf("INSERT INTO pelajar (FirstName, LastName, NoMatrik, NoIC, Email, Password, VerifyPassword, UserName) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['FirstName'], "text"),
                       GetSQLValueString($_POST['LastName'], "text"),
                       GetSQLValueString($_POST['NoMatrik'], "int"),
                       GetSQLValueString($_POST['NoIC'], "int"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Password'], "text"),
                       GetSQLValueString($_POST['VerifyPassword'], "text"),
                       GetSQLValueString($_POST['UserName'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "../pelajar/index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo '<script type="text/javascript">
alert("Pendaftaran Berjaya!");
window.location.href = "home.php";
</script>'; 
}

mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = "SELECT * FROM pelajar";
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
        <li><a href="home.php">Halaman Utama</a></li>
        <li class="active"><a href="#">Tambah Pengguna<span class="sr-only">(current)</span></a></li>
		<li><a href="<?php echo $logoutAction ?>">Log Keluar</a></li>
	  </ul>
	</div>
</nav>
 
    		<p><br/></p>
  		<div class="row">
  			<div class="col-xs-6 .col-sm-4"></div>
  				<div class="panel panel-default">
  					<div class="panel-body">
					<div class="pull-right"> <a href="senarai.php" class="btn btn-success">Senarai Pelajar</a></div>
    						<div class="page-header">
							<ol class="breadcrumb">
  <li><a href="#">Halaman Utama</a></li>
  <li><a href="#">Administrator</a></li>
  <li class="active">Tambah Pengguna</li>
</ol>

  <div class="row">
  			<div class="col-xs-4"></div>
  			<div class="col-xs-4">
  				<div class="panel panel-primary">
  					<div class="panel-body">
    						<div class="page-header">
							
<center>
  							<h3>Tambah Pelajar </h3>
					  </div>
						<form ACTION="<?php echo $editFormAction; ?>" METHOD="POST" name="form1" onSubmit="MM_validateForm('0','','R','exampleInputPassword1','','R','1','','R','2','','R','0','','R','1','','R');return document.MM_returnValue" role="form">
  							<div class="form-group">
    								<label for="exampleInputEmail1">Nama Pertama</label>
    								
  									<input name="FirstName" type="text" class="form-control" id="exampleInputEmail1" placeholder="Nama Pertama">
							  </div>
  							<div class="form-group">
    								<label for="exampleInputPassword1">Nama Kedua</label>
    								
  									<input name="LastName" type="text" class="form-control" id="exampleInputPassword1" placeholder="Nama Kedua">
								</div>
  							
							<div class="form-group">
    								<label for="exampleInputEmail1">No Matrik</label>
    								
  									<input name="NoMatrik" type="int" class="form-control" id="exampleInputEmail1" placeholder="No Matrik">
							  </div>
  							
							<div class="form-group">
    								<label for="exampleInputEmail1">No IC</label>
    								
  									<input name="NoIC" type="text" class="form-control" id="exampleInputEmail1" placeholder="No IC">
							  </div>
  							
							<div class="form-group">
    								<label for="exampleInputEmail1">Email</label>
    								
  									<input name="Email" type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
							  </div>
  						
							<div class="form-group">
    								<label for="exampleInputEmail1">Katalaluan</label>
    								
  									<input name="Password" type="password" class="form-control" id="exampleInputEmail1" placeholder="Katalaluan">
							  </div>
  							
							<div class="form-group">
    								<label for="exampleInputEmail1">Katalaluan Semula</label>
    								
  									<input name="VerifyPassword" type="password" class="form-control" id="exampleInputEmail1" placeholder="Katalaluan Semula">
							  </div>
  							
							<div class="form-group">
    								<label for="exampleInputEmail1">Nama Pengguna</label>
    								
  									<input name="UserName" type="text" class="form-control" id="exampleInputEmail1" placeholder="Nama Pengguna">
							  </div>
  							<hr/>
						<button type="reset" name="Reset" class="btn btn-success"> Semula </button>
  							<button type="submit" class="btn btn-primary">
  							<div>Daftar</div>
  							</button>
							
  							<p><br/></p>
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
        
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>