
<?php



$data=mysqli_fetch_array(mysqli_query($koneksi,"select * from user where id_user='$kode'"));
if(!$data)
{
	$dataterakhir=mysqli_num_rows(mysqli_query($koneksi,"select * from user"));
	$data['id_user']="1".str_pad($dataterakhir+1,4,"0",STR_PAD_LEFT);
	$data['username']="";
	$data['password']="";
	$data['akses']="";
}

if (isset($_POST['simpan']))
{
	$save=mysqli_query($koneksi," insert into user set   username='$_POST[username]' , password='$_POST[password]' , akses='$_POST[akses]'  ");
	if($save)
	{
		echo"<script>window.location='?halaman=$halaman'</script>";
	}
}


if (isset($_POST['edit']))
{
	mysqli_query($koneksi," update user set  username='$_POST[username]' , password='$_POST[password]' , akses='$_POST[akses]'  where id_user='$kode'"); 
	echo"<script>window.location='?halaman=$halaman&proses=edit&kode=$kode'</script>";
}

if($proses=="hapus")
{
	mysqli_query($koneksi,"delete from user  where id_user='$kode'");	
	echo"<script>window.location='?halaman=$halaman'</script>";
}


?>




<?php if($proses=="edit" or $proses=="input"){?>

<div class="card shadow mb-12">
<div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Data User</h6></div>
<div class="card-body">

<form class="form1" action="" method="post" enctype="multipart/form-data">
  <div class="row">
    <div class="col-sm-5">

		
		
		
		<label>username</label>
		<input name="username"  class="form-control" type="text" value="<?=$data['username']?>" required>
        
        <label>password</label>
		<input name="password"  class="form-control" type="text" value="<?=$data['password']?>" required>
		
        
		
		
		<label>akses</label>
		<select name="akses"  class="form-control" required  >
        <option value="">-pilih-</option>
        <option value="Admin" <?php if($data['akses']=="Admin"){echo" selected";} ?>>Admin</option>
        <option value="Pimpinan" <?php if($data['akses']=="Pimpinan"){echo" selected";} ?>>Pimpinan</option>
        </select>
        
        
       
		 
         
		
		
		
		
		
		<p>&nbsp; </p>
    	<?php if($proses=="edit"){?>
    	<input name="edit" class="btn btn-primary " type="submit" value="Update">
		<?php } else { ?>
    	<input name="simpan" class="btn btn-primary" type="submit" value="Simpan">
        <?php } ?>
		<input  class="btn" type="button" value="Kembali" onclick="window.location='?halaman=<?=$halaman?>'">
        
        
        
        
</div>
</div>
	
	
    
    
    
    
</form>
</div>
</div>




<?php  }  else { ?>


<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Daftar User</h1>
</div>



<p>
<a href="?halaman=<?=$halaman?>&subhalaman=<?=$subhalaman?>&proses=input"><input type="button" class="btn btn-primary " value="+ Input User" style="z-index:999;"  /></a>
</p>

 

<div class="card shadow mb-4">
 
<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered" id="dataTable" cellspacing="0" width="100%">
<thead>
 <tr>
	<th style="width:50px;">No</th> 
	<th>Username</th> 
	<th>Password</th> 
	<th>Akses</th> 
	<th>Action</th>
  </tr>
</thead>
<tbody>

 
<?php
$no=0;
$query=mysqli_query($koneksi,"select * from user ");
while ($data=mysqli_fetch_array($query))
{
	$no++;
	echo "<tr >
		  <td>$no</td> 
		  <td>$data[username]</td> 
		  <td>$data[password] </td> 
		  <td>$data[akses] </td> 
		  <td>
			<a href='?proses=edit&kode=$data[id_user]&halaman=$halaman'><span class='fas fa-fw fa-edit' title='edit'></span></a> &nbsp;  &nbsp; 
			<a href='?proses=hapus&kode=$data[id_user]&halaman=$halaman' ><span class='fas fa-fw fa-trash'  onclick=\"return confirm('Hapus item?');\" ></span></a>
		  </td>
		  </tr>";
}
?>  
</tbody>
</table>

</div>
</div>
</div>


 
<?php } ?>


 