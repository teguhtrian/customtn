<?php 
	$data['my_token'] = md5(uniqid(rand(), true));
	session_start();
	$_SESSION['my_token'] = $data['my_token'];
?>
<head>
	<META HTTP-EQUIV="refresh">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('template/dist/css/bootstrap-datepicker.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/typeahead/typeahead.css')?>">
   <link rel="stylesheet" href="<?php echo base_url('template/vendor/confirm/jquery-confirm.min.css')?>">
	<script type="text/javascript" src="<?php echo base_url('template/dist/js/bootstrap-datepicker.min.js')?>"></script>
	<script src="<?php echo base_url('asset/maskedinput/jquery.maskedinput.min.js')?>"></script>
	<script src="<?php echo base_url('asset/validate/dist/jquery.validate.js')?>"></script>
	<script src="<?php echo base_url('asset/typeahead/typeahead.bundle.js')?>"></script>
	<script src="<?php echo base_url('asset/handlebars/handlebars-v4.0.5.js')?>"></script>
	<script type="text/javascript">
		$body = $("body");

		$(document).on({
		    ajaxStart: function(){ 
		    	$body.addClass("loading");},
		    ajaxStop: function(){ 
		    	$body.removeClass("loading");
		    }    
		});

		$(document).on('click', "a[name='edit']", function () { // <-- changes
            //alert($(this).attr('id'));
            id = $(this).attr('id');
            //$(this).closest('tr').remove();
            // location.replace('<?php echo base_url()?>admin/editDataUu/'+id);
            window.location.href = '<?php echo base_url()?>home/editUserById/'+id;
            return false;
        });

        $(document).on('click', "a[name='hapus']", function () { // <-- changes
            //alert($(this).attr('id'));
            id = $(this).attr('id');
            //$(this).closest('tr').remove();
            // location.replace('<?php echo base_url()?>admin/editDataUu/'+id);
            // window.location.href = '<?php echo base_url()?>home/hapusBiayaBybId/'+id;
            // location.reload();
            $.confirm({
                title: 'Perhatian!',
                content: 'Data yang dihapus tidak bisa dikembalikan!<br>Yakin untuk dihapus?',
                buttons: {
                    Ya: function () {
                        //btnClass: 'btn-warning',
                        //$.alert('Confirmed!');
                        location.replace('<?php echo base_url()?>home/hapusUserBybId/'+id);
                    },
                    Batal: function () {
                        //$.alert('Hapus data dibatalkan.');
                    }
                }
            });
            return false;
        });

		var nipp = new Bloodhound({
            //datumTokenizer: function(d){ return Bloodhound.tokenizers.whitespace(d.npa);},
            datumTokenizer: Bloodhound.tokenizers.whitespace,
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			remote:{
				url: "<?php echo base_url('home/getNipp')?>",
				prepare: function (query, settings) {
                    settings.type = "POST";
                    settings.data = { query: query };
                    return settings;
                }
			}
        });

       	$(document).ready(function(){
       		
       		nipp.initialize();
	        $('#nipp').typeahead(null,{
	        	name: 'nipp',
	        	items:5,
	        	displayKey:'nipp',
	        	source:nipp,//.ttAdapter(),
	        	hint:true,
	        	templates:{
	        		empty: ['<div class="empty-message" align="center">','NIPP tidak ditemukan','</div>'].join('\n'),
				    suggestion:function(data){
				    	return '<div><strong>' + data.NIPP + ' -</strong> ' + data.fullname + '</div>'
				    }
	        	}
	    	}).bind('typeahead:select',function(e,sugestion){
	    		$('#nippUsr').val(sugestion.NIPP);
	    		$('#nipp').val(sugestion.NIPP);
	    		$('#nama').val(sugestion.fullname);
	    		$('#ketUser').val(sugestion.FixFullWorkUnitName);
	    	});

			$('#tanggal').datepicker({
				format: 'yyyy/mm/dd',
				setDate: new Date(),
				todayHighlight: true,
			});

            $('#submit').click(function(){
            	$('#myModal').modal('toggle');
                $('#formUser').validate({
                    errorClass: "my-error-class",
                    rules:{
                    	kocab:{
                            required:true,
                        },
                        nippUsr:{
                            required:true,
                        },
                        pass:{
                            required:true,
                        },
                        grup_user:{
                            required:true,
                        },
                    },

                    messages:{
                    	kocab:{
                            required:"Silahkan diisi",
                        },
                        nippUsr:{
                            required:"Silahkan diisi",
                        },
                        pass:{
                            required:"Silahkan diisi",
                        },
                        grup_user:{
                            required:"Silahkan diisi",
                        },
                    },

                    //fungsi submitHandler 
                    //untuk menggabungkan jquery validate
                    //dengan $.post
                    submitHandler: function(form){
                        $.post('<?php echo base_url()?>home/inputDataPengguna', //akses modul ini
                            $('#formUser').serialize(), //data form dikirim secara serial
                            function(data,status){
                                // alert(data);
                                //alert("Data berhasil di input");
                                $.confirm({
					                title: 'Perhatian!',
					                content: data,
					            });
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

		/* Start by setting display:none to make this hidden.
		   Then we position it in relation to the viewport window
		   with position:fixed. Width, height, top and left speak
		   for themselves. Background we set to 80% white with
		   our animation centered, and no-repeating */
		.modalload {
		    display:    none;
		    position:   fixed;
		    z-index:    1000;
		    top:        0;
		    left:       0;
		    height:     100%;
		    width:      100%;
		    background: rgba( 255, 255, 255, .8 ) 
		                url(<?php echo base_url('asset/images/load.gif')?>) 
		                50% 50% 
		                no-repeat;
		}

		/* When the body has the loading class, we turn
		   the scrollbar off with overflow:hidden */
		body.loading .modalload {
		    overflow: hidden;   
		}

		/* Anytime the body has the loading class, our
		   modal element will be visible */
		body.loading .modalload {
		    display: block;
		}
	</style>
</head>

	<div id="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Menu Pengguna Program</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>Data Pengguna</b>
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
		                                        <th>Kantor/Unit</th>
		                                        <th>Nama</th>
		                                        <th>Username</th>
		                                        <th>Grup Pengguna</th>
		                                        <th>&nbsp;</th>
		                                    </tr>
		                                </thead>
		                                <tbody>
		                                	<?php
		                                		$no=1;
			                                	foreach ($pengguna as $b) {
			                                		echo '<tr>
				                                		<td>'.$no.'.</td>
				                                		<td>'.$b->cabang.'</td>
				                                		<td>'.$b->fullname.'</td>
				                                		<td>'.$b->nipp.'</td>
				                                		<td>'.$b->grup_user.'</td>
				                                		<td><a id="'.$b->id.'" class="btn btn-primary" name="edit"><i class="fa fa-edit"></i> Edit</a> <a id="'.$b->id.'" class="btn btn-danger" name="hapus"><i class="fa fa-trash"></i> Hapus</a></td>
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
									        <button type="button" class="close" data-dismiss="modal">&times;</button>
									        <h4 class="modal-title" id="myModalLabel">Input Data Pengguna</h4>
									      </div>
									      <?php //echo form_open('home/inputDataBiaya')?>
									      <form id="formUser">
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
					                            	<div class="col-lg-7">
						                            	<label>NIPP</label>
					                            		<div class="form-group input-group">
					                        				<input class="form-control" type="text" name="nipp" id="nipp" placeholder="Cari Pengguna dengan NIPP Disini..">
					                        				<span class="input-group-addon">
					                        				<i class="fa fa-search"></i>
					                        				</span>
							                            </div>
					                            	</div>
					                            </div>
					                            <div class="row">
					                            	<div class="col-lg-5">
					                            		<div class="form-group">
						                            	<label>Nama</label>
					                        				<input class="form-control" type="text" name="nama" id="nama" readonly="">
							                            </div>
					                            	</div>
					                            	<div class="col-lg-4">
					                            		<div class="form-group">
						                            	<label>NIPP</label>
					                        				<input class="form-control" type="text" name="nippUsr" id="nippUsr" readonly="">
							                            </div>
					                            	</div>
					                            </div>
					                            <div class="row">
					                            	<div class="col-lg-8">
					                            		<div class="form-group">
						                            	<label>Keterangan User</label>
						                            		<textarea class="form-control" cols="15" rows="4" name="ketUser" id="ketUser" readonly=""></textarea>
							                            </div>
					                            	</div>
					                            </div>
					                            <div class="row">				                            	
					                            	<div class="col-lg-5">
					                            		<div class="form-group">
						                            	<label>Password</label>
					                        				<input class="form-control" type="password" name="pass" id="pass" placeholder="Input Password Disini..">
						                            	</div>
					                            	</div>					                            	
					                            </div>
					                            <div class="row">
					                            	<div class="col-lg-4">
					                            		<div class="form-group">
						                            	<label>Grup User</label>
					                        				<select class="form-control" name="grup_user" id="grup_user">
				                                                <option value="">-- Silahkan Pilih --</option>
				                                                <?php 
				                                                	if ($this->session->userdata('grup_user')=='1') {
				                                                		echo '<option value="1">Super Admin</option>';
				                                                		echo '<option value="2">Admin Cabang</option>';
				                                                	}
				                                                ?>
				                                                <option value="3">User</option>
				                                            </select>
							                            </div>
					                            	</div>
					                            </div>
					                          </div>
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

    <div class="modalload"><!-- Place at bottom of page --></div>