<?php
date_default_timezone_set("Asia/Jakarta");
if(isset($_GET['bln'])){$bln=$_GET['bln'];}else{$bln="";}
if(isset($_GET['thn'])){$thn=$_GET['thn'];}else{$thn=date("Y");}
if(isset($_GET['tgl'])){$tgl=$_GET['tgl'];}else{$tgl="";}

$tahunan="";

	if($bln!=""){$tanggal=$thn."-".str_pad($bln,2,"0",STR_PAD_LEFT);}else{$tanggal=$thn;$tahunan="Ya";}
	$periode=namabulan($bln)." ".$thn;




?>


<div class="row">

    <div class="col-xl-12 col-lg-7">


        <div class="card shadow mb-12">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Barang Keluar/ Penjualan</h6>
            </div>
            <div class="card-body">
                
                
                <?php

$tggl1=$thn."-01";
$data1=mysqli_fetch_array(mysqli_query($koneksi,"select sum(total) as total_penjualan from penjualan where tgl like'$tggl1%'"));
$tggl2=$thn."-02";
$data2=mysqli_fetch_array(mysqli_query($koneksi,"select sum(total) as total_penjualan from penjualan where tgl like'$tggl2%'"));
$tggl3=$thn."-03";
$data3=mysqli_fetch_array(mysqli_query($koneksi,"select sum(total) as total_penjualan from penjualan where tgl like'$tggl3%'"));
$tggl4=$thn."-04";
$data4=mysqli_fetch_array(mysqli_query($koneksi,"select sum(total) as total_penjualan from penjualan where tgl like'$tggl4%'"));
$tggl5=$thn."-05";
$data5=mysqli_fetch_array(mysqli_query($koneksi,"select sum(total) as total_penjualan from penjualan where tgl like'$tggl5%'"));
$tggl6=$thn."-06";
$data6=mysqli_fetch_array(mysqli_query($koneksi,"select sum(total) as total_penjualan from penjualan where tgl like'$tggl6%'"));
$tggl7=$thn."-07";
$data7=mysqli_fetch_array(mysqli_query($koneksi,"select sum(total) as total_penjualan from penjualan where tgl like'$tggl7%'"));
$tggl8=$thn."-08";
$data8=mysqli_fetch_array(mysqli_query($koneksi,"select sum(total) as total_penjualan from penjualan where tgl like'$tggl8%'"));
$tggl9=$thn."-09";
$data9=mysqli_fetch_array(mysqli_query($koneksi,"select sum(total) as total_penjualan from penjualan where tgl like'$tggl9%'"));
$tggl10=$thn."-10";
$data10=mysqli_fetch_array(mysqli_query($koneksi,"select sum(total) as total_penjualan from penjualan where tgl like'$tggl10%'"));
$tggl11=$thn."-11";
$data11=mysqli_fetch_array(mysqli_query($koneksi,"select sum(total) as total_penjualan from penjualan where tgl like'$tggl11%'"));
$tggl12=$thn."-12";
$data12=mysqli_fetch_array(mysqli_query($koneksi,"select sum(total) as total_penjualan from penjualan where tgl like'$tggl12%'"));

if($data1['total_penjualan']>0){}else{$data1['total_penjualan']=0;}
if($data2['total_penjualan']>0){}else{$data2['total_penjualan']=0;}
if($data3['total_penjualan']>0){}else{$data3['total_penjualan']=0;}
if($data4['total_penjualan']>0){}else{$data4['total_penjualan']=0;}
if($data5['total_penjualan']>0){}else{$data5['total_penjualan']=0;}
if($data6['total_penjualan']>0){}else{$data6['total_penjualan']=0;}
if($data7['total_penjualan']>0){}else{$data7['total_penjualan']=0;}
if($data8['total_penjualan']>0){}else{$data8['total_penjualan']=0;}
if($data9['total_penjualan']>0){}else{$data9['total_penjualan']=0;}
if($data10['total_penjualan']>0){}else{$data10['total_penjualan']=0;}
if($data11['total_penjualan']>0){}else{$data11['total_penjualan']=0;}
if($data12['total_penjualan']>0){}else{$data12['total_penjualan']=0;}

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>


<p style="text-align:center;font-size:18px;">Grafik Penjualan</p>
<canvas id="myChart" style="width:1000px;max-width:1000px;height:300px;margin:0 auto;"></canvas>

<script>
const xValues = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

new Chart("myChart", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{ 
      data: [<?=$data1['total_penjualan']?>,
	  		 <?=$data2['total_penjualan']?>,
	  		 <?=$data3['total_penjualan']?>,
	  		 <?=$data4['total_penjualan']?>,
	  		 <?=$data5['total_penjualan']?>,
	  		 <?=$data6['total_penjualan']?>,
	  		 <?=$data7['total_penjualan']?>,
	  		 <?=$data8['total_penjualan']?>,
	  		 <?=$data9['total_penjualan']?>,
	  		 <?=$data10['total_penjualan']?>,
	  		 <?=$data11['total_penjualan']?>,
	  		 <?=$data12['total_penjualan']?>],
      borderColor: "red",
      fill: false
    }]
  },
  options: {
    legend: {display: false}
  }
});
</script> 
                
                
            </div>
        </div>


<br />

        <div class="card shadow mb-12">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Barang Masuk</h6>
            </div>
            <div class="card-body">
                
                
                <?php

$tggl1=$thn."-01";
$data1=mysqli_fetch_array(mysqli_query($koneksi,"select sum(subtotal) as total_masuk from barang_masuk where tgl like'$tggl1%'"));
$tggl2=$thn."-02";
$data2=mysqli_fetch_array(mysqli_query($koneksi,"select sum(subtotal) as total_masuk from barang_masuk where tgl like'$tggl2%'"));
$tggl3=$thn."-03";
$data3=mysqli_fetch_array(mysqli_query($koneksi,"select sum(subtotal) as total_masuk from barang_masuk where tgl like'$tggl3%'"));
$tggl4=$thn."-04";
$data4=mysqli_fetch_array(mysqli_query($koneksi,"select sum(subtotal) as total_masuk from barang_masuk where tgl like'$tggl4%'"));
$tggl5=$thn."-05";
$data5=mysqli_fetch_array(mysqli_query($koneksi,"select sum(subtotal) as total_masuk from barang_masuk where tgl like'$tggl5%'"));
$tggl6=$thn."-06";
$data6=mysqli_fetch_array(mysqli_query($koneksi,"select sum(subtotal) as total_masuk from barang_masuk where tgl like'$tggl6%'"));
$tggl7=$thn."-07";
$data7=mysqli_fetch_array(mysqli_query($koneksi,"select sum(subtotal) as total_masuk from barang_masuk where tgl like'$tggl7%'"));
$tggl8=$thn."-08";
$data8=mysqli_fetch_array(mysqli_query($koneksi,"select sum(subtotal) as total_masuk from barang_masuk where tgl like'$tggl8%'"));
$tggl9=$thn."-09";
$data9=mysqli_fetch_array(mysqli_query($koneksi,"select sum(subtotal) as total_masuk from barang_masuk where tgl like'$tggl9%'"));
$tggl10=$thn."-10";
$data10=mysqli_fetch_array(mysqli_query($koneksi,"select sum(subtotal) as total_masuk from barang_masuk where tgl like'$tggl10%'"));
$tggl11=$thn."-11";
$data11=mysqli_fetch_array(mysqli_query($koneksi,"select sum(subtotal) as total_masuk from barang_masuk where tgl like'$tggl11%'"));
$tggl12=$thn."-12";
$data12=mysqli_fetch_array(mysqli_query($koneksi,"select sum(subtotal) as total_masuk from barang_masuk where tgl like'$tggl12%'"));

if($data1['total_masuk']>0){}else{$data1['total_masuk']=0;}
if($data2['total_masuk']>0){}else{$data2['total_masuk']=0;}
if($data3['total_masuk']>0){}else{$data3['total_masuk']=0;}
if($data4['total_masuk']>0){}else{$data4['total_masuk']=0;}
if($data5['total_masuk']>0){}else{$data5['total_masuk']=0;}
if($data6['total_masuk']>0){}else{$data6['total_masuk']=0;}
if($data7['total_masuk']>0){}else{$data7['total_masuk']=0;}
if($data8['total_masuk']>0){}else{$data8['total_masuk']=0;}
if($data9['total_masuk']>0){}else{$data9['total_masuk']=0;}
if($data10['total_masuk']>0){}else{$data10['total_masuk']=0;}
if($data11['total_masuk']>0){}else{$data11['total_masuk']=0;}
if($data12['total_masuk']>0){}else{$data12['total_masuk']=0;}

?>
 

<canvas id="myChart2" style="width:900px;max-width:900px;height:300px;margin:0 auto;"></canvas>

<script>
const xValues2 = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

new Chart("myChart2", {
  type: "line",
  data: {
    labels: xValues2,
    datasets: [{ 
      data: [<?=$data1['total_masuk']?>,
	  		 <?=$data2['total_masuk']?>,
	  		 <?=$data3['total_masuk']?>,
	  		 <?=$data4['total_masuk']?>,
	  		 <?=$data5['total_masuk']?>,
	  		 <?=$data6['total_masuk']?>,
	  		 <?=$data7['total_masuk']?>,
	  		 <?=$data8['total_masuk']?>,
	  		 <?=$data9['total_masuk']?>,
	  		 <?=$data10['total_masuk']?>,
	  		 <?=$data11['total_masuk']?>,
	  		 <?=$data12['total_masuk']?>],
      borderColor: "blue",
      fill: false
    }]
  },
  options: {
    legend: {display: false}
  }
});
</script>  
                
            </div>
        </div>

    </div>

  
     
</div>

            

<!-- 
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

 
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

 
    <script src="js/sb-admin-2.min.js"></script>

 
    <script src="vendor/chart.js/Chart.min.js"></script>

-->