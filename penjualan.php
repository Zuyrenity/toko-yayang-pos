
<?php
 
if(isset($_GET['bln'])){$bln=$_GET['bln'];}else{$bln=date("m");}
if(isset($_GET['thn'])){$thn=$_GET['thn'];}else{$thn=date("Y");}
if(isset($_GET['tgl'])){$tgl=$_GET['tgl'];}else{$tgl="";}

$tahunan="";

if($bln!=""){$tanggal=$thn."-".str_pad($bln,2,"0",STR_PAD_LEFT);}else{$tanggal=$thn;$tahunan="Ya";}
$periode=namabulan($bln)." ".$thn;


$proses = isset ($_GET['proses']) ? $_GET['proses']:'';
$kode=isset($_GET['kode']) ? $_GET['kode']:'';
$subkode=isset($_GET['subkode'])?$_GET['subkode']:'';
$data=mysqli_fetch_array(mysqli_query($koneksi,"select * from penjualan where id_penjualan='$kode'"));
if(!$data)
{
	$jlh=mysqli_num_rows(mysqli_query($koneksi,"select * from penjualan"))+1;
	$data['id_penjualan']=rand(111,999).str_pad($jlh,4,"0",STR_PAD_LEFT);
}

 

if($proses=="delete")
{
	mysqli_query($koneksi,"delete from penjualan where id_penjualan='$kode'");	
	echo"<script>window.location='?halaman=$halaman'</script>";
}
if($proses=="valid")
{
	$save=mysqli_query($koneksi,"update penjualan set status_penjualan='Lunas' where id_penjualan='$kode'");	
	if($save)
	{
		echo"<script>window.location='?halaman=$halaman'</script>";
	}
}
if($proses=="selesai")
{
	$save=mysqli_query($koneksi,"update penjualan set status_penjualan='Selesai' where id_penjualan='$kode'");	
	if($save)
	{
		echo"<script>window.location='?halaman=$halaman'</script>";
	}
}
?>




 <div style="padding:10px;position:absolute;width:80%;"> 
    <select class="form-control" id="thn" name="thn" style="width:80px;float:right;font-size:12px;height:25px;padding:2px;line-height:20px;" onchange="set_tanggal()">
    <?php
    $tahun=date("Y");
    $tahun1=$tahun-5;
    for ($i=$tahun;$i>=$tahun1;$i--)
    {
        echo"<option value='$i' "; if($i==$thn){echo" selected";} echo">$i</option>"; 
    }
    ?>
    </select>
     <select class="form-control" id="bln" name="bln" style="width:100px;float:right;font-size:12px;height:25px;padding:2px;line-height:20px;" onchange="set_tanggal()">
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
    
    
    </div>



<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Barang Keluar / Daftar Penjualan</h1>
</div>
 



<p><a href="?halaman=input_penjualan"><input type="button" class="btn btn-primary" value="+ Input Data Penjualan" /></a></p>
<hr />

<div class="card shadow mb-4">
 
<div class="card-body">
<div class="table-responsive">
<table  class="table table-bordered" id="dataTable"  cellspacing="0" width="100%">
<thead>
 <tr>
	<th style="width:50px;">No</th> 
	<th>Tanggal</th> 
	<th>Detail Penjualan </th> 
	<th>Total </th>
	<th>Kasir </th> 
	<th>Nota</th> 
  </tr>
</thead>
<tbody>

 
<?php
$no=0;
$nom=0;
$total=0;
$query=mysqli_query($koneksi,"select * from penjualan left join user on user.id_user=penjualan.id_user where tgl like'$tanggal%' order by tgl asc ");
while ($data=mysqli_fetch_array($query))
{
	if(strlen($data[username])>0){}else{$data[username]="<i>Admin</i>";}
	$no++;
	echo "<tr>
		  <td>$no</td> 
		  <td>".tanggal($data['tgl'])."</td> 
		  <td>";
		  
		  	$cari=mysqli_query($koneksi,"select *from detail_penjualan left join barang on barang.id_barang=detail_penjualan.id_barang where id_penjualan='$data[id_penjualan]'");
			  while ($detail_penjualan=mysqli_fetch_array($cari))
			  { 
				  $nom++;
				  $total+=$detail_penjualan['subtotal'];
				  echo"
				  <li>$detail_penjualan[nama_barang] ($detail_penjualan[jlh] x @".rupiah($detail_penjualan['hrg']).") Rp ".rupiah($detail_penjualan['subtotal'])."</li>
				  "; 
			  }
		 
		  echo"
		  </td> 
		  <td>".rupiah($data['total'])."</td> 
		  <td>$data[username]</td> 
		  <td><a href='?halaman=nota&kode=$data[id_penjualan]'><span class='glyphicon glyphicon-file'>Nota</a>  </td> 
		  </tr>";
}
?>  
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