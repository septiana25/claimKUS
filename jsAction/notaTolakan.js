var tableNotaTolakan;
$(document).ready(function() {
	var divRequest = $(".div-request").text();
	$('#activeClaim').addClass('active');

	tableNotaTolakan = $('#tableNotaTolakan').DataTable({
		'ajax' : 'action/claim/fetchNotaTolakan.php',
		'order': []
	});

	if (divRequest == 'notaTolakan') {
		$('#activeNotaTolakan').addClass('active');

		$("#submitPrintNota").unbind('submit').bind('submit', function() {

			var toko      = $("#toko").val();
			var keputusan = $("#keputusan").val();
			var idNota    = $("#idNota").val();

			if (toko == '' || keputusan == '' || idNota == '') {
				alert('Lakukan Reload Halaman tekan F5');
			}

			if (toko && keputusan && idNota) {
				//ambil data form
				var form = $(this);
				//loading button print
				$("#printNotaBtn").button('loading');

				$.ajax({
					url  : form.attr('action'),
					type : form.attr('method'),
					data : form.serialize(),
					dataType : 'text',
					success:function(response){
						//reset button print
						$("#printNotaBtn").button('reset');

						var mywindow = window.open('', 'Apliksai Inventori Gudang KTA', 'height=400, width=600');
						mywindow.document.write('<html><head>');
						mywindow.document.write('</head><body>');
						mywindow.document.write(response);
						mywindow.document.write('</body></html>');

						mywindow.document.close();// necessary for IE >= 10
						mywindow.focus();// necessary for IE >= 10

						mywindow.print();
						mywindow.close();						
					}
				});
			}

			return false;
		});

	}
});

/*function printPenggantian(idNota = null){
	if (idNota) {
		$.ajax({
			url  : 'action/claim/printNota.php',
			type : 'POST',
			data : {idNota: idNota},
			dataType : 'text',
			success:function(response){
				var mywindow = window.open('', 'Apliksai Inventori Gudang KTA', 'height=400, width=600');
				mywindow.document.write('<html><head>');
				mywindow.document.write('</head><body>');
				mywindow.document.write(response);
				mywindow.document.write('</body></html>');

				mywindow.document.close();// necessary for IE >= 10
				mywindow.focus();// necessary for IE >= 10

				mywindow.print();
				mywindow.close();
			}
		});
	}
}*/

function lihatData(idNota = null){
	if (idNota) {
		// modal spinner
		$('.modal-loading').removeClass('div-hide');
		$.ajax({
		url : 'action/claim/fetchLihatNota.php',
		type: 'post',
		data: {idNota: idNota},
		dataType: 'json',
		success:function(response) {
			$('#toko').val(response.toko);
			$('#keputusan').val(response.keputusan);
			$('#idNota').val(idNota);
			
			// modal spinner
			$('.modal-loading').addClass('div-hide');
			$("#printNotaBtn").removeClass('hidden');

			var tabelNota;
			tabelNota = $('#tableNotaTolak').DataTable({
				'ajax' : {
					'url' : 'action/claim/fetchTableLihatNota.php',
					'type': 'POST',
					'data': {idNota: idNota},
					// 'dataType': 'json'
				},
				'order': [],
				// 'displayLength' : 25,
				// 'searching' : false,
				'paging' 	: false,
				'ordering'	: false,

			}); 

			tabelNota.destroy();// hapus isi table
		}
		});
	}else{
		alert('Oops! Reload this page');
	}
}