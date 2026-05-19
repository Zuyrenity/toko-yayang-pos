<?php  session_start(); 
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


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Toko Yayang</title>

    <!-- Custom fonts for this template-->
    <link rel="icon" href="img/logo.png"  sizes="10x10">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-4 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                    
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                             
                            
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                    	<img src="img/logo.png">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome</h1>
                                    </div>
                                    <form method="post">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user" required  placeholder="Enter Username...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" required id="exampleInputPassword" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember  Me</label>
                                            </div>
                                        </div>
                                        <input name="proses_login" type="submit" class="btn btn-primary btn-user btn-block" value="Login">
                                        
                                        <hr>
                                          <?php if($notif_gagal=="Ya"){echo"<p style='background-color:#F00;color:#FFF;padding:10px;text-align:center;font-size:14px;position:absolute;'> Login Gagal </p>";} ?>   
                                         
                                    </form>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>