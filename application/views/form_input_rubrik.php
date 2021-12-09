<?php 
	$data['my_token'] = md5(uniqid(rand(), true));
	session_start();
	$_SESSION['my_token'] = $data['my_token'];
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
		$(document).ready(function(){

            $('#submit').click(function(){
                $('#formMeterInput').validate({
                    errorClass: "my-error-class",
                    rules:{
                        npa:{
                            required:true,
                        },
                        nohp:{
                            required:true,
                            number:true,
                            maxlength:12,
                        },
                    },

                    messages:{
                        npa:{
                            required: "NPA tidak boleh kosong!",
                        },
                        nohp:{
                            required:"Silahkan pilih keterangan",
                            number:"Silahkan input Angka saja!",
                            maxlength:"Maksimum 12 digit",
                        },
                    },

                    //fungsi submitHandler 
                    //untuk menggabungkan jquery validate
                    //dengan $.post
                    submitHandler: function(form){
                        $.post('<?php echo base_url()?>home/getBpbraPeriod', //akses modul ini
                            $('#formMeterInput').serialize(), //data form dikirim secara serial
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
                    <h1 class="page-header">Menu Input BPBRA</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Data BPBRA</b>
                        </div>
                        <div class="panel-body">
                        	<form>

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

</body>