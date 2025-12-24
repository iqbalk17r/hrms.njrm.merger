<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example4").dataTable();
				//datemask
				//$("#datemaskinput").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});                               
				//$("#datemaskinput").daterangepicker();                              
				$("#dateinput").datepicker();                               
            });			
</script>
<legend><?php echo $title;?></legend>
<?php echo $message; ?>
				<div class="row">
					
				   <div class="col-xs-12">
						<div><a href="<?php echo site_url('recruitment/calonkaryawan');?>" type="button" class="btn btn-primary"/> Kembali</a></div></br>
						<div class="box">
							<div class="box-header">
					  
					</div><!-- /.box-header -->	
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped" >
                                    <thead>
										<tr>											
											
											<th>No.</th>
											<th>No. KTP</th>
											<th>Nama Pelamar</th>
											<th>Tanggal Lahir</th>
											<th>Posisi Diminati</th>
											<th>Contact 1</th>
											<th>Contact 2</th>
											<th>Email</th>
											<th>Tgl Lowongan</th>
											<th>Tgl Lamaran</th>
													
										</tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($list_lebih as $row): $no++;?>
								<tr>
									
									<td><?php echo $no;?></td>
									<td><a href="<?php echo site_url('recruitment/calonkaryawan/dtllist_pelamar_lebih').'/'.$row->noktp;?>"><?php echo $row->noktp ?></a></td>
									<td><?php echo $row->nmlengkap;?></td>
									<td><?php echo $row->tgllahir;?></td>
									<td><?php echo $row->kdposisi;?></td>
									<td><?php echo $row->nohp1;?></td>
									<td><?php echo $row->nohp2;?></td>
									<td><?php echo $row->email;?></td>
									<td><?php echo $row->tgllowongan;?></td>
									<td><?php echo $row->tgllamaran;?></td>
									
								</tr>
								<?php endforeach;?>	
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
				</div>
<!-- Modal Input bank -->

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">

</div>
</div>  


<script>

  $("[data-mask]").inputmask();

	
	//Date range picker
    $('#tgl').datepicker();

  

</script>