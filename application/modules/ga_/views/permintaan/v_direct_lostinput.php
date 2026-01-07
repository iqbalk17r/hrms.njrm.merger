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
				$("#kdsubgroup").chained("#kdgroup");
				//$("#kdbarang").chained("#kdsubgroup");
			////	$("#onhand").chained("#kdbarang");
			//alert ($('#kdsubgroup').val() != '');
					$('.kdbarang').change(function(){
						console.log($('#kdbarang').val() != '');
						if 	($('#kdbarang').val() != '') {						
							var param1=$(this).val();
							  $.ajax({
								url : "<?php echo site_url('ga/permintaan/js_viewstock')?>/" + param1,
								type: "GET",
								dataType: "JSON",
								success: function(data)
								{			   
									$('[name="onhand"]').val(data.conhand);                        
									$('[name="loccode"]').val(data.loccode);                                                          
						
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									alert('Error get data from ajax');
								}
							}); 
						};				
					});
				$('.drst').hide();
				$('#daristock').on('click', function() {
					if ($(this).val()=='YES') {
						console.log($(this).val());
						$('.drst').prop('required',true);
						$('.drst').show();
					} else if ($(this).val()=='NO') {
						console.log($(this).val());
						$('.drst').prop('required',false);
						$('.drst').hide();
					}
				});
				$('#daristockED').on('click', function() {
					if ($(this).val()=='YES') {
						console.log($(this).val());
						$('.drst').prop('required',true);
						$('.drst').show();
					} else if ($(this).val()=='NO') {
						console.log($(this).val());
						$('.drst').prop('required',false);
						$('.drst').hide();
					}
				});
					
					
			});
</script>

<legend><?php echo $title;?></legend>
<h5><b><strong><?php echo TRIM($dtlnik['nmlengkap']).'  ADA INPUTAN/EDITAN YANG BELUM TERSELESAIKAN SILAHAKAN LIHAT PADA LIST DIBAWAH';?></strong></b></h5>

<div class="row">
	<div class="col-xs-12">                            
		<div class="box">
			<div class="box-header"  align="center">
			<h5><b><strong><?php echo 'MASTER PBK';?></strong></b></h5>
			</div><!-- /.box-header -->	
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
								<tr>											
									<th width="2%">No.</th>
									<th>NODOK</th>
									<th>NOMOR TR</th>
									<th>NIK</th>
									<th>NAMA LENGKAP</th>
									<th>LOCCODE</th>
									<th>STATUS</th>
									<th>KETERANGAN</th>
									<th width="14%">>AKSI</th>
								</tr>
					</thead>
							<tbody>
							<?php $no=0; foreach($list_pbk_tmp_mst as $row): $no++;?>
						<tr>
							
							<td width="2%"><?php echo $no;?></td>
							<td><?php echo $row->nodok;?></td>
							<td><?php echo $row->nodoktmp;?></td>
							<td><?php echo $row->nik;?></td>
							<td><?php echo $row->nmlengkap;?></td>
							<td><?php echo $row->loccode;?></td>
							<td><?php echo $row->status;?></td>
							<td><?php echo $row->keterangan;?></td>
							<td width="14%">
							<a href="#" class="btn btn-success  btn-sm"><i class="fa fa-edit"></i> LANJUT </a>
							<a href="#" class="btn btn-danger  btn-sm"><i class="fa fa-edit"></i> HAPUS </a>
							</td>
						</tr>
						<?php endforeach;?>	
							</tbody>		
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div><!-- END ROW 1 --->
</div>	


<script type="text/javascript">
            $(function() {
			/* 		var rad = document.inputformPbk.optradio;
					var prev = null;
					for(var i = 0; i < rad.length; i++) {
						rad[i].onclick = function() {
							(prev)? console.log(prev.value):null;
							if(this !== prev) {
								prev = this;
							}
							console.log(this.value)
						};
					}
			
			
				$('#lookstockno').on('click change', function(e) {
					console.log(e.type);
				});
				
				$('#lookstockyes').onclick(function(){
						console.log('yes1');
			
					});
					 */	
			});
</script>
	  