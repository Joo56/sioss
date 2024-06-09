<?php
class fungzie{
	function number_rupiah($nilai){
		return number_format($nilai,0,",",".");
	}
	
	function get_bulan($bln){
		$bulan = array(
			1 => 'Januari',
			2 => 'February',
			3 => 'Maret',
			4 => 'April',
			5 => 'Mei',
			6 => 'Juni',
			7 => 'Juli',
			8 => 'Agustus',
			9 => 'September',
			10 => 'Oktober',
			11 => 'November',
			12 => 'Desember'
		);
		return $bulan[$bln];
	}
	
	function formatHariTanggal($waktu){
		$hari_array = [
			'Minggu',
			'Senin',
			'Selasa',
			'Rabu',
			'Kamis',
			'Jumat',
			'Sabtu'
		];
 
		$hr = date('w', strtotime($waktu));
		$hari = $har_array[$hr];
 
		$tanggal = date('j', strtotime($waktu));
 
		$bulan_array = [
			1 => 'Januari',
			2 => 'February',
			3 => 'Maret',
			4 => 'April',
			5 => 'Mei',
			6 => 'Juni',
			7 => 'Juli',
			8 => 'Agustus',
			9 => 'September',
			10 => 'Oktober',
			11 => 'November',
			12 => 'Desember',
		];
 
		$bl = date('n', strtotime($waktu));
		$bulan = $bulan_array[$bl];
		$tahun = date('Y', strtotime($waktu));
 
		return "$hari, $tanggal, $bulan, $tahun";
	}
	
	function tanggal($tgl){
		$str = explode('-', $tgl);
		return $str[2]."-".$str[1]."-".$str[0];
	}
	
	function tanggalindo($waktu){
		$str = explode('-', $waktu);
		
		$bulan = array(
			'01' => 'Januari',
			'02' => 'Februari',
			'03' => 'Maret',
			'04' => 'April',
			'05' => 'Mei',
			'06' => 'Juni',
			'07' => 'Juli',
			'08' => 'Agustus',
			'09' => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'Desember'
		);	
		return $str[2]." ".$bulan[$str[1]]." ".$str[0];
	}
	
	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = $this->penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . $this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . $this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim($this->penyebut($nilai));
		} else {
			$hasil = trim($this->penyebut($nilai));
		}     		
		return $hasil;
	}
	
	/* NO_LAMA, KODE_DEPAN */
	function kode_otomatis($nomor, $kd_depan){	
		if($nomor < 9){
			$urut = $nomor + 1;
			$kd_lengkap = $kd_depan."0000".$urut;
		}elseif($nomor < 99){
			$urut = $nomor + 1;
			$kd_lengkap = $kd_depan."000".$urut;
		}elseif($nomor < 999){
			$urut = $nomor + 1;
			$kd_lengkap = $kd_depan."00".$urut;
		}elseif($nomor < 9999){
		$urut = $nomor + 1;
			$kd_lengkap = $kd_depan."0".$urut;
		}elseif($nomor < 99999){
			$urut = $nomor + 1;
			$kd_lengkap = $kd_depan."".$urut;
		}else{
			$kd_lengkap = $kd_depan."00001";
		}
		return $kd_lengkap;
	}
}
	
	
?>	