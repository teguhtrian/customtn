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
                        $.post('<?php echo base_url()?>home/updatePenggunaById/<?php echo $user[0]->id?>', //akses modul ini
                            $('#formBiaya').serialize(), //data form dikirim secara serial
                            function(data,status){
                                alert(data);
                                //alert("Data berhasil di input");
                                location.replace('<?php echo base_url()?>home/menuPengguna/');
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
                    <h1 class="page-header">Menu Edit Pengguna</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Edit Data Pengguna</b>
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
                                        <div class="form-group">
                                        <label>Nama</label>
                                            <input class="form-control" type="text" name="nama" id="nama" readonly="" value="<?php echo $user[0]->fullname?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                        <label>NIPP</label>
                                            <input class="form-control" type="text" name="nippUsr" id="nippUsr" readonly="" value="<?php echo $user[0]->nipp?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                        <label>Keterangan User</label>
                                            <textarea class="form-control" cols="15" rows="4" name="ketUser" id="ketUser" readonly=""><?php echo $user[0]->FixFullWorkUnitName?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                                               
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                        <label>Password</label>
                                            <input class="form-control" type="password" name="pass" id="pass" placeholder="Input Password Disini.." value="<?php echo $user[0]->password?>">
                                        </div>
                                    </div>                                                  
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                        <label>Grup User</label>
                                            <select class="form-control" name="grup_user" id="grup_user" readonly>
                                                <!-- <option value="">-- Silahkan Pilih --</option> -->
                                                <?php 
                                                    if ($this->session->userdata('grup_user')=='1') {
                                                        if ($user[0]->grup_user=='1') {
                                                            echo '<option value="1" selected>Super Admin</option>';
                                                        }else{
                                                            echo '<option value="1">Super Admin</option>';
                                                        }

                                                        if ($user[0]->grup_user=='2') {
                                                            echo '<option value="2" selected>Admin Cabang</option>';
                                                        }else{
                                                            echo '<option value="2">Admin Cabang</option>';
                                                        }
                                                    }
                                                ?>
                                                <option value="3" <?php echo $user[0]->password=='3'?'selected':''; ?>>User</option>
                                            </select>
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