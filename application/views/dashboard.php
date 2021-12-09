<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Page-Level Plugin CSS - Tables -->
    <link href=<?php echo base_url("template/vendor/dataTables/css/dataTables.bootstrap.css") ?> rel="stylesheet">
    <link href=<?php echo base_url('template/vendor/font-awesome/css/font-awesome.min.css') ?> rel="stylesheet" type="text/css">
</head>

<body>
    <div id="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dashboard</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <b>DATA PELANGGAN</b>
                    </div>
                    <div class="panel-body">
                        <?php //echo form_open('home/inputPelanggan'); 
                        ?>
                        <form id="formInputPelanggan">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            A. DATA PELANGGAN PADA <?php echo date("d-m-Y") ?>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                                    <col style="width:5%">
                                                    <col style="width:15%">
                                                    <col style="width:20%">
                                                    <col style="width:30%">
                                                    <col style="width:10%">
                                                    <col style="width:20%">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>NPA</th>
                                                            <th>Nama</th>
                                                            <th>Alamat</th>
                                                            <th>Tarif</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="odd gradeX">
                                                            <td>Trident</td>
                                                            <td>Internet Explorer 4.0</td>
                                                            <td>Win 95+</td>
                                                            <td class="center">4</td>
                                                            <td class="center">X</td>
                                                            <td class="center"><button class="btn btn-info">Lihat Detail</button> <button class="btn btn-success">Edit</button></td>
                                                        </tr>
                                                        <tr class="even gradeC">
                                                            <td>Trident</td>
                                                            <td>Internet Explorer 5.0</td>
                                                            <td>Win 95+</td>
                                                            <td class="center">5</td>
                                                            <td class="center">C</td>
                                                            <td class="center"><button class="btn btn-info">Lihat Detail</button> <button class="btn btn-success">Edit</button></td>
                                                        </tr>
                                                        <tr class="odd gradeA">
                                                            <td>Trident</td>
                                                            <td>Internet Explorer 5.5</td>
                                                            <td>Win 95+</td>
                                                            <td class="center">5.5</td>
                                                            <td class="center">A</td>
                                                            <td class="center"><button class="btn btn-info">Lihat Detail</button> <button class="btn btn-success">Edit</button></td>
                                                        </tr>
                                                        <tr class="even gradeA">
                                                            <td>Trident</td>
                                                            <td>Internet Explorer 6</td>
                                                            <td>Win 98+</td>
                                                            <td class="center">6</td>
                                                            <td class="center">A</td>
                                                            <td class="center"><button class="btn btn-info">Lihat Detail</button> <button class="btn btn-success">Edit</button></td>
                                                        </tr>
                                                        <tr class="odd gradeA">
                                                            <td>Trident</td>
                                                            <td>Internet Explorer 7</td>
                                                            <td>Win XP SP2+</td>
                                                            <td class="center">7</td>
                                                            <td class="center">A</td>
                                                            <td class="center"><button class="btn btn-info">Lihat Detail</button> <button class="btn btn-success">Edit</button></td>
                                                        </tr>
                                                        <tr class="even gradeA">
                                                            <td>Trident</td>
                                                            <td>AOL browser </td>
                                                            <td>Win XP</td>
                                                            <td class="center">6</td>
                                                            <td class="center">A</td>
                                                            <td class="center"><button class="btn btn-info">Lihat Detail</button> <button class="btn btn-success">Edit</button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Theme JavaScript -->
    <script src=<?php echo base_url('template/dist/js/sb-admin-2.js') ?>></script>
    <!-- Page-Level Plugin Scripts - Tables -->
    <script src=<?php echo base_url("template/vendor/dataTables/js/jquery.dataTables.js") ?>></script>
    <script src=<?php echo base_url("template/vendor/dataTables/js/dataTables.bootstrap.js") ?>></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').dataTable();
        });
    </script>
</body>

</html>