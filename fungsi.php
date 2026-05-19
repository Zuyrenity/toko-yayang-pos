<?php
/*---------------fungsi menampilkan tanggal dalam format indonesia	*/
function tanggal($tgl)
{
	$tanggal = substr($tgl,8,2);
	$bulan   = namabulan(substr($tgl,5,2));
	$tahun   = substr($tgl,0,4);
	if($tahun>0)
	{
		return $tanggal.' '.$bulan.' '.$tahun;
	}
	else
	{
		return "-";
	}
}

 


/*-------------fungsi nama bulan	*/
function namabulan($bl)
{
	if($bl=="01"){return "Januari";}elseif($bl=="02"){return "Februari";}elseif($bl=="03"){return "Maret";}elseif($bl=="04"){return "April";}elseif($bl=="05"){return "Mei";}elseif($bl=="06"){return "Juni";}elseif($bl=="07"){return "Juli";}elseif($bl=="08"){return "Agustus";}elseif($bl=="09"){return "September";}elseif($bl=="10"){return "Oktober";}elseif($bl=="11"){return "November";}elseif($bl=="12"){return "Desember";}
}

/*-----------fungsi format ribuan	*/
function rupiah($angka)
{
 	$rupiah = number_format($angka,0,',','.');
	return $rupiah;
}

/*------------fungsi menampilkan nama hari-------*/
function hari($d)
{
	switch($d)
	{
		case"Sunday":
			$hari="Minggu";
			break;
		case"Monday":
			$hari="Senin";
			break;
		case"Tuesday":
			$hari="Selasa";
			break;
		case"Wednesday":
			$hari="Rabu";
			break;
		case"Thursday":
			$hari="Kamis";
			break;
		case"Friday":
			$hari="Jumat";
			break;
		case"Saturday":
			$hari="Sabtu";
			break;
	}
	return $hari;
}



 




function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return $hasil;
	}	
	
	



?>