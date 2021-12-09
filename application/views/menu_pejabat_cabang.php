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
                $('#formPejabat').validate({
                    errorClass: "my-error-class",
                    rules:{                        
                    	kocab:{
                            required:true,
                        },
                    	nm_kacab:{
                            required:true,
                        },
                    	nm_kabag:{
                            required:true,
                        },
                    	nm_ast:{
                            required:true,
                        },                        
                    	jb_kacab:{
                            required:true,
                        },                        
                    	jb_kabag:{
                            required:true,
                        },                        
                    	jb_ast:{
                            required:true,
                        },                        
                    	nipp_kacab:{
                            required:true,
                        },                        
                    	nipp_kabag:{
                            required:true,
                        },                        
                    	nipp_ast:{
                            required:true,
                        },
                    },

                    messages:{
                    	kocab:{
                            required:"Silahkan diisi",
                        },
                    	nm_kacab:{
                            required:"Silahkan diisi",
                        },
                    	nm_kabag:{
                            required:"Silahkan diisi",
                        },
                    	nm_ast:{
                            required:"Silahkan diisi",
                        },                        
                    	jb_kacab:{
                            required:"Silahkan diisi",
                        },                        
                    	jb_kabag:{
                            required:"Silahkan diisi",
                        },                        
                    	jb_ast:{
                            required:"Silahkan diisi",
                        },                        
                    	nipp_kacab:{
                            required:"Silahkan diisi",
                        },                        
                    	nipp_kabag:{
                            required:"Silahkan diisi",
                        },                        
                    	nipp_ast:{
                            required:"Silahkan diisi",
                        },
                    },

                    //fungsi submitHandler 
                    //untuk menggabungkan jquery validate
                    //dengan $.post
                    submitHandler: function(form){
                        $.post('<?php echo base_url()?>home/inputDataPejabat', //akses modul ini
                            $('#formPejabat').serialize(), //data form dikirim secara serial
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
                <h1 class="page-header">Menu Pejabat</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>Data Pejabat Penandatangan</b>
                    </div>
                    <div class="panel-body">
                        <div class="row">	                     
	                        <div class="form-group">
	                        	<div class="col-lg-12">
	                        		<form id="formPejabat">
	                        			<div class="row">
			                            	<div class="col-lg-5">
			                            		<div class="form-group">
				                            	<label>Kantor/Unit</label>
			                        				<select class="form-control" name="kocab" id="kocab">
		                                                <option value="">-- Silahkan Pilih --</option>
			                        					<?php
			                        						foreach ($cabang as $c) {
			                        							echo '<option value="'.$c->Code.'">'.$c->nama.'</option>';
			                        						}
			                        					?>
		                                            </select>
					                            </div>
			                            	</div>
			                            </div>
								        <div class="row">
			                            	<div class="col-lg-5">
				                            	<div class="form-group">
				                            	<label>Nama Kepala Cabang</label>
			                        				<input class="form-control" type="text" name="nm_kacab" id="nm_kacab" placeholder="Input Nama Pejabat Disini.." value="<?php echo ($pejabat==NULL)?'':$pejabat[0]->nm_ttd_kacab;?>">
					                            </div>
			                            	</div>
			                            </div>
			                            <div class="row">
			                            	<div class="col-lg-8">
			                            		<div class="form-group">
				                            	<label>Jabatan Kepala Cabang</label>
			                        				<input class="form-control" type="text" name="jb_kacab" id="jb_kacab" placeholder="Input jabatan Disini.." value="<?php echo ($pejabat==NULL)?'':$pejabat[0]->jb_ttd_kacab;?>">
					                            </div>
			                            	</div>
			                            </div>
								        <div class="row">
			                            	<div class="col-lg-5">
				                            	<div class="form-group">
				                            	<label>Nipp Kepala Cabang</label>
			                        				<input class="form-control" type="text" name="nipp_kacab" id="nipp_kacab" placeholder="Input Nama Pejabat Disini.." value="<?php echo ($pejabat==NULL)?'':$pejabat[0]->nipp_kacab;?>">
					                            </div>
			                            	</div>
			                            </div>
			                            <hr>
								        <div class="row">
			                            	<div class="col-lg-5">
				                            	<div class="form-group">
				                            	<label>Nama Kepala Bagian</label>
			                        				<input class="form-control" type="text" name="nm_kabag" id="nm_kabag" placeholder="Input Nama Pejabat Disini.." value="<?php echo ($pejabat==NULL)?'':$pejabat[0]->nm_ttd_kabag;?>">
					                            </div>
			                            	</div>
			                            </div>
			                            <div class="row">
			                            	<div class="col-lg-8">
			                            		<div class="form-group">
				                            	<label>Jabatan Kepala Bagian</label>
			                        				<input class="form-control" type="text" name="jb_kabag" id="jb_kabag" placeholder="Input jabatan Disini.." value="<?php echo ($pejabat==NULL)?'':$pejabat[0]->jb_ttd_kabag;?>">
					                            </div>
			                            	</div>
			                            </div>
								        <div class="row">
			                            	<div class="col-lg-5">
				                            	<div class="form-group">
				                            	<label>Nipp Kepala Bagian</label>
			                        				<input class="form-control" type="text" name="nipp_kabag" id="nipp_kabag" placeholder="Input Nama Pejabat Disini.." value="<?php echo ($pejabat==NULL)?'':$pejabat[0]->nipp_kabag;?>">
					                            </div>
			                            	</div>
			                            </div>
			                            <hr>
								        <div class="row">
			                            	<div class="col-lg-5">
				                            	<div class="form-group">
				                            	<label>Nama Asisten</label>
			                        				<input class="form-control" type="text" name="nm_ast" id="nm_ast" placeholder="Input Nama Pejabat Disini.." value="<?php echo ($pejabat==NULL)?'':$pejabat[0]->nm_ttd_ast;?>">
					                            </div>
			                            	</div>
			                            </div>
			                            <div class="row">
			                            	<div class="col-lg-8">
			                            		<div class="form-group">
				                            	<label>Jabatan Asisten</label>
			                        				<input class="form-control" type="text" name="jb_ast" id="jb_ast" placeholder="Input jabatan Disini.." value="<?php echo ($pejabat==NULL)?'':$pejabat[0]->jb_ttd_ast;?>">
					                            </div>
			                            	</div>
			                            </div>
								        <div class="row">
			                            	<div class="col-lg-5">
				                            	<div class="form-group">
				                            	<label>Nipp Asisten</label>
			                        				<input class="form-control" type="text" name="nipp_ast" id="nipp_ast" placeholder="Input Nama Pejabat Disini.." value="<?php echo ($pejabat==NULL)?'':$pejabat[0]->nipp_ast;?>">
					                            </div>
			                            	</div>
			                            </div>
			                            <hr>
								      <div class="row">
								      	<div class="col-lg-8">
								        <input class="btn btn-danger" type="reset" value="batal" onclick="window.location.reload()">
	                            		<input class="btn btn-success" type="submit" value="Input" id="submit">
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
	    });
    </script>