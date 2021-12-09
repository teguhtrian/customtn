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
				$('#npa_pel').val(sugestion.npa);
				$('#na_ctm').val(sugestion.na_ctm);
				$('#tarif').val(sugestion.tarif);
				$('#alamat').val(sugestion.alamat);
				$('#no_rmh').val(sugestion.no_rmh);
			});

			$('#tanggal').datepicker({
				format: 'yyyy/mm/dd',
				setDate: new Date(),
				todayHighlight: true,
			});

			// $('#myform').submit(function(e){
			//     e.preventDefault();
			//     var msg = $('#uname').val();
			//     var url=$(this).attr('action');k/
			//     $.post(url, {uname: msg}, function(r) {
			//         console.log(r);
			//     });
			// });

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
	</style>
</head>

<body>
	<div id="wrapper">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Menu Input BPBRA Non-NPA</h1>
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<b>Data BPBRA Non-NPA</b>
					</div>
					<div class="panel-body">
						<?php echo form_open('home/inputBPBRANonNpa') ?>
						<?php //echo form_open('home/inputCetakBPBRA', array('id' => 'myform','target' => '_blank'))
						?>
						<?php //echo form_open('welcome/cetakBPBRA','target' => '_blank', array('id' => 'myform'))
						?>
						<!-- <form id="formMeterInput" action="welcome/bukaEditSPPD"> -->
						<input type="hidden" name="my_token" id="my_token" value="<?php echo $_SESSION['my_token'] ?>" />
						<div class="row">
							<!-- /.col-lg-2 -->
							<div class="col-lg-4">
								<div class="form-group">
									<label>Nama Pelanggan</label>
									<input class="form-control" type="text" name="na_ctm" id="na_ctm">
								</div>
							</div>
						</div>
						<!-- /.row -->
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Alamat</label>
									<textarea class="form-control" rows="2" name="alamat" id="alamat"></textarea>
								</div>
							</div>
						</div>
						<!-- /.row -->
						<hr style="margin-top: 0px">
						<div class="row">
							<div class="form-group">
								<div class="col-lg-6" style="border-style: solid;border: 10px">
									<label>Pilihan Biaya</label>
									<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example" style="font-size: 12px">
										<thead>
											<tr>
												<th></th>
												<th>No. Rubrik</th>
												<th>Redaksi Cetak</th>
												<th>Biaya</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
											// echo $fmt->formatCurrency($amt, "INR");
											foreach ($biaya as $b) {
												echo '<tr>
					                                		<td><input type="checkbox" id="tb-' . $b->id . '" value="' . $b->id . '-' . $b->rubrik . '" name="box[]"><input hidden id="biaya-' . $b->id . '" value="' . $b->biaya . '""></td>
					                                		<td>' . $b->rubrik . $this->session->userdata('kocab') . '</td>
					                                		<td>' . $b->itemnya . '</td>
					                                		<td>' . $fmt->formatCurrency($b->biaya, "IDR") . '</td>
					                                	</tr>';
											}
											?>
										</tbody>
									</table><br>
									<table width="100%">
										<tr>
											<td><strong>Keterangan Cetak</strong></td>
											<td>
												<textarea class="form-control" rows="1" name="ket" id="ket" placeholder="Cth: Turun Tarif, RT-4 ke RT-3"></textarea>
											</td>
										</tr>
									</table>
								</div>
								<div class="col-lg-6" style="background-color: gray">
									<label style="color: white">Yang akan dicetak</label>
									<table class="table" style="color: white; font-size: 10px; font-weight: bold" id="tableSaya">
										<thead>
											<tr>
												<th>Rubrik</th>
												<th>Redaksi</th>
												<th style="width: 30%">Biaya</th>
											</tr>
										</thead>
										<tbody>
											<tr id="insertFrom">
											</tr>
											<tr id="sumColumn">
												<td colspan="2" style="font-size: 15px"><strong>Total Biaya Belum PPN</strong></td>
												<td id="sumColumnBiaya" style="font-size: 15px">0</td>
											</tr>
											<tr id="tr">
												<td colspan="2" style="font-size: 15px">Input Total Biaya Belum PPN Disini :</td>
												<td id="to" style="font-size: 15px"><input autocomplete="off" class="form-control" id="btotal" type="text" name="btotal"></td>
											</tr>
											<tr id="tr">
												<td colspan="2" style="font-size: 15px">Apakah Total Biaya Berupa DP Cicilan? : <br /><strong>*Centang Jika YA</strong></td>
												<td style="font-size: 15px"><input type="checkbox" id="cicil" name="cicil" value="1"></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-lg-6">
								<input class="btn btn-danger" type="reset" value="Cancel" onclick="window.location.reload()">
								<input class="btn btn-success" type="submit" value="Input dan Cetak" id="submit" disabled="">
							</div>
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
					var nama = $('#na_ctm').val();
					// alert(nama);
					var btotal = $(this).val();
					var btotal = btotal.replace(".00", "");
					var btotal = btotal.replace(",", "");
					var btotal = btotal.replace(",", "");
					var cicil = $('#cicil').is(":checked");
					// alert(cicil);
					// alert("nilai sum: "+sum+"; nilai btotal: "+btotal);
					if (btotal == sum && nama != '') {
						$(':input[type="submit"]').prop('disabled', false);
					} else if (nama !== '') {
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