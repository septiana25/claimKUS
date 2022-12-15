var tabelClaim;

$(document).ready(function() {
	var divRequest = $(".div-request").text();
	$('#activeClaim').addClass('active');//active menu

	//autocomplite
	$("#approveKerusakan").keyup(function() {
		$.ajax({
			url : "action/claim/fetchSelectKerusakan.php",
			type: "POST",
			data : "cari="+$(this).val(),
			beforeSend:function(){
				$("#approveKerusakan").css("background","#FFF url(LoaderIcon.gif) no-repeat 370px");
			},
			success:function(data){
				$("#suggesstion-box").show();
				$("#suggesstion-box").html(data);
				$("#approveKerusakan").css("background", "#FFF");
			}
		});
	});


	$('.datepicker').datepicker();

	if (divRequest == 'dataClaim') {
		$('#activeDataClaim').addClass('active');//active sub menu

		tabelClaim = $('#tabelClaim').DataTable({
			'ajax' : 'action/claim/fetchClaim.php',
			'order':[]
		});//manage TableClaim
	}else if(divRequest == 'Nota') {
		$('#activeDataClaim').addClass('active');//active sub menu
		
		var hiddenBtn = $(".hiddenBtn").text();
		if (hiddenBtn == 'hiddenBtn') {
			$("#simpanNotaBtn").addClass('hidden');
			alert('Nota Sudah Di Buat. Untuk Print Ulang Di Menu Nota Penggantian Atau Nota Tolakan');
			window.location.href="notaPenggantian.php";
		}

		$("#submitNota").unbind('submit').bind('submit', function() {
			var noReg = $( "#noReg" ).val();
			var toko = $( "#toko" ).val();
			var totalID = $( "#totalID" ).val();

			if (toko == "") {
				$("#toko").after('<span class="error help-inline">Nama Toko Masih Kosong</span>');
				$("#toko").closest('#toko').addClass('error');
			}else{
				$("#toko").closest('.control-group').addClass('success');
				$("#toko").find('.error .help-inline').remove();				
			}
/*			var noCM = document.getElementsByName('noCM[]');
			var validateNoCM;
				// alert(noCM);
			for (var x = 0; x < noCM.length; x++) {
				var productNameId = noCM[x].id;
				alert("tes "+productNameId);
			}
*/

			// if (noReg == "") {
			// 	$("#noReg").after('<span class="error help-inline">No Register Masih Kosong</span>');
			// 	$("#noReg").closest('#noReg').addClass('error');
			// }else{
			// 	$("#noReg").closest('#noReg').addClass('success');
			// 	$("#noReg").find('.error .help-inline').remove();
			// }

			if (toko) {
				//ambil data form
				var form = $(this);
				//button loading
				$("#simpanNotaBtn").button('loading');

				$.ajax({
					url  : form.attr('action'),
					type : form.attr('method'),
					data : form.serialize(),
					dataType: 'json',
					success:function(response){
						$("#simpanNotaBtn").button('reset');//button reset ketika success

						if (response.success == true) {
							$("#simpanNotaBtn").addClass('hidden');
							// $("#printNotaBtn").removeClass('hidden');
							// 
							
							$(".print").html('<a href="" role="button" class="btn btn-success tambah"'+
							'onclick="printPenggantian('+response.idNota+')"> <i class="fa fa-print"></i> Print</a>');

							var unique_id = $.gritter.add({
					            // (string | mandatory) the heading of the notification
					            title: 'Pesan Success!',
					            // (string | mandatory) the text inside the notification
					            text: response.messages,
					            // (string | optional) the image to display on the left
					            image: 'img/success-mini.png',
					            // (bool | optional) if you want it to fade out on its own or just sit there
					            sticky: true,
					            // (int | optional) the time you want it to be alive for before fading out
					            time: '',
					            // (string | optional) the class name you want to apply to that specific message
					            class_name: 'my-sticky-class'
					        });

					        // You can have it return a unique id, this can be used to manually remove it later using
					        
					         setTimeout(function(){

						         $.gritter.remove(unique_id, {
						         fade: true,
						         speed: 'slow'
						         });

					         }, 6000)
						}else if (response.success == false){
						var unique_id = $.gritter.add({
				            // (string | mandatory) the heading of the notification
				            title: 'Pesan Error!',
				            // (string | mandatory) the text inside the notification
				            text: response.messages,
				            // (string | optional) the image to display on the left
				            image: 'img/error-mini.png',
				            // (bool | optional) if you want it to fade out on its own or just sit there
				            sticky: true,
				            // (int | optional) the time you want it to be alive for before fading out
				            time: '',
				            // (string | optional) the class name you want to apply to that specific message
				            class_name: 'gritter-light'
				        });
						}else if (response.success == 'cek_nota'){

						}
					}
				});

			}
			return false;
		});
	}

});

function printPenggantian(idNota = null){
	if (idNota) {
		$.ajax({
			url  : 'action/claim/printNota.php',
			type : 'POST',
			data : {idNota: idNota},
			dataType : 'text',
			success:function(response){
				var mywindow = window.open('', 'Apliksai Inventori Gudang KTA', 'height=400,width=600');
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
	}else{
		alert('Nota Tidak Bisa Di Print');
	}
}

function approveClaim(id_claim = null){
	if (id_claim) {
		// alert(id_claim);
		// 
		//hapus input editIdClaim
		$( '#approveIdClaim' ).remove();

		// reset the form text
		$( "#submitApproveClaim" )[0].reset();

		//modal footer
		$( ".modal-footer" ).addClass('div-hide');

		// modal spinner
		$('.modal-loading').removeClass('div-hide');

		$.ajax({
			url : 'action/claim/fetchSelectedClaim.php',
			type: 'post',
			data: {id_claim : id_claim},
			dataType: 'json',
			success:function(response){

				// modal spinner
				$('.modal-loading').addClass('div-hide');

				//unhide modal footer 
				$('.modal-footer').removeClass('div-hide');

				//isi input toko
				$('#approveToko').val(response.toko);

				//isi input ukuran
				$('#approveUkuran').val(response.brg);

				//isi input no Seri
				$('#approveNoSeri').val(response.pattern+'-'+response.dot);

				//isi input kerusakan
				if (response.kerusakan == '-') {
					$('#approveKerusakan').val('');
				}else{
					$('#approveKerusakan').val(response.kerusakan);
				}

				//isi input keputusan
				$('#approveKeputusan').val(response.keputusan);

				// //isi input keputusan
				// if (response.tread == '0') {
				// 	$('#editTread').val('');
				// }else{
				// 	$('#editTread').val(response.tread);
				// }

				//isi input nomonal
				if (response.keputusan == 'Proses') {
					$('#nominalPusat').val('');
				}else{
					$('#nominalPusat').val(response.nominal);
				}

				if (response.keputusan == 'Proses') {
					$('#approveNominal').val('');
				}else{
					$('#approveNominal').val(response.nominal);
				}

				//tambaha input id_claim
				$(".modal-footer").after('<input type="hidden" name="approveIdClaim" id="approveIdClaim" value="'+response.id_claim+'" />');

				$('#submitApproveClaim').unbind('submit').bind('submit', function() {

					var approveKerusakan = $('#approveKerusakan').val();
					var approveKeputusan = $('#approveKeputusan').val();
					// var editTread     = $('#editTread').val();
					var nominalPusat     = $('#nominalPusat').val();
					var approveNominal   = $('#approveNominal').val();

					if (approveKerusakan == '') {
						$("#approveKerusakan").after('<span class="help-inline">Kerusakan Masih Kosong</span>');
						$("#approveKerusakan").closest('.control-group').addClass('error');
					}else{
						$("#approveKerusakan").closest('.control-group').addClass('success');
						$(".help-inline").remove();
					}

					if (approveKeputusan == '') {
						$("#approveKeputusan").after('<span class="help-inline">Keputusan Masih Kosong</span>');
						$("#approveKeputusan").closest('.control-group').addClass('error');
					}else{
						$("#approveKeputusan").closest('.control-group').addClass('success');
						$(".help-inline").remove();
					}

					// if (editTread == '') {
					// 	$("#editTread").after('<span class="help-inline">Tread Dept Masih Kosong</span>');
					// 	$("#editTread").closest('.control-group').addClass('error');
					// }else{
					// 	$("#editTread").closest('.control-group').addClass('success');
					// 	$(".help-inline").remove();
					// }

					if (nominalPusat == '') {
						$("#nominalPusat").after('<span class="help-inline">Nominal Pertama Masih Kosong</span>');
						$("#nominalPusat").closest('.control-group').addClass('error');
					}else{
						$("#nominalPusat").closest('.control-group').addClass('success');
						$(".help-inline").remove();
					}

					if (approveNominal == '') {
						$("#approveNominal").after('<span class="help-inline">Nominal Masih Kosong</span>');
						$("#approveNominal").closest('.control-group').addClass('error');
					}else{
						$("#approveNominal").closest('.control-group').addClass('success');
						$(".help-inline").remove();
					}

					if ( approveKerusakan && approveKeputusan && nominalPusat && approveNominal ) {
						//ambil data form
						var form = $(this);

						$('#simpanApproveClaimBtn').button('loading');

						$.ajax({
							url : form.attr('action'),
							type: form.attr('method'),
							data: form.serialize(),
							dataType: 'json',
							success:function(response){
								$('#simpanApproveClaimBtn').button('reset');

								if (response.success == true) {
									tabelClaim.ajax.reload(null, false);

									$(".help-inline").remove();
									//remove the form error
									$(".control-group").removeClass('error').removeClass('success');
									//show messages pesan
									$('#approve-pesan').html('<div class="alert alert-success">'+
									'<button class="close" data-dismiss="alert">×</button>'+
									response.messages+'</div>');
									//fungsi tampil pesan delay
									$(".alert-success").delay(500).show(10, function() {
										$(this).delay(4000).hide(10, function() {
											$(this).remove();
										});
									});
								}else{
									//remove the error text
									$(".help-inline").remove();
									//remove the form error
									$(".control-group").removeClass('error').removeClass('success');
									//show messages pesan
									$('#approve-pesan').html('<div class="alert alert-error">'+
										'<button class="close" data-dismiss="alert">×</button>'+
										response.messages+'</div>');
								}

							}
						});
					}

					return false;
				});
			
			}
		});		
	}else{
		alert('Oops!! Refresh the page');
	}
}


function editClaim(id_claim = null){
	if (id_claim) {
		// alert(id_claim);
		//hapus input editIdClaim
		$( '#editIdClaim' ).remove();
		// reset the form text
		$( "#submitEditClaim" )[0].reset();
		//modal footer
		$( ".modal-footer" ).addClass('div-hide');

		// modal spinner
		$('.modal-loading').removeClass('div-hide');

		$.ajax({
			url : 'action/claim/fetchSelectedClaim.php',
			type: 'post',
			data: {id_claim : id_claim},
			dataType: 'json',
			success:function(response){

				// modal spinner
				$('.modal-loading').addClass('div-hide');

				//unhide modal footer 
				$('.modal-footer').removeClass('div-hide');

				//isi input toko
				$('#editToko').val(response.toko);

				//isi input ukuran
				$('#editUkuran').val(response.id_brg);

				//isi input no Pattern
				$('#editPattern').val(response.pattern);

				//isi input no Pattern
				$('#editDOT').val(response.dot);

				//isi input no Pattern
				$('#editTahun').val(response.jenis_claim);

				//tambaha input id_claim
				$(".modal-footer").after('<input type="hidden" name="editIdClaim" id="editIdClaim" value="'+response.id_claim+'" />');

				$('#submitEditClaim').unbind('submit').bind('submit', function() {

					var editToko    = $('#editToko').val();
					var editUkuran  = $('#editUkuran').val();
					var editPattern = $('#editPattern').val();
					var editDOT     = $('#editDOT').val();
					var editTahun   = $('#editTahun').val();

					if (editToko == '') {
						$("#editToko").after('<span class="help-inline">Toko Masih Kosong</span>');
						$("#editToko").closest('.control-group').addClass('error');
					}else{
						$("#editToko").closest('.control-group').addClass('success');
						$(".help-inline").remove();
					}

					if (editUkuran == '') {
						$("#editUkuran").after('<span class="help-inline">Ukuran Masih Kosong</span>');
						$("#editUkuran").closest('.control-group').addClass('error');
					}else{
						$("#editUkuran").closest('.control-group').addClass('success');
						$(".help-inline").remove();
					}

					if (editPattern == '') {
						$("#editPattern").after('<span class="help-inline">Pattern Masih Kosong</span>');
						$("#editPattern").closest('.control-group').addClass('error');
					}else{
						$("#editPattern").closest('.control-group').addClass('success');
						$(".help-inline").remove();
					}

					if (editDOT == '') {
						$("#editDOT").after('<span class="help-inline">DOT Masih Kosong</span>');
						$("#editDOT").closest('.control-group').addClass('error');
					}else{
						$("#editDOT").closest('.control-group').addClass('success');
						$(".help-inline").remove();
					}

					if (editTahun == '') {
						$("#editTahun").after('<span class="help-inline">Tahun Masih Kosong</span>');
						$("#editTahun").closest('.control-group').addClass('error');
					}else{
						$("#editTahun").closest('.control-group').addClass('success');
						$(".help-inline").remove();
					}

					if ( editToko && editUkuran && editPattern &&  editDOT && editTahun ) {
						//ambil data form
						var form = $(this);

						$('#simpanEditClaimBtn').button('loading');

						$.ajax({
							url : form.attr('action'),
							type: form.attr('method'),
							data: form.serialize(),
							dataType: 'json',
							success:function(response){
								$('#simpanEditClaimBtn').button('reset');

								if (response.success == true) {
									tabelClaim.ajax.reload(null, false);

									$(".help-inline").remove();
									//remove the form error
									$(".control-group").removeClass('error').removeClass('success');
									//show messages pesan
									$('#edit-pesan').html('<div class="alert alert-success">'+
									'<button class="close" data-dismiss="alert">×</button>'+
									response.messages+'</div>');
									//fungsi tampil pesan delay
									$(".alert-success").delay(500).show(10, function() {
										$(this).delay(4000).hide(10, function() {
											$(this).remove();
										});
									});
								}else{
									//remove the error text
									$(".help-inline").remove();
									//remove the form error
									$(".control-group").removeClass('error').removeClass('success');
									//show messages pesan
									$('#edit-pesan').html('<div class="alert alert-error">'+
										'<button class="close" data-dismiss="alert">×</button>'+
										response.messages+'</div>');
								}

							}
						});
					}

					return false;
				});
			
			}
		});		
	}else{
		alert('Oops!! Refresh the page');
	}
}



function hapusClaim(id_claim = null){
	if (id_claim) {
		$.ajax({
			url : 'action/claim/fetchSelectedClaim.php',
			type: 'post',
			data: {id_claim: id_claim},
			dataType:'json',
			success:function(response){
				$(".modal-footer").removeClass('div-hide');	
				$("#pesanHapus").html('<strong>Yakin Ingin Menghapus Nomor Urut : '+response.no_urut+'?</strong>');

				$('#hapusClaimBtn').unbind('click').bind('click', function() {
					$.ajax({
						url : 'action/claim/hapusClaim.php',
						type: 'post',
						data: {id_claim: id_claim},
						dataType:'json',
						success:function(response){
							if (response.success == true) {
								$('#hapusModalClaim').modal('hide');

								tabelClaim.ajax.reload(null, false);

								var unique_id = $.gritter.add({
						            // (string | mandatory) the heading of the notification
						            title: 'Pesan Success!',
						            // (string | mandatory) the text inside the notification
						            text: response.messages,
						            // (string | optional) the image to display on the left
						            image: 'img/success-mini.png',
						            // (bool | optional) if you want it to fade out on its own or just sit there
						            sticky: true,
						            // (int | optional) the time you want it to be alive for before fading out
						            time: '',
						            // (string | optional) the class name you want to apply to that specific message
						            class_name: 'my-sticky-class'
						        });

						        // You can have it return a unique id, this can be used to manually remove it later using
						        
						         setTimeout(function(){

							         $.gritter.remove(unique_id, {
							         fade: true,
							         speed: 'slow'
							         });

						         }, 6000)	
							}else{
								$('#hapusModalClaim').modal('hide');

								var unique_id = $.gritter.add({
						            // (string | mandatory) the heading of the notification
						            title: 'Pesan Error!',
						            // (string | mandatory) the text inside the notification
						            text: response.messages,
						            // (string | optional) the image to display on the left
						            image: 'img/error-mini.png',
						            // (bool | optional) if you want it to fade out on its own or just sit there
						            sticky: true,
						            // (int | optional) the time you want it to be alive for before fading out
						            time: '',
						            // (string | optional) the class name you want to apply to that specific message
						            class_name: 'gritter-light'
						        });	

							}
						}
					});
				});
			} 
		});
	}else{
		alert('Oops!! Refresh the page');
	}
}

function laporanProses(){
	$('#submitLaporanProses').unbind('submit').bind('submit', function() {
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
			//ambil data form
			var form = $(this);
			//button lodiang
			$("#laporanProsesBtn").button('loading');

			$.ajax({
				url  : form.attr('action'),
				type : form.attr('method'),
				data : form.serialize(),
				dataType: 'text',
				success:function(response){
					$("#laporanProsesBtn").button('reset');

					var mywindow = window.open('', 'Laporan Proses', 'height=380,width=700');
					mywindow.document.write(response);
				}


			});
		}

		return false;
	});
}


function HurufBesar(a){
	setTimeout(function() {
		a.value = a.value.toUpperCase();
	}, 1);
}

function validAngka(a)
{
	if (!/^[0-9.]+$/.test(a.value))
	{
		a.value = a.value.substring(0,a.value.length-1000);
	}
}

//function autcomplite
function selectKers(val){
	$("#approveKerusakan").val(val);
	$("#suggesstion-box").hide();
}

