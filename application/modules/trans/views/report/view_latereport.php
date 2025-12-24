<script type="text/javascript">
            $(function() {
                //$("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": true,
                    "bFilter": true,
                    "bSort": false,
                    "bInfo": true,
                    "bSearch": true,
                    "bAutoWidth": false
                });
            });
			//disabel enable selection
			/*function disableSelects(form){
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
		  }*/
</script>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
                        <div class="col-xs-12">  
						<a href="<?php echo site_url('trans/report');?>" class="btn btn-primary"style=" margin:10px"><i class="glyphicon glyphicon-search"></i><font color="#fffff"><b> FILTER</b></font></a>                                
						<p align='right' style='margin-right:10px'>Download Laporan Keterlambatan :
						<!--<a href="<?php echo site_url('hrd/report/pdf');?>"><i class='fa fa-file-text-o'></i> <label>PDF</label></a>
						<a href="<?php echo site_url('hrd/report/excel03');?>"><i class='fa fa-file-text-o'></i> <label>Excel 2003</label></a>-->
						<a href="<?php echo site_url("trans/report/excel_late/$periode/$kantor");?>"><i class='fa fa-file-text-o'></i> <label>Excel 2007</label></a></p>
						<div class="box">
                                <div class="box-header">
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive" style='overflow-x:scroll;'>
                                    <table id="example2" class="table table-bordered table-striped" >
                                        <thead>
											<tr>
												<th align="justify">Nama Karyawan</th>
												<!--<th align="justify">Total Keterlambatan</th>-->
												<th align="justify">Tanggal</th>
												<th align="justify">Jam Absen</th>
												<th align="justify">Durasi Keterlambatan</th>										
												<th align="justify">Ref Dokumen</th>										
											</tr>
										</thead>
                                        <tbody>
                                           <?php foreach($list_att as $cl) { ?>
											  <tr>
												 
												<td><?php  echo $cl->nmlengkap; ?></td>
												<td><?php echo $cl->tgl;?></td>
												<td><?php echo $cl->jam_masuk_absen;?></td>
												<td><?php if (trim($cl->kode=='B')) { echo '<b>TOTAL KETERLAMBATAN : '.$cl->total_terlambat.'</b>'; } else { echo $cl->total_terlambat;}?></td>
												<td><?php echo $cl->nodok_ref?></td>
												
											  </tr>	
											<?php } ?>
                                        </tbody>                                        
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
</div>
					<!--<div id="container"></div>-->
					

<script type="text/javascript">

</script>