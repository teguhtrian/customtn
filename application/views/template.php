<!DOCTYPE html>
<html>

<head>
    <title>CustomTN</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Core CSS -->
    <link href=<?php echo base_url('template/vendor/bootstrap/css/bootstrap.min.css') ?> rel="stylesheet">

    <!-- Bootstrap Core CSS -->
    <link href=<?php //echo base_url('template/vendor/bootstrap/css/bootstrap.css')
                ?> rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href=<?php echo base_url('template/vendor/metisMenu/metisMenu.min.css') ?> rel="stylesheet">

    <!-- Custom CSS -->
    <link href=<?php echo base_url('template/dist/css/sb-admin-2.css') ?> rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href=<?php echo base_url('template/vendor/morrisjs/morris.css') ?> rel="stylesheet">

    <!-- Custom Fonts -->
    <link href=<?php echo base_url('template/vendor/font-awesome/css/font-awesome.min.css') ?> rel="stylesheet" type="text/css">

    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="text/css" href=<?php echo base_url('asset/images/fix.png') ?>>

    <!-- jQuery -->
    <script src=<?php echo base_url('template/vendor/jquery/jquery.min.js') ?>></script>

    <!-- Bootstrap Core JavaScript -->
    <script src=<?php echo base_url('template/vendor/bootstrap/js/bootstrap.min.js') ?>></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src=<?php echo base_url('template/vendor/metisMenu/metisMenu.min.js') ?>></script>

    <!-- Custom Theme JavaScript -->
    <script src=<?php echo base_url('template/dist/js/sb-admin-2.js') ?>></script>

    <!-- Morris Charts JavaScript -->
    <script src=<?php // echo base_url('template/vendor/raphael/raphael.min.js') 
                ?>></script>
    <script src=<?php // echo base_url('template/vendor/morrisjs/morris.min.js') 
                ?>></script>
    <script src=<?php //echo base_url('template/data/morris-data.js')
                ?>></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <[endif]-->
</head>

<body>
    <?php //var_dump($data);
    ?>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url('home'); ?>"><img src="<?php echo base_url('asset/images/logo.png'); ?>" alt="logoPDAM" width="100%" height="100%" align="middle"></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <strong><?php echo $this->session->userdata('fullname'); ?></strong> : <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><?php echo anchor('login/changePass', '<i class="fa fa-user fa-fw"></i> Ganti Password'); ?>
                        </li>
                        <li class="divider"></li>
                        <li><?php echo anchor('login/logout', '<i class="fa fa-sign-out fa-fw"></i> Logout'); ?>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <strong>Menu Utama</strong>
                        </li>
                        <li>
                            <?php echo anchor('home', '<i class="fa fa-dashboard fa-fw"></i> Dashboard'); ?>
                        </li>
                        <li>
                            <?php echo anchor('home/formInputPelanggan', '<i class="fa fa-edit fa-fw"></i> Input Data Pelanggan'); ?>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-print fa-fw"></i> Cetak<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <?php echo anchor('home/ctkFormDaPel', '<i class="fa fa-print fa-fw"></i> Cetak Form Data Pelanggan per Buku'); ?>
                                </li>
                                <li>
                                    <?php echo anchor('home/ctkProgressInput', '<i class="fa fa-print fa-fw"></i> Cetak Form Data Pelanggan per Buku'); ?>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li <?php echo ($this->session->userdata('grup_user') == '3') ? 'style="display: none"' : ''; ?>>
                            <a href="#"><i class="fa fa-gears fa-fw"></i> Setting<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <?php echo anchor('home/menuBiaya', '<i class="fa fa-list-alt fa-fw"></i> Data Rubrik Pembayaran'); ?>
                                </li>
                                <li>
                                    <?php echo anchor('home/menuPejabat', '<i class="fa fa-user-md fa-fw"></i> Data Pejabat'); ?>
                                </li>
                                <li>
                                    <?php echo anchor('home/menuPengguna', '<i class="fa fa-user fa-fw"></i> Data Pengguna'); ?>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <?php $this->load->view($content) ?>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <!-- SB Admin Scripts - Include with every page -->
    <script src=<?php echo base_url("template/js/sb-admin-2.js") ?>></script>
</body>

</html>