<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
				
				
								$modal = $('.pp');
				$('#example1').on('click', '.show', function () {
						//var data = $('#example1').DataTable().row( this ).data();
						//alert( 'You clicked on '+data[0]+'\'s row' );
						var el = $(this);
						//alert(el.attr('data-url'));
						$modal.load(el.attr('data-url'), '', function(){
						$modal.modal();
					
					
					} );
				} );
            });
			

</script>
<legend><?php echo $title;?></legend>
<?php echo $message; ?>
				<div class="row">
                    <div class="col-xs-12">
						<div class="box">
							<div class="box-header">
					   <a class="btn btn-primary" href="<?php echo site_url('recruitment/calonkaryawan/input')?>" style="margin:10px; color:#ffffff;"><i class="glyphicon glyphicon-plus"></i> INPUT</a>
					   <button href="#" data-toggle="modal" data-target="#filter" class="btn btn-primary" style="margin:10px; color:#ffffff;">Filter</button>
					   <a class="btn btn-warning" href="<?php echo site_url('recruitment/calonkaryawan/list_pelamar_lebih')?>" style="margin:10px; color:#ffffff;"><i class="glyphicon glyphicon-person"></i> List Lebih dari 1 Lamaran</a>
					</div><!-- /.box-header -->	
                            <div class="box-body">
                                <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
										<tr>											
											
											<th>No.</th>
											<th>No. KTP</th>
											<th>Nama Pelamar</th>
											<th>Usia</th>
											<th width="10%">Tanggal Lahir</th>
											<th>Posisi Diminati</th>
											<th>Contact 1</th>
											<th>Contact 2</th>
											<th width="20%">Email</th>
											<th width="10%">Tgl Lowongan</th>
											<th width="10%">Tgl Lamaran</th>
											<th width="20%">Status</th>
											<th>Action</th>
													
										</tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($list_pelamar as $row): $no++;?>
								<tr>
									
									<td><?php echo $no;?></td>
									<td><a href="<?php echo site_url('recruitment/calonkaryawan/dtlpelamar').'/'.trim($row->noktp).'/'.trim($row->tgllowongan).'/'.trim($row->tgllamaran);?>"><?php echo $row->noktp ?></a></td>
									<td><?php echo $row->nmlengkap;?></td>
									<td><?php echo $row->usia;?></td>
									<td><?php echo date('d-m-Y',strtotime($row->tgllahir));?></td>
									<td><?php echo $row->kdposisi;?></td>
									<td><?php echo $row->nohp1;?></td>
									<td><?php echo $row->nohp2;?></td>
									<td width="20%"><?php echo $row->email;?></td>
									<td><?php echo date('d-m-Y',strtotime($row->tgllowongan));?></td>
									<td><?php echo date('d-m-Y',strtotime($row->tgllamaran)) ;?></td>
									<td  width="20%"><?php echo $row->statusnya;?></td>
									<td><!--a href="<?php echo site_url('recruitment/calonkaryawan/hps_pelamar').'/'.trim($row->noktp).'/'.$row->tgllowongan.'/'.$row->tgllamaran;?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Anda Yakin Menghapus Data Pelamar Ini? ini?')"><i class="glyphicon glyphicon-trash"></i></a--->
									<a data-url="<?php echo site_url('recruitment/calonkaryawan/up_status').'/'.trim($row->noktp).'/'.$row->tgllowongan.'/'.$row->tgllamaran;?>" data-toggle="modal" data-target=".pp" class="btn btn-primary  btn-sm show"> Status
									
									<!--a  <?php $nik=trim($lu->nik); $no_urut=trim($lu->no_urut); $nodok=trim($lu->nodok);?> data-url="<?php echo site_url("payroll/issfinal_payroll/detail_komponen/$nodok/$no_urut")?>" class="btn btn-success  btn-sm show"  data-toggle="modal" data-target=".pp">
									<i class="fa fa-cloud"></i> Detail
									</a-->
									<a href="<?php echo site_url('recruitment/calonkaryawan/hps_pelamar').'/'.trim($row->noktp).'/'.$row->tgllowongan.'/'.$row->tgllamaran;?>" onclick="return confirm('Anda Yakin Menghapus Data Pelamar Ini Secara Permanen?')" class="btn btn-danger  btn-sm"><i class="fa fa-edit"></i> Hapus
								</a>
									</td>											
									
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





 <!--Modal untuk Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Filter Tanggal Lowongan</h4>
      </div>
	  <form action="<?php echo site_url('recruitment/calonkaryawan/index')?>" method="post">
      <div class="modal-body">
			<div class="form-group input-sm">
				 <label class="col-lg-3">TANGGAL LOWONGAN</label>
				<div class="col-lg-9">
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" id="tgl1" name="tgl1"   class="form-control pull-right">
					</div><!-- /.input group -->
				</div>
			</div>
		
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">FILTER STATUS</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" id="status" name="status">
							<option value="">--PILIH STATUS--</option>
							<?php foreach ($jenis_seleksi as $lp){ ?>
							<option value="<?php echo trim($lp->kdtrx);?>"><?php echo trim($lp->kdtrx).'   ||   '.trim($lp->uraian);?></option>
							<?php } ?>																																					
				</select>
			</div>			
		</div>
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">PILIH KTP PELAMAR</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" id="ktp" name="noktp">
							<option value="">--PILIH PELAMAR--</option>
							<?php foreach ($list_pelamar2 as $lp){ ?>
							<option value="<?php echo trim($lp->noktp);?>"><?php echo trim($lp->noktp).'   ||   '.trim($lp->nmlengkap).' || '.trim($lp->kdposisi);?></option>
							<?php } ?>																																					
						</select>
			</div>			
		</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit1" class="btn btn-primary">Filter</button>
      </div>
	  </form>
    </div>
  </div>
</div>
 
 
 <!--Modal Data Ganti Status-->

    <div  class="modal fade pp">
                <!-- Content will be loaded here from "remote.php" file -->
    </div>

<!---End Modal Data --->
 
 
 
 
<script>

  $("[data-mask]").inputmask();
	//Date range picker
    $('#tgl').datepicker();
	$('#tgl1').daterangepicker();
	$('#ktp').selectize();

  

</script>