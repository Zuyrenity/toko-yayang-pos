<?php
$sekarang=date("Y-m-d H:i:s");
$aksi=isset($_GET['aksi'])?$_GET['aksi']:'';
$kode=isset($_GET['kode'])?$_GET['kode']:'';

if(isset($_GET['keyword'])){$keyword=$_GET['keyword'];}else{$keyword="";}
if(isset($_GET['kategori'])){$kategori=$_GET['kategori'];}else{$kategori="";}


$detail=mysqli_fetch_array(mysqli_query($koneksi,"select *from barang where id_barang='$kode'"));
 
 
 
 



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






?>

<style>

.tabel_sub_detail{line-height:25px;font-size:15px;} 
.tabel_sub_detail td{line-height:25px;font-size:15px; vertical-align:top;text-align:justify;padding-bottom:5px;} 
.tabel_sub_detail label{color:#CCC;} 
.barang{ padding:5px; color:#0CF; font-family:calibri;}
.tabel_detail{font-family:Calibri;font-size:14px;}
.tabel_detail td{vertical-align:top;line-height:30px;}
.tabel_detail td:first-child{text-transform:capitalize;color:#999;}
 
.detail td{font-size:14px;color:#555;line-height:25px;}
.detail td:first-child{font-size:14px;color:#777;width:130px;text-transform:capitalize;}
.pilih-bintang{float:left;}
.kecil{width:15px !important;height:15px !important;}
 
 
.item2{border:0.5px solid #DDD;width:98%;padding:10px;margin:0 0 20px 0;background-color:rgba(250,250,250,1);border-radius:5px;font-family:Helvetica;text-align:justify;line-height:25px;color:#555;}
.bintang{width:30px;}
.skor{font-size:40px;font-weight:bold;position:absolute;margin-top:0px;margin-left:10px;color:#09C;}
</style>

 

<input name="keyword" id="keyword" style="color:#000;padding:4px;width:150px;float:right;" placeholder="Keyword..."  />


<p class="judul_conten" style="margin-bottom:0;">Daftar barang </p>

<div class="isi_conten" style="min-height:450px;background-color:#FFF;">

                  
<table style="width:100%;">
<tr>
<td>
  <?php
  $no=0;
  $cari=mysqli_query($koneksi,"select *from barang ");
  while ($data=mysqli_fetch_array($cari))
  {
	  $no++;
		
	  echo"
	  <div class='subbarang' onclick=\"window.location='?halaman=daftar_barang&kode=$data[id_barang]&aksi=beli&harga=$data[harga]'\">";
	  
		echo"
		<center><img src='foto/barang/$data[id_barang].jpg'></center>
		<div class='keterangan'>
		
		<label>".substr($data['nama_barang'],0,30)." <br>$data[merk]</label>";
		$harga=$data['harga'];
		
		echo"
		<p style='margin-top:2px;font-weight:bold;font-size:15px;color:#777;'>Rp <font style='color:#D00;'>".rupiah($harga)."</font></p>
				
		$data[kategori]			
		
		</div>
	</div>";
	
	//
}
	if($no==0)
	{
		echo"<i style='font-family:Calibri;'>Tidak ada data yang ditemukan</i>";
	}
		
	?>
</td>
</tr>
</table>

</div>

 





<style>
.subbarang{width:200px;height:250px;border:2px solid #999;float:left ;margin-right:30px;text-align:center;background-color:#EEF;border-radius:5px;margin-bottom:10px; margin:10px !important;overflow:hidden;box-shadow:0 0 10px #999;}
.subbarang img{width:200px;height:150px;margin:0 auto;}
.subbarang label{width:100%;color:#069;font-size:12px;}
.subbarang .keterangan{height:60px;padding:10px;font-family:Verdana;font-size:12px;color:#777;font-size:11px;}
.subbarang:hover{border:1px solid #999;cursor:pointer;box-shadow:none;}
</style>


<style>
.list_gambar_barang{display:block;float:left;width:50px;height:50px;margin:0 1px 1px 0;overflow:hidden;}
.list_gambar_barang img{width:50px;height:50px;cursor:pointer;border:1px solid #CCC;}
.suka{width:20px !important;height:20px !important;margin-left:5px !important;}
.suka2{width:30px !important;height:30px !important;margin-left:20px;}
</style> 




 <script>
var $rows = $('#table  td');
$('#keyword').keyup(function () {

var kata_kunci=document.getElementById("keyword").value;
if(kata_kunci=="")
{
	var x = document.getElementsByClassName("subbarang");
	var i;
	for (i = 0; i < x.length; i++) 
	{
		x[i].style.display='block';
	}
}
else
{
	var x = document.getElementsByClassName("subbarang");
	var i;
	for (i = 0; i < x.length; i++) 
	{
		if(x[i].innerHTML.toLowerCase().indexOf(kata_kunci.toLowerCase()) > -1) 
		{
			x[i].style.display='block';
		}
		else
		{
			x[i].style.display='none';
		}
	}
}

 
});
</script>
