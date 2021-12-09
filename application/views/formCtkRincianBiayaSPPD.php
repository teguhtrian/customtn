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
	<link rel="stylesheet" type="text/css" href="<?php //echo base_url('template/dist/css/bootstrap-datepicker3.standalone.min.css')?>">
	<script type="text/javascript" src="<?php echo base_url('template/dist/js/bootstrap-datepicker.min.js')?>"></script>
	<script src="<?php echo base_url('asset/maskedinput/jquery.maskedinput.min.js')?>"></script>
	<script src="<?php echo base_url('asset/validate/dist/jquery.validate.js')?>"></script>
	<script src="<?php echo base_url('asset/typeahead/typeahead.bundle.js')?>"></script>
	<script src="<?php echo base_url('asset/handlebars/handlebars-v4.0.5.js')?>"></script>
	<script type="text/javascript">
		var sppd = new Bloodhound({
            //datumTokenizer: function(d){ return Bloodhound.tokenizers.whitespace(d.npa);},
            datumTokenizer: Bloodhound.tokenizers.whitespace,
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			remote:{
				url: "<?php echo base_url('welcome/getEditSPPDData')?>",
				prepare: function (query, settings) {
                    settings.type = "POST";
                    settings.data = { query: query };
                    return settings;
                }
			}
        });

       	$(document).ready(function(){
       		
       		sppd.initialize();
	        $('#SPPD').typeahead(null,{
	        	name: 'sppd',
	        	items:2,
	        	displayKey:'Code',
	        	source:sppd,//.ttAdapter(),
	        	hint:true,
	        	templates:{
	        		empty: ['<div class="empty-message" align="center">','SPPD tidak ditemukan','</div>'].join('\n'),
				    suggestion:function(data){
				    	return '<div><strong>' + data.Code + ' -</strong> ' + data.Description + '</div>'
				    }
	        	}
	    	}).bind('typeahead:select',function(e,sugestion){
	    		$('#code').val(sugestion.Code);
	    		$('#mulai').val(sugestion.StartDate);
	    		$('#selesai').val(sugestion.EndDate);
	    		$('#SPPDGroupName').val(sugestion.SPPDGroupName);
	    		$('#Destination').val(sugestion.Destination);
	    		$('#Description').val(sugestion.Description);
	    		$('#Reason').val(sugestion.Reason);
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
                    <h1 class="page-header">Menu Cetak Rincian Biaya SPPD</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Data SPPD</b>
                        </div>
                        <div class="panel-body">
                        	<?php echo form_open('welcome/cetakRincianBiayaSPPD', array('id' => 'myform','target' => '_blank'))?>
                        	<?php //echo form_open('welcome/cetakUsulanDanaSPPD','target' => '_blank', array('id' => 'myform'))?>
                        	<!-- <form id="formMeterInput" action="welcome/bukaEditSPPD"> -->
                        		<input type="hidden" name="my_token" id="my_token" value="<?php echo $_SESSION['my_token']?>" />

                        		<div class="row">
	                            	<div class="col-lg-5">
	                            	<label>SPPD</label>
	                            	<div class="form-group input-group">
                        				<input class="form-control" type="text" name="SPPD" id="SPPD" placeholder="Input Kode SPPD Disini..">
                        				<span class="input-group-addon">
                        				<i class="fa fa-search"></i>
                        				</span>
	                            	</div>
	                            	</div>
	                            </div>
	                            <div class="row">
	                            	<div class="col-lg-4">
	                            		<label>Tipe Cetak</label>
	                            		<div class="form-group">
	                            			<select class="form-control" name="tipe" id="tipe">
	                            				<option value="1">1. Cetak Usulan Dana SPPD</option>
	                            				<option value="2">2. Cetak Usulan Penginapan SPPD</option>
	                            			</select>
	                            		</div>
	                            	</div>
	                            	<div class="col-lg-6">
	                            		<label>Tipe SPPD</label>
	                            		<div class="form-group">
	                            			<select class="form-control" name="tipe" id="tipe">
	                            				<option value="1">1. RINCIAN BIAYA PERJALANAN DINAS INTERN</option>
	                            				<option value="2">2. RINCIAN BIAYA PERJALANAN DINAS EXTERN LUAR PROPINSI</option>
	                            				<option value="3">3. RINCIAN BIAYA PERJALANAN DINAS EXTERN DALAM PROPINSI</option>
	                            				<option value="4">4. RINCIAN BIAYA PERJALANAN DINAS EXTERN LUAR NEGERI</option>
	                            			</select>
	                            		</div>
	                            	</div>
	                            </div>
	                            <div class="row">
	                            	<!-- /.col-lg-5 -->	
	                            	<div class="col-lg-3">
	                            		<div class="form-group">
	                            			<label>Kode SPPD</label>
	                            			<input class="form-control" type="text" name="code" id="code" readonly="readonly">
	                            		</div>
	                            	</div>
	                            	<!-- /.col-lg-2 -->
	                            	<div class="col-lg-3">
	                            		<div class="form-group">
	                            			<label>Tgl. Mulai</label>
	                            			<input class="form-control" type="text" name="mulai" id="mulai" readonly="readonly">
	                            		</div>
	                            	</div>
	                            	<!-- /.col-lg-2 -->
	                            	<div class="col-lg-3">
	                            		<div class="form-group">
	                            			<label>Tgl. Selesai</label>
	                            			<input class="form-control" type="text" name="selesai" id="selesai" readonly="readonly">
	                            		</div>
	                            	</div>
	                            	<!-- /.col-lg-2 -->
	                        	</div>
	                            <!-- /.row -->
	                            <div class="row">
	                            	<div class="col-lg-6">
	                            		<div class="form-group">
		                            		<label>Kelompok SPPD</label>
		                            		<textarea class="form-control" rows="2" name="SPPDGroupName" id="SPPDGroupName" readonly="readonly"></textarea>
	                            		</div>
	                            	</div>
	                            	<!-- /.col-lg-7 -->
	                            	<div class="col-lg-4">
	                            		<div class="form-group">
	                            			<label>Tujuan</label>
		                            		<input class="form-control" type="text" name="Destination" id="Destination" readonly="readonly">
	                            		</div>
	                            	</div>
	                            	<!-- /.col-lg-3 -->
	                            </div>
	                            <!-- /.row -->
	                            <div class="row">
	                            	<div class="col-lg-6">
	                            		<div class="form-group">
	                            			<label>Keterangan</label>
	                            			<textarea class="form-control" name="Description" id="Description" rows="4" readonly="readonly"></textarea>
	                            		</div>
	                            	</div>
	                            </div>
	                            <!-- /.row -->
	                            <div class="row">
	                            	<div class="col-lg-8">
	                            		<div class="form-group">
	                            			<label>Dasar Perintah</label>
	                            			<textarea class="form-control" name="Reason" id="Reason" rows="3" readonly="readonly"></textarea>
	                            		</div>
	                            	</div>
	                            </div>
	                            <hr/>
	                            <div class="row">
	                            	<div class="col-lg-6">
	                            		<input class="btn btn-info" type="submit" value="Print" id="submit">
                            			<input class="btn btn-danger" type="reset" value="Cancel">
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
</body>