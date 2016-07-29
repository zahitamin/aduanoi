<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
 <link href="css/bootstrap.min.css" rel="stylesheet">
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
 <link href="css/js-image-slider.css" rel="stylesheet" type="text/css" />
  	<script src="js/js-image-slider.js" type="text/javascript"></script>

<title>Sistem Laporan Kerosakan</title>
</head>
<style>
gambar {
    width: 500px;
    height: 100px;
    border: 3px solid #73AD21;
}
</style>
<body style="background:#eee;">
<div class="container">
<br>
<center><IMG SRC="gambar/banner.png" BORDER="0" WIDTH="1000" HEIGHT="188" ALT="Sistem Laporan"></center>
<br>
<nav class="navbar navbar-inverse">
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Halaman Utama <span class="sr-only">(current)</span></a></li>
        <li><a data-toggle="modal" href="#loginModal">Pelajar</a></li>
		<li><a href="admin/index.php">Administrator</a></li>
		</ul>
		</div>
</nav>
 
    		<p><br/></p>
  		<div class="row">
  			<div class="col-xs-6 .col-sm-4"></div>
  				<div class="panel panel-default">
  					<div class="panel-body">
    						<div class="page-header">
							<div class="push">
          <div align="center">
            Selamat Datang Ke Sistem Laporan Kerosakan Alatan Di Blok Penginapan Kasturi
            Terima Kasih kerana menggunakan Sistem Laporan Kerosakan Alatan Di Blok Penginapan Kasturi.
            Sistem in adalah sebuah sistem yang dibangunkan bagi memudahkan pelajar di UPNM
            membuat laporan kerosakan berkaitan alatan yang terdapat di Blok Penginapan Kasturi.
          </div>
		  <br>
							
	<img src="gambar/upnm asrama.JPG" class="thumbnail" style="width: 100%;
    height: 400px;">
</div>
</div>
</div>
</div>
</div>
</div>
</body>
<?php include 'pelajar/modal.php';?>
</html>