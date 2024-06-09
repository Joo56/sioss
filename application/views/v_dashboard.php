<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	 
	<title>TESTING</title>
	<!-- icon -->
	<link href="assetbaru/css/sb-admin-2.min.css" rel="stylesheet" >
	<link href="assetbaru/css/bootstrap-datetimepicker.css" rel="stylesheet">		
	<link href="assetbaru/css/bootstrap4.5.2.css" rel="stylesheet" >	
	<link href="assetbaru/css/dataTables.bootstrap4.css" rel="stylesheet" >	
	<link href="assetbaru/css/select2.min.css" rel="stylesheet" >	
	<link href="assetbaru/css/bootstrap-select.min.css" rel="stylesheet" >	
	<link href="assetbaru/css/style.css" type="text/css" rel="stylesheet">
	<link href="assetbaru/css/sweetalert2.min.css" rel="stylesheet">

</head>
<br>
<div id="loading" class='container d-none'>
  <div class='loader'>
    <div class='loader--dot'></div>
    <div class='loader--dot'></div>
    <div class='loader--dot'></div>
    <div class='loader--dot'></div>
    <div class='loader--dot'></div>
    <div class='loader--dot'></div>
    <div class='loader--text'></div>
  </div>
</div>
<div class="card-body">
	<form id="frmUpload" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-auto" style="width: 200px;">
				<label for="exampleFormControlFile1"><b>FILE DATA IZIN :</b></label>
				<input id="data_izin" name="data_izin" type="file" class="form-control-file" id="exampleFormControlFile1" required="required">
			</div>
			<div class="col-md-auto" style="width: 200px;">
				<label for="exampleFormControlFile1"><b>FILE DATA PROYEK :</b></label>
				<input id="data_proyek" name="data_proyek" type="file" class="form-control-file" id="exampleFormControlFile1" required="required">
			</div>
			<div class="col-md-3 pt-2">
				<button id="upload" type="button" name="upload" class="btn btn-primary btn-lg">Import</button>
			</div>
			<div class="col-md-2 ml-auto">
				<h4>UPDATE TERAKHIR :</h4><span><?= $update_data->tgl_pengajuan_proyek ?></span>
			</div>
		</div>
	</form>
	<hr>
	<form>
		<div class="row">
			<div class="form-group col-md-2">
				<label class="pl-2">KBLI</label>
				<select id="kbli" name="kbli[]" class="select2-multi form-control" multiple="multiple">
				<?php 
				foreach($kbli->result() AS $row){
				?>
					<option value="<?= $row->kbli ?>" data-foo="<?= $row->judul_kbli ?>"><?= $row->kbli ?></option>
				<?php			
				}
				?>
				</select>
			</div>
			<div class="form-group col-md-2">
				<label class="pl-2">RISIKO</label>
				<select id="risiko" name="risiko" class="select2 form-control" >
					<option value="" selected >&nbsp;</option>
					<option value="Rendah">Rendah</option>
					<option value="Menengah Rendah">Menengah Rendah</option>
					<option value="Menengah Tinggi">Menengah Tinggi</option>
					<option value="Tinggi">Tinggi</option>
				</select>
			</div>
			<div class="form-group col-md-auto mr-auto">
				<label class="w-100">&nbsp;</label>
				<button type="button" id="cari" class="btn btn-info form-control" name="cari" style="width:80px">CARI</button>
				<button type="button" id="btnreset" class="btn btn-secondary form-control" name="cari" style="width:80px">RESET</button>
			</div>
		</div>
	</form>
</div>
<div class="card-body">
	<table id="datatable" class="table table-bordered table-hover" style="width:100%">
	</table>
</div>
<script src="assetbaru/js/jquery-3.2.1.slim.min.js"></script>
<script src="assetbaru/js/jquery-3.7.1.js"></script>
<script src="assetbaru/js/sb-admin-2.min.js"></script>
<script src="assetbaru/js/popper.min.js"></script>
<script src="assetbaru/js/bootstrap4.5.2.min.js"></script>
<script src="assetbaru/js/dataTables.js"></script>
<script src="assetbaru/js/dataTables.bootstrap4.js"></script>
<script src="assetbaru/js/moment.js"></script>
<script src="assetbaru/js/id.js"></script>
<script src="assetbaru/js/bootstrap-datetimepicker.min.js"></script>
<script src="assetbaru/js/jquery.mask.min.js"></script>
<script src="assetbaru/js/jquery.validate.min.js"></script>
<script src="assetbaru/js/select2.min.js"></script>
<script src="assetbaru/js/bootstrap-select.min.js"></script>
<script src="assetbaru/js/sweetalert2.min.js"></script>
<script type="text/javascript" src="assetbaru/js/script.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	fetch_data();
	
	function fetch_data(kbli,risiko){
		var table = $('#datatable').DataTable({
			responsive: true,
			"ajax": {
				"type": "POST",
				"url": "dashboard/dataoss",
				"data":{"kbli":kbli,"risiko":risiko},
				// "timeout": 120000,
				"dataSrc": function (json) {
					if(json != null){
						return json
					} else {
						return "";
					}
				}
			},
			
			"sAjaxDataProp": "",
			// "destroy":true,
			"width": "100%",
			"order": [[ 0, "asc" ]],
			"aoColumns": [
				{
					"mData": null,
					"title": "NO",
					"width": "3%",
					"className": "text-center",
					render: function (data, type, row, meta) {
						return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
				{
					"mData": null,
					"title": "NIB",
					// "width": "3%",
					"className": "text-center",
					render: function (data, type, row, meta) {
						return data.nib;
					}
				},
				{
					"mData": null,
					"title": "TGL. TERBIS OSS",
					// "width": "3%",
					"className": "text-center",
					render: function (data, type, row, meta) {
						return data.tgl_terbit_oss;
					}
				},
				{
					"mData": null,
					"title": "NAMA PERUSAHAAN / NAMA PROYEK",
					// "width": "3%",
					"className": "text-left",
					render: function (data, type, row, meta) {
						return data.nama_perusahaan+" / "+data.nama_proyek+"<br><span class='text-muted'>"+data.alamat+"<br>"+data.jenis_usaha+"</span>";
					}
				},
				{
					"mData": null,
					"title": "RISIKO",
					// "width": "3%",
					"className": "text-center",
					render: function (data, type, row, meta) {
						return data.risiko_proyek;
					}
				},
				{
					"mData": null,
					"title": "KBLI",
					// "width": "3%",
					"className": "text-center",
					render: function (data, type, row, meta) {
						return data.kbli;
					}
				},
				{
					"mData": null,
					"title": "JUDUL KBLI",
					// "width": "3%",
					"className": "text-center",
					render: function (data, type, row, meta) {
						return data.judul_kbli;
					}
				},
				{
					"mData": null,
					"title": "NAMA DOKUMEN",
					// "width": "3%",
					"className": "text-center",
					render: function (data, type, row, meta) {
						return data.nama_dokumen;
					}
				},
				{
					"mData": null,
					"title": "TGL. IZIN",
					// "width": "3%",
					"className": "text-center",
					render: function (data, type, row, meta) {
						return data.tgl_izin;
					}
				},
				{
					"mData": null,
					"title": "STATUS",
					// "width": "3%",
					"className": "text-center",
					render: function (data, type, row, meta) {
						return data.status_respon;
					}
				},
					
			]
		});
		
	}
	
	$("#upload").on("click",function (event){
		var data_izin = $('#data_izin').prop('files')[0];   
		var data_proyek = $('#data_proyek').prop('files')[0];   
		var form_data_izin = new FormData();                                
		form_data_izin.append('data_izin', data_izin);
		form_data_izin.append('data_proyek', data_proyek);                             
		$.ajax({
			url: 'dashboard/upload', // <-- point to server-side PHP script 
			dataType: 'text',  // <-- what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			data: form_data_izin,                         
			type: 'post',
			beforeSend: function() {
				$(".container").removeClass('d-none');
			},
			success: function(e){
				$(".container").addClass('d-none');	
				console.log(e);
				var json = e,
				obj = JSON.parse(json);
				if(obj.succes == true){
					 swal({
						title: "Data berhasil disimpan!",
						text: "",
						type: "success",
					}).then(function()  {
						location.reload();
					});
				}else if(obj.succes == false){
					swal(obj.pesan,"","warning");
				}		
			}
		});
	});
	
	$('#btnreset').click(function(){
		$('#datatable').DataTable().destroy();
		$('select').val('').trigger("change");
		fetch_data();
	});
	
	$('#cari').click(function(){
		let kbli = $('#kbli').val();
		let risiko = $('#risiko').val();
		if(kbli != '' || risiko != ''){
			$('#datatable').DataTable().destroy();
			fetch_data(kbli,risiko);
		}
	})
});	
</script>
</html>