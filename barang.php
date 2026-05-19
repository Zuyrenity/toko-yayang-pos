
<?php



$data=mysqli_fetch_array(mysqli_query($koneksi,"select * from barang where id_barang='$kode'"));
if(!$data)
{
	$dataterakhir=mysqli_num_rows(mysqli_query($koneksi,"select * from barang"));
	$data['id_barang']="1".str_pad($dataterakhir+1,4,"0",STR_PAD_LEFT).rand(11,99);
	$data['nama_barang']="";
	$data['deskripsi']="";
	$data['harga']="";
}

if (isset($_POST['simpan']))
{
	$save=mysqli_query($koneksi," insert into barang set  id_barang='$_POST[id_barang]' , nama_barang='$_POST[nama_barang]' , deskripsi='$_POST[deskripsi]',  harga='$_POST[harga]',  stok='0'  ");
	if($save)
	{
		$fileSize = $_FILES['foto']['size'];  
	   	$fileError = $_FILES['foto']['error'];
		if($fileSize > 0 || $fileError == 0)
	   	{
			$move=move_uploaded_file($_FILES['foto']['tmp_name'],'foto/barang/'.$_POST['id_barang'].'.jpg');	
		}	
		echo"<script>window.location='?halaman=$halaman&subproses=notif&notif=Data Berhasil Disimpan'</script>"; 
	}
}


if (isset($_POST['edit']))
{
	mysqli_query($koneksi," update barang set  nama_barang='$_POST[nama_barang]' , deskripsi='$_POST[deskripsi]', harga='$_POST[harga]'  where id_barang='$kode'"); 
	$fileSize = $_FILES['foto']['size'];  
	   	$fileError = $_FILES['foto']['error'];
		if($fileSize > 0 || $fileError == 0)
	   	{
			$move=move_uploaded_file($_FILES['foto']['tmp_name'],'foto/barang/'.$kode.'.jpg');	
		}
	echo"<script>window.location='?halaman=$halaman&subproses=notif&notif=Data Berhasil Diubah'</script>";
		
}

if($proses=="hapus")
{
	mysqli_query($koneksi,"delete from barang  where id_barang='$kode'");	
	echo"<script>window.location='?halaman=$halaman&subproses=notif&notif=Data Berhasil Dihapus'</script>";
}


?>
 

<?php if($proses=="edit" or $proses=="input"){?>




<div class="card shadow mb-12">
<div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Data Barang</h6></div>
<div class="card-body" >
                                    
 
<form class="form1" action="" method="post" enctype="multipart/form-data" >
  <div class="row">
    <div class="col-sm-5">

	<div style="display:none;">
		<label>id barang</label>
		<div style="height:35px;">
        <input name="id_barang" class="form-control" type="text" value="<?=$data['id_barang']?>"  required  >
        </div>
    </div>
		
		 
		
		
		<label>nama barang</label>
		<input name="nama_barang"  class="form-control" type="text" value="<?=$data['nama_barang']?>" required>
        
        <label>deskripsi</label>
		<textarea name="deskripsi"  class="form-control" required><?=$data['deskripsi']?></textarea>
		
        
        <label>harga Jual</label>
		<input name="harga"  class="form-control" type="text" value="<?=$data['harga']?>" required onkeypress="return goodchars(event,'0123456789',this)">
        
        
        
        </div>
    	<div class="col-sm-7">
    
		
		
		 <div class="form-group">
              <label >Foto </label>
              <input class="form-control" name="foto" type="file"  onchange="loadFile(event)">
                  <img id="output" src="foto/barang/<?=$kode.".jpg?val=$random"?>" class="img-thumbnail" style="height:100px;" />
         </div>
         
		
		
		
		
		
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
<h1 class="h3 mb-0 text-gray-800">Daftar Barang</h1>
</div>


<p>
<a href="?halaman=<?=$halaman?>&subhalaman=<?=$subhalaman?>&proses=input"><input type="button" class="btn btn-primary " value="+ Input Data Baru" style="z-index:999;"  /></a>
</p>

<hr />
 

<div class="kelas_tabel">
<table  cellspacing="0" width="100%">

<tbody>

 
<?php
$no=0;
$query=mysqli_query($koneksi,"select * from barang order by nama_barang asc");
while ($data=mysqli_fetch_array($query))
{
	$src="foto/barang/$data[id_barang].jpg?val=$random";
	/*
	if(!file_exists($src))
	{
		$src="img/logo.png";
	}
	*/
	$no++;
	echo "
		  <div class='row list_barang'>
		  	<div class='col-sm-4'>
				<img class='img-thumbnail' src='$src' style='width:100px;height:100px;'>
				
				<p style='margin-top:10px;'>
				<a href='?proses=edit&kode=$data[id_barang]&halaman=$halaman' class='btn btn-sm btn-success'><span class='fas fa-fw fa-edit' title='edit'></span></a> 
				<a href='?proses=hapus&kode=$data[id_barang]&halaman=$halaman'  class='btn btn-sm btn-danger' onclick=\"return confirm('Yakin data barang akan dihapus? ')\"><span class='fas fa-fw fa-trash' ></span></a>
				</p>
			</div>
			
		  	<div class='col-sm-8'>
				<label style='font-size:13px;'>$data[nama_barang]</label> 
				<p style='font-size:12px;'>".substr($data['deskripsi'],0,100)."</p>
				
				
				Rp ".rupiah($data['harga'])."<br>
				Stok : $data[stok] <br>";
				
				if($data['stok']<1){echo"<p class='stok_habis btn btn-icon-split btn-xs btn-danger' style='width:100px;'>Stok Habis !!!</p>";}
				elseif($data['stok']<20){echo"<p class='stok_menipis btn btn-warning btn-icon-split btn-xs' style='width:100px;'>Stok Menipis !</p>";}
				
			echo"
			</div>
			 
			 
		  </div> ";
}
?>  
</tbody>
</table>
</div>

 

 
<?php } ?>


 
 
<style>
.list_gambar_barang{display:block;float:left;width:100px;height:120px;margin:0 5px 5px 0;overflow:hidden;}
.list_gambar_barang img{width:100px;height:100px;}
.coret{font-style:italic;color:#F66;}

.stok_menipis{}
.stok_habis{}
.list_barang{border:2px solid #DDD;margin:5px 20px 10px 0; border-radius:5px; width:31%;float:left;height:170px; background-color:#EEE;padding:10px 0 0 0;overflow:hidden;}
.list_barang *{font-size:14px; }
</style>


<script>
 

nx=1;
function tambah_item()
{   
    nx++; 
	row='<div class="'+nx+' frame_file" style="height:25px;">'+
	'<span class="glyphicon glyphicon-remove" onclick="del_item('+nx+')" style="color:#F00;"></span>'+
	'<input type="file" id="gbr'+nx+'"   name="gambar['+nx+']" required style="float:left;">'+
	'</div>';
    $(row).insertBefore("#last");  
} 

function del_item(nn)
{
	$("."+nn).remove();
}


function set_pointer()
{
	if(document.getElementById("all_baris").checked==false)
	{
		var x = document.getElementsByClassName("baris");
		var i;
		for (i = 0; i < x.length; i++) {
		  x[i].checked=false;
		}
	}
	else
	{
		var x = document.getElementsByClassName("baris");
		var i;
		for (i = 0; i < x.length; i++) {
		  x[i].checked=true;
		}
	}
}
</script>