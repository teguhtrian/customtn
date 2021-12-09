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
        // $(document).on('click', 'a.edit', function () { // <-- changes
        //     //alert($(this).attr('id'));
        //     id = $(this).attr('id');
        //     //$(this).closest('tr').remove();
        //     // location.replace('<?php echo base_url()?>admin/editDataUu/'+id);
        //     window.location.href = '<?php echo base_url()?>home/editBiayaBybId/'+id;
        //     return false;
        // });

        $(document).ready(function(){
            $('#rubrik').mask("99.99.99.");
            
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
                        $.post('<?php echo base_url()?>home/updateBiayaById/<?php echo $rubrik[0]->id?>', //akses modul ini
                            $('#formBiaya').serialize(), //data form dikirim secara serial
                            function(data,status){
                                alert(data);
                                //alert("Data berhasil di input");
                                location.replace('<?php echo base_url()?>home/menuBiaya/');
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

<body>
    <div id="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Menu Edit Rubrik Biaya</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Input Data Biaya</b>
                        </div>
                        <div class="panel-body">
                            <form id="formBiaya">
                              <!-- Modal body -->
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                        <label>Kantor/Unit</label>
                                            <select class="form-control" name="kocab" id="kocab">
                                                <?php
                                                    $fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
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
                                            <input class="form-control" type="text" name="rubrik" id="rubrik" placeholder="Input No Rubrik Disini.." value="<?php echo $rubrik[0]->rubrik?>">
                                        <span class="input-group-addon">.<?php echo $this->session->userdata('kocab')?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                        <label>Jenis Pembayaran</label>
                                            <input class="form-control" type="text" name="jenis" id="jenis" placeholder="Input Jenis Pembayaran Disini.." value="<?php echo $rubrik[0]->jenis?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                        <label>Item Bayar</label>
                                            <input class="form-control" type="text" name="item" id="item" placeholder="Input Item Pembayaran Disini.." value="<?php echo $rubrik[0]->itemnya?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                        <label>Biaya</label>
                                            <input class="form-control" type="text" name="biaya" id="biaya" placeholder="Input Biaya Disini.." value="<?php echo $fmt->formatCurrency($rubrik[0]->biaya,"IDR")?>">
                                        </div>
                                    </div>                                                  
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                        <label>PPN</label>
                                            <input class="form-control" type="text" name="ppn" id="ppn" value="10%" readonly="">
                                        </div>
                                    </div>                                                  
                                </div>                                
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                        <input class="btn btn-danger" type="reset" value="Cancel" onclick="window.location.reload()">
                                        <input class="btn btn-success" type="submit" value="Update" id="submit">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
    </div>
</body>