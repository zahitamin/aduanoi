<?php require_once('../Connections/localhost.php'); ?>
<?php
$colname_Recordset1 = "-1";
if (isset($_GET['aduan_id'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_GET['aduan_id'] : addslashes($_GET['aduan_id']);
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = sprintf("SELECT * FROM aduan WHERE aduan_id = %s", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
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
</head>

<body><center>
<img src="../gambar/logo-upnm.gif.png" width="308" height="249" align="middle" /></center>
<div class="table-responsive">
							<table id="example" class="table table-hover" cellspacing="0" width="100%">
   <th>JENIS ASET</th>
    <th>PERIHAL KEROSAKAN</th>
    <th>NO BILIK</th>
    <th>NAMA PENGADU</th>
    <th>NO MATRIK</th>
    <th>TARIKH LAPORAN</th>
	<th>STATUS</th>
  </tr>
  <tr>
    <td><?php echo $row_Recordset1['jenis_aset']; ?></td>
    <td><?php echo $row_Recordset1['perihal_laporan']; ?></td>
    <td><?php echo $row_Recordset1['no_bilik']; ?></td>
    <td><?php echo $row_Recordset1['nama_penggadu']; ?></td>
    <td><?php echo $row_Recordset1['no_matrik']; ?></td>
    <td><?php echo $row_Recordset1['tarikh_laporan']; ?></td>
	<td><?php echo $row_Recordset1['status']; ?></td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
