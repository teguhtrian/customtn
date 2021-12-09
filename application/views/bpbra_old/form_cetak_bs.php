<?php 
	$data['my_token'] = md5(uniqid(rand(), true));
	session_start();
	$_SESSION['my_token'] = $data['my_token'];
	// print_r($_SESSION);
?>
<head>
	<META HTTP-EQUIV="refresh">
	<!-- <link rel="stylesheet" type="text/css" href="<?php //echo base_url('template/dist/css/bootstrap-datepicker.min.css')?>"> -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/typeahead/typeahead.css')?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('template/vendor/datepicker/css/bootstrap-datepicker.css')?>">
	<link rel="stylesheet" type="text/css" href="<?php //echo base_url('template/dist/css/bootstrap-datepicker3.standalone.min.css')?>">
	<!-- <link rel="stylesheet" type="text/css" href="<?php // echo base_url('template/vendor/datetimepicker/css/bootstrap-datetimepicker.css')?>"> -->
	<!-- <script type="text/javascript" src="<?php //echo base_url('template/dist/js/bootstrap-datepicker.min.js')?>"></script> -->
	<!-- <script src="<?php //echo base_url('template/vendor/datetimepicker/js/bootstrap-datetimepicker.js')?>"></script> -->
	<script src="<?php echo base_url('template/vendor/datepicker/js/bootstrap-datepicker.js')?>"></script>
	<script src="<?php echo base_url('asset/maskedinput/jquery.maskedinput.min.js')?>"></script>
	<script src="<?php echo base_url('asset/validate/dist/jquery.validate.js')?>"></script>
	<script src="<?php echo base_url('asset/typeahead/typeahead.bundle.js')?>"></script>
	<script src="<?php echo base_url('asset/handlebars/handlebars-v4.0.5.js')?>"></script>
	<script src="<?php echo base_url('asset/handlebars/handlebars-v4.0.5.js')?>"></script>
	<script type="text/javascript">
		
	</script>
	<style type="text/css">
		.my-error-class {
		    color:#FF0000;  /* red */
		}	
	</style>
</head>

<body>
	<div id="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Menu Cetak Bukti Setoran Bank</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Data Periode Bukti Setoran Bank</b>
                        </div>
                        <div class="panel-body">
                        	<?php //echo form_open('home/cetakLppPeriode')?>
                        	<?php echo form_open('cetak/cetakBsPeriode', array('id' => 'myform','target' => '_blank'))?>
                        	<?php //echo form_open('welcome/cetakBPBRA','target' => '_blank', array('id' => 'myform'))?>
                        	<!-- <form id="formMeterInput" action="welcome/bukaEditSPPD"> -->
                        		<input type="hidden" name="my_token" id="my_token" value="<?php echo $_SESSION['my_token']?>" />
                        		<div class="row">
	                            	<div class="col-lg-5">
                            			<div class="form-group">
		                            	<label>Kantor/Unit</label>
	                        				<select class="form-control" name="kocab" id="kocab">
                                                <option value="">-- Silahkan Pilih --</option>
	                        					<?php
	                        						foreach ($cabang as $c) {
	                        							echo '<option value="'.$c->Code.'" ';
	                        							echo $c->Code==$this->session->userdata('kocab')?'selected':'';
	                        							echo'>'.$c->nama.'</option>';
	                        						}
	                        					?>
                                            </select>
			                            </div>
	                            	</div>
	                            </div>
                        		<div class="row">
	                            	<div class="col-lg-4">
	                            	<label>Tujuan Bank</label>
	                            	<div class="form-group">
                        				<input class="form-control" type="text" name="tujbank" id="tujbank" value="" placeholder="Cth: BANK SUMUT">
	                            	</div>
	                            	</div>
	                            </div>
	                            <div class="row">
	                            	<div class="col-lg-4">
	                            	<label>Nomor Account Bank</label>
	                            	<div class="form-group">
                        				<input class="form-control" type="text" name="noac" id="noac" value="" placeholder="Cth: 117.01.03.000001.0">
	                            	</div>
	                            	</div>
	                            </div>
                        		<div class="row">
	                            	<div class="col-lg-6">
	                            	<label>Tanggal Cetak Bukti</label>
	                            	<div class="form-group input-group">
                        				<input class="form-control" type="text" value="<?php echo date("Y-m-d");?>" id="datepicker" name="tglHari" readonly>
                        				<span class="input-group-addon">
                        				<i class="fa fa-calendar-o"></i>
                        				</span>
	                            	</div>
	                            	</div>
	                            </div>
	                            <hr>
	                            <div class="row">
	                            	<div class="col-lg-6">
                            			<input class="btn btn-danger" type="reset" value="Cancel" onclick="window.location.reload()">
	                            		<input class="btn btn-success" type="submit" value="Cetak" id="submit" disabled="">
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
    <script src="<?php echo base_url('template/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo base_url('template/vendor/datatables-plugins/dataTables.bootstrap.min.js')?>"></script>
    <script src="<?php echo base_url('template/vendor/datatables-responsive/dataTables.responsive.js')?>"></script>

	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>

	    $(document).ready(function() {
	    	 // $('#datetimepicker1').datetimepicker();
	    	 // $('#datetimepicker').datetimepicker({
			    // format: 'yyyy-mm-dd',
		     //    todayBtn: true
			// });
	    	 // $('#datetimepicker2').datetimepicker({
			    // format: 'yyyy-mm-dd',
		     //    todayBtn: true
			// });
			$('#datepicker').datepicker({
				language: "id",
				format: "yyyy-mm-dd",
			    autoclose: true,
			    todayHighlight: true
			});
			$('#datepicker2').datepicker({
				language: "id",
				format: "yyyy-mm-dd",
			    autoclose: true,
			    todayHighlight: true
			});

			$('#noac').change(function() {
		    	var tbank = $('#tujbank').val();
		    	var noac = $(this).val();
		    	if (noac!='' && tbank!= '') {
		    		$(':input[type="submit"]').prop('disabled', false);
		    	}else{
		    		$(':input[type="submit"]').prop('disabled', true);
		    	}
			});

			$('#tujbank').change(function() {
		    	var tbank = $('#tujbank').val();
		    	var noac = $(this).val();
		    	if (noac!='' && tbank!= '') {
		    		$(':input[type="submit"]').prop('disabled', false);
		    	}else{
		    		$(':input[type="submit"]').prop('disabled', true);
		    	}
			});

	    });
    </script>
</body>