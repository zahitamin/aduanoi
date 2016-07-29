<?php require_once('../Connections/localhost.php'); ?>
<?php
mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = "SELECT * FROM `admin`";
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?><?php
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
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "home.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_localhost, $localhost);
  
  $LoginRS__query=sprintf("SELECT idpengguna, katalaluan FROM admin WHERE idpengguna='%s' AND katalaluan='%s'",
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
    echo '<script language="javascript"> alert("Sila Cuba lagi!");</script>'; 
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	 <link href="../css/js-image-slider.css" rel="stylesheet" type="text/css" />
  	<script src="../js/js-image-slider.js" type="text/javascript"></script>
    <title>HALAMAN ADMINISTRATOR</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
  <body style="background:#eee;">
    
    <div class="container">
    
	<br>
	<br>
	<br>
	<br>
  		<div class="row">
  			<div class="col-xs-4"></div>
  			<div class="col-xs-4">
  				<div class="panel panel-default">
  					<div class="panel-body">
    						<div class="page-header">
							<center> <img src="../gambar/logo-upnm.gif.png" width="219" height="167" align="texttop">
							</center>
<center>
  							<h3>LOG MASUK</h3>
					  </div>
						<form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" role="form" name="form1">
  							<div class="form-group">
    								<label for="exampleInputEmail1">ID ADMIN</label>
    								
  									<input name="username" type="USERNAME" class="form-control" id="exampleInputEmail1" placeholder="ID ADMIN">
							  </div>
  							
  							<div class="form-group">
    								<label for="exampleInputPassword1">KATALALUAN</label>
    								
  									<input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="KATALALUAN">
								
  							</div>
  							<hr/>
						<a type="button" href="../index.php" class="btn btn-success"> Kembali</a>
  							<button type="submit" class="btn btn-primary">
  							<div> Log Masuk</div>
  							</button>
							
  							<p><br/></p>
					  </form>
					  
					
					 
  					</div>
					</center>
				</div>
  			</div>
		</div>
    </div>
<br>
					 <br>
					 <br>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  </body>
</html>
<?php
mysql_free_result($Recordset1);
?>
