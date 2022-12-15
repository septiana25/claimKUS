var tabelLaporan;
$(document).ready(function() {

	//
	//var divRequest = $(".div-request").text();
	//export excel 
	var divRequest = $(".div-request").text();

	$('#activeLaporan').addClass('active');
	
	if (divRequest == "laporanKeluar") {
	$('#activeLaporanKeluar').addClass('active');
	$('#exportExcelBtn').unbind('click').bind('click', function() {
		var b = $("#bulan").val();
		var t = $("#tahun").val();

		if (b == "") {
			$("#bulan").after('<span class="help-inline">Bulan Masih Kosong</span>');
			$("#bulan").closest('.control-group').addClass('error');	
		}else{
			$(".help-inline").remove();
			$("#bulan").closest('.control-group').addClass('success');
		}
		if (t == "") {
			$("#tahun").after('<span class="help-inline">Tahun Masih Kosong</span>');
			$("#tahun").closest('.control-group').addClass('error');
		}else{
			$("#tahun").removeClass('help-inline');
			$("#tahun").closest('.control-group').addClass('success');
		}

		if (b && t) {
			var mywindow = window.open('action/laporan/exportexcel.php?b='+b+'&t='+t, 'Laporan Transaksi', '');
		}
	});	

	//export PDF
	$('#exportPDFBtn').unbind('click').bind('click', function() {
		var b = $("#bulan").val();
		var t = $("#tahun").val();

		if (b == "") {
			$("#bulan").after('<span class="help-inline">Bulan Masih Kosong</span>');
			$("#bulan").closest('.control-group').addClass('error');	
		}else{
			$(".help-inline").remove();
			$("#bulan").closest('.control-group').addClass('success');
		}
		if (t == "") {
			$("#tahun").after('<span class="help-inline">Tahun Masih Kosong</span>');
			$("#tahun").closest('.control-group').addClass('error');
		}else{
			$("#tahun").removeClass('help-inline');
			$("#tahun").closest('.control-group').addClass('success');
		}

		if (b && t) {
			var mywindow = window.open('action/laporan/exportPDF.php?b='+b+'&t='+t, 'Laporan Transaksi', '');
		}
	});
	$('#submitLaporan').unbind('submit').bind('submit', function() {
		var bulan = $("#bulan").val();
		var tahun = $("#tahun").val();

		if (bulan == "") {
			$("#bulan").after('<span class="help-inline">Bulan Masih Kosong</span>');
			$("#bulan").closest('.control-group').addClass('error');	
		}else{
			$(".help-inline").remove();
			$("#bulan").closest('.control-group').addClass('success');
		}
		if (tahun == "") {
			$("#tahun").after('<span class="help-inline">Tahun Masih Kosong</span>');
			$("#tahun").closest('.control-group').addClass('error');
		}else{
			$("#tahun").removeClass('help-inline');
			$("#tahun").closest('.control-group').addClass('success');
		}

		if (bulan && tahun) {
			var form = $(this);
			//
			$("#cariLaporanBtn").button('loading');
			//
			$.ajax({
				url: form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'text',
				success:function(response){
					//
					$("#cariLaporanBtn").button('reset');
		
					var mywindow = window.open('', 'Laporan Transaksi', 'height=380,width=700');
					mywindow.document.write(response);
				}
			});
		}
	return false;
	});
	}
	
});