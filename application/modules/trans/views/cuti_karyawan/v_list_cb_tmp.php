<script type="text/javascript">
            $(function() {
                $("#test1").dataTable();
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();
				$("#dateinput").datepicker();
				$("#dateinput1").datepicker();
				$("#dateinput2").datepicker();
				$("#dateinput3").datepicker();
				$("#dept").selectize();
                $("#tahun").selectize();
                $("#jabatan").selectize();
				$("[data-mask]").inputmask();
            });

</script>

<legend><?php echo $title;?></legend>
<?php// echo $message;?>
<div>
<a href="<?php echo site_url("trans/cuti_karyawan/cutibersama")?>"  class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a>
<a href="#" data-toggle="modal" data-target="#filter" class="btn btn-primary" style="margin:10px; color:#ffffff;">FILTER</a>
</div>
<div class="row">
    <div class="col-md-12">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab"><b>LIST POTONG CUTI</b></a></li>
                <li><a href="#tab_2" data-toggle="tab"><b>LIST BATAL CUTI</b></a></li>
                <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="box">
                        <div class="box-header">
                            <div class="col-sm-12">
                                <!--a href="<?php echo site_url("trans/cuti_karyawan/addcutibersama")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a-->
                            </div>
                        </div>
                        <table id="example1" class="table table-bordered table-striped" >
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>NIK</th>
                                <th>Nama Karyawan</th>
                                <th>Nomer Dokumen</th>
                                <th>TGL DOKUMEN</th>
                                <th>Departmen</th>
                                <th>Jabatan</th>
                                <th>Cuti BERKURANG</th>
                                <th>DOCTYPE</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $no=0; foreach($list_tmp_cb as $lu): $no++;?>
                                <tr>
                                    <td width="2%"><?php echo $no;?></td>
                                    <td><?php echo trim($lu->nik);?></td>
                                    <td><?php echo $lu->nmlengkap;?></td>
                                    <td><?php echo $lu->no_dokumen;?></td>
                                    <td><?php echo $lu->tanggal;?></td>
                                    <td><?php echo $lu->nmdept;?></td>
                                    <td><?php echo $lu->nmjabatan;?></td>
                                    <td><?php echo $lu->out_cuti;?></td>
                                    <td><?php echo $lu->doctype;?></td>
                                    <td>
                                        <a href="<?php echo site_url("trans/cuti_karyawan/update_tmp_cb/".trim($lu->nik)."/".$lu->no_dokumen."");?>" onclick="return confirm('Anda Yakin Hapus <?php echo 'NIK:  ',$lu->nik,'  NO DOKUMEN:   ',$lu->no_dokumen;?> ?')" class="btn btn-warning">Batalkan</a>

                                    </td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <div class="box">
                        <div class="box-header">
                            <div class="col-sm-12">
                                <!--a href="<?php echo site_url("trans/cuti_karyawan/list_tmp_cb")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a-->
                            </div>
                        </div>

                        <div class="box-body">
                            <table id="example2" class="table table-bordered table-striped" >
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>NIK</th>
                                    <th>Nama Karyawan</th>
                                    <th>Nomer Dokumen</th>
                                    <th>TGL DOKUMEN</th>
                                    <th>Departmen</th>
                                    <th>Jabatan</th>
                                    <th>Cuti BERKURANG</th>
                                    <th>DOCTYPE</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $no=0; foreach($list_tmp_cb_c as $lu): $no++;?>
                                    <tr>
                                        <td width="2%"><?php echo $no;?></td>
                                        <td><?php echo $lu->nik;?></td>
                                        <td><?php echo $lu->nmlengkap;?></td>
                                        <td><?php echo $lu->no_dokumen;?></td>
                                        <td><?php echo $lu->tanggal;?></td>
                                        <td><?php echo $lu->nmdept;?></td>
                                        <td><?php echo $lu->nmjabatan;?></td>
                                        <td><?php echo $lu->out_cuti;?></td>
                                        <td><?php echo $lu->doctype;?></td>
                                        <td>
                                            <a <?php $niknya=trim($lu->nik); $doknya=trim($lu->no_dokumen);?>href="<?php echo site_url("trans/cuti_karyawan/update_tmp_cb/$niknya/$doknya");?>" onclick="return confirm('Anda Yakin Hapus <?php echo 'NIK:  ',$lu->nik,'  NO DOKUMEN:   ',$lu->no_dokumen;?> ?')" class="btn btn-success">Batal/Ikut</a>

                                        </td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div>
                </div>
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
<!-- END CUSTOM TABS -->

<!--Modal untuk Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Periode Inquiry Cuti</h4>
      </div>
	  <form action="<?php echo site_url("trans/cuti_karyawan/list_tmp_cb/".$nodok."")?>" method="post">
      <div class="modal-body">

		<!--div class="form-group input-sm ">
			<label class="label-form col-sm-3">Tahun</label>
			<div class="col-sm-9">
				<select id="tahun" Name='pilihtahun' required>
										<option value="">--Pilih Tahun--></option>
										<!--option value=""><!--?php echo $tahune; ?></option!>
										<?php
										for ($ngantukjeh=date('Y'); $ngantukjeh>2000; $ngantukjeh--)
										  {
											echo'<option value="'.$ngantukjeh.'">'.$ngantukjeh.'</option>';
										  }
										?>
				</select>
			</div>
		</div-->
		<div class="form-group input-sm ">
			<label class="label-form col-sm-3">Pilih Department</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" id="dept" name="lsdept" >
				    <option value="">--Pilih Department--></option>
					<?php foreach ($listdepartmen as $db){?>
					<option value="<?php echo trim($db->kddept);?>"><?php echo $db->nmdept;?>
					</option>
					<!--input type="hidden" value="<?php// echo $db->nmdept;?>" name='nmdept'-->
					<?php }?>

				</select>

			</div>
		</div>
		<div class="form-group input-sm ">
			<label class="label-form col-sm-3">Pilih Jabatan</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" id="jabatan" name="jabatan" >
				    <option value="">--Pilih Jabatan--></option>
					<?php foreach ($listjabatan as $db){?>
					<option value="<?php echo trim($db->kdjabatan);?>"><?php echo trim($db->kdjabatan).' || '.$db->nmjabatan;?>
					</option>
					<!--input type="hidden" value="<?php// echo $db->nmdept;?>" name='nmdept'-->
					<?php }?>

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



