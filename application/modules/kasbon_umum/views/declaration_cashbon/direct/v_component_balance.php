<?php
?>
<div class="form-group">
    <label class="col-sm-4">Nominal Deklarasi</label>
    <div class="col-sm-8">
        <input type="text" name="" class="form-control" value="<?php echo (isset($declaration->totaldeclaration) ? $declaration->totaldeclarationformat : 0) ?>" readonly/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-4">Nominal Kasbon</label>
    <div class="col-sm-8">
        <input type="text" name="" class="form-control" value="<?php echo (isset($declaration->totalcashbon) && $declaration->totalcashbon > 0 ? $declaration->totalcashbonformat : (isset($cashbon->totalcashbon) ? $cashbon->totalcashbonformat : 0)) ?>" readonly/>
    </div>
</div>
<div class="form-group returnamount">
    <label class="col-sm-4"><?php
        if (isset($declaration->returnamount) && $declaration->returnamount < 0) {
            echo 'Kelebihan Deklarasi';
        } elseif (isset($declaration->returnamount) && $declaration->returnamount > 0) {
            echo 'Kelebihan Kasbon';
        } elseif (isset($declaration->returnamount) && $declaration->returnamount == 0) {
            echo 'Tidak Ada Kelebihan';
        } elseif (isset($cashbon->totalcashbon)) {
            echo 'Kelebihan Deklarasi';
        }
        ?></label>
    <div class="col-sm-8">
        <input type="text" name="" class="form-control" value="<?php echo (isset($declaration->returnamount) ? $declaration->returnamountformat : number_format((isset($cashbon->totalcashbon) ? $cashbon->totalcashbon : 0) -0,0,',','.')) ?>" readonly/>
    </div>
</div>