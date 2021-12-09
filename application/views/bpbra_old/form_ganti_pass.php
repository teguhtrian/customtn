<?php 
	$data['my_token'] = md5(uniqid(rand(), true));
	session_start();
	$_SESSION['my_token'] = $data['my_token'];
?>
<head>
	<META HTTP-EQUIV="refresh">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('template/dist/css/bootstrap-datepicker.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/typeahead/typeahead.css')?>">
	<script type="text/javascript" src="<?php echo base_url('template/dist/js/bootstrap-datepicker.min.js')?>"></script>
	<script src="<?php echo base_url('asset/maskedinput/jquery.maskedinput.min.js')?>"></script>
	<script src="<?php echo base_url('asset/validate/dist/jquery.validate.js')?>"></script>
	<script src="<?php echo base_url('asset/typeahead/typeahead.bundle.js')?>"></script>
	<script src="<?php echo base_url('asset/handlebars/handlebars-v4.0.5.js')?>"></script>
	<script type="text/javascript">
		$(document).on('click', 'a.edit', function () { // <-- changes
            //alert($(this).attr('id'));
            id = $(this).attr('id');
            //$(this).closest('tr').remove();
            // location.replace('<?php echo base_url()?>admin/editDataUu/'+id);
            window.location.href = '<?php echo base_url()?>home/editBiaya/'+id;
            return false;
        });

		$(document).ready(function(){
            $('#submit').click(function(){
                $('#formPass').validate({
                    errorClass: "my-error-class",
                    rules:{                        
                    	pass:{
                            required:true,
                        },
                    	konf_pass:{
                            required:true,
                        },
                    },

                    messages:{
                    	pass:{
                            required:"Silahkan diisi",
                        },
                    	konf_pass:{
                            required:"Silahkan diisi",
                        },
                    },

                    //fungsi submitHandler 
                    //untuk menggabungkan jquery validate
                    //dengan $.post
                    submitHandler: function(form){
                        $.post('<?php echo base_url()?>login/updatePass', //akses modul ini
                            $('#formPass').serialize(), //data form dikirim secara serial
                            function(data,status){
                                alert(data);
                                //alert("Data berhasil di input");
                                location.reload();
                            }
                        );
                    }
                });
                //validate closed
            });
            //submit closed
        }); 
	</script>
	<script type="text/javascript" src="<?php echo base_url('template/vendor/autonum/autoNumeric.js')?>"></script>
	<script type="text/javascript">
		jQuery(function($) {
		    $('#biaya').autoNumeric('init');
		    // $('#btotal').autoNumeric('init');
		});
	</script>
	<style type="text/css">
		.my-error-class {
		    color:#FF0000;  /* red */
		}	
	</style>
</head>

	<div id="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Menu Ganti Password</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>Update Password User</b>
                    </div>
                    <div class="panel-body">
                        <div class="row">	                     
	                        <div class="form-group">
	                        	<div class="col-lg-12">
	                        		<form id="formPass">
	                        			<input type="text" name="nipp" value="<?php echo $this->session->userdata('nipp')?>" hidden>
								        <div class="row">
			                            	<div class="col-lg-5">
				                            	<div class="form-group">
				                            	<label>Input Password Bassssru</label>
			                        				<input class="form-control" type="password" name="pass" id="pass" placeholder="Input Password Baru Disini..">
					                            </div>
			                            	</div>
			                            </div>
			                            <div class="row">
			                            	<div class="col-lg-5">
			                            		<div class="form-group">
				                            	<label>Konfirmasi Password Baru</label>
			                        				<input class="form-control" type="password" name="konf_pass" id="konf_pass" placeholder="Konfirmasi Password Baru Disini..">
					                            </div>
			                            	</div>
			                            </div>
			                            <hr>
								      <div class="row">
								      	<div class="col-lg-8">
								        <input class="btn btn-danger" type="reset" value="cancel" onclick="window.location.reload()">
	                            		<input class="btn btn-success" type="submit" value="submit" id="submit" disabled="">
		                            	</div>
								      </div>
	                        		</form>
	                        	</div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- /.wrapper -->
    <!-- DataTables JavaScript -->
    <script src="<?php echo base_url('template/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo base_url('template/vendor/datatables-plugins/dataTables.bootstrap.min.js')?>"></script>
    <script src="<?php echo base_url('template/vendor/datatables-responsive/dataTables.responsive.js')?>"></script>
    <script src="<?php echo base_url('template/vendor/confirm/jquery-confirm.min.js')?>"></script>
     <script type="text/javascript">
	    $(document).ready(function() {
	        $('#dataTables-example').DataTable({
	        	responsive: true,
	            // "scrollY": "200px",
		        "scrollCollapse": true,
		        // "paging":         false,
		        // "searching": false,
		        // "bInfo" : false
	        });

		    $('#konf_pass').change(function() {
		    	var pass = $('#pass').val();
		    	var kpass = $(this).val();
		    	// alert("nilai sum: "+sum+"; nilai btotal: "+btotal);
		    	if (kpass==pass ) {
		    		$(':input[type="submit"]').prop('disabled', false);
		    	}else{
		    		alert("Password tidak sama");
		    		$(':input[type="submit"]').prop('disabled', true);
		    	}
		    });
	    });
    </script>