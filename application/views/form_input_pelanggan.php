<?php
$token = md5(date('Y-m-d h:i:s') . $this->session->userdata('nipp'));
// print_r($kotakabu);
?>

<head>
	<META HTTP-EQUIV="refresh">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('template/dist/css/bootstrap-datepicker.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/typeahead/typeahead.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('template/vendor/confirm/jquery-confirm.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php //echo base_url('template/dist/css/bootstrap-datepicker3.standalone.min.css')
													?>">
	<!--Ini Css-->
	<!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" /> -->
	<!--Ini JS-->
	<!-- <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script> -->
	<link rel="stylesheet" href="<?php echo base_url('asset/leaflet/leaflet.css ') ?>" />
	<script src="<?php echo base_url('asset/leaflet/leaflet.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('template/dist/js/bootstrap-datepicker.min.js') ?>"></script>
	<script src="<?php echo base_url('asset/maskedinput/jquery.maskedinput.min.js') ?>"></script>
	<script src="<?php echo base_url('asset/validate/dist/jquery.validate.js') ?>"></script>
	<script src="<?php echo base_url('asset/typeahead/typeahead.bundle.js') ?>"></script>
	<script src="<?php echo base_url('asset/handlebars/handlebars-v4.0.5.js') ?>"></script>
	<script type="text/javascript">
		var npa = new Bloodhound({
			//datumTokenizer: function(d){ return Bloodhound.tokenizers.whitespace(d.npa);},
			datumTokenizer: Bloodhound.tokenizers.whitespace,
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: "<?php echo base_url('home/getNpa') ?>",
				prepare: function(query, settings) {
					settings.type = "POST";
					settings.data = {
						query: query
					};
					return settings;
				}
			}
		});


		function refmaps() {
			let lat, long;
			lat = $('#lat').val();
			long = $('#long').val();

			// var map = L.map('map', {
			// 	center: [1.69516, 98.8217, 12],
			// 	zoom: 25
			// });
			var map = L.map('map', {
				center: [lat, long],
				zoom: 25
			});

			// var marker = L.marker([1.69516, 98.8217, 13]).bindPopup('<b>Hello world!</b><br>I am a popup.').addTo(map);
			var marker = L.marker([lat, long, 13]).addTo(map);

			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
			}).addTo(map);
		}

		$(document).ready(function() {
			npa.initialize();
			$('#npa').typeahead(null, {
				name: 'npa',
				items: 5,
				displayKey: 'npa',
				source: npa, //.ttAdapter(),
				hint: true,
				templates: {
					empty: ['<div class="empty-message" align="center">', 'NPA tidak ditemukan', '</div>'].join('\n'),
					suggestion: function(data) {
						return '<div><strong>' + data.npa + ' -</strong> ' + data.na_ctm + '</div>'
					}
				}
			}).bind('typeahead:select', function(e, sugestion) {
				$('#npa_ctm').val(sugestion.npa);
				$('#na_ctm').val(sugestion.na_ctm);
				$('#notlp_ctm').val(sugestion.notelp_ctm);
				$('#nohp_ctm').val(sugestion.nohp_ctm);
				$('#email_ctm').val(sugestion.email_ctm);
				$('#noktp_ctm').val(sugestion.noktp_ctm);
				$('#na_pmlk').val(sugestion.na_pem);
				$('#notlp_pmlk').val(sugestion.notelp_pem);
				$('#nohp_pmlk').val(sugestion.nohp_pem);
				$('#email_pmlk').val(sugestion.email_pem);
				$('#noktp_pmlk').val(sugestion.noktp_pem);
				$('#na_pghn').val(sugestion.na_pen);
				$('#notlp_pghn').val(sugestion.notelp_pen);
				$('#nohp_pghn').val(sugestion.nohp_pen);
				$('#email_pghn').val(sugestion.email_pen);
				$('#noktp_pghn').val(sugestion.noktp_pen);
				$('#trf_ctm').val(sugestion.tarif);
				$('#almt_ctm').val(sugestion.alamat);
				$('#normh_ctm').val(sugestion.no_rmh);
				$('#kbptn').val(sugestion.kabu);
				$('#long').val(sugestion.longitude);
				$('#lat').val(sugestion.latitude);
				$('#lbang_ctm').val(sugestion.luas);
				$('#ketush_ctm').val(sugestion.usaha_ket);
				if (sugestion.usaha_persil === 'ada') {
					$('#ketush').removeAttr('hidden');
					$("input[name=kegush_ctm][value=" + sugestion.usaha_persil + "]").attr('checked', true);
				} else {
					$("input[name=kegush_ctm][value=" + sugestion.usaha_persil + "]").attr('checked', true);
				}
				if (sugestion.usaha_skala === 'kecil') {
					$('#sklaush').removeAttr('hidden');
					$("input[name=sklaush_ctm][value=" + sugestion.usaha_skala + "]").attr('checked', true);
				} else if (sugestion.usaha_skala === 'sedang') {
					$('#sklaush').removeAttr('hidden');
					$("input[name=sklaush_ctm][value=" + sugestion.usaha_skala + "]").attr('checked', true);
				} else {
					$("input[name=sklaush_ctm][value=" + sugestion.usaha_skala + "]").attr('checked', true);
				}
				$('#kcmtn').append(`<option value="${sugestion.keca}" selected>
                                       ${sugestion.kecamatan}
                                  </option>`);
				// $('#klrhn').val(sugestion.kelu);
				$('#klrhn').append(`<option value="${sugestion.kelu}" selected>
                                       ${sugestion.kelurahan}
                                  </option>`);
				map.remove();
				$("#contmap").html("<div id='map'></div>");
				refmaps();
			});

			$('#submit').click(function() {
				$('#formInputPelanggan').validate({
					errorClass: "my-error-class",
					rules: {
						npa: {
							required: true,
						},
						npa_ctm: {
							required: true,
						},
						na_ctm: {
							required: true,
						},
						notlp_ctm: {
							required: true,
							number: true,
							maxlength: 13,
						},
						nohp_ctm: {
							required: true,
							number: true,
							maxlength: 13,
						},
						email_ctm: {
							required: true,
							email: true,
						},
						noktp_ctm: {
							required: true,
						},
						na_pmlk: {
							required: true,
						},
						notlp_pmlk: {
							required: true,
							number: true,
							maxlength: 13,
						},
						nohp_pmlk: {
							required: true,
							number: true,
							maxlength: 13,
						},
						email_pmlk: {
							required: true,
							email: true,
						},
						noktp_pmlk: {
							required: true,
						},
						na_pghn: {
							required: true,
						},
						notlp_pghn: {
							required: true,
							number: true,
							maxlength: 13,
						},
						nohp_pghn: {
							required: true,
							number: true,
							maxlength: 13,
						},
						email_pghn: {
							required: true,
							email: true,
						},
						noktp_pghn: {
							required: true,
						},
						almt_ctm: {
							required: true,
						},
						normh_ctm: {
							required: true,
						},
						kbptn: {
							required: true,
						},
						kcmtn: {
							required: true,
						},
						klrhn: {
							required: true,
						},
						trf_ctm: {
							required: true,
						},
						lbang_ctm: {
							required: true,
						},
						kegush_ctm: {
							required: true,
						},
						// ketush_ctm: {
						// 	required: true,
						// },
						// sklaush_ctm: {
						// 	required: true,
						// },
						// email:{
						//     required:true,
						//     email:true,
						// },
						// nohp: {
						// 	required: true,
						// 	number: true,
						// 	maxlength: 13,
						// },
					},

					messages: {
						npa: {
							required: "NPA tidak boleh kosong!",
						},
						npa_ctm: {
							required: "NPA tidak boleh kosong!",
						},
						na_ctm: {
							required: "Nama Pelanggan tidak boleh kosong!",
						},
						notlp_ctm: {
							required: "Nomor Telpon tidak boleh kosong!",
							number: "Silahkan input Angka saja dan jangan ada spasi.",
							maxlength: "Maksimum 13 digit",
						},
						nohp_ctm: {
							required: "Nomor HP tidak boleh kosong!",
							number: "Silahkan input Angka saja dan jangan ada spasi.",
							maxlength: "Maksimum 13 digit",
						},
						email_ctm: {
							required: "Email tidak boleh kosong!",
							email: "Input dengan format email!"
						},
						noktp_ctm: {
							required: "Nomor KTP tidak boleh kosong!",
						},
						na_pmlk: {
							required: "Nama Pemilik tidak boleh kosong!",
						},
						notlp_pmlk: {
							required: "Nomor Telpon tidak boleh kosong!",
							number: "Silahkan input Angka saja dan jangan ada spasi.",
							maxlength: "Maksimum 13 digit",
						},
						nohp_pmlk: {
							required: "Nomor HP tidak boleh kosong!",
							number: "Silahkan input Angka saja dan jangan ada spasi.",
							maxlength: "Maksimum 13 digit",
						},
						email_pmlk: {
							required: "Email tidak boleh kosong!",
							email: "Input dengan format email!"
						},
						noktp_pmlk: {
							required: "Nomor KTP tidak boleh kosong!",
						},
						na_pghn: {
							required: "Nama Penghuni tidak boleh kosong!",
						},
						notlp_pghn: {
							required: "Nomor Telpon tidak boleh kosong!",
							number: "Silahkan input Angka saja dan jangan ada spasi.",
							maxlength: "Maksimum 13 digit",
						},
						nohp_pghn: {
							required: "Nomor HP tidak boleh kosong!",
							number: "Silahkan input Angka saja dan jangan ada spasi.",
							maxlength: "Maksimum 13 digit",
						},
						email_pghn: {
							required: "Email tidak boleh kosong!",
							email: "Input dengan format email!"
						},
						noktp_pghn: {
							required: "Nomor KTP tidak boleh kosong!",
						},
						almt_ctm: {
							required: "Alamat tidak boleh kosong!",
						},
						normh_ctm: {
							required: "Nomor Rumah tidak boleh kosong!",
						},
						kbptn: {
							required: "Kabupaten/Kota tidak boleh kosong!",
						},
						kcmtn: {
							required: "Kecamatan tidak boleh kosong!",
						},
						klrhn: {
							required: "Kelurahan tidak boleh kosong!",
						},
						trf_ctm: {
							required: "Tarif tidak boleh kosong!",
						},
						lbang_ctm: {
							required: "Luas bangunan tidak boleh kosong!",
						},
						kegush_ctm: {
							required: "Kegiatan usaha tidak boleh kosong!",
						},
						// ketush_ctm: {
						// 	required: "Keterangan usaha tidak boleh kosong!",
						// },
						// sklaush_ctm: {
						// 	required: "Skala usaha tidak boleh kosong!",
						// },
						// cth::
						// email:{
						//     required:"Silahkan alamat email Pelanggan",
						//     email:"Silahkan input dengan format email!",
						// },
						// nohp: {
						// 	required: "Nomor harus diinput.",
						// 	number: "Silahkan input Angka saja dan jangan ada spasi.",
						// 	maxlength: "Maksimum 13 digit",
						// },
					},

					//fungsi submitHandler 
					//untuk menggabungkan jquery validate
					//dengan $.post
					submitHandler: function(form) {
						// $('#loader').show()
						$.post('<?php echo base_url() ?>home/inputPelanggan', $('#formInputPelanggan').serialize(), function(data) {
							$.alert({
								title: 'Perhatian!',
								// content: data,
								content: 'Data berhasil di input.',
								buttons: {
									ok: function() {
										window.location.reload();
										window.scrollTo(0, 0);
									},
								}
							});
						}).fail(function(xhr, status, error) {
							// alert(`status: \n${status}. \nerror: \n${error}. \nxhr: \n${xhr.responseText}.`);
							// alert(xhr.responseText);
							console.log(xhr);
							if (xhr.responseText.search("UNIQUE KEY") === '-1') {
								console.log(xhr);
								$.alert({
									title: 'Terjadi Kesalahan!',
									content: xhr.responseText,
								});
							} else {
								// confirm("Perbarui Data?");
								$.confirm({
									title: 'Perhatian!',
									content: 'Data sudah pernah diinput. Perbahrui data?',
									buttons: {
										ya: function() {
											$.post('<?php echo base_url() ?>home/updatePelanggan', $('#formInputPelanggan').serialize(), function(data) {
												$.alert({
													title: 'Perhatian!',
													content: data,
													buttons: {
														ok: function() {
															window.location.reload();
															window.scrollTo(0, 0);
														},
													}
												});
											}).fail(function(xhr, status, error) {
												// alert(`status: \n${status}. \nerror: \n${error}. \nxhr: \n${xhr.responseText}.`);
												// alert(xhr.responseText);
												$.alert({
													title: 'Terjadi Kesalahan!',
													content: xhr.responseText,
												});
												console.log(xhr);
											});
										},
										batal: function() {
											$.alert('Dibatalkan!');
										},
									}
								});

							}
						});
						// $.post('<?php //echo base_url() 
									?>home/inputPelanggan', $('#formInputPelanggan').serialize(), function(data, status) {
						// 	alert(data);
						// 	$.alert({
						// 		title: 'Alert!',
						// 		content: data,
						// 	});
						// }).fail(function(xhr, status, error) {
						// 	// error handling
						// 	alert(error);
						// }).done(function() {
						// 	alert('done');
						// });
						// $.post('<?php echo base_url() ?>home/inputPelanggan', $('#formInputPelanggan').serialize()).fail(function(xhr, status, error) {
						// 	// error handling
						// 	// alert(error);
						// 	$.alert({
						// 		title: 'Alert!',
						// 		content: error,
						// 	});
						// }).done(function() {
						// 	// alert('done');
						// 	$.alert({
						// 		title: 'Alert!',
						// 		content: 'Berhasil diinput',
						// 	});
						// });
					}
				});
				//validate closed
			});
			//submit closed
		});
	</script>
	<script type="text/javascript" src="<?php echo base_url('template/vendor/autonum/autoNumeric.js') ?>"></script>
	<script type="text/javascript">
		jQuery(function($) {
			$('#btotal').autoNumeric('init');
		});
	</script>
	<style type="text/css">
		.my-error-class {
			color: #FF0000;
			/* red */
		}

		#loader {
			display: none;
			position: fixed;
			z-index: 1000;
			top: 0;
			left: 0;
			height: 100%;
			width: 100%;
			background: rgba(255, 255, 255, .8) url('http://i.stack.imgur.com/FhHRx.gif') 50% 50% no-repeat;
		}

		#map {
			width: 960px;
			height: 500px;
		}
	</style>
</head>

<body>
	<div id="wrapper">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Menu Data Pelanggan</h1>
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<!-- /.row -->
		<?php echo validation_errors();
		?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<b>FORM DATA PELANGGAN</b>
					</div>
					<div class="panel-body">
						<?php //echo form_open('home/inputPelanggan'); 
						?>
						<form id="formInputPelanggan">
							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-info">
										<div class="panel-heading">
											A. DATA PELANGGAN
										</div>
										<div class="panel-body">
											<input type="hidden" class="form-control" name="my_token" id="my_token" value="<?php
																															echo $token;
																															?>" />

											<div class="row">
												<div class="col-lg-5">
													<label> Cari NPA</label>
													<div class="form-group input-group">
														<input class="form-control" type="text" name="npa" id="npa" placeholder="Input Kode NPA Disini.." value="<?php echo set_value('npa'); ?>">
														<span class="input-group-addon">
															<i class="fa fa-search"></i>
														</span>
													</div>
												</div>
											</div>
											<!-- /.row -->
											<div class="row">
												<div class="table-responsive">
													<table class="table table-striped table-hover">
														<tbody>
															<tr>
																<th>1.</th>
																<th>NPA</th>
																<td colspan="3"><input class="form-control" type="text" name="npa_ctm" id="npa_ctm" placeholder="Input NPA Disini.." value="<?php echo set_value('npa_ctm'); ?>"></td>
															</tr>
															<tr>
																<th>&nbsp;</th>
																<th>&nbsp;</th>
																<th>Pelanggan</th>
																<th>Pemilik</th>
																<th>Penghuni</th>
															</tr>
															<tr>
																<th>2.</th>
																<th>Nama</th>
																<td><input class="form-control" type="text" name="na_ctm" id="na_ctm" placeholder="Input Nama Pelanggan Disini.." value="<?php echo set_value('na_ctm'); ?>"></td>
																<td><input class="form-control" type="text" name="na_pmlk" id="na_pmlk" placeholder="Input Nama Pemilik Disini.." value="<?php echo set_value('na_pmlk'); ?>"></td>
																<td><input class="form-control" type="text" name="na_pghn" id="na_pghn" placeholder="Input Nama Penghuni Disini.." value="<?php echo set_value('na_pghn'); ?>"></td>
															</tr>
															<tr>
																<th>3.</th>
																<th>No. Telp</th>
																<td><input class="form-control" type="tel" name="notlp_ctm" id="notlp_ctm" placeholder="Input No. Telp Pelanggan Disini.." value="<?php echo set_value('notlp_Ctm'); ?>"></td>
																<td><input class="form-control" type="tel" name="notlp_pmlk" id="notlp_pmlk" placeholder="Input No. Telp Pemilik Disini.." value="<?php echo set_value('notlp_pmlk'); ?>"></td>
																<td><input class="form-control" type="tel" name="notlp_pghn" id="notlp_pghn" placeholder="Input No. Telp Penghuni Disini.." value="<?php echo set_value('notlp_pghn'); ?>"></td>
															</tr>
															<tr>
																<th>4.</th>
																<th>No. HP/WA</th>
																<td><input class="form-control" type="tel" name="nohp_ctm" id="nohp_ctm" placeholder="081212341234" pattern="[0]{1}[8]{1}" value="<?php echo set_value('nohp_ctm'); ?>"></td>
																<td><input class="form-control" type="tel" name="nohp_pmlk" id="nohp_pmlk" placeholder="081212341234" pattern="[0]{1}[8]{1}" value="<?php echo set_value('nohp_pmlk'); ?>"></td>
																<td><input class="form-control" type="tel" name="nohp_pghn" id="nohp_pghn" placeholder="081212341234" pattern="[0]{1}[8]{1}" value="<?php echo set_value('nohp_pghn'); ?>"></td>
															</tr>
															<tr>
																<th>5.</th>
																<th>Email</th>
																<td><input class="form-control" type="text" name="email_ctm" id="email_ctm" placeholder="Input Email Pelanggan Disini.." value="<?php echo set_value('email_ctm'); ?>"></td>
																<td><input class="form-control" type="text" name="email_pmlk" id="email_pmlk" placeholder="Input Email Pemilik Disini.." value="<?php echo set_value('email_pmlk'); ?>"></td>
																<td><input class="form-control" type="text" name="email_pghn" id="email_pghn" placeholder="Input Email Penghuni Disini.." value="<?php echo set_value('email_pghn'); ?>"></td>
															</tr>
															<tr>
																<th>6.</th>
																<th>No. KTP</th>
																<td><input class="form-control" type="text" name="noktp_ctm" id="noktp_ctm" placeholder="Input No. KTP Pelanggan Disini.." value="<?php echo set_value('noktp_ctm'); ?>"></td>
																<td><input class="form-control" type="text" name="noktp_pmlk" id="noktp_pmlk" placeholder="Input No. KTP Pemilik Disini.." value="<?php echo set_value('noktp_pmlk'); ?>"></td>
																<td><input class="form-control" type="text" name="noktp_pghn" id="noktp_pghn" placeholder="Input No. KTP Penghuni Disini.." value="<?php echo set_value('noktp_pghn'); ?>"></td>
															</tr>
															<tr>
																<th>7.</th>
																<th colspan="4">Alamat Sesuai NPA</th>
															</tr>
															<tr>
																<th>&nbsp;</th>
																<th>Jalan</th>
																<td><input class="form-control" type="text" name="almt_ctm" id="almt_ctm" placeholder="Input Data Jalan Disini.." value="<?php echo set_value('almt_ctm'); ?>"></td>
																<th>No. Rumah</th>
																<td><input class="form-control" type="text" name="normh_ctm" id="normh_ctm" placeholder="Input Data N Disini.." value="<?php echo set_value('normh_ctm'); ?>"></td>
															</tr>
															<tr>
																<th>&nbsp;</th>
																<th>Kabupaten/Kota</th>
																<td colspan="3">
																	<!-- <input class="form-control" type="text" name="klrhn_ctm" id="kbptn_ctm" placeholder="Input Data Jalan Disini.."> -->
																	<select class="form-control" id="kbptn" name="kbptn">
																		<option value="">-- Pilih --</option>
																		<?php foreach ($kotakabu as $kb) : ?>
																			<option value="<?php echo $kb->kd_kab; ?>" <?php echo $kb->kd_kab == $kotakabu ? 'selected' : ''; ?>><?php echo $kb->kabupaten; ?></option>
																		<?php endforeach; ?>
																	</select>
																</td>
															</tr>
															<tr>
																<th>&nbsp;</th>
																<th>Kecamatan</th>
																<td colspan="3">
																	<!-- <input class="form-control" type="text" name="kcmtn_ctm" id="kcmtn_ctm" placeholder="Input Data Jalan Disini.."> -->
																	<select class="form-control" id="kcmtn" name="kcmtn">
																		<option value="">-- Pilih --</option>
																	</select>
																	<div id="loading" style="margin-top: 15px;">
																		<img src="http://i.stack.imgur.com/FhHRx.gif" width="18"> <small>Loading...</small>
																	</div>
																</td>
															</tr>
															<tr>
																<th>&nbsp;</th>
																<th>Kelurahan</th>
																<td colspan="3">
																	<!-- <input class="form-control" type="text" name="klrhn_ctm" id="klrhn_ctm" placeholder="Input Data Jalan Disini.."> -->
																	<select class="form-control" id="klrhn" name="klrhn">
																		<option value="">-- Pilih --</option>
																	</select>
																	<div id="loading2" style="margin-top: 15px;">
																		<img src="http://i.stack.imgur.com/FhHRx.gif" width="18"> <small>Loading...</small>
																	</div>
																</td>
															</tr>
															<tr>
																<th>8.</th>
																<th colspan="4">Posisi Koordinat</th>
															</tr>
															<tr>
																<th>&nbsp;</th>
																<th>Longitude</th>
																<td><input class="form-control" type="text" name="long" id="long" placeholder="Input Data Longitude Disini.." value="<?php echo set_value('long_ctm'); ?>"></td>
																<td colspan="2"><button class="btn btn-info" name="btn-map" id="btn-map" type="button">Refresh Map</button></td>
															</tr>
															<tr>
																<th>&nbsp;</th>
																<th>Latitude</th>
																<td><input class="form-control" type="text" name="lat" id="lat" placeholder="Input Data Latitude Disini.." value="<?php echo set_value('lat_ctm'); ?>"></td>
																<td colspan="2">&nbsp;</td>
															</tr>
															<tr>
																<th>&nbsp;</th>
																<th>Map</th>
																<td colspan="3" id="contmap" name="contmap">
																	<div id="map" style="background-color: gray;"></div>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="panel panel-info">
										<div class="panel-heading">
											B. KONDISI TARIF
										</div>
										<div class="panel-body">
											<table class="table table-striped table-hover">
												<tbody>
													<tr>
														<th>1.</th>
														<th width="300px">Tarif Air Saat Ini</th>
														<td colspan="3"><input class="form-control" type="text" name="trf_ctm" id="trf_ctm" placeholder="Input Tarif Saat Ini Disini.." value="<?php echo set_value('trf_ctm'); ?>"></td>
													</tr>
													<tr>
														<th>2.</th>
														<th width="300px">Luas Bangunan</th>
														<td colspan="3"><input class="form-control" type="text" name="lbang_ctm" id="lbang_ctm" placeholder="Input Luas Bangunan Disini.." value="<?php echo set_value('lbang_ctm'); ?>"></td>
													</tr>
													<tr>
														<th>3.</th>
														<th width="300px">Kegiatan Usaha Pada Persil</th>
														<td>
															<div class="radio"><label for=""><input type="radio" name="kegush_ctm" id="kegush_ctm" value="ada">Ada</label></div>
														</td>
														<td colspan="2">
															<div class="radio"><label for=""><input type="radio" name="kegush_ctm" id="kegush_ctm" value="tidak_ada">Tidak Ada</label></div>
														</td>
													</tr>
													<tr id="ketush" hidden>
														<th>&nbsp;</th>
														<th>Jika ada, sebutkan</th>
														<td colspan='3'><input class="form-control" type="text" name="ketush_ctm" id="ketush_ctm" placeholder="Sebutkan Disini.." value="<?php echo set_value('ketush_ctm'); ?>"></td>
													</tr>
													<tr id="sklaush" hidden>
														<th>&nbsp;</th>
														<th>Skala Usaha</th>
														<td>
															<div class="radio"><label for=""><input type="radio" name="sklaush_ctm" id="sklaush_ctm" value="kecil" value="<?php echo set_value('sklaush_ctm'); ?>">Kecil</label></div>
														</td>
														<td>
															<div class="radio"><label for=""><input type="radio" name="sklaush_ctm" id="sklaush_ctm" value="sedang" value="<?php echo set_value('sklaush_ctm'); ?>">Sedang</label></div>
														</td>
														<td>
															<div class="radio"><label for=""><input type="radio" name="sklaush_ctm" id="sklaush_ctm" value="besar" value="<?php echo set_value('sklaush_ctm'); ?>">Besar</label></div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>

								<!-- <div class="col-lg-12">
								<div class="panel panel-info">
									<div class="panel-heading">
										C. DATA KONDISI AIR
									</div>
									<div class="panel-body">
										<table class="table table-striped table-hover">
											<tbody>
												<tr>
													<th>1.</th>
													<th>Lancar</th>
													<td>
														&nbsp;
													</td>
													<td colspan="2">
														<div class="radio"><label for=""><input type="radio" name="kndsiair_ctm" id="kndsiair_ctm" value="lancar">Ya</label></div>
													</td>
												</tr>
												<tr>
													<th>2.</th>
													<th>Tidak Lancar</th>
													<td>
														Hidup pagi saja ( jam <input class="form-control" name="mlihdp[]" id="mlihdp[]" style="width:100px;display:inline" type="time"> sd <input class="form-control" name="slshdp[]" id="slshdp[]" style="width:100px;display:inline" type="time"> )
													</td>
													<td colspan="2">
														<div class="radio"><label for=""><input type="radio" name="kndsiair_ctm" id="kndsiair_ctm" value="tlancar1">Tidak Ada</label></div>
													</td>
												</tr>
												<tr>
													<th>&nbsp;</th>
													<th>&nbsp;</th>
													<td>
														Hidup siang saja ( jam <input class="form-control" name="mlihdp[]" id="mlihdp[]" style="width:100px;display:inline" type="time"> sd <input class="form-control" name="slshdp[]" id="slshdp[]" style="width:100px;display:inline" type="time"> )
													</td>
													<td colspan="2">
														<div class="radio"><label for=""><input type="radio" name="kndsiair_ctm" id="kndsiair_ctm" value="tlancar2">Tidak Ada</label></div>
													</td>
												</tr>
												<tr>
													<th>&nbsp;</th>
													<th>&nbsp;</th>
													<td>
														Hidup malam saja ( jam <input class="form-control" name="mlihdp[]" id="mlihdp[]" style="width:100px;display:inline" type="time"> sd <input class="form-control" name="slshdp[]" id="slshdp[]" style="width:100px;display:inline" type="time"> )
													</td>
													<td colspan="2">
														<div class="radio"><label for=""><input type="radio" name="kndsiair_ctm" id="kndsiair_ctm" value="tlancar3">Tidak Ada</label></div>
													</td>
												</tr>
												<tr>
													<th>&nbsp;</th>
													<th>&nbsp;</th>
													<td>
														Hidup pagi & malam saja ( jam <input class="form-control" name="mlihdp[]" id="mlihdp[]" style="width:100px;display:inline" type="time"> sd <input class="form-control" name="slshdp[]" id="slshdp[]" style="width:100px;display:inline" type="time"> )
													</td>
													<td colspan="2">
														<div class="radio"><label for=""><input type="radio" name="kndsiair_ctm" id="kndsiair_ctm" value="tlancar4">Tidak Ada</label></div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div> -->

								<hr style="margin-top: 0px">

								<hr>
								<div class="col-lg-12">
									<input class="btn btn-danger" type="reset" value="Cancel" onclick="window.location.reload()">
									<!-- <input class="btn btn-success" type="submit" value="Input dan Cetak" id="submit" onclick="$('#loader').show()"> -->
									<input class="btn btn-success" type="submit" value="Input" id="submit">
									<!-- <button id="submit" name="submit">tekan</button> -->
								</div>
						</form>
						<!-- /.form -->
					</div>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<!-- /.wrapper -->

		<div id="loader"></div>
	</div>
	<!-- DataTables JavaScript -->
	<?php //echo base_url('template/vendor/raphael/raphael.min.js')
	?>
	<script src="<?php echo base_url('template/vendor/datatables/js/jquery.dataTables.min.js') ?>"></script>
	<script src="<?php echo base_url('template/vendor/datatables-plugins/dataTables.bootstrap.min.js') ?>"></script>
	<script src="<?php echo base_url('template/vendor/datatables-responsive/dataTables.responsive.js') ?>"></script>
	<script src="<?php echo base_url('template/vendor/confirm/jquery-confirm.min.js') ?>"></script>
	<!-- <script src="//code.jquery.com/jquery-1.11.2.min.js"></script> -->
	<!-- <script src="<?php //echo base_url('template/vendor/terbilang/terbilang.js')
						?>"></script> -->
	<!-- <script src="<?php //echo base_url('template/vendor/terbilang/terbilang2.js')
						?>"></script> -->

	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
	<script>
		var sum = 0;

		function jumlah() {
			// alert( "ready!" );
			$("#biaya").each(function() {
				sum += parseFloat($(this).text());
			});
			// $("#ppn").each(function(){
			//   sum += parseFloat($(this).text());
			// });
			$('#sumColumnBiaya').text(sum);
			$('#sumColumnBiaya').autoNumeric('init');
			$('#sumColumnBiaya').autoNumeric('set', sum);
		};

		function kurang(nilai, ppn) {
			// alert( "ready!" );
			// alert('nilai sum:'+sum+' - nilai:'+nilai);
			sum -= nilai;
			// alert('nilai sum sekarang:'+sum+' - ppn:'+ppn);
			// sum -= ppn;
			// alert('nilai sum:'+sum);
			$('#sumColumnBiaya').text(sum);
			$('#sumColumnBiaya').autoNumeric('init');
			$('#sumColumnBiaya').autoNumeric('set', sum);
		};

		$(document).ready(function() {
			$("#loading").hide();
			$("#loading2").hide();

			$("input[name$='kegush_ctm']").click(function() {
				var test = $(this).val();

				// alert(test);
				// $("#Cars" + test).show();
				if (test == 'ada') {
					$("#ketush").show();
					$("#sklaush").show();
				} else {
					$("#ketush").hidden();
				}
			});

			$("#kbptn").click(function() { // Ketika user mengganti atau memilih data provinsi
				// $("#kcmtn").val().hide(); // Sembunyikan dulu combobox kota nya
				$("#loading").show(); // Tampilkan loadingnya

				$.ajax({
					type: "POST", // Method pengiriman data bisa dengan GET atau POST
					url: "<?php echo base_url("home/listKeca"); ?>", // Isi dengan url/path file php yang dituju
					data: {
						kbptn: $("#kbptn").val()
					}, // data yang akan dikirim ke file yang dituju
					dataType: "json",
					beforeSend: function(e) {
						if (e && e.overrideMimeType) {
							e.overrideMimeType("application/json;charset=UTF-8");
						}
					},
					success: function(response) { // Ketika proses pengiriman berhasil
						$("#loading").hide(); // Sembunyikan loadingnya
						// set isi dari combobox kota
						// lalu munculkan kembali combobox kotanya
						$("#kcmtn").html(response.list_keca).show();
					},
					error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
						alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
					}
				});
			});

			$("#kcmtn").click(function() { // Ketika user mengganti atau memilih data provinsi
				// $("#kcmtn").val().hide(); // Sembunyikan dulu combobox kota nya
				$("#loading2").show(); // Tampilkan loadingnya

				$.ajax({
					type: "POST", // Method pengiriman data bisa dengan GET atau POST
					url: "<?php echo base_url("home/listKelu"); ?>", // Isi dengan url/path file php yang dituju
					data: {
						kbptn: $("#kbptn").val(),
						kcmtn: $("#kcmtn").val()
					}, // data yang akan dikirim ke file yang dituju
					dataType: "json",
					beforeSend: function(e) {
						if (e && e.overrideMimeType) {
							e.overrideMimeType("application/json;charset=UTF-8");
						}
					},
					success: function(response) { // Ketika proses pengiriman berhasil
						$("#loading2").hide(); // Sembunyikan loadingnya
						// set isi dari combobox kota
						// lalu munculkan kembali combobox kotanya
						$("#klrhn").html(response.list_kelu).show();
					},
					error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
						alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
					}
				});
			});

			// $("#submit").click(function() {
			// 	$.alert({
			// 		title: 'Alert!',
			// 		content: 'Simple alert!',
			// 	});
			// });

			$("#btn-map").click(function() {
				console.log("diklik");
				// // document.getElementById('map').innerHTML = "<div id='map' style='width: 100%; height: 100%;'></div>";
				// map.removeLayer()
				map.remove();
				$("#contmap").html("<div id='map'></div>");
				refmaps();
			});

			$('#dataTables-example').DataTable({
				responsive: true,
				"scrollY": "200px",
				"scrollCollapse": true,
				"paging": false,
				"searching": false,
				"bInfo": false
			});

		});
	</script>
</body>