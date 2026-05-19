
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
		echo"<script>window.location='?halaman=$halaman'</script>";
	}
}


if (isset($_POST['edit']))
{
	mysqli_query($koneksi," update barang_masuk set  tgl='$_POST[tgl]' , id_barang='$_POST[id_barang]' , jlh='$_POST[jlh]',  hrg_satuan='$_POST[hrg_satuan]',  subtotal='$_POST[subtotal]'  where id_barang_masuk='$kode'"); 
	echo"<script>window.location='?halaman=$halaman&proses=edit&kode=$kode'</script>";
}

if($proses=="hapus")
{
	mysqli_query($koneksi,"delete from barang_masuk  where id_barang_masuk='$kode'");	
	echo"<script>window.location='?halaman=$halaman'</script>";
}


?>




<?php if($proses=="edit" or $proses=="input"){?>

<p class="judul_conten">Data barang</p>
<div class="isi_conten">

<form class="form1" action="" method="post" enctype="multipart/form-data">
  <div class="row">
    <div class="col-sm-5">
		
        
        <label>Tanggal</label>
		<input name="tgl"  class="form-control" type="date" value="<?=$data['tgl']?>" required>
		
        
		<label>barang/barang</label>
		<div style="height:35px;">
        <input name="id_barang" id="id_barang" class="form-control" type="text" value="<?=$data['id_barang']?>"  readonly="readonly" onclick="view_list_barang()">
        </div>
		
		
        
        <label>jumlah </label>
		<input name="jlh" id="jlh"  class="form-control" type="text" value="<?=$data['jlh']?>" required onkeypress="return goodchars(event,'0123456789',this)" onkeyup="set_subtotal()" onchange="set_subtotal()">
        
        <label>harga satuan </label>
		<input name="hrg_satuan" id="hrg_satuan"  class="form-control" type="text" value="<?=$data['hrg_satuan']?>" required onkeypress="return goodchars(event,'0123456789',this)" onkeyup="set_subtotal()" onchange="set_subtotal()">
        
        <label>subtotal</label>
		<input name="subtotal" id="subtotal"  class="form-control" type="text" value="<?=$data['subtotal']?>" required onkeypress="return goodchars(event,'0123456789',this)">
        
        
        
        </div>
    	<div class="col-sm-7">
    
		
		
		
		
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



<?php  }  else { ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Data Barang Masuk</h1>
</div>
 



<p>
<a href="?halaman=<?=$halaman?>&subhalaman=<?=$subhalaman?>&proses=input"><input type="button" class="btn btn-primary " value="+ Input Data Barang Masuk" style="z-index:999;"  /></a>
</p>

<hr />
 

<div class="table-responsive">
<table class="table table-bordered" id="dataTable" cellspacing="0" width="100%">
<thead>
 <tr>
	<th style="width:100px;">No</th> 
	<th>Tanggal</th> 
	<th>nama barang</th> 
	<th>jumlah</th> 
	<th>harga</th> 
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
			<a href='?proses=edit&kode=$data[id_barang_masuk]&halaman=$halaman'><span class='glyphicon glyphicon-edit' title='edit'></span></a> &nbsp;  &nbsp; 
			<a href='?proses=hapus&kode=$data[id_barang_masuk]&halaman=$halaman' ><span class='glyphicon glyphicon-remove'  onclick=\"return confirm('Hapus item?');\" ></span></a>
		  </td>
		  </tr>";
		   
}
?>  
</tbody>
</table>
</div>

 


 
<?php } ?>





<div id="frame_barang" style="width:100%;height:100%;background-color:rgba(0,0,0,0.7);position:fixed;top:0;left:0;display:none;">
<p style="text-align:center;margin-top:80px;"><input class="btn btn-warning" type="button" value="Kembali" onclick="close_list_barang();"></p>
<div style="background-color:#FFF;border:1px solid #333;box-shadow:2px 2px #333;width:900px;height:500px;margin:5px auto;padding:20px;overflow:auto;">

<p style="text-align:center;font-weight:bold;font-size:15px;background-color:#999;padding:5px;">Daftar barang</p>

<table id="example" class="table" cellspacing="0" width="100%">
<thead>
 <tr>
	<th style="width:70px;">ID barang</th> 
	<th style="width:300px;">nama barang</th> 
	<th style="width:150px;">deskripsi</th> 
	<th style="width:120px;">harga</th> 
	<th style="width:150px;">stok</th> 
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





<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Salary</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Salary</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61</td>
                                            <td>2011/04/25</td>
                                            <td>$320,800</td>
                                        </tr>
                                        <tr>
                                            <td>Garrett Winters</td>
                                            <td>Accountant</td>
                                            <td>Tokyo</td>
                                            <td>63</td>
                                            <td>2011/07/25</td>
                                            <td>$170,750</td>
                                        </tr>
                                        <tr>
                                            <td>Ashton Cox</td>
                                            <td>Junior Technical Author</td>
                                            <td>San Francisco</td>
                                            <td>66</td>
                                            <td>2009/01/12</td>
                                            <td>$86,000</td>
                                        </tr>
                                        <tr>
                                            <td>Cedric Kelly</td>
                                            <td>Senior Javascript Developer</td>
                                            <td>Edinburgh</td>
                                            <td>22</td>
                                            <td>2012/03/29</td>
                                            <td>$433,060</td>
                                        </tr>
                                        <tr>
                                            <td>Airi Satou</td>
                                            <td>Accountant</td>
                                            <td>Tokyo</td>
                                            <td>33</td>
                                            <td>2008/11/28</td>
                                            <td>$162,700</td>
                                        </tr>
                                        <tr>
                                            <td>Brielle Williamson</td>
                                            <td>Integration Specialist</td>
                                            <td>New York</td>
                                            <td>61</td>
                                            <td>2012/12/02</td>
                                            <td>$372,000</td>
                                        </tr>
                                         
                                         
                                        <tr>
                                            <td>Jenette Caldwell</td>
                                            <td>Development Lead</td>
                                            <td>New York</td>
                                            <td>30</td>
                                            <td>2011/09/03</td>
                                            <td>$345,000</td>
                                        </tr>
                                        <tr>
                                            <td>Yuri Berry</td>
                                            <td>Chief Marketing Officer (CMO)</td>
                                            <td>New York</td>
                                            <td>40</td>
                                            <td>2009/06/25</td>
                                            <td>$675,000</td>
                                        </tr>
                                         
                                        <tr>
                                            <td>Gavin Joyce</td>
                                            <td>Developer</td>
                                            <td>Edinburgh</td>
                                            <td>42</td>
                                            <td>2010/12/22</td>
                                            <td>$92,575</td>
                                        </tr>
                                        <tr>
                                            <td>Jennifer Chang</td>
                                            <td>Regional Director</td>
                                            <td>Singapore</td>
                                            <td>28</td>
                                            <td>2010/11/14</td>
                                            <td>$357,650</td>
                                        </tr>
                                        <tr>
                                            <td>Brenden Wagner</td>
                                            <td>Software Engineer</td>
                                            <td>San Francisco</td>
                                            <td>28</td>
                                            <td>2011/06/07</td>
                                            <td>$206,850</td>
                                        </tr>
                                        <tr>
                                            <td>Fiona Green</td>
                                            <td>Chief Operating Officer (COO)</td>
                                            <td>San Francisco</td>
                                            <td>48</td>
                                            <td>2010/03/11</td>
                                            <td>$850,000</td>
                                        </tr>
                                               
                                        <tr>
                                            <td>Donna Snider</td>
                                            <td>Customer Support</td>
                                            <td>New York</td>
                                            <td>27</td>
                                            <td>2011/01/25</td>
                                            <td>$112,000</td>
                                        </tr>
                                    </tbody>
                                </table>
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



    
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>