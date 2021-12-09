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
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('template/vendor/datetimepicker/css/bootstrap-datetimepicker.css')?>">
	<!-- <script type="text/javascript" src="<?php //echo base_url('template/dist/js/bootstrap-datepicker.min.js')?>"></script> -->
	<script src="<?php echo base_url('template/vendor/datetimepicker/js/bootstrap-datetimepicker.js')?>"></script>
	<script src="<?php echo base_url('asset/maskedinput/jquery.maskedinput.min.js')?>"></script>
	<script src="<?php echo base_url('asset/validate/dist/jquery.validate.js')?>"></script>
	<script src="<?php echo base_url('asset/typeahead/typeahead.bundle.js')?>"></script>
	<script src="<?php echo base_url('asset/handlebars/handlebars-v4.0.5.js')?>"></script>
	<script src="<?php echo base_url('asset/handlebars/handlebars-v4.0.5.js')?>"></script>
    <script type="text/javascript">
        $body = $("body");
        $(document).on({
            ajaxStart: function() { $body.addClass("loading");    },
            ajaxStop: function() { $body.removeClass("loading"); }    
        });

        $(document).ready(function(){
            // $('#btnFilter').click(function(){
            //     alert('Klik');die();
            // });
        $('#submit').click(function(){
           // alert("ayam");
                $('#form').validate({
                    errorClass: "my-error-class",

                    rules:{
                        tahun:{
                            required:true,
                            // accept: "image/jpg, image/jpeg, image/png",
                            // filesize: 3000000,
                        },
                    },

                    //fungsi submitHandler 
                    //untuk menggabungkan jquery validate
                    //dengan $.post
                    submitHandler: function(form){
                        $.post('<?php echo base_url()?>home/getBpbraPeriod',
                            $('#form').serialize(),
                            function(data,status){
                            //alert(data);
                            $("#content").html(data);
                            //location.reload();
                            }
                        );
                        // $.ajax({
                        //     url: '<?php echo base_url()?>admin/getUmpkByRegion/',
                        //     type: 'POST',
                        //     success: function(html){
                        //         alert(data);
                        //         //$("#kepala").html(html);
                        //     }
                        // });
                    }
                });
                //validate closed
            });
            //submit closed
        });
    </script>
	<style type="text/css">
		.my-error-class {
		    color:#FF0000;  /* red */
		}

        /* Start by setting display:none to make this hidden.
           Then we position it in relation to the viewport window
           with position:fixed. Width, height, top and left speak
           for themselves. Background we set to 80% white with
           our animation centered, and no-repeating */
        .modal {
            display:    none;
            position:   fixed;
            z-index:    1000;
            top:        0;
            left:       0;
            height:     100%;
            width:      100%;
            background: rgba( 255, 255, 255, .8 ) 
                        url('http://i.stack.imgur.com/FhHRx.gif') 
                        50% 50% 
                        no-repeat;
        }

        /* When the body has the loading class, we turn
           the scrollbar off with overflow:hidden */
        body.loading .modal {
            overflow: hidden;   
        }

        /* Anytime the body has the loading class, our
           modal element will be visible */
        body.loading .modal {
            display: block;
        }
	</style>
</head>

<body>
	<div id="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Menu Cetak Ulang Bon BPBRA</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>Data Bon BPBRA Perbulan</b>
                    </div>
                    <div class="panel-body">
                    	<?php //echo form_open('home/cetakLppPeriode')?>
                    	<?php //echo form_open('cetak/cetakTranPerbulan', array('id' => 'myform','target' => '_blank'))?>
                    	<?php //echo form_open('welcome/cetakBPBRA','target' => '_blank', array('id' => 'myform'))?>
                    	<!-- <form id="formMeterInput" action="welcome/bukaEditSPPD"> -->
                            <form id="form" method="post">
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
                            	<div class="col-lg-3">
                            	<label>Bulan</label>
                            	<div class="form-group">
                    				<select class="form-control" name="bulan" id="bulan">
                    					<option value="01">01 - Januari</option>
                    					<option value="02">02 - Februari</option>
                    					<option value="03">03 - Maret</option>
                    					<option value="04">04 - April</option>
                    					<option value="05">05 - Mei</option>
                    					<option value="06">06 - Juni</option>
                    					<option value="07">07 - Juli</option>
                    					<option value="08">08 - Agustus</option>
                    					<option value="09">09 - September</option>
                    					<option value="10">10 - Oktober</option>
                    					<option value="11">11 - November</option>
                    					<option value="12">12 - Desember</option>
                    				</select>
                            	</div>
                            	</div>
                            	<div class='col-sm-2'>
                            		<label>Tahun</label>
						            <div class="form-group input-group">
                        				<input class="form-control" type="number" placeholder="Cth:2020" id="tahun" name="tahun" >
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
        <!-- /.row -->
        <div class="row">
        	<div class="col-lg-12">
        		<div id="content">
        	</div>
        </div>
	</div>
	<!-- /.wrapper -->

    <div class="modal"><!-- Place at bottom of page --></div>
    <!-- DataTables JavaScript -->
    <script src="<?php echo base_url('template/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo base_url('template/vendor/datatables-plugins/dataTables.bootstrap.min.js')?>"></script>
    <script src="<?php echo base_url('template/vendor/datatables-responsive/dataTables.responsive.js')?>"></script>

	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>

	    $(document).ready(function() {
			$('#tahun').change(function() {
		    	var tgl = $('#tahun').val();
		    	if (tgl!= '') {
		    		$(':input[type="submit"]').prop('disabled', false);
		    	}else{
		    		$(':input[type="submit"]').prop('disabled', true);
		    	}
			});
	    });
    </script>
</body>