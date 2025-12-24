<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();                             
				$("#dateinput").datepicker();                               
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();	
            });
		
</script>

<legend><?php echo $title;?></legend>


<form action="<?php echo site_url('trans/cuti_karyawan/savecutibersama')?>" method="post">

	
		<div class="modal fade <?php echo trim($lu->nodok,'');?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<form class="form-horizontal" action="<?php echo site_url('dashboard/edit_user');?>" method="post">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<h4 class="modal-title" id="myModalLabel">EDIT</h4>
										</div>
										<div class="modal-body">
										
											<div class="row">
												<div class="box">
													<div class="box-body table-responsive">
														<table id="example3" class="table table-bordered table-striped" >
															<thead>
																<tr>																	
																	<th>Pilih</th> 
																	<th>Nik</th>
																	<th>Nama Karyawan</th>
																	<th>Departemen</th>
																</tr>
															</thead>
															<tbody>
																<?php $no=0; foreach($listkary as $db){ $no++;?>
																<tr>																	
																	<td><input name="<?php echo trim($db->nik);?>" value="Y" type="checkbox" <?php foreach ($listblc as $usr) {																		
																		if ($usr->no_dokumen==$lu->nodok and $db->nik==$usr->nik){
																			echo 'checked';
																		} 
																	}//if ($col->userid==$row->userid) { echo 'checked';}?>></td>															
																	<td><?php echo $db->nik;?></td>
																	<td><?php echo $db->nmlengkap;?></td>
																	<td><?php echo $db->bag_dept;?></td>																	
																</tr>
																<?php }?>
															</tbody>
														</table>
													</div><!-- /.box-body -->
												</div>
											</div>
											
										</div>
										<div class="modal-footer">											
											<button type="submit" class="btn btn-primary" onclick="return confirm('Yakin Simpan Perubahan User: <?php echo $lu->nodok;?>?')">Simpan</button>	
											<a class="btn btn-primary" href="<?php echo site_url('dashboard/hapus_user/'.$lu->nodok);?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus User: <?php echo $lu->nodok;?>?')"><i class="glyphicon glyphicon-trash"></i>Hapus</a>											
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										</div>
										</form>
									</div>
								  </div>
								</div>
								
								
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
</div>
	
</form>
