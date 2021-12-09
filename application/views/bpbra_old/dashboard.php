<head>
    <!-- DataTables JavaScript -->
    <script src="<?php echo base_url('template/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo base_url('template/vendor/datatables-plugins/dataTables.bootstrap.min.js')?>"></script>
    <script src="<?php echo base_url('template/vendor/datatables-responsive/dataTables.responsive.js')?>"></script>
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
</head>
<body>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dashboard</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
	        <div class="panel-heading">
	            <i class="fa fa-th-list fa-fw"></i> BPBRA Hari ini (<strong> <?php echo date('d-m-Y')?> </strong>)
	        </div>
	        <!-- /.panel-heading -->
	        <div class="panel-body">
	            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example" style="font-size: 12px">
                	<thead>
                        <tr>
                            <th>No.</th>
                            <th>No Kwitansi</th>
                            <th>NPA/Nama</th>
                            <th>Alamat</th>
                            <th>Pembayaran</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php
                    		$no=1;
                        	foreach ($bpbra as $b) {
                        		echo '<tr>
                            		<td>'.$no.'.</td>
                            		<td>'.$b->no_kwitansi.'</td>
                            		<td>'.$b->npa.' | '.$b->nm_ctm.'</td>
                            		<td>'.$b->alamat.'</td>
                            		<td>'.$b->item.'</td>
                            		<td><form action="http://10.61.0.201:8080/bpbra/cetak/cetakbon/'.$b->no_kwitansi.'" method="post" accept-charset="utf-8" id="myform" target="_blank"><button type="submit" class="btn btn-success"><i class="fa fa-print fa-fw"></i> Cetak</button></form></td>
                            	</tr>';
                            	$no++;
                        	}
                    	?>
                    </tbody>
                </table>
	        </div>
	        <!-- /.panel-body -->
	    </div>
	    <!-- /.panel -->		
	</div>
</div>
</body>