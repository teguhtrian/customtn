<?php 
	$data['my_token'] = md5(uniqid(rand(), true));
	session_start();
	$_SESSION['my_token'] = $data['my_token'];
	// print_r($_SESSION);
?>
<head>
	<META HTTP-EQUIV="refresh">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/typeahead/typeahead.css')?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('template/vendor/datepicker/css/bootstrap-datepicker.css')?>">
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
                    <h1 class="page-header">Menu Cetak Bukti Penerimaan Kas/Bank</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Data Periode Bukti Penerimaan Kas/Bank</b>
                        </div>
                        <div class="panel-body">
                        	<?php //echo form_open('home/cetakLppPeriode')?>
                        	<?php echo form_open('cetak/cetakBpkbPeriode', array('id' => 'myform','target' => '_blank'))?>
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
	                            	<div class="col-lg-6">
	                            	<label>Tanggal awal</label>
	                            	<div class="form-group input-group">
                        				<input class="form-control" ttype="text" value="<?php echo date("Y-m-d");?>" id="datepicker" name="tglAwal" readonly>
                        				<span class="input-group-addon">
                        				<i class="fa fa-calendar-o"></i>
                        				</span>
	                            	</div>
	                            	</div>
	                            	<div class='col-sm-6'>
	                            		<label>Tanggal Akhir</label>
							            <div class="form-group input-group">
	                        				<input class="form-control" ttype="text" value="<?php echo date("Y-m-d");?>" id="datepicker2" name="tglAkhir" readonly>
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
	                            		<input class="btn btn-success" type="submit" value="Cetak" id="submit">
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
	    });
    </script>
</body>