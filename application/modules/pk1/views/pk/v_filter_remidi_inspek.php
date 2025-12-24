<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<style>
    .selectize-input {
        overflow: visible;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }
    .selectize-input.dropdown-active {
        min-height: 30px;
        line-height: normal;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }
    .selectize-dropdown, .selectize-input, .selectize-input input {
        min-height: 30px;
        line-height: normal;
    }
    .loading .selectize-dropdown-content:after {
        content: 'loading...';
        height: 30px;
        display: block;
        text-align: center;
    }
</style>
<legend><?php echo $title;?></legend>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <div class="col-xs-12">
                    <h4>FILTER HISTORY REMIDI INSPEK</h4>
                </div>
            </div>
            <form action="<?php echo site_url('pk/pk/history_remidi_inspeksi')?>" method="post" name="inputPeriode">
                <div class="box-body">
                <div class="form-horizontal">
                    <div class="form-group ">
                        <label class="col-sm-4" for="inputsm">PILIH PERIODE </label>
                        <div class="col-sm-8">
                            <input type="input" name="periode" id="periode" class="form-control input-sm  tglYM"  required >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-4" for="inputsm">PILIH DEPARTMENT </label>
                        <div class="col-sm-8">
                            <select class="form-control input-sm inputfill" name="dept" id="dept" required>
                                <option value=""><tr><th width="20%">-- Kode Dept |</th><th width="80%">| Department --</th></tr></option>
                                <?php foreach($list_dept as $sc){?>
                                    <option value="<?php echo trim($sc->kddept);?>" ><tr><th width="20%"><?php echo trim($sc->kddept);?>  |</th><th width="80%">| <?php echo trim($sc->nmdept);?></th></tr></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <!--div class="form-group ">
                        <label class="col-sm-4" for="inputsm">PILIH NAMA KARYAWAN </label>
                        <div class="col-sm-8">
                            <select class="form-control input-sm inputfill" name="nik" id="nik">
                                <option value=""><tr><th width="20%">-- NIK |</th><th width="80%">| NAMA KARYAWAN --</th></tr></option>
                                <!?php foreach($list_nik as $sc){?>
                                    <option value="<!?php echo trim($sc->nik);?>" ><tr><th width="20%"><!?php echo trim($sc->nik);?>  |</th><th width="80%">| <!?php echo trim($sc->nmlengkap);?></th></tr></option>
                                <!?php }?>
                            </select>
                        </div>
                    </div-->
                    <div class="modal-footer">
                        <button type="submit" id="submit"  class="btn btn-primary">FILTER</button>
                    </div>
            </form>
        </div><!-- /.box-body -->
            </div>
        </div>
    </div>
</div>



<script>
    $('.tglYM').datepicker({
        format: "yyyy-mm",
        viewMode: "months",
        minViewMode: "months"
    });
</script>