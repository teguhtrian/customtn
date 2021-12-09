<?php 
	$data['my_token'] = md5(uniqid(rand(), true));
	session_start();
	$_SESSION['my_token'] = $data['my_token'];
	// print_r($_SESSION);
?>
<head>
	<META HTTP-EQUIV="refresh">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('template/dist/css/bootstrap-datepicker.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/typeahead/typeahead.css')?>">
   <link rel="stylesheet" href="<?php echo base_url('template/vendor/confirm/jquery-confirm.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?php //echo base_url('template/dist/css/bootstrap-datepicker3.standalone.min.css')?>">
	<script type="text/javascript" src="<?php echo base_url('template/dist/js/bootstrap-datepicker.min.js')?>"></script>
	<script src="<?php echo base_url('asset/maskedinput/jquery.maskedinput.min.js')?>"></script>
	<script src="<?php echo base_url('asset/validate/dist/jquery.validate.js')?>"></script>
	<script src="<?php echo base_url('asset/typeahead/typeahead.bundle.js')?>"></script>
	<script src="<?php echo base_url('asset/handlebars/handlebars-v4.0.5.js')?>"></script>
	<script type="text/javascript">
		var noreg = new Bloodhound({
            //datumTokenizer: function(d){ return Bloodhound.tokenizers.whitespace(d.noreg);},
            datumTokenizer: Bloodhound.tokenizers.whitespace,
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			remote:{
				url: "<?php echo base_url('home/getNoreg/'.$this->session->userdata('kocab').'')?>",
				prepare: function (query, settings) {
                    settings.type = "POST";
                    settings.data = { query: query };
                    return settings;
                }
			}
        });

       	$(document).ready(function(){
       		
       		noreg.initialize();
	        $('#noreg').typeahead(null,{
	        	name: 'noreg',
	        	items:5,
	        	displayKey:'noreg',
	        	source:noreg,//.ttAdapter(),
	        	hint:true,
	        	templates:{
	        		empty: ['<div class="empty-message" align="center">','noreg tidak ditemukan','</div>'].join('\n'),
				    suggestion:function(data){
				    	return '<div><strong>' + data.no_reg + ' -</strong> ' + data.nama + '</div>'
				    }
	        	}
	    	}).bind('typeahead:select',function(e,sugestion){
	    		$('#noreg_pel').val(sugestion.no_reg);
	    		$('#na_ctm').val(sugestion.nama);
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
	<script type="text/javascript" src="<?php echo base_url('template/vendor/autonum/autoNumeric.js')?>"></script>
	<script type="text/javascript">
		jQuery(function($) {
		    $('#btotal').autoNumeric('init');
		});
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
                    <h1 class="page-header">Menu Cetak Surat Pasang Baru</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Data Pasang Baru</b>
                        </div>
                        <div class="panel-body">
                        	<?php echo form_open('cetak/cetakSpPsb')?>
                        	<?php //echo form_open('home/inputCetakBPBRA', array('id' => 'myform','target' => '_blank'))?>
                        	<?php //echo form_open('welcome/cetakBPBRA','target' => '_blank', array('id' => 'myform'))?>
                        	<!-- <form id="formMeterInput" action="welcome/bukaEditSPPD"> -->
                        		<input type="hidden" name="my_token" id="my_token" value="<?php echo $_SESSION['my_token']?>" />

                        		<!-- <div class="row">
	                            	<div class="col-lg-5">
	                            	<label>Nomor Register</label>
	                            	<div class="form-group input-group">
                        				<input class="form-control" type="text" name="noreg" id="noreg" placeholder="Input Nomor Register Disini..">
                        				<span class="input-group-addon">
                        				<i class="fa fa-search"></i>
                        				</span>
	                            	</div>
	                            	</div>
	                            </div> -->
	                            <div class="row">
	                            	<!-- /.col-lg-5 -->	
	                            	<div class="col-lg-3">
	                            		<div class="form-group">
	                            			<label>Nomor Register</label>
	                            			<input class="form-control" type="text" name="noreg_pel" value="" id="noreg_pel" placeholder="Input Nomor Register Disini">
	                            		</div>
	                            	</div>
	                            	<!-- /.col-lg-2 -->
	                            	<div class="col-lg-3">
	                            		<div class="form-group">
	                            			<label>Nama Pendaftar</label>
	                            			<input class="form-control" type="text" name="na_ctm" id="na_ctm" placeholder="Input Nama Pendaftar Disini">
	                            		</div>
	                            	</div>
	                            	<!-- /.col-lg-2 -->
	                            	<div class="col-lg-3">
	                            		<div class="form-group">
	                            			<label>Kode Tarif</label>
	                            			<input class="form-control" type="text" name="tarif" id="tarif" placeholder="Input Kode Tarif Pendaftar Disini">
	                            		</div>
	                            	</div>
	                            	<!-- /.col-lg-2 -->
	                        	</div>
	                            <!-- /.row -->
	                            <div class="row">
	                            	<div class="col-lg-6">
	                            		<div class="form-group">
		                            		<label>Alamat Pendaftar</label>
		                            		<textarea class="form-control" rows="2" name="alamat" id="alamat" placeholder="Input Alamat Pendaftar Disini"></textarea>
	                            		</div>
	                            	</div>
	                            	<!-- /.col-lg-7 -->
	                            	<div class="col-lg-4">
	                            		<div class="form-group">
	                            			<label>Nomor Rumah</label>
		                            		<input class="form-control" type="text" name="no_rmh" id="no_rmh" placeholder="Input Nomor Rumah Pendaftar Disini">
	                            		</div>
	                            	</div>
	                            	<!-- /.col-lg-3 -->
	                            </div>
	                            <!-- /.row -->
	                            <hr style="margin-top: 0px">
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
    <?php //echo base_url('template/vendor/raphael/raphael.min.js')?>
    <script src="<?php echo base_url('template/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo base_url('template/vendor/datatables-plugins/dataTables.bootstrap.min.js')?>"></script>
    <script src="<?php echo base_url('template/vendor/datatables-responsive/dataTables.responsive.js')?>"></script>
    <script src="<?php echo base_url('template/vendor/confirm/jquery-confirm.min.js')?>"></script>
    <!-- <script src="//code.jquery.com/jquery-1.11.2.min.js"></script> -->
    <!-- <script src="<?php //echo base_url('template/vendor/terbilang/terbilang.js')?>"></script> -->
    <!-- <script src="<?php //echo base_url('template/vendor/terbilang/terbilang2.js')?>"></script> -->

	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
 	    $(document).ready(function() {
			$('#noreg_pel').change(function() {
		    	var pel = $('#noreg_pel').val();
		    	if (pel!= '') {
		    		$(':input[type="submit"]').prop('disabled', false);
		    	}else{
		    		$(':input[type="submit"]').prop('disabled', true);
		    	}
			});
	    });
    </script>
</body>