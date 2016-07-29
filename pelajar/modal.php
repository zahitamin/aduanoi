<?php require_once('Connections/localhost.php'); ?>
<?php
$colname_Recordset1 = "-1";
if (isset($_SESSION['NoMatrik'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_SESSION['NoMatrik'] : addslashes($_SESSION['NoMatrik']);
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = sprintf("SELECT * FROM pelajar WHERE NoMatrik = %s", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['KATALALUAN'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "pelajar/index.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_localhost, $localhost);
  
  $LoginRS__query=sprintf("SELECT NoMatrik, Password FROM pelajar WHERE NoMatrik='%s' AND Password='%s'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $localhost) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    echo '<script language="javascript"> alert("Sila Cuba Lagi! ");</script>'; 
  }
}
?>
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title"><strong><em>SILA LOG MASUK UNTUK MEMBUAT LAPORAN</em></strong></h5>
            </div>

            <div class="modal-body">
                <!-- The form is placed inside the body of modal -->
                <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" role="form" name="form1">
  							<div class="form-group">
    								<label for="exampleInputEmail1">NO MATRIK</label>
  									<input name="username" type="USERNAME" class="form-control" id="exampleInputEmail1" placeholder="NO MATRIK">
								
  							</div>
  							<div class="form-group">
    								<label for="exampleInputPassword1">KATALALUAN</label>
  									<input name="KATALALUAN" type="password" class="form-control" id="exampleInputPassword1" placeholder="KATALALUAN">
								
  							</div>
  							<hr/>
  							<button type="submit" class="btn btn-primary"> Log Masuk</button>
  							<p><br/></p>
			  </form>
            </div>
        </div>
    </div>
</div>

<?php
mysql_free_result($Recordset1);
?>
