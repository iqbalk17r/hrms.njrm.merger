<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form role="form" class="formcreatecashboncomponent" action="<?php echo site_url('trans/cashbon/docreatecomponentpopup/'.bin2hex(json_encode(array('branch' => $employee->branch, 'employeeid' => $employee->nik, 'dutieid' => $dinas->nodok ))))?>" method="post">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $title ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <?php foreach ((count($cashboncomponents) > 0 ? $cashboncomponents : $cashboncomponentsempty) as $index => $row ) { ?>
                        <div class="form-group">
                            <input type="hidden" name="id[]" class="form-control" value="<?php echo $row->componentid ?>" readonly/>
                            <label class="col-sm-3"><?php echo $row->componentname ?></label>
                            <div class="col-sm-3">
                                <input type="text" name="nominal[]" class="form-control text-right autonumeric" value="<?php echo $row->nominal ?>" <?php echo ($row->readonly == 't' ? 'readonly' : '') ?> autocomplete="off"/>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="description[]" class="form-control" value="<?php echo $row->description ?>" <?php echo ($row->readonly == 't' ? 'readonly' : '') ?> autocomplete="off"/>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>