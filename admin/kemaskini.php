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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pelajar SET FirstName=%s, LastName=%s, NoMatrik=%s, NoIC=%s, Email=%s, Password=%s, VerifyPassword=%s, UserName=%s WHERE StudentID=%s",
                       GetSQLValueString($_POST['FirstName'], "text"),
                       GetSQLValueString($_POST['LastName'], "text"),
                       GetSQLValueString($_POST['NoMatrik'], "int"),
                       GetSQLValueString($_POST['NoIC'], "int"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Password'], "text"),
                       GetSQLValueString($_POST['VerifyPassword'], "text"),
                       GetSQLValueString($_POST['UserName'], "text"),
                       GetSQLValueString($_POST['StudentID'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "eee";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo '<script type="text/javascript">
alert("Kemaskini Berjaya!");
window.location.href = "senarai.php";
</script>';
}

$colname_Recordset1 = "-1";
if (isset($_GET['StudentID'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_GET['StudentID'] : addslashes($_GET['StudentID']);
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = sprintf("SELECT * FROM pelajar WHERE StudentID = %s", $colname_Recordset1);
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
				    
  					
                    
				  
                            <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                              <div class="form-group">
    								<label for="exampleInputEmail1">Nama Pertama</label>
                                  <input type="text" class="form-control" name="FirstName" value="<?php echo $row_Recordset1['FirstName']; ?>" >
                                </div>
  							<div class="form-group">
    								<label for="exampleInputPassword1">Nama Kedua</label>
                                  <input type="text" class="form-control" name="LastName" value="<?php echo $row_Recordset1['LastName']; ?>" >
                                </div>
  							
							<div class="form-group">
    								<label for="exampleInputEmail1">No Matrik</label>
                                  <input type="text" class="form-control" name="NoMatrik" value="<?php echo $row_Recordset1['NoMatrik']; ?>" >
                                </div>
  							
							<div class="form-group">
    								<label for="exampleInputEmail1">No IC</label>
                                  <input type="text" class="form-control" name="NoIC" value="<?php echo $row_Recordset1['NoIC']; ?>" >
                               </div>
  							
							<div class="form-group">
    								<label for="exampleInputEmail1">Email</label>
                                  <input type="text" class="form-control" name="Email" value="<?php echo $row_Recordset1['Email']; ?>" >
                                 </div>
  						
							<div class="form-group">
    								<label for="exampleInputEmail1">Katalaluan</label>
    								
                                  <input type="text" class="form-control" name="Password" value="<?php echo $row_Recordset1['Password']; ?>" >
                                 </div>
  							
							<div class="form-group">
    								<label for="exampleInputEmail1">Katalaluan Semula</label>
                                  <input type="text" class="form-control" name="VerifyPassword" value="<?php echo $row_Recordset1['VerifyPassword']; ?>" >
                                </div>
  							
							<div class="form-group">
    								<label for="exampleInputEmail1">Nama Pengguna</label>
                                  <input type="text" class="form-control" name="UserName" value="<?php echo $row_Recordset1['UserName']; ?>" >
                                 </div>
  							<hr/>
                                  <input type="submit" class="btn btn-success" value="Kemaskini">
                                </tr>
                              </table>
                              <input type="hidden" name="MM_update" value="form1">
                              <input type="hidden" name="StudentID" value="<?php echo $row_Recordset1['StudentID']; ?>">
                            </form>
                            <p>&nbsp;</p>
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
