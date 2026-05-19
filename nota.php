
<?php


$proses=isset($_GET['proses'])?$_GET['proses']:'';
$kode=isset($_GET['kode'])?$_GET['kode']:'';

$data=mysqli_fetch_array(mysqli_query($koneksi,"select * from penjualan where id_penjualan='$kode'"));


?>



<input type="button" value="Cetak" onclick="PrintElem('print','Nota')"  style="padding:6px;margin-bottom:20px;" />

<textarea id="printing-css" style="display:none;">.no-print{display:none}</textarea>
<iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;width:100%;"></iframe>

<div id="print_area" style="width:100%;">  
<style>
.print * {
 
}

.table td{border:1px solid #333 !important;}
</style>

<div id="print" class="print" style="background-color:#EEE;margin:0 auto;width:600px;margin:0 auto;border:1px  solid #999;"> 
 

 
<table style="margin:10px 30px;font-family:Cambria;">
    <tr>
        <td style=""><img src="img/logo.png?val=2" style="width:50px;" /></td>
        <td style="padding-left:20px;">
        <p style="font-size:30px;font-weight:bold;color:#CF3;font-family:cambria;">
        	<span style="color:#690;">Toko </span> <span style="color:#F60;"> Yayang</span>
        </p> 
        </td>
    </tr>
</table>
<hr />
<form class="transaksi" action="" method="post" style="background-color:#FFF;padding:20px 40px;">
<p style="font-size:18px;text-align:center;color:#666;">Nota Penjualan</p>
<hr style="border:1px dashed #999;" />
    <div class="row">
        <div class="col-sm-6">
        <table class="tabel_transaksi" style="font-size:14px;font-family:Cambria;line-height:25px;">
          <tr>
            <td style="width:120px;">ID Penjualan </td><td style="width:20px;">: </td><td style="width:150px;"> <b><?=$data['id_penjualan']?></b></td> 
          </tr>
          <tr>
            <td >Tanggal</td><td>:</td><td> <b><?=tanggal($data['tgl'])?></b></td> 
          </tr>
          <tr>
            <td >Total Belanja</td><td>:</td><td style="text-align:right;"> <b><?=rupiah($data['total'])?></b></td> 
          </tr>
          <tr>
            <td >Bayar</td><td>:</td><td style="text-align:right;"> <b><?=rupiah($data['bayar'])?></b></td> 
          </tr>
          <tr>
            <td >Kembalian</td><td>:</td><td style="text-align:right;"> <b><?=rupiah($data['kembalian'])?></b></td> 
          </tr>
          
        </table>
        </div>
         
     </div>   


<hr />

    <p class="header_detail">Detail barang</p>
    
    <table class="table" border="1" >
    <thead>
    <tr>
    	<td>No</td>
        <td style="width:100px;">ID barang</td>
        <td style="width:200px;">Nama barang</td>
        <td style="text-align:center;">Jumlah</td>
        <td style="text-align:right;">Hrg Satuan</td>
        <td style="text-align:right;">Subtotal</td>
    </tr>
    </thead>
    <tbody>
      <?php
	  $nom=0;
	  $total=0;
	  $daftar_barang="";
      $cari=mysqli_query($koneksi,"select *from detail_penjualan left join barang on barang.id_barang=detail_penjualan.id_barang where id_penjualan='$kode'  ");
      while ($item=mysqli_fetch_array($cari))
      {
		  $nom++;
          $total+=$item['subtotal'];
          echo"
		  <tr>
		  	<td>$nom</td>
		  	<td>$item[id_barang]</td>
		  	<td>$item[nama_barang]</td>
		  	<td style='width:50px;text-align:center;'>$item[jlh]</td>
		  	<td style='text-align:right;width:120px;'>".rupiah($item['hrg'])."</td>
		  	<td style='text-align:right;width:120px;'>".rupiah($item['subtotal'])."</td>
		  </tr>
          "; 
      	}
      	?>
     </tbody>
     <tfoot>
     	<tr><td colspan="5">Total</td><td style="text-align:right;"><?=rupiah($total)?></td></tr>
     </tfoot>
     </table>
    


</form>
 

</div>


</div>


<br />
<a href="?halaman=penjualan"><input type="button" class="btn btn-xs btn-primary" value="Kembali" /> </a>




 
