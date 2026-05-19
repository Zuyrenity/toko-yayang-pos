<?php
error_reporting(0);
include "koneksi.php";

if(isset($_GET['bln'])){$bln=$_GET['bln'];}else{$bln=date("m");}
if(isset($_GET['thn'])){$thn=$_GET['thn'];}else{$thn=date("Y");}
if(isset($_GET['tgl'])){$tgl=$_GET['tgl'];}else{$tgl="";}

$tahunan="";

if($bln!=""){$tanggal=$thn."-".str_pad($bln,2,"0",STR_PAD_LEFT);}else{$tanggal=$thn;$tahunan="Ya";}
$periode=namabulan($bln)." ".$thn;





?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Laporan Barang Masuk</h1>
</div>
<div class="isi_conten">

<div class="row">
    <div class="col-sm-7"> 
    <label>Periode : </label><br />
     <select class="form-control" id="bln" name="bln" style="width:150px;float:left;" onchange="set_tanggal()" >
        <option value="" <?php if($bln==""){echo" selected";}?>>Setahun</option>
        <option value="1" <?php if($bln=="1"){echo" selected";}?>>Januari</option>
        <option value="2" <?php if($bln=="2"){echo" selected";}?>>Februari</option>
        <option value="3" <?php if($bln=="3"){echo" selected";}?>>Maret</option>
        <option value="4" <?php if($bln=="4"){echo" selected";}?>>April</option>
        <option value="5" <?php if($bln=="5"){echo" selected";}?>>Mei</option>
        <option value="6" <?php if($bln=="6"){echo" selected";}?>>Juni</option>
        <option value="7" <?php if($bln=="7"){echo" selected";}?>>Juli</option>
        <option value="8" <?php if($bln=="8"){echo" selected";}?>>Agustus</option>
        <option value="9" <?php if($bln=="9"){echo" selected";}?>>September</option>
        <option value="10" <?php if($bln=="10"){echo" selected";}?>>Oktober</option>
        <option value="11" <?php if($bln=="11"){echo" selected";}?>>November</option>
    <option value="12" <?php if($bln=="12"){echo" selected";}?>>Desember</option>
    </select>
    
    <select class="form-control" id="thn" name="thn" style="padding:5px;width:100px;float:left;" onchange="set_tanggal()" >
    <?php
    $tahun=date("Y");
    $tahun1=$tahun-5;
    for ($i=$tahun;$i>=$tahun1;$i--)
    {
        echo"<option value='$i' "; if($i==$thn){echo" selected";} echo">$i</option>"; 
    }
    ?>
    </select>
    <button type="button" style="padding:6px;margin-left:5px;" onclick="set_tanggal()"> <span class="glyphicon glyphicon-search"></span> Search</button>
    
    <button type="button" style="padding:6px;margin-left:5px;" onclick="PrintElem('print','Laporan Barang Masuk');"> <span class="glyphicon glyphicon-print"></span> Cetak</button>
    </div>
    
     
    
    
</div>

<hr />

<textarea id="printing-css" style="display:none;">.no-print{display:none}</textarea>
<iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;width:100%;"></iframe>

<div id="print_area" style="width:100%;">  
<style>
.print * {
  transition: none !important;  
   -webkit-print-color-adjust: exact; 
}
</style>
<div id="print" class="print">  
<style>
h1,h2,h3,h4,h4{text-transform:capitalize;}

</style>
<style>
 .tabel_grafik td{border:none !important;text-align:center;width:50px;}
 .bar_grafik{width:30px;margin:0 auto;border:1px solid #BBB;background-color:#CCC;}
 .klik_bulan:hover{background-color:#333;cursor:pointer;}
 
.table th,.table td{border:1px solid #999 !important;}
 </style>

 

  

<h2>Laporan barang masuk  <label style="color:#F60;">(<?=$periode?>)</label></h2>
 

<table   class="table table-striped table-bordered tabel1 tabel_garis" cellspacing="0" width="100%">
<thead>
  <tr>
    <th style="width:50px;">No</th> 
    <th>Tanggal</th> 
	<th>Nama Barang</th> 
	<th style="text-align:center;">Jumlah</th> 
	<th style="text-align:right;width:150px;">Harga Satuan</th> 
	<th style="text-align:right;width:150px;">Subtotal</th> 
  </tr>
</thead>
<tbody>  
<?php
$no=0;
$total=0;
$query=mysqli_query($koneksi,"select * from barang_masuk left join barang on barang.id_barang=barang_masuk.id_barang  where tgl like'$tanggal%'  order by tgl asc");
while ($data=mysqli_fetch_array($query))
{
	$total+=$data['subtotal'];
	$no++;
	echo "<tr>
		  <td>$no</td>
		  <td>".tanggal($data['tgl'])."</td> 
		  <td>$data[nama_barang] </td> 
		  <td style='text-align:center;'>$data[jlh] </td> 
		  <td style='text-align:right;'>Rp ".rupiah($data['hrg_satuan'])."</td> 
		  <td style='text-align:right;'>Rp ".rupiah($data['subtotal'])."</td>  
		  </tr>";
}
?>  

<tr style="background-color:#EEE;">
	<td colspan="5" style="text-align:right;padding-right:50px;">Total</td>
    <td style='text-align:right;'>Rp <?=rupiah($total)?></td>
</tr>
</tbody>
</table>

 


</div>
</div>


</div>



<script>
function set_tanggal()
{
	var bln=document.getElementById("bln").value;
	var thn=document.getElementById("thn").value;
	window.location="?halaman=<?=$halaman?>&bln="+bln+"&thn="+thn;
}
function set_tgl()
{
	var tgl=document.getElementById("tgl").value;
	window.location="?halaman=<?=$halaman?>&tgl="+tgl;
}
</script>