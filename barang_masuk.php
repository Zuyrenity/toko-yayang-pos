
<?php



$data=mysqli_fetch_array(mysqli_query($koneksi,"select * from barang_masuk where id_barang_masuk='$kode'"));
if(!$data)
{
	$dataterakhir=mysqli_num_rows(mysqli_query($koneksi,"select * from barang_masuk"));
	$data['id_barang_masuk']="1".str_pad($dataterakhir+1,4,"0",STR_PAD_LEFT);
	$data['nama_barang_masuk']="";
	$data['merk']="";
	$data['kategori']="";
	$data['harga']="";
}

if (isset($_POST['simpan']))
{
	$save=mysqli_query($koneksi," insert into barang_masuk set  tgl='$_POST[tgl]' , id_barang='$_POST[id_barang]' , jlh='$_POST[jlh]',  hrg_satuan='$_POST[hrg_satuan]',  subtotal='$_POST[subtotal]'  ");
	if($save)
	{
		mysqli_query($koneksi,"update barang set stok=stok+'$_POST[jlh]' where id_barang='$_POST[id_barang]'");
		echo"<script>window.location='?halaman=$halaman&subproses=notif&notif=Data Berhasil Disimpan'</script>";
	}
}


if (isset($_POST['edit']))
{
	mysqli_query($koneksi," update barang_masuk set  tgl='$_POST[tgl]' , id_barang='$_POST[id_barang]' , jlh='$_POST[jlh]',  hrg_satuan='$_POST[hrg_satuan]',  subtotal='$_POST[subtotal]'  where id_barang_masuk='$kode'"); 
	echo"<script>window.location='?halaman=$halaman&proses=edit&kode=$kode&subproses=notif&notif=Data Berhasil Diubah'</script>";
}

if($proses=="hapus")
{
	mysqli_query($koneksi,"delete from barang_masuk  where id_barang_masuk='$kode'");	
	echo"<script>window.location='?halaman=$halaman&subproses=notif&notif=Data Berhasil Dihapus'</script>";
}


?>




<?php if($proses=="edit" or $proses=="input"){?>

<div class="card shadow mb-12">
<div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Data Barang Masuk</h6></div>
<div class="card-body">

<form class="form1" action="" method="post" enctype="multipart/form-data">
  <div class="row">
    <div class="col-sm-5">
		
        
        <label>Tanggal</label>
		<input name="tgl"  class="form-control" type="date" value="<?=$data['tgl']?>" required>
		
        
		<label>barang/barang</label>
		<div style="height:35px;">
        <input name="id_barang" id="id_barang" class="form-control" type="text" value="<?=$data['id_barang']?>"  readonly="readonly" onClick="view_list_barang()">
        </div>
		
		
        
        <label>jumlah </label>
		<input name="jlh" id="jlh"  class="form-control" type="text" value="<?=$data['jlh']?>" required onKeyPress="return goodchars(event,'0123456789',this)" onKeyUp="set_subtotal()" onChange="set_subtotal()">
        
        <label>harga satuan </label>
		<input name="hrg_satuan" id="hrg_satuan"  class="form-control" type="text" value="<?=$data['hrg_satuan']?>" required onKeyPress="return goodchars(event,'0123456789',this)" onKeyUp="set_subtotal()" onChange="set_subtotal()">
        
        <label>subtotal</label>
		<input name="subtotal" id="subtotal"  class="form-control" type="text" value="<?=$data['subtotal']?>" required onKeyPress="return goodchars(event,'0123456789',this)">
        
        
		
		
		
		<p>&nbsp; </p>
    	<?php if($proses=="edit"){?>
    	<input name="edit" class="btn btn-primary " type="submit" value="Update">
		<?php } else { ?>
    	<input name="simpan" class="btn btn-primary" type="submit" value="Simpan">
        <?php } ?>
		<input  class="btn" type="button" value="Kembali" onClick="window.location='?halaman=<?=$halaman?>'">
        
        
        
        
</div>
</div>
	
	
    
    
    
    
</form>
</div>
</div>




<?php  }  else { ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Data Barang Masuk</h1>
</div>
 



<p>
<a href="?halaman=<?=$halaman?>&subhalaman=<?=$subhalaman?>&proses=input"><input type="button" class="btn btn-primary " value="+ Input Data Barang Masuk" style="z-index:999;"  /></a>
</p>

<hr />
 

<div class="card shadow mb-4">
 
<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered" id="dataTable" cellspacing="0" width="100%">
<thead>
 <tr>
	<th style="width:50px;">No</th> 
	<th>Tanggal</th> 
	<th>Nama Barang</th> 
	<th>Jumlah</th> 
	<th>Harga</th> 
	<th>Subtotal</th> 
	<th>Action</th>
  </tr>
</thead>
<tbody>

 
<?php
$no=0;
$query=mysqli_query($koneksi,"select * from barang_masuk left join barang on barang.id_barang=barang_masuk.id_barang order by tgl asc");
while ($data=mysqli_fetch_array($query))
{
	$no++;
	echo "<tr >
		  <td>$no</td> 
		  <td>".tanggal($data[tgl])."</td> 
		  <td>$data[nama_barang]</td> 
		  <td>$data[jlh] </td> 
		  <td>Rp ".rupiah($data['hrg_satuan'])."</td> 
		  <td>Rp ".rupiah($data['subtotal'])."</td> 
		  <td>
			<a href='?proses=edit&kode=$data[id_barang_masuk]&halaman=$halaman'><span class='fas fa-fw fa-edit' title='edit'></span></a> &nbsp;  &nbsp; 
			<a href='?proses=hapus&kode=$data[id_barang_masuk]&halaman=$halaman' ><span class='fas fa-fw fa-trash'  onclick=\"return confirm('Hapus item?');\" ></span></a>
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




 
<div id="frame_barang" style="width:100%;height:100%;background-color:rgba(0,0,0,0.7);position:fixed;top:0;left:0;display:none;">
<p style="text-align:center;margin-top:80px;"><input class="btn btn-warning" type="button" value="Kembali" onClick="close_list_barang();"></p>
<div style="background-color:#FFF;border:1px solid #333;box-shadow:2px 2px #333;width:900px;height:500px;margin:5px auto;padding:20px;overflow:auto;">

<div class="card shadow mb-12">
<div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Daftar Barang</h6></div>
<div class="card-body">
<div class="table-responsive">
<table id="dataTable" class="table"  cellspacing="0" width="100%">
<thead>
 <tr>
	<th style="width:100px;">ID Barang</th> 
	<th style="width:300px;">Nama Barang</th> 
	<th style="width:150px;">Deskripsi</th> 
	<th style="width:120px;">Harga</th> 
	<th style="width:70px;">Stok</th> 
  </tr>
</thead>
<tbody>

 
<?php
$no=0;
$query=mysqli_query($koneksi,"select * from barang ");
while ($data=mysqli_fetch_array($query))
{
	$no++;
	echo "<tr onclick=\"pilih_barang('$data[id_barang]')\">
		  <td style='width:70px;'>$data[id_barang]</td> 
		  <td>$data[nama_barang] </td> 
		  <td>$data[deskripsi] </td> 
		  <td style='text-align:right;width:120px;'>Rp ".rupiah($data['harga'])."</td> 
		  <td>$data[stok] </td> 
		  </tr>";
}
?>  
</tbody>
</table>
</div>
</div>

</div>

</div>
</div>

 
 





 
 
<style>
.list_gambar_barang_masuk{display:block;float:left;width:100px;height:120px;margin:0 5px 5px 0;overflow:hidden;}
.list_gambar_barang_masuk img{width:100px;height:100px;}
.coret{font-style:italic;color:#F66;}
</style>


<script>
function set_subtotal()
{
	var jlh=document.getElementById('jlh').value;
	var hrg_satuan=document.getElementById('hrg_satuan').value;
	//alert(jlh+"-"+hrg_satuan);
	var subtotal=eval(jlh)* eval(hrg_satuan);
	document.getElementById('subtotal').value=subtotal;
}
function view_list_barang()
{
	document.getElementById('frame_barang').style.display="block";
}
function close_list_barang()
{
	document.getElementById('frame_barang').style.display="none";
}
function pilih_barang(kd)
{
	document.getElementById('id_barang').value=kd;
	close_list_barang();
}
</script>


