<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h2>Status Input: <?php echo $data ?></h2><br>
    <p>
        
    </p>
		<!-- <p>Untuk kembali ke menu input silahkan klik <a href="<?php echo base_url('/home/formInputBpbra')?>"><strong>disini</strong></a></p>
		<p>Untuk mencetak BPBRA silahkan klik <a href="<?php echo base_url('/cetak/cetakBon/'.$no_kwitansi)?>" target="_blank"><strong>Cetak Bon</strong></a></p> -->

		<div class="row">
            <div class="col-lg-5 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-print fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">Cetak Surat</div>
                                <div>Bukti Penerimaan Bukan Rekening Air</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo base_url('/cetak/cetakBon/'.$no_kwitansi)?>" target="_blank">
                        <div class="panel-footer">
                            <span class="pull-left">Klik Disini</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-5 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-edit fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">Input Data</div>
                                <div>Bukti Penerimaan Bukan Rekening Air</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo base_url('/home/formInputBpbra')?>">
                        <div class="panel-footer">
                            <span class="pull-left">Klik Disini</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
</body>
</html>