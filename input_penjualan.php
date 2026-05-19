
<?php

$kode=isset($_GET['kode'])?$_GET['kode']:'';
$aksi=isset($_GET['aksi'])?$_GET['aksi']:'';
$proses=isset($_GET['proses'])?$_GET['proses']:'';
$harga=isset($_GET['harga'])?$_GET['harga']:'';

if($aksi=="beli")
{		
	$cek_barang=mysqli_fetch_array(mysqli_query($koneksi,"select * from detail_penjualan where id_penjualan='99999' and id_barang='$kode' "));
	if($cek_barang)
	{
		$jlh=$cek_barang['jlh']+1;
		$subtotal=$jlh*$_GET['harga'];
		mysqli_query($koneksi,"update detail_penjualan set jlh='$jlh', subtotal='$subtotal', hrg='$_GET[harga]' where id_detail='$cek_barang[id_detail]'");
		
	}
	else
	{
		$subtotal=1*$_GET['harga'];
		mysqli_query($koneksi,"insert into detail_penjualan set id_penjualan='99999' ,id_barang='$kode', jlh='1' , hrg='$_GET[harga]' , subtotal='$subtotal'");
	}
	echo"<script>window.location='?halaman=input_penjualan'</script>";
}
 

if($proses=="update_jumlah" and $aksi=="kurangi")
{
		$jlh=$_GET['jumlah']-1;
		$subtotal=$jlh*$_GET['hrg'];
		if($subtotal>0)
		{
			mysqli_query($koneksi,"update detail_penjualan set jlh='$jlh', subtotal='$subtotal'  where id_detail='$_GET[id_detail]'");
		}
		else
		{
			mysqli_query($koneksi,"delete from detail_penjualan where id_detail='$_GET[id_detail]'");
		}

	
}

if($proses=="update_jumlah" and $aksi=="tambahkan")
{
	$jlh=$_GET['jumlah']+1;
	$subtotal=$jlh*$_GET['hrg'];
	mysqli_query($koneksi,"update detail_penjualan set jlh='$jlh', subtotal='$subtotal'  where id_detail='$_GET[id_detail]'");
	
}
if($proses=="update_angka")
{
	$jlh=$_GET['jumlah'];
	$subtotal=$jlh*$_GET['hrg'];
	if($subtotal>0)
	{
		mysqli_query($koneksi,"update detail_penjualan set jlh='$jlh', subtotal='$subtotal'  where id_detail='$_GET[id_detail]'");
	}
	else
	{
		mysqli_query($koneksi,"delete from detail_penjualan where id_detail='$_GET[id_detail]'");
	}
	
}

if(isset($_POST['simpan_transaksi']))
{
	
	$id_penjualan=date("ymd").rand(111,999);
	$query=mysqli_query($koneksi,"insert into penjualan set id_penjualan='$id_penjualan',
														  tgl='$_POST[tgl]',
														  total='$_POST[total]',
														  bayar='$_POST[bayar]',
														  kembalian='$_POST[kembalian]',
														  id_user='$log_id'");
	if($query)
	{
		$query_detail=mysqli_query($koneksi,"select * from detail_penjualan where id_penjualan='99999'");
		while($detail=mysqli_fetch_array($query_detail))
		{
			mysqli_query($koneksi,"update barang set stok=stok-'$detail[jlh]' where id_barang='$detail[id_barang]'");
		}
		mysqli_query($koneksi,"update detail_penjualan set id_penjualan='$id_penjualan' where id_penjualan='99999'");
		$_SESSION['indeks_belanja']=$rand_indeks;
		echo"<script>window.location='?halaman=nota&kode=$id_penjualan&subproses=notif&notif=Data Berhasil Disimpan'</script>";
	}
}


$cek_keranjang=mysqli_fetch_array(mysqli_query($koneksi,"select * from detail_penjualan where id_penjualan='$_SESSION[indeks_belanja]'"));

$kategori_terpilih="";
?>


 



<form class="transaksi" action="" method="post" >

<div class="card shadow mb-12">
<div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Input Penjualan</h6></div>
<div class="card-body">


  
    
    <table class="table tabel_penjualan">
    <thead>
    <tr>
    	<td style="width:50px;">No</td>
        <td style="width:120px;">Kode</td>
        <td>Nama barang</td>
        <td colspan="3" style="text-align:center;">Jumlah</td>
        <td style="text-align:right;width:100px !important;">Harga </td>
        <td style="text-align:right;width:110px !important;">Subtotal</td>
    </tr>
    </thead>
    <tbody>
      <?php
	  $nom=0;
	  $total=0;
	  $daftar_barang="";
      $cari=mysqli_query($koneksi,"select *from detail_penjualan left join barang on barang.id_barang=detail_penjualan.id_barang where id_penjualan='99999'  ");
      while ($data=mysqli_fetch_array($cari))
      {
          $nom++;
          $total+=$data['subtotal'];
          echo"
		  <tr>
		  	<td >$nom</td>
		  	<td >$data[id_barang]</td>
		  	<td>$data[nama_barang]</td>
		  	<td style='width:20px;text-align:right;'>
				<a href='?halaman=$halaman&proses=update_jumlah&id_detail=$data[id_detail]&aksi=kurangi&jumlah=$data[jlh]&hrg=$data[hrg]'>
				<span style='cursor:pointer;'>-</span>
				</a>
		    </td>
		  	<td style='width:30px;text-align:center;'>
				<input value='$data[jlh]' style='width:50px;text-align:center;'
				onkeypress=\"return goodchars(event,'0123456789',this)\" onchange=\"window.location='?halaman=$halaman&proses=update_angka&id_detail=$data[id_detail]&jumlah='+this.value+'&hrg=$data[hrg]'\">
				
			</td>
		  	<td style='width:20px;text-align:left;'>
				<a href='?halaman=$halaman&proses=update_jumlah&id_detail=$data[id_detail]&aksi=tambahkan&jumlah=$data[jlh]&hrg=$data[hrg]'>
				<span style='cursor:pointer;'>+</span>
				</a>
		    </td>
		  	<td style='text-align:right;width:100px !important;'>".rupiah($data['hrg'])."</td>
		  	<td style='text-align:right;width:110px !important;'>".rupiah($data['subtotal'])."</td>
		  </tr>
          "; 
      	}
      	?>
     </tbody>
     <tfoot>
     	<tr>
        <td colspan="3">
        <br />
        <p><input type="button" class="btn btn-xs btn-primary" value="+ Tambah barang" style="width:150px !important;background-color:#069;font-size:14px;" onclick="view_list_barang()" /></p>    
        <br />  
        </td>
        <td colspan="4" style="text-align:right;">Total</td>
        <td style="text-align:right;"><input id="total" value="<?=$total?>" name="total" style="text-align:right;width:100px;border:none;font-weight:bold;font-size:18px;color:#D00;display:none;" readonly="readonly" />
        <input value="<?=rupiah($total)?>"  style="text-align:right;width:100px;border:none;font-weight:bold;font-size:15px;color:#D00;" readonly="readonly" /></td>
        </tr>
        <tr>
        	<td colspan="6" style="text-align:right;">Tanggal</td>
            <td colspan="2" style="text-align:right;"><input class="form-control" name="tgl" type="date" value="<?=date("Y-m-d")?>" readonly style="width:150px;float:right;" /></td>
        </tr>
        <tr>
        	<td colspan="6" style="text-align:right;">Bayar</td>
            <td colspan="2" style="text-align:right;"><input class="form-control" id="bayar" name="bayar" type="text" required style="width:150px;float:right;padding:0;text-align:right;padding-right:10px;" onkeypress="return goodchars(event,'0123456789',this)" onkeyup="set_kembalian()" /></td>
        </tr>
        <tr>
        	<td colspan="6" style="text-align:right;">Kembalian</td>
            <td colspan="2" style="text-align:right;"><input class="form-control" id="kembalian" name="kembalian" type="text"  style="width:150px;float:right;text-align:right;padding-right:10px;" readonly="readonly" /></td>
        </tr>
        <tr>
        	<td colspan="7"></td>
            <td><a href="?halaman=input_transaksi"><input class="btn btn-danger" type="submit" name="simpan_transaksi" value="Simpan" style="margin-bottom:20px;font-size:17px;width:100px !important;background-color:#900;"/></a>
</td>
        </tr>
     </tfoot>
     </table>
    

<br />

</div>
</div>


 
</form>






<div id="frame_barang" style="width:100%;height:100%;background-color:rgba(0,0,0,0.7);position:fixed;top:0;left:0;display:none;z-index:9999999;">
<p style="text-align:center;margin-top:20px;"><input class="btn btn-warning" type="button" value="Kembali" onclick="close_list_barang();"></p>
<div style="background-color:#FFF;border:1px solid #333;box-shadow:2px 2px #333;width:900px;height:550px;margin:20px auto;padding:20px;overflow:auto;">

<div class="card shadow mb-12">
<div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Daftar Barang</h6></div>
<div class="card-body">
<div class="table-responsive">
<table id="dataTable" class="table"  cellspacing="0" width="100%">
<thead>
 <tr>
	<th style="width:100px;">ID barang</th> 
	<th style="width:300px;">Nama Barang</th> 
	<th style="width:150px;">Deskripsi</th> 
	<th style="width:120px;">Harga</th> 
	<th style="width:100px;">Stok</th> 
  </tr>
</thead>
<tbody>

 
<?php
$no=0;
$query=mysqli_query($koneksi,"select * from barang ");
while ($data=mysqli_fetch_array($query))
{
	$no++;
	echo "<tr onclick=\"window.location='?halaman=input_penjualan&kode=$data[id_barang]&aksi=beli&harga=$data[harga]'\">
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
.tabel_penjualan{margin:0 auto;} 

.harga_subtotal{color:#F00;}
.header_detail{text-transform:capitalize;font-size:15px;font-weight:bold;color:#09C;}
.tabel_transaksi td{font-family:Calibri;text-transform:capitalize;line-height:25px;}
.detail_pembelian tr:first-child td{background-color:#EEE;}
.detail_pembelian td{font-family:Calibri;padding:1px 5px;border:1px solid #CCC;text-transform:capitalize;padding:1px 5px;min-width:100px;}
.detail_pembelian td:first-child{min-width:30px;width:50px;}
.sembunyi{display:none;}
.nilai{width:70px;text-align:center;}
.kanan{text-align:right;border:none;float:right;}
.input_readonly{border:none;}
.kolom_bawah td{padding-bottom:5px;}
</style>



<script>
function set_kembalian()
{
	var bayar=document.getElementById('bayar').value;
	var total=document.getElementById('total').value;
	var kembalian=eval(bayar)-eval(total);
	document.getElementById('kembalian').value=kembalian;
	
}
function view_list_barang()
{
	document.getElementById('frame_barang').style.display="block";
}
function close_list_barang()
{
	document.getElementById('frame_barang').style.display="none";
}
</script>