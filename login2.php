<?php  session_start(); 
include"koneksi.php";
?>
<html>
<head>
<title>TOKO YAYANG</title>

<link rel="icon" href="img/logo.png"  sizes="10x10">

<link href="css/style1.css?val=<?=$random_date?>" rel="stylesheet">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/dataTables.bootstrap.min.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>

<body style="background-image:url(img/minimarket.jpg);overflow:hidden;background-size:cover;">
<?php
include"koneksi.php";
$notif_gagal="";	   
$_SESSION['indeks_belanja']="";

if(isset($_POST['proses_login']))
{
	   if($_POST['username']=="admin" and $_POST['password']=="12345")
	   {
		   	$_SESSION['log_user']="Admin";
			$_SESSION['log_username']="Admin";
			echo"<script>window.parent.location='index.php'</script>";
	   }
	   elseif($_POST['username']=="pimpinan" and $_POST['password']=="12345")
	   {
		   	$_SESSION['log_user']="Pimpinan";
			$_SESSION['log_username']="Pimpinan";
			echo"<script>window.parent.location='index.php'</script>";
	   }
	   else
	   {
		  $cek=mysqli_fetch_array(mysqli_query($koneksi,"select * from user where username='$_POST[username]' and password='$_POST[password]'"));
		   if($cek)
		   {
			   /*
			   if($cek['akses']=="Kasir")
			   {
				   $_SESSION['log_user']=$cek['akses'];
				   $_SESSION['log_username']=$cek['username'];
				   $_SESSION['log_id']=$cek['id_user'];
			   }
			   else
			   {
				*/
				
				   $_SESSION['log_user']=$cek['akses'];
				   $_SESSION['log_username']=$cek['username'];
				   $_SESSION['log_id']=$cek['id_user'];
			   			   				
										
				echo"<script>window.parent.location='index.php'</script>";
		   }
		   else
		   {
				$notif_gagal="Ya";
		   }
	   }
	
	
}

?>





<div style="min-height:400px;background-color:rgba(0,0,0,0.7);width:400px;height:100%;padding-top:100px;">





<div style="width:300px;border-radius:10px;margin:100px auto 0 auto;padding:10px;background-color:#CCC;box-shadow:1px 2px 5px rgba(0,0,0,0.7);">

<center><img src="img/login.png?val=11" style="width:150px;z-index:9999; position:absolute;margin:-130px 0 0 -70px;" /></center>
<br><br>
        <center style="font-size:25px;color:#069;font-family:Cambria;font-weight:bold;">LOGIN </center>
       
    		<div class="panel-body" style="font-size:14px;color:#333;border-radius:5px;color:#FFF;color:#333;color:#333;margin-top:10px;">
             
             
            <div style="width:200px;margin:0 auto;"> 
              <form method="post" style="font-family:Calibri;line-height:25px;color:#333;" >
              	
                <div class="input-group input_login" style="margin-bottom:10px;">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                <input name="username" class="form-control" placeholder="Username" aria-describedby="basic-addon1" required>
                </div>
                <div class="input-group input_login">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                <input name="password" type="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1" required>
                </div>
                 
                <input type="submit" class="btn btn-primary" name="proses_login" value="Login"  style="margin-top:5px;border:none;width:100%;margin-top:15px;font-family:Cambria;font-size:14px;">
                
              
                
        	</form>
           </div> 
            
            </div>
            
    <?php if($notif_gagal=="Ya"){echo"<p style='background-color:#F00;color:#FFF;padding:10px;text-align:center;font-size:14px;position:absolute;'> Login Gagal </p>";} ?>        
    
</div>


</div>







<style>
.input_login{font-size:15px;margin-bottom:5px;font-family:Cambria;color:#000;}
.isi_content{background:#333 !important;}
.input-sm{background:none;color:#FFF;padding:10px;color:#333;font-size:14px;}
</style> 


</body>

</html>