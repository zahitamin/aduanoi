<?php require_once('../Connections/localhost.php'); ?>
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
  $updateSQL = sprintf("UPDATE aduan SET status=%s WHERE aduan_id=%s",
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['aduan_id'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "hehe";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo '<script type="text/javascript">
alert("Kemaskini Data Berjaya!");
window.opener.location = "home.php";
    window.close();
	</script>';
}

$colname_Recordset1 = "-1";
if (isset($_GET['aduan_id'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_GET['aduan_id'] : addslashes($_GET['aduan_id']);
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = sprintf("SELECT * FROM aduan WHERE aduan_id = %s", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_free_result($Recordset1);
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
<body>
<div class="row">
<div class="col-xs-4"></div>
  			<div class="col-xs-4">
  				<div class="panel panel-success">
  					<div class="panel-body">
    						<div class="page-header">
							
<center>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <div class="form-group">
    								<label for="exampleInputEmail1">Status</label>
	  <select name="status" class="form-control">
	  <option value="<?php echo $row_Recordset1['status']; ?>"><?php echo $row_Recordset1['status']; ?></option>
	    <option value="Selesai">Selesai</option>
		<option value="Diproses">Diproses</option>
	  </select>
    </div>
	
    <div class="form-group">
      <td><input type="submit" value="Kemaskini" class="btn btn-success"></td>
   </div>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="aduan_id" value="<?php echo $row_Recordset1['aduan_id']; ?>">
</form>
<p>&nbsp;</p>
</center>
</div>
</div>
</div>
</div>
</div>

</body>
</html>
