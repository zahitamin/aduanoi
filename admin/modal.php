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

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = "SELECT * FROM pelajar";
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" />

<div class="modal fade" id="TambahPelajar" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>                </button>
                <h5 class="modal-title">SILA LOG MASUK UNTUK MEMBUAT ADUAN</h5>
            </div>

          <div class="modal-body">
      <center>          
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <div class="form-group">
    								<td>FirstName:</td>
    								<div class="input-group">
      <td><input name="FirstName" type="text" class="form form-control" value=""></td>
    </div>
    <div class="input-group">
      <td>LastName:</td>
      <td><input name="LastName" type="text" class="form form-control" value=""></td>
    </div>
    <div class="input-group">
      <td>NoMatrik:</td>
      <td><input name="NoMatrik" type="text" class="form form-control" value=""></td>
    </div>
    <div class="input-group">
      <td>NoIC:</td>
      <td><input name="NoIC" type="text" class="form form-control" value=""></td>
    </div>
    <div class="input-group">
      <td>Email:</td>
      <td><input name="Email" type="text" class="form form form-control" value=""></td>
    </div>
    <div class="input-group">
      <td>Password:</td>
      <td><input name="Password" type="password" class="form form-control" value=""></td>
    </div>
    <div class="input-group">
      <td>VerifyPassword:</td>
      <td><input name="VerifyPassword" type="password" class="form form-control" value=""></td>
    </div>
    <div class="input-group">
      <td>UserName:</td>
      <td><input name="UserName" type="text" class="form form-control" value=""></td>
    </div>
	<br />
    <div class="input-group">
      <td><input type="submit" class="btn btn-primary" value="Daftar Pelajar"></td>
    </div>
  </div>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</center>
            </div>
        </div>
    </div>
</div>
<?php
mysql_free_result($Recordset1);
?>
