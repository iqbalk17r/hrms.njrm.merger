<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();
                $("#example4").dataTable();
            });
</script>
<ol class="breadcrumb">
    <div class="pull-right"><i style="color:transparent;"><?php echo $t; ?></i> Versi: <?php echo $version; ?></div>
    <?php foreach ($y as $y1) { ?>
        <?php if( trim($y1->kodemenu)!=trim($kodemenu)) { ?>
            <li><a href="<?php echo site_url( trim($y1->linkmenu)) ; ?>"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo  trim($y1->namamenu); ?></a></li>
        <?php } else { ?>
            <li class="active"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo trim($y1->namamenu); ?></li>
        <?php } ?>
    <?php } ?>
</ol>
<h3><?php echo $title; ?></h3>
<?php echo $message;?>

<div class="row">
    <div class="box">
        <div class="box-header">
            <div>
                <a href="<?php echo site_url('ga/arsipdokumen/form_master_arsip');?>" type="button"  style="margin:0px; color:#000000;" class="btn btn-default"><i class="fa fa-arrow-left"> Kembali </i> </a>
            </div>
        </div>
        <form role="form" action="<?php echo site_url('ga/arsipdokumen/save_master_arsip');?>" method="post">
        <div class="box-body">
            <div class='col-sm-6'>
                <div class="form-group">
                    <label for="inputsm">KODE ARSIP ASLI</label>
                    <input type="hidden" id="type" name="type" value="UPDATE">
                    <input type="hidden" id="docno" name="docno" value="<?php echo trim($dtlmst['docno']);?>">
                    <input type="text" class="form-control input-sm"  style="text-transform:uppercase" id="archives_id" style="text-transform:uppercase" name="archives_id" placeholder="Inputkan Kode Dokumen Arsip" maxlength="30" value="<?php echo trim($dtlmst['archives_id']);?>" required>
                </div>
                <div class="form-group">
                    <label for="inputsm">NAMA ARSIP</label>
                    <input type="text" class="form-control input-sm"  style="text-transform:uppercase" id="archives_name" style="text-transform:uppercase" name="archives_name" placeholder="Inputkan Nama Dokumen Arsip" maxlength="30" value="<?php echo trim($dtlmst['archives_name']);?>" required>
                </div>
                <div class="form-group">
                    <label for="inputsm">Lokasi Arsip</label>
                    <select class="form-control input-sm" name="loccode" id="loccode" required>
                        <option value="">---PILIH LOKASI ARSIP---</option>
                        <?php foreach($list_gudang as $sc){?>
                            <option value="<?= trim($sc->loccode); ?>" <?php if (trim($dtlmst['loccode'])==trim($sc->loccode)) { echo 'selected'; };?> ><?php echo trim($sc->loccode).' || '.trim($sc->locaname);?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputsm">Kode Group</label>
                    <select class="form-control input-sm" name="kdgroup" id="kdgroup" disabled>
                        <option value="">---PILIH KODE GROUP--</option>
                        <?php foreach($list_scgroup as $sc){?>

                            <option value="<?= trim($sc->kdgroup); ?>" <?php if (trim($dtlmst['kdgroup'])==trim($sc->kdgroup)) { echo 'selected'; };?> ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputsm">Kode Sub Group</label>
                    <select class="form-control input-sm" name="kdsubgroup" id="kdsubgroup" disabled>
                        <option value="">---PILIH KODE SUB GROUP--</option>
                        <?php foreach($list_scsubgroup as $sc){?>
                            <option value="<?= trim($sc->kdsubgroup); ?>" <?php if (trim($dtlmst['kdsubgroup'])==trim($sc->kdsubgroup)) { echo 'selected'; };?> ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>
                        <?php }?>
                    </select>
                </div>
            </div> <!---- col 1 -->
            <div class='col-sm-6'>
                <div class="form-group">
                    <label for="inputsm">Nama Pemilik Arsip</label>
                    <input type="text" class="form-control input-sm"  style="text-transform:uppercase" id="archives_own" style="text-transform:uppercase" name="archives_own" placeholder="Inputkan Nama Pemilik Arsip" maxlength="30" value="<?php echo trim($dtlmst['archives_own']);?>" required>
                </div>
                <div class="form-group">
                    <label for="inputsm">Tanggal Arsip Dokumen</label>
                    <input type="text" class="form-control input-sm tgl" id="archives_exp" style="text-transform:uppercase" name="archives_exp"   placeholder="Exp Archive" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y',strtotime($dtlmst['archives_exp']));?>" REQUIRED>
                </div>
                <div class="form-group">
                    <label for="inputsm">HOLD</label>
                    <select class="form-control input-sm" name="chold" id="chold" required>
                        <option  <?php if (trim($dtlmst['chold'])=='NO') { echo 'selected'; };?> value="NO">TIDAK</option>
                        <option  <?php if (trim($dtlmst['chold'])=='YES') { echo 'selected'; };?>  value="YES">YA</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="inputsm">Keterangan</label>
                    <textarea  class="textarea" name="description" placeholder="Keterangan"  maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ; text-transform: uppercase" required>  <?php echo trim($dtlmst['description']);?> </textarea>
                </div>
            </div>

        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"> Simpan Ubah</i> </button>
        </div>
        </form>
    </div>

</div>



<script>




	//Date range picker
    	$("#tgl").datepicker();
    	$(".tgl").datepicker();
    	$(".tglan").datepicker();
				$('.year').datepicker({
					format: " yyyy",
					viewMode: "years",
					minViewMode: "years"

				});


</script>
