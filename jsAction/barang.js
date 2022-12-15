var tabel;
$(document).ready(function() {
	$(".choiceChosen, .productChosen").chosen();
	//mengambil data div class div-request
	var divRequest = $(".div-request").text();
	// active manu barang
	$('#activeMaster').addClass('active');
	
	if (divRequest == 'barang') {
		// active submenu barang masuk
		$('#activeBarang').addClass('active');

		tabel = $('#tabelBarang').DataTable({
		'ajax' : 'action/barang/fetchBarang.php',
		'order':[]
	});// manage TabelMasuk

	$('#addBarangBtnModal').unbind('click').bind('click', function() {

	$('#submitBarang').unbind('submit').bind('submit', function() {

		var kategori = $("#kategori").val();
		var barang = $("#barang").val();

		if (kategori == "") {
			$("#kategori").after('<span class="help-inline">Kategori Masih Kosong</span>');
			$("#kategori").closest('.control-group').addClass('error');
		}else{
			$("#kategori").closest('.control-group').addClass('success');
			$(".help-inline").remove();
		}
		if (barang == "") {
			$("#barang").after('<span class="help-inline">Nama Barang Masih Kosong</span>');
			$("#barang").closest('.control-group').addClass('error');
		}else{
			$("#barang").closest('.control-group').addClass('success');
			
		}
		
		if (kategori && barang) {
			//ambil data form
			var form = $(this);
			//button loading
			$("#simpanBarangBtn").button('loading');

			$.ajax({
				url : form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {

					$("#simpanBarangBtn").button('reset');

					if (response.success == true) {

						tabel.ajax.reload(null, false);

						//reset the form text
						$("#submitBarang")[0].reset();
						//remove the error text
						$(".help-inline").remove();
						//
						$("#kategori").trigger("chosen:updated");
						//remove the form error
						$(".control-group").removeClass('error').removeClass('success');
						//show messages pesan
						$('#pesan').html('<div class="alert alert-success">'+
							'<button class="close" data-dismiss="alert">×</button>'+
							response.messages+'</div>');
						//fungsi tampil pesan delay
						$(".alert-success").delay(500).show(10, function() {
							$(this).delay(4000).hide(10, function() {
								$(this).remove();
							});
						});
					}
					if (response.success == false) {
						//remove the error text
						$(".help-inline").remove();
						//remove the form error
						$(".control-group").removeClass('error').removeClass('success');
						//show messages pesan
						$('#pesan').html('<div class="alert alert-error">'+
							'<button class="close" data-dismiss="alert">×</button>'+
							response.messages+'</div>');
					}
					if (response.success == 'cek_brg') {
						//remove the error text
						$(".help-inline").remove();
						//remove the form error
						$(".control-group").removeClass('error').removeClass('success');

						$("#barang").closest('.control-group').addClass('error');
						//show messages pesan
						$('#pesan').html('<div class="alert alert-error">'+
							'<button class="close" data-dismiss="alert">×</button>'+
							response.messages+'</div>');
					}
				}
			});
		}

		return false;
	});//submit categories form function
	});//on click on submit barang form modal

	}
	
});// /document

// edit barang function
function editBarang(id_brg = null){
	// remove the added barang id 
	$('#editBarangId').remove();
	if (id_brg) {
		// remove the added barang id 
		$('#editBarangId').remove();
		// reset the form text
		$("#editBarangForm")[0].reset();
		//modal footer
		$(".modal-footer").addClass('div-hide');
		// reset the form group errro		
		$(".control-group").removeClass('error').removeClass('success');

		// // edit categories messages
		// $("#pesan").html("");
		
		$.ajax({
			url: 'action/barang/fetchSelectedBarang.php',
			type: 'post',
			data: {id_brg: id_brg},
			dataType: 'json',
			success:function(response) {
				// alert('tes');
				//modal footer
				$(".modal-footer").removeClass('div-hide');	
				// set the categories name
				$("#editKategori").val(response.id_kat);
				// set the barang status
				$("#editBarang").val(response.brg);
				// add the categories id
				$(".modal-footer").after('<input type="hidden" name="editBarangId" id="editBarangId" value="'+response.id_brg+'" />');
				$(".help-inline").remove();
				// submit of edit categories form
				$("#editBarangForm").unbind('submit').bind('submit', function() {
					var editKategori = $("#editKategori").val();
					var editBarang = $("#editBarang").val();

					if (editKategori == "") {
						$("#editKategori").after('<span class="help-inline">Kategori Masih Kosong</span>');
						$("#editKategori").closest('.control-group').addClass('error');
					}else{
						$("#editKategori").closest('.control-group').addClass('success');
						$(".help-inline").remove();
					}
					if (editBarang == "") {
						$("#editBarang").after('<span class="help-inline">Barang Masih Kosong</span>');
						$("#editBarang").closest('.control-group').addClass('error');
					}else{
						$("#editBarang").closest('.control-group').addClass('success');
						$(".help-inline").remove();
					}

					if (editKategori && editBarang) {
						//ambil data form
						var form = $(this);
						//button loading
						$("#editBarangBtn").button('loading');

						$.ajax({
							url : form.attr('action'),
							type: form.attr('method'),
							data: form.serialize(),
							dataType: 'json',
							success:function(response) {
								// button reset
								$("#editBarangBtn").button('reset');
								//jika berhasil disimpan
								if (response.success == true) {

									tabel.ajax.reload(null, false);

									//reset the form text
									//$("#editBarangForm")[0].reset();
									//remove the error text
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
								}
								//jika gagal disimpan
								if (response.success == false) {
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
				});// /submit of edit categories form
			}

		});

	} else {
		alert('Oops!! Refresh the page');
	}
}

function hapusBarang(id_brg = null){
	$.ajax({
			url: 'action/barang/fetchSelectedBarang.php',
			type: 'post',
			data: {id_brg: id_brg},
			dataType: 'json',
			success:function(response) {

				//modal footer
				$(".modal-footer").removeClass('div-hide');	
				// add the categories id
				$("#pesanHapus").html('<strong>Yakin Ingin Menghapus '+response.brg+'?</strong>');
				// remove categories btn clicked to remove the categories function
				$("#hapusBarangBtn").unbind('click').bind('click', function() {
					// remove categories btn
					$("#hapusBarangBtn").button('loading');

					$.ajax({
					url: 'action/barang/hapusBarang.php',
					type: 'post',
					data: {id_brg: id_brg},
					dataType: 'json',
					success:function(response) {
						
						if (response.success == 'cek_brg') {
							tabel.ajax.reload(null, false);
							$("#hapusBarangBtn").button('reset');
							// close the modal 
							$("#hapusModalBarang").modal('hide');
							//show messages pesan
							/*$('#hapus-pesan').html('<div class="alert alert-error">'+
								'<button class="close" data-dismiss="alert">×</button>'+
								response.messages+'</div>');
							//fungsi tampil pesan delay
								$(".alert-error").delay(500).show(10, function() {
									$(this).delay(4000).hide(10, function() {
										$(this).remove();
									});
								});*/

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
						if (response.success == true) {
							tabel.ajax.reload(null, false);
							$("#hapusBarangBtn").button('reset');
							// close the modal 
							$("#hapusModalBarang").modal('hide');
							//show messages pesan
							/*$('#hapus-pesan').html('<div class="alert alert-success">'+
								'<button class="close" data-dismiss="alert">×</button>'+
								response.messages+'</div>');
							//fungsi tampil pesan delay
							$(".alert-success").delay(500).show(10, function() {
								$(this).delay(4000).hide(10, function() {
									$(this).remove();
								});
							});*/
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
						}if (response.success == false){
							$("#hapusBarangBtn").button('reset');
							// close the modal 
							$("#hapusModalBarang").modal('hide');
							//show messages pesan
							/*$('#hapus-pesan').html('<div class="alert alert-error">'+
								'<button class="close" data-dismiss="alert">×</button>'+
								response.messages+'</div>');
							//fungsi tampil pesan delay
								$(".alert-error").delay(500).show(10, function() {
									$(this).delay(4000).hide(10, function() {
										$(this).remove();
									});
								});*/
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
}

function upperCaseF(a){
  setTimeout(function(){
      a.value = a.value.toUpperCase();
  }, 1);
}