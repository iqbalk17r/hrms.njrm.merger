<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<style>
    textarea {
        overflow-y: scroll;
        height: 100px;

    }
</style>
<script type="text/javascript" charset="utf-8">
    $(function() {
        $("#example1").dataTable();
        $("#example3").dataTable();
        $("#example4").dataTable();

    });





</script>
<!--div class="pull-right">Versi: <?php echo $version; ?></div--->
<!--div class="nav-tabs-custom"-->
<legend><?php echo $title;?></legend>

<!--?php echo $message;?-->

<form action="<?php echo site_url('intern/patch/save_patch')?>" method="post">
<div class="row">
    <div class="col-sm-12">
        <a href="<?php echo site_url("intern/patch/list_patch")?>"   class="btn btn-default" style="margin:0px; color:#000000;">Kembali</a>
        <?php if ($dtl['patchstatus']=='I') { ?>
            <button type="submit"  onclick="return confirm('Anda Yakin Dengan Inputan Yang Anda Buat?')" class="btn btn-success pull-right" style="margin:0px; color:#ffffff;">Persetujan Patch</button>
        <?php } else if ($dtl['patchstatus']=='F') { ?>
            <button type="submit"  onclick="return confirm('Anda Yakin Dengan Inputan Yang Anda Buat?')" class="btn btn-danger pull-right" style="margin:0px; color:#ffffff;">Batal Patch</button>
        <?php } ?>

    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="box box-danger">
            <div class="box-body">
                <div class="form-horizontal">
                    <div class="form-group ">
                        <label class="col-sm-4">NO DOKUMEN</label>
                        <div class="col-sm-8">
                            <input type="input" id="id" name="id"  value="<?php echo trim($dtl['id']);?>" placeholder="0" class="form-control" readonly >
                            <?php if ($dtl['patchstatus']=='I') { ?>
                            <input type="hidden" id="type" name="type"  value="finalPatch" class="form-control" readonly >
                            <?php } else if ($dtl['patchstatus']=='F') { ?>
                            <input type="hidden" id="type" name="type"  value="cancelPatch" class="form-control" readonly >
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-4" for="inputsm">HOLD PATCH</label>
                        <div class="col-sm-8">
                            <select class="form-control input-sm " name="patchhold" disabled>
                                <option <?php if (trim($dtl['patchhold'])=='NO') { echo 'selected';}?> value="NO"> TIDAK </option>
                                <option <?php if (trim($dtl['patchhold'])=='YES') { echo 'selected';}?> value="YES"> YA </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-4" for="inputsm">USER SPECIFICATION</label>
                        <div class="col-sm-8">
                            <select class="form-control input-sm " name="userspecification" disabled>
                                <option <?php if (trim($dtl['userspecification'])=='NO') { echo 'selected';}?> value="NO"> TIDAK </option>
                                <option <?php if (trim($dtl['userspecification'])=='YES') { echo 'selected';}?> value="YES"> YA </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-4">INPUT USER</label>
                        <div class="col-sm-8">
                            <input type="input" id="useridspecification" name="useridspecification"  value="<?php echo trim($dtl['useridspecification']);?>" maxlength="5" class="form-control"  readonly>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-4">LAST COMMIT DATE</label>
                        <div class="col-sm-8">
                            <input type="input" id="lastcommitdate" name="lastcommitdate"  value="<?php echo trim($dtl['lastcommitdate']);?>" class="form-control" readonly >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-4">LAST COMMIT BY</label>
                        <div class="col-sm-8">
                            <input type="input" id="lastcommitby" name="lastcommitby"  value="<?php echo trim($dtl['lastcommitby']);?>" class="form-control" readonly >
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>

    <div class="col-sm-6">
        <div class="box box-danger">
            <div class="box-body">
                <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2">Sisipkan Query Patch</label>
                    <div class="col-sm-10" >
                        <textarea  type="text" style="font-size: 10px; font-family:monospace; height: 340px" id="patchtext" name="patchtext" class="form-control" ><?php echo $dtl['patchtext']; ?></textarea>
                    </div>
                </div>
                </div>
                <div class="form-horizontal">
                <div class="form-group" >
                    <label class="col-sm-2">Keterangan</label>
                    <div class="col-sm-10" >
                        <textarea type="text" id="description" name="description"   style="text-transform:uppercase" class="form-control" ><?php echo $dtl['description']; ?></textarea>
                    </div>
                </div>
                </div>

            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>
</form>


<script>
    //Date range picker
    $("#tgl").datepicker();
    $(".tglan").datepicker();
    });
</script>