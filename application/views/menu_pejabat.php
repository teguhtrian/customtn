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
                $('#formBiaya').validate({
                    errorClass: "my-error-class",
                    rules:{
                    	kocab:{
                            required:true,
                        },
                    	rubrik:{
                            required:true,
                        },
                        jenis:{
                            required:true,
                        },
                        item:{
                            required:true,
                        },
                        biaya:{
                            required:true,
                        },
                    },

                    messages:{
                        kocab:{
                            required:"Silahkan diisi",
                        },
                    	rubrik:{
                            required:"Silahkan diisi",
                        },
                        jenis:{
                            required:"Silahkan diisi",
                        },
                        item:{
                            required:"Silahkan diisi",
                        },
                        biaya:{
                            required:"Silahkan diisi",
                        },
                    },

                    //fungsi submitHandler 
                    //untuk menggabungkan jquery validate
                    //dengan $.post
                    submitHandler: function(form){
                        $.post('<?php echo base_url()?>home/inputDataBiaya', //akses modul ini
                            $('#formBiaya').serialize(), //data form dikirim secara serial
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
                <h1 class="page-header">Menu Rubrik Biaya</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>Data Rubrik Biaya</b>
                    </div>
                    <div class="panel-body">
                        <div class="row">	                     
	                        <div class="form-group">
	                        	<div class="col-lg-12">
	                        		<!-- <a href="<?php echo base_url().'home/inputDataBiaya';?>" type="button" class="btn btn-primary">Input Data Biaya</a> -->
	                        		<!-- Button to Open the Modal -->
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
									  Input Data
									</button>
				                    <br><hr>
	                        		<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example" style="font-size: 12px">
			                        	<thead>
		                                    <tr>
		                                        <th>No.</th>
		                                        <th>No. Rubrik</th>
		                                        <th>Jenis</th>
		                                        <th>Biaya</th>
		                                        <th>Item</th>
		                                        <th>PPN</th>
		                                        <th></th>
		                                    </tr>
		                                </thead>
		                                <tbody>
		                                	<?php
		                                		$no=1;
		                                		$fmt = new NumberFormatter('en_IN', NumberFormatter::CURRENCY);
			                                	foreach ($biaya as $b) {
			                                		echo '<tr>
				                                		<td>'.$no.'.</td>
				                                		<td>'.$b->rubrik.$this->session->userdata('kocab').'</td>
				                                		<td>'.$b->jenis.'</td>
				                                		<td>'.$fmt->formatCurrency($b->biaya,"IDR").'</td>
				                                		<td>'.$b->itemnya.'</td>
				                                		<td>'.$b->ppn.'%</td>
				                                		<td><a id="'.$b->id.'" class="edit"><i class="fa fa-edit"></i></a> <a id="'.$b->id.'" class="erase"><i class="fa fa-times"></i></a></td>
				                                	</tr>';
				                                	$no++;
			                                	}
		                                	?>
		                                </tbody>
			                        </table>
			                        <!-- The Modal -->
									<div class="modal" id="myModal">
									  <div class="modal-dialog">
									    <div class="modal-content">

									      <!-- Modal Header -->
									      <div class="modal-header">
									        <h4 class="modal-title">Input Data Biaya</h4>
									        <button type="button" class="close" data-dismiss="modal">&times;</button>
									      </div>
									      <?php //echo form_open('home/inputDataBiaya')?>
									      <form id="formBiaya">
										      <!-- Modal body -->
										      <div class="modal-body">
										      	<div class="row">
					                            	<div class="col-lg-8">
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
						                            	<label>No. Rubrik</label>
					                            		<div class="form-group input-group">
					                        				<input class="form-control" type="text" name="rubrik" id="rubrik" placeholder="Input No Rubrik Disini..">
							                            <span class="input-group-addon">.<?php echo $this->session->userdata('kocab')?></span>
							                            </div>
					                            	</div>
					                            </div>
					                            <div class="row">
					                            	<div class="col-lg-8">
					                            		<div class="form-group">
						                            	<label>Jenis Pembayaran</label>
					                        				<input class="form-control" type="text" name="jenis" id="jenis" placeholder="Input Jenis Pembayaran Disini..">
							                            </div>
					                            	</div>
					                            </div>
					                            <div class="row">
					                            	<div class="col-lg-8">
					                            		<div class="form-group">
						                            	<label>Item Bayar</label>
					                        				<input class="form-control" type="text" name="item" id="item" placeholder="Input Item Pembayaran Disini..">
							                            </div>
					                            	</div>
					                            </div>
					                            <div class="row">
					                            	<div class="col-lg-5">
					                            		<div class="form-group">
						                            	<label>Biaya</label>
					                        				<input class="form-control" type="text" name="biaya" id="biaya" placeholder="Input Biaya Disini..">
							                            </div>
					                            	</div>					                            	
					                            	<div class="col-lg-3">
					                            		<div class="form-group">
						                            	<label>PPN</label>
					                        				<input class="form-control" type="text" name="ppn" id="ppn" value="10%" readonly="">
						                            	</div>
					                            	</div>					                            	
					                            </div>
					                          </div>

										      <!-- Modal footer -->
										      <div class="modal-footer">
										        <input class="btn btn-danger" type="reset" value="batal" onclick="window.location.reload()">
			                            		<input class="btn btn-success" type="submit" value="Input" id="submit">
										      </div>
									      </form>
									    </div>
									  </div>
									</div>
	                        	</div>	
	                        </div>
                        </div>	
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
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