<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
			//disabel enable selection
			function disableSelects(form){
			for(var i=0;i<form.elements.length;i++){
			  if(form.elements[i].type.match(/select/i)){
				 form.elements[i].disabled = 1;
			  }
			  if(form.elements[i].type.match(/checkbox/i)){
				 form.elements[i].onclick = function(){
				 this.parentNode.getElementsByTagName('select')[0].disabled =
				 this.parentNode.getElementsByTagName('select')[0].disabled == 0 ? 1 : 0; 
				}
			  }
			}
		  }
</script>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div id="container"></div>
<div class="row">
                        <div class="col-xs-12"> 
						<a href="<?php echo site_url('hrd/report');?>" class="btn btn-primary" style=" margin:10px"><i class="glyphicon glyphicon-search"></i><font color="#fffff"><b> FILTER</b></font></a>                                
						<!--<p align='right' style='margin-right:10px'>Download Laporan Status Kepegawaian:
						<a href="<?php echo site_url('hrd/report/pdf');?>"><i class='fa fa-file-text-o'></i> <label>PDF</label></a>
						<a href="<?php echo site_url('hrd/report/excel03');?>"><i class='fa fa-file-text-o'></i> <label>Excel 2003</label></a>
						<a href="<?php echo site_url('hrd/report/excel07');?>"><i class='fa fa-file-text-o'></i> <label>Excel 2007</label></a></p>-->
						<div class="box">
                                <div class="box-header">
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive" style='overflow-x:scroll;'>
                                    <table <?php if(!empty($list_stspeg))
												 {
												 echo 'id="example1"';
												 } 
												 
												 ?> class="table table-bordered table-striped" >
                                        <thead>

											<tr>
												<th align="justify">Nama</th>
												<th align="justify">NIP</th>
												<th align="justify">Departement/Sub Departement</th>
												<th align="justify">Jabatan</th>
												<th align="justify">Masuk Kerja </th>
												<th align="justify">OJT</th>
												<th align="justify">PKWT1</th>
												<th align="justify">PKWT2</th>
												<th align="justify">Permanen</th>
												<th align="justify">NO SK</th>
												<th align="justify">Keterangan</th>
																				
											</tr>
										</thead>
                                        <tbody>
                                            <?php
												 //Menampilkan data turn over yang ada
												 if(empty($list_stspeg))
												 {
												 echo "<tr><td colspan=\"11\">Data tidak tersedia</td></tr>";
												 }else
												 {
												 foreach($list_stspeg as $column)
												 {
												?>
											  <tr>
												<!--Junis 18-08-2015-->
												<td><?php echo $column->nmlengkap;?></td>
												<td><?php echo $column->nip;?></td>
												<td><?php echo $column->departement;?>/<?php echo $column->subdepartement;?></td>
												<td><?php echo $column->deskripsi;?></td>
												<td><?php echo $column->masuk;?></td>
												<td><?php echo $column->ojt;?></td>
												<td><?php echo $column->pwkt1;?></td>
												<td><?php echo $column->pwkt2;?></td>
												<td><?php echo $column->tetap;?></td>						
												<td><?php echo $column->nosk;?></td>						
												<td><?php echo $column->ket;?></td>						
											  </tr>	
											<?php }} ?>
                                        </tbody>
										<tfoot>
											<tr>
												<th colspan='5' align="justify">TOTAL</th>
												<th align="justify"><?php echo $ttl_stspeg['ojt'];?></th>
												<th align="justify"><?php echo $ttl_stspeg['pkwt1'];?></th>
												<th align="justify"><?php echo $ttl_stspeg['pkwt2'];?></th>
												<th align="justify"><?php echo $ttl_stspeg['tetap'];?></th>												
												<th align="justify"></th>
												<th align="justify"></th>												
											</tr>
										</tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
					

<script type="text/javascript">
$(function () {
    var chart;
    
    $(document).ready(function () {
    	
    	// Build the chart
        $('#container').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: '<?php echo $title;?>'
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.y:.0f} orang</b>  <b>({point.percentage:.0f}%)</b> '
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: 'Jumlah',
                data: [
                    ['OJT',   <?php echo $ttl_stspeg['ojt'];?>],
                    ['PKWT 1',<?php echo $ttl_stspeg['pkwt1'];?>],                    
                    ['PKWT 2',<?php echo $ttl_stspeg['pkwt2'];?>],
                    ['TETAP', <?php echo $ttl_stspeg['tetap'];?>],                    
                ]
            }],			
        });
    });
    
});
		</script>
	</head>
	<body>

<script src="../../js/highcharts.js"></script>
<script src="../../js/highcharts-3d.js"></script>
<script src="../../js/modules/exporting.js"></script>

<div id="container" style="height: 400px"></div>
	</body>
</html>
