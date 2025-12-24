<script type="text/javascript">
    $(function() {
        $('input[name="tanggal"]').daterangepicker();
    });
</script>
<legend><?php echo $title;?></legend>
<div class="form-horizontal">
<form action="<?php echo site_url('trans/report/op_filter');?>" name="form" role="form" method="post">

    <div class="form-group">
        <label class="col-lg-3">IDBU</label>
        <div class="col-lg-5">
            <select class='form-control' name="idbu" id="idbu">
                <option value="" selected>NASIONAL</option>
                <?php foreach($idbu as $v) { ?>
                    <option value="<?php echo $v->area; ?>"><?php echo $v->areaname; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

	<div class="form-group">
		<label class="col-lg-3">Tanggal</label>
        <div class="col-lg-5">
            <input type="text" name="tanggal" class='form-control' />
        </div>
	</div>
       
    <div class="form-group">
        <div class="col-lg-4">
			<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
        </div>
    </div>
</div>
</form>

<div id="tampil"></div>
