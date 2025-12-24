<?php echo $_getCustom; ?>

<div class="modal-dialog modal-lg">
    <form name="autoSumForm" action="#" method="post" id="formz">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <legend><?php echo $title.$dtl['nmlengkap'];?></legend>
                <!--?php echo $message;?-->

                <!--h4 class="modal-title" id="myModalLabel">Transaksi Bulan</h4--->
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <input type="hidden"  name="nik" value="<?php echo trim($dtl['nik']);?>" class="form-control">
                                    <input type="hidden"  name="kdgroup_pg" value="<?php echo trim($dtl['grouppenggajian']);?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">PILIH WILAYAH NOMINAL GAJI</label>
                                    <div class="col-md-9">
                                        <select name="kdwilayahnominal" class="form-control inform c_hold" style="text-transform:uppercase;">
                                            <option value="">--Pilih Wilayah--</option>
                                            <?php foreach($wilnom as $mo){?>
                                                <option <?php if (trim($dtl['kdwilayahnominal'])===trim($mo->kdwilayahnominal)){ echo 'selected';} ?> value="<?php echo trim($mo->kdwilayahnominal);?>"> <?php echo trim($mo->nmwilayahnominal);?> </option>
                                            <?php }?>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">PILIH LEVEL</label>
                                    <div class="col-md-9">
                                        <select name="kdlvlgp" class="form-control inform c_hold" style="text-transform:uppercase;">
                                            <option value="">--Pilih Level--</option>
                                            <?php foreach($mlvlgp as $mv){?>
                                                <option  <?php if (trim($dtl['kdlvlgp'])===trim($mv->kdlvlgp)){ echo 'selected';} ?> value="<?php echo trim($mv->kdlvlgp);?>"> <?php echo trim($mv->kdlvlgp);?> </option>
                                            <?php }?>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">PILIH GRADE JABATAN</label>
                                    <div class="col-md-9">
                                        <select name="kdgradejabatan" class="form-control inform c_hold" style="text-transform:uppercase;">
                                            <option value="">--Pilih Grade Jabatan--</option>
                                            <?php foreach($mgrade as $mg){?>
                                                <option <?php if (trim($dtl['kdgradejabatan'])===trim($mg->kdgradejabatan)){ echo 'selected';} ?> value="<?php echo trim($mg->kdgradejabatan); ?>"> <?php echo trim($mg->nmgradejabatan);?> </option>
                                            <?php }?>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <!--a-- href="<!?php echo site_url('payroll/tetap/index'); ?>" type="button" class="btn btn-default">Close</a-->
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                </div>
            </div>
    </form>
</div>
</div>


<!--Modal Data Detail -->

<div  class="modal fade pp1" data-modal-parent=".lod" data-backdrop-limit="1"  data-backdrop="static">
    <!-- Content will be loaded here from "remote.php" file -->
</div>

<!---End Modal Data --->


<script type="text/javascript">
    $(".hitung").keyup(function(){
        a = $("#gajipokok").val().toString();
        b = $("#tj_jabatan").val().toString();
        c = $("#tj_masakerja").val().toString();
        d = $("#tj_prestasi").val().toString();
        vala = parseInt(a.replace(/[^-?(\d*\)?\d+$;]/g,''));
        valb = parseInt(b.replace(/[^-?(\d*\)?\d+$;]/g,''));
        valc = parseInt(c.replace(/[^-?(\d*\)?\d+$;]/g,''));
        vald = parseInt(d.replace(/[^-?(\d*\)?\d+$;]/g,''));

        var v_nominal = ((vala + valb + valc + vald) != null ? (vala + valb + valc + vald) : "0");
        $("#ttltarget").val((v_nominal));
        console.log((v_nominal))
    });
function calc(objek) {
    a = objek.value.toString();
    val = a.replace(/[^-?(\d*\.)?\d+$;]/g,'');
    $("#ttltarget").val(val);
}
/*    function startCalc(){interval=setInterval("calc()",1)}
    function calc(){
        gajipokok=document.autoSumForm.gajipokok.value;
        tj_jabatan=document.autoSumForm.tj_jabatan.value;
        tj_komunikasi=document.autoSumForm.tj_komunikasi.value;
        tj_prestasi=document.autoSumForm.tj_prestasi.value;


        document.autoSumForm.ttltarget.value=(gajipokok*1)+(tj_jabatan*1)+(tj_komunikasi*1)+(tj_prestasi*1)

    }
    function stopCalc(){clearInterval(interval)}*/
    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax
    }
    function save()
    {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable
        var url;
        url = "<?php echo site_url('payroll/tetap/ubahganti_master')?>";

        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#formz').serialize(),
            dataType: "JSON",
            success: function(data)
            {

                if(data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
                    reload_table();
                }

                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable


            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Gagal Menyimpan / Ubah data / data sudah ada');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable

            }
        });
    }
</script>
