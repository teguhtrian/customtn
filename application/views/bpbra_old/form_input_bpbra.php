<?php
$data['my_token'] = md5(uniqid(rand(), true));
session_start();
$_SESSION['my_token'] = $data['my_token'];
// print_r($_SESSION);
?>

<head>
	<META HTTP-EQUIV="refresh">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('template/dist/css/bootstrap-datepicker.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/typeahead/typeahead.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('template/vendor/confirm/jquery-confirm.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php //echo base_url('template/dist/css/bootstrap-datepicker3.standalone.min.css')
													?>">
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
				$('#trf_ctm').val(sugestion.tarif);
				$('#almt_ctm').val(sugestion.alamat);
				$('#normh_ctm').val(sugestion.no_rmh);
			});

			$('#tanggal').datepicker({
				format: 'yyyy/mm/dd',
				setDate: new Date(),
				todayHighlight: true,
			});

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
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<b>FORM DATA PELANGGAN</b>
					</div>
					<div class="panel-body">
						<?php echo form_open('home/inputPelanggan') ?>
						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-info">
									<div class="panel-heading">
										A. DATA PELANGGAN
									</div>
									<div class="panel-body">
										<input type="hidden" name="my_token" id="my_token" value="<?php echo $_SESSION['my_token'] ?>" />

										<div class="row">
											<div class="col-lg-5">
												<label> Cari NPA</label>
												<div class="form-group input-group">
													<input class="form-control" type="text" name="npa" id="npa" placeholder="Input Kode NPA Disini..">
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
															<td colspan="3"><input class="form-control" type="text" name="npa_ctm" id="npa_ctm" placeholder="Input NPA Disini.."></td>
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
															<td><input class="form-control" type="text" name="na_ctm" id="na_ctm" placeholder="Input Nama Pelanggan Disini.."></td>
															<td><input class="form-control" type="text" name="na_pmlk" id="na_pmlk" placeholder="Input Nama Pemilik Disini.."></td>
															<td><input class="form-control" type="text" name="na_pghn" id="na_pghn" placeholder="Input Nama Penghuni Disini.."></td>
														</tr>
														<tr>
															<th>3.</th>
															<th>No. Telp</th>
															<td><input class="form-control" type="text" name="notlp_ctm" id="notlp_ctm" placeholder="Input No. Telp Pelanggan Disini.."></td>
															<td><input class="form-control" type="text" name="notlp_pmlk" id="notlp_pmlk" placeholder="Input No. Telp Pemilik Disini.."></td>
															<td><input class="form-control" type="text" name="notlp_pghn" id="notlp_pghn" placeholder="Input No. Telp Penghuni Disini.."></td>
														</tr>
														<tr>
															<th>4.</th>
															<th>No. HP/WA</th>
															<td><input class="form-control" type="text" name="nohp_ctm" id="nohp_ctm" placeholder="Input No. HP/WA Pelanggan Disini.."></td>
															<td><input class="form-control" type="text" name="nohp_pmlk" id="nohp_pmlk" placeholder="Input No. HP/WA Pemilik Disini.."></td>
															<td><input class="form-control" type="text" name="nohp_pghn" id="nohp_pghn" placeholder="Input No. HP/WA Penghuni Disini.."></td>
														</tr>
														<tr>
															<th>5.</th>
															<th>Email</th>
															<td><input class="form-control" type="text" name="email_ctm" id="email_ctm" placeholder="Input Email Pelanggan Disini.."></td>
															<td><input class="form-control" type="text" name="email_pmlk" id="email_pmlk" placeholder="Input Email Pemilik Disini.."></td>
															<td><input class="form-control" type="text" name="email_pghn" id="email_pghn" placeholder="Input Email Penghuni Disini.."></td>
														</tr>
														<tr>
															<th>6.</th>
															<th>No. KTP</th>
															<td><input class="form-control" type="text" name="noktp_ctm" id="noktp_ctm" placeholder="Input No. KTP Pelanggan Disini.."></td>
															<td><input class="form-control" type="text" name="noktp_pmlk" id="noktp_pmlk" placeholder="Input No. KTP Pemilik Disini.."></td>
															<td><input class="form-control" type="text" name="noktp_pghn" id="noktp_pghn" placeholder="Input No. KTP Penghuni Disini.."></td>
														</tr>
														<tr>
															<th>7.</th>
															<th colspan="4">Alamat Sesuai NPA</th>
														</tr>
														<tr>
															<th>&nbsp;</th>
															<th>Jalan</th>
															<td><input class="form-control" type="text" name="almt_ctm" id="almt_ctm" placeholder="Input Data Jalan Disini.."></td>
															<th>No. Rumah</th>
															<td><input class="form-control" type="text" name="normh_ctm" id="normh_ctm" placeholder="Input Data N Disini.."></td>
														</tr>
														<tr>
															<th>&nbsp;</th>
															<th>Kelurahan</th>
															<td colspan="3"><input class="form-control" type="text" name="klrhn_ctm" id="klrhn_ctm" placeholder="Input Data Jalan Disini.."></td>
														</tr>
														<tr>
															<th>&nbsp;</th>
															<th>Kecamatan</th>
															<td colspan="3"><input class="form-control" type="text" name="kcmtn_ctm" id="kcmtn_ctm" placeholder="Input Data Jalan Disini.."></td>
														</tr>
														<tr>
															<th>&nbsp;</th>
															<th>Kabupaten/Kota</th>
															<td colspan="3"><input class="form-control" type="text" name="kbptn_ctm" id="kbptn_ctm" placeholder="Input Data Jalan Disini.."></td>
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
													<td colspan="3"><input class="form-control" type="text" name="trf_ctm" id="trf_ctm" placeholder="Input Tarif Saat Ini Disini.."></td>
												</tr>
												<tr>
													<th>2.</th>
													<th width="300px">Luas Bangunan</th>
													<td colspan="3"><input class="form-control" type="text" name="lbang_ctm" id="lbang_ctm" placeholder="Input Luas Bangunan Disini.."></td>
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
												<tr>
													<th>&nbsp;</th>
													<th>Jika ada, sebutkan</th>
													<td colspan='3'><input class="form-control" type="text" name="ketush_ctm" id="ketush_ctm" placeholder="Sebutkan Disini.."></td>
												</tr>
												<tr>
													<th>&nbsp;</th>
													<th>Skala Usaha</th>
													<td>
														<div class="radio"><label for=""><input type="radio" name="sklaush_ctm" id="sklaush_ctm" value="kecil">Kecil</label></div>
													</td>
													<td>
														<div class="radio"><label for=""><input type="radio" name="sklaush_ctm" id="sklaush_ctm" value="sedang">Sedang</label></div>
													</td>
													<td>
														<div class="radio"><label for=""><input type="radio" name="sklaush_ctm" id="sklaush_ctm" value="besar">Besar</label></div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="col-lg-12">
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
														Hidup pagi saja ( jam <input class="form-control" style="width:100px;display:inline" type="number"> sd <input class="form-control" style="width:100px;display:inline" type="number"> )
													</td>
													<td colspan="2">
														<div class="radio"><label for=""><input type="radio" name="kndsiair_ctm" id="kndsiair_ctm" value="tlancar1">Tidak Ada</label></div>
													</td>
												</tr>
												<tr>
													<th>&nbsp;</th>
													<th>&nbsp;</th>
													<td>
														Hidup siang saja ( jam <input class="form-control" style="width:100px;display:inline" type="number"> sd <input class="form-control" style="width:100px;display:inline" type="number"> )
													</td>
													<td colspan="2">
														<div class="radio"><label for=""><input type="radio" name="kndsiair_ctm" id="kndsiair_ctm" value="tlancar2">Tidak Ada</label></div>
													</td>
												</tr>
												<tr>
													<th>&nbsp;</th>
													<th>&nbsp;</th>
													<td>
														Hidup malam saja ( jam <input class="form-control" style="width:100px;display:inline" type="number"> sd <input class="form-control" style="width:100px;display:inline" type="number"> )
													</td>
													<td colspan="2">
														<div class="radio"><label for=""><input type="radio" name="kndsiair_ctm" id="kndsiair_ctm" value="tlancar3">Tidak Ada</label></div>
													</td>
												</tr>
												<tr>
													<th>&nbsp;</th>
													<th>&nbsp;</th>
													<td>
														Hidup pagi & malam saja ( jam <input class="form-control" style="width:100px;display:inline" type="number"> sd <input class="form-control" style="width:100px;display:inline" type="number"> )
													</td>
													<td colspan="2">
														<div class="radio"><label for=""><input type="radio" name="kndsiair_ctm" id="kndsiair_ctm" value="tlancar4">Tidak Ada</label></div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<hr style="margin-top: 0px">

							<hr>
							<div class="col-lg-12">
								<input class="btn btn-danger" type="reset" value="Cancel" onclick="window.location.reload()">
								<input class="btn btn-success" type="submit" value="Input dan Cetak" id="submit" onclick="$('#loader').show()">
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
				$('#dataTables-example').DataTable({
					responsive: true,
					"scrollY": "200px",
					"scrollCollapse": true,
					"paging": false,
					"searching": false,
					"bInfo": false
				});
				// $('#tb').val(this.checked);
				// $('#tb').change(function() {
				//     if(this.checked) {
				//         var returnVal = confirm("Are you sure?");
				//         // $(this).prop("checked", returnVal);
				//     }       
				// });
				<?php
				foreach ($biaya as $b) {
					if ($b->isNotPpn > 0) {
						// artinya tidak hitung Ppn
						echo '$(\'#tb-' . $b->id . '\').click(function(){
							if($(this).prop("checked") == true){
								//alert("Checkbox is checked.");
								var returnVal = confirm("Menambahkan ' . $b->itemnya . '?");
								//alert(returnVal);
								if(returnVal==true){
	
								$(\'#insertFrom\').after(\'<tr id="tb-' . $b->id . '"><td colspan="3" hidden><input class="form-control"  type="text" id="tb-' . $b->id . '" value="' . $b->id . '-' . $b->rubrik . $b->kocab . '-' . $b->biaya . '" name="boxChecklist[]"></td></tr><tr id="tb-' . $b->id . '"><td>' . $b->rubrik . $b->kocab . '</td><td>' . $b->itemnya . '**</td><td>' . $fmt->formatCurrency($b->biaya, "IDR") . '</td><td id="biaya" hidden>' . $b->biaya . '</td></tr><tr id="tb-' . $b->id . '"><td colspan="3" hidden><input class="form-control"  type="text" id="tb-' . $b->id . '" value="' . $b->id . '-50.06.50.00-0" name="boxChecklist[]"></td></tr><tr id="tb-' . $b->id . '"><td>50.06.50.00</td><td>PPN 10 % ' . $b->itemnya . '**</td><td>0</td></tr>\');
									jumlah();
								}else{
									$(this).prop("checked", false);
								}
							}
							else if($(this).prop("checked") == false){
								// kurang();
								// var nilai = $(\'#tb-' . $b->id . '\').val();
								// alert(nilai);
								// var ppn = nilai*0.1;
								// alert(ppn);
								// kurang(nilai,ppn);
								//alert("Checkbox is unchecked.");
								var returnVal = confirm("Menghapus ' . $b->itemnya . '?");
								//alert(returnVal);
								if(returnVal==true){
									var nilai = $(\'#biaya-' . $b->id . '\').val();
									var ppn = nilai*0.1;
									kurang(nilai,ppn);
									$(\'table#tableSaya tr#tb-' . $b->id . '\').remove();
								}else{
									$(this).prop("checked", true);
								}
							}
						});';
					} else {
						// artinya hitung Ppn
						echo '$(\'#tb-' . $b->id . '\').click(function(){
							if($(this).prop("checked") == true){
								//alert("Checkbox is checked.");
								var returnVal = confirm("Menambahkan ' . $b->itemnya . '?");
								//alert(returnVal);
								if(returnVal==true){
	
								$(\'#insertFrom\').after(\'<tr id="tb-' . $b->id . '"><td colspan="3" hidden><input class="form-control"  type="text" id="tb-' . $b->id . '" value="' . $b->id . '-' . $b->rubrik . $b->kocab . '-' . $b->biaya . '" name="boxChecklist[]" hidden></td></tr><tr id="tb-' . $b->id . '"><td>' . $b->rubrik . $b->kocab . '</td><td>' . $b->itemnya . '</td><td>' . $fmt->formatCurrency($b->biaya, "IDR") . '</td><td id="biaya" hidden>' . $b->biaya . '</td></tr><tr id="tb-' . $b->id . '"><td colspan="3" hidden><input class="form-control"  type="text" id="tb-' . $b->id . '" value="' . $b->id . '-50.06.50.00-' . ($b->biaya * 0.1) . '" name="boxChecklist[]"></td></tr><tr id="tb-' . $b->id . '"><td>50.06.50.00</td><td>PPN 10 % ' . $b->itemnya . '</td><td>' . $fmt->formatCurrency($b->biaya * 0.1, "IDR") . '</td></tr>\');
									jumlah();
								}else{
									$(this).prop("checked", false);
								}
							}
							else if($(this).prop("checked") == false){
								// kurang();
								// var nilai = $(\'#tb-' . $b->id . '\').val();
								// alert(nilai);
								// var ppn = nilai*0.1;
								// alert(ppn);
								// kurang(nilai,ppn);
								//alert("Checkbox is unchecked.");
								var returnVal = confirm("Menghapus ' . $b->itemnya . '?");
								//alert(returnVal);
								if(returnVal==true){
									var nilai = $(\'#biaya-' . $b->id . '\').val();
									var ppn = nilai*0.1;
									kurang(nilai,ppn);
									$(\'table#tableSaya tr#tb-' . $b->id . '\').remove();
								}else{
									$(this).prop("checked", true);
								}
							}
						});';
					}
				}
				?>
				$('#btotal').change(function() {
					var npa = $('#npa_pel').val();
					// alert(npa);
					var btotal = $(this).val();
					var btotal = btotal.replace(".00", "");
					var btotal = btotal.replace(",", "");
					var btotal = btotal.replace(",", "");
					var cicil = $('#cicil').is(":checked");
					// alert(cicil);
					// alert("nilai sum: "+sum+"; nilai btotal: "+btotal);
					if (btotal == sum && npa != '') {
						$(':input[type="submit"]').prop('disabled', false);
					} else if (npa !== '') {
						$.confirm({
							title: 'Perhatian!',
							content: 'Data yang diinput tidak sesuai dengan Total Biaya!<br>Yakin untuk input harga baru?',
							buttons: {
								Ya: function() {
									//btnClass: 'btn-warning',
									//$.alert('Confirmed!');
									// location.replace('<?php echo base_url() ?>home/hapusBiayaBybId/'+id);
									if (cicil == false) {
										$.confirm({
											title: 'Perhatian!',
											content: 'Apakah Biaya diinput berupa DP cicilan?',
											buttons: {
												Ya: function() {
													$('#cicil').prop('checked', true);
													$(':input[type="submit"]').prop('disabled', false);
												},
												tidak: function() {
													$(':input[type="submit"]').prop('disabled', false);
												}
											},

										});
									}
									$(':input[type="submit"]').prop('disabled', false);
								},
								Batal: function() {
									//$.alert('Hapus data dibatalkan.');
									$(':input[type="submit"]').prop('disabled', true);
								}
							}
						});
						return false;
					} else {
						$(':input[type="submit"]').prop('disabled', true);
					}
				});
			});
		</script>
</body>