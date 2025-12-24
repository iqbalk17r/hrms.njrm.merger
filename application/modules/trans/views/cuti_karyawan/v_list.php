<?php 
/*   	LIST CUTI
	@author : junis 10-12-2012\m/
	@update by: fiky 09/04/2016
*/
?>
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
<script type="text/javascript">
	
    var save_method; //for save method string
    var table;
    $(document).ready(function() {
      table = $('#ajaxcuti').DataTable({ 
        
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('trans/cuti_karyawan/ajax_list')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
        },
        ],

      });
    });
	
	$('#cbxShowHide').click(function(){
			this.checked?$('#block').show(1000):$('#block').hide(1000);
		});

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

  </script>
  <script>
    $(document).ready(function() {
        function disableBack() { window.history.forward() }

        window.onload = disableBack();
        window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
    });
</script>  
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
					<?php if (trim($akses['aksesinput']=='t')){?>
					<a href="<?php echo site_url("trans/cuti_karyawan/karyawan")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>
					<?php } ?>
					<a href="#" data-toggle="modal" data-target="#filter" class="btn btn-info" style="margin:10px; color:#ffffff;">FILTER</a>	
				<!--?php //foreach($list_karyawan as $ms){?>
				<?php if (trim($cek_tglmskkerja['ceker'])<>0){?> 	<!--?php// if (trim($ms->tglmasukkerja)==date('Y-m-d')){?-->
				
				<!--a href="<?php echo site_url("trans/cuti_karyawan/pr_addcutirata")?>" class="btn btn-warning" style="margin:10px; color:#ffffff;"><?php echo $cek_tglmskkerja['ceker'],' HAK CUTI ULANG TAHUN';?></a-->	
				
					<!--a href="cuti_karyawan/pr_addcutikrybr" class="btn btn-warning" style="margin:10px; color:#ffffff;"><!--?php echo $cek_tglmskkerja['ceker'],' Karyawan Mendapat Hak Cuti';?></a-->	
				<?php }?>
				<!--?php if (trim($akses['aksesapprove']=='t') and (trim($aksesatasan1>=1) or (trim($aksesdept>=1)))) { ?-->
				<!--div --------------FILTER APPROVAL >
				<form action="<?php// echo site_url('trans/cuti_karyawan/index')?>" method="post">
					<!--a href="<?php// $status='P'; echo site_url("trans/cuti_karyawan/index/$status")?>" name="status"class="btn btn-primary"> Approval 1</a>
					<!--input type="hidden" id="status" name="status"  value="I" class="form-control" style="text-transform:uppercase" maxlength="40" readonly-->
					<!--input type="hidden" name="status"  value="A1" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
					<input type="hidden" name="bulan"  value='<?php //$tgl=date('m'); echo $tgl; ?>' class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
					<input type="hidden" name="tahun"  value='<?php/// $tgl=date('Y'); echo $tgl; ?>' class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
				   <button type="submit" class="btn btn-primary">Approval 1</button>
				</form>
				</div-->
				<?php //} ?>
				<?php //if (trim($akses['aksesapprove2']=='t')and (trim($aksesatasan2>=1) or (trim($aksesdept>=1)))) { ?>
				<!--div>
				<form action="<?php/// echo site_url('trans/cuti_karyawan/index')?>" method="post">
					<!--a href="<?php// $status='P'; echo site_url("trans/cuti_karyawan/index/$status")?>" name="status"class="btn btn-primary"> Approval 1</a>
					<!--input type="hidden" id="status" name="status"  value="I" class="form-control" style="text-transform:uppercase" maxlength="40" readonly-->
					<!--input type="hidden" name="status"  value="A2" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
					<input type="hidden" name="bulan"  value='<?php// $tgl=date('m'); echo $tgl; ?>' class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
					<input type="hidden" name="tahun"  value='<?php// $tgl=date('Y'); echo $tgl; ?>' class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
				   <button type="submit" class="btn btn-primary">Approval 2</button>
				</form>
				</div>
				<?php //} ?>
				<?php// if (trim($akses['aksesapprove3']=='t') and (trim($aksesdept>=1))) { ?>
				<div>
				<form action="<?php echo site_url('trans/cuti_karyawan/index')?>" method="post">
					<!--a href="<?php// $status='P'; echo site_url("trans/cuti_karyawan/index/$status")?>" name="status"class="btn btn-primary"> Approval 1</a>
					<!--input type="hidden" id="status" name="status"  value="I" class="form-control" style="text-transform:uppercase" maxlength="40" readonly-->
					<!--input type="hidden" name="status"  value="P" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
					<input type="hidden" name="bulan"  value='<?php// $tgl=date('m'); echo $tgl; ?>' class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
					<input type="hidden" name="tahun"  value='<?php// $tgl=date('Y'); echo $tgl; ?>' class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
				   <button type="submit" class="btn btn-primary">Approval Final</button>
				</form>
				</div>
				<?php// } ?>
				</div>
				
				<!--?php// } ?-->	
				
				<!--?php $a=date('Y-01-01'); 
				if ($a==date('Y-m-d')){?>
					<a href="cuti_karyawan/pr_addcutirata" class="btn btn-danger" style="margin:10px; color:#ffffff;"> HAK CUTI CUTI TAHUNAN </a>	
				<!--?php } ?-->	
				<!--/div-->
				
				<!--?php/ $a=date('Y-12-31'); 
				if ($a==date('Y-m-d')){?>
					<a href="cuti_karyawan/pr_hanguscuti" class="btn btn-danger" style="margin:10px; color:#ffffff;"> HANGUS CUTI TAHUNAN </a--->	
				<!--?php } ?-->	
				</div>
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<!--<th>NIK</th>
							<th>Nama Karyawan</th>-->
							
							<th>Nomer Dokumen</th>										
							<th>NIK</th>
							<th>TGL DOKUMEN</th>	
							<th>Nama Karyawan</th>										
							<th>Department</th>										
							<th>Tipe Cuti</th>										
							<th>Tanggal Awal Cuti/Ijin</th>										
							<th>Tanggal Akhir Cuti/Ijin</th>
							<th>Sisa Cuti</th>
							<th>Status</th>											
							<th width="8%">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_cuti_karyawan as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->nodok;?></td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->tgl_dok;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->nmdept;?></td>
							<td><?php echo $lu->tpcuti1;?></td>
							<td><?php echo $lu->tgl_mulai1;?></td>
							<td><?php echo $lu->tgl_selesai1;?></td>
							<td align="right"><?php echo $lu->sisacuti;?></td>
							<td><?php echo $lu->status1;?></td>
							<td width="8%" class="text-nowrap">
								<!--a data-toggle="modal" data-target="#dtl<!?php echo trim($lu->nodok);?>" href='#' class="btn btn-success  btn-sm">
									<i class="fa fa-edit"></i> Detail
								</a-->
							<?php if (trim($lu->nik)!=trim($nama) or trim($lu->status)=='P' or trim($lu->status)=='D' or trim($lu->status)=='C') { ?>
								<a href="<?php
                                $enc_nodok=bin2hex($this->encrypt->encode(trim($lu->nodok)));
                                echo site_url("trans/cuti_karyawan/detail".'/'.$enc_nodok)?>"  class="btn btn-default  btn-sm" title="DETAIL"><i class="fa fa-bars"></i></a>
							<?php } ?>		
							<?php if (trim($lu->status)<>'C' and trim($lu->status)<>'P' and trim($lu->status)<>'D' and trim($lu->status)<>'F' ) {?>
								<?php if($akses['aksesupdate']=='t') { ?>
								<a href="<?php
                                $enc_nodok=bin2hex($this->encrypt->encode(trim($lu->nodok)));
                                echo site_url("trans/cuti_karyawan/edit".'/'.$enc_nodok)?>"  class="btn btn-primary  btn-sm"  title="UBAH"><i class="fa fa-gear"></i></a>
								</a>
                                <a href="<?php
                                $enc_nodok=bin2hex($this->encrypt->encode(trim($lu->nodok)));
                                echo site_url("trans/cuti_karyawan/resend_sms".'/'.$enc_nodok)?>"  class="btn btn-warning  btn-sm"  title="Kirim Ulang SMS Approval"><i class="fa fa-envelope-o"></i></a>
                                </a>
								<?php } ?>
								
								<?php if($akses['aksesdelete']=='t') { ?>
								<a  href="<?php
                                $nik=trim($lu->nik);
                                $enc_nodok=bin2hex($this->encrypt->encode(trim($lu->nodok)));
								echo site_url("trans/cuti_karyawan/hps_cuti_karyawan".'/'.$enc_nodok)?>" onclick="return confirm('Anda Yakin Membatalkan Cuti ini?')" class="btn btn-danger  btn-sm"  title="BATALKAN">
								<i class="fa fa-trash-o"></i>
								</a>
								<?php } ?>
							<?php } ?>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>

<!--Modal Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Periode Cuti/Ijin Khusus</h4>
      </div>
	  <form action="<?php echo site_url('trans/cuti_karyawan/index')?>" method="post">
      <div class="modal-body">
        <div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Bulan</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name='bulan'>
					
					<option value="01" <?php $tgl=date('m'); if($tgl=='01') echo "selected"; ?>>Januari</option>
					<option value="02" <?php $tgl=date('m'); if($tgl=='02') echo "selected"; ?>>Februari</option>
					<option value="03" <?php $tgl=date('m'); if($tgl=='03') echo "selected"; ?>>Maret</option>
					<option value="04" <?php $tgl=date('m'); if($tgl=='04') echo "selected"; ?>>April</option>
					<option value="05" <?php $tgl=date('m'); if($tgl=='05') echo "selected"; ?>>Mei</option>
					<option value="06" <?php $tgl=date('m'); if($tgl=='06') echo "selected"; ?>>Juni</option>
					<option value="07" <?php $tgl=date('m'); if($tgl=='07') echo "selected"; ?>>Juli</option>
					<option value="08" <?php $tgl=date('m'); if($tgl=='08') echo "selected"; ?>>Agustus</option>
					<option value="09" <?php $tgl=date('m'); if($tgl=='09') echo "selected"; ?>>September</option>
					<option value="10" <?php $tgl=date('m'); if($tgl=='10') echo "selected"; ?>>Oktober</option>
					<option value="11" <?php $tgl=date('m'); if($tgl=='11') echo "selected"; ?>>November</option>
					<option value="12" <?php $tgl=date('m'); if($tgl=='12') echo "selected"; ?>>Desember</option>
				</select>
			</div>			
		</div>
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Tahun</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name="tahun">
					<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
				</select>
			</div>			
		</div>
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Status</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name="status">
					<option value="">SEMUA</option>
					<option value="P">DISETUJUI</option>
					<option value="A1">PERLU PERSETUJUAN 1</option>
					<option value="A2">PERLU PERSETUJUAN 2</option>
					<option value="C">DIBATALKAN</option>				
					<option value="D">DIHAPUS</option>	
					
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

