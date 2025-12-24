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
                                    <label class="col-sm-4">Gaji Pokok</label>
                                    <div class="col-sm-8">
                                        <input type="hidden"  name="nik" value="<?php echo trim($dtl['nik']);?>" class="form-control">
                                        <input type="hidden"  name="kdgroup_pg" value="<?php echo trim($dtl['grouppenggajian']);?>" class="form-control">
                                        <input type="text" id="gajipokok" name="gajipokok"  value="<?php  echo (int)trim(str_replace('.','', $dtl['gaji']));?>" class="form-control fikyseparator ratakanan hitung"  onClick="this.select();"  required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Tunjangan Jabatan</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="tj_jabatan" name="tj_jabatan"  value="<?php  echo (int)trim(str_replace('.','', $dtl['tj_jabatan'])); ?>" class="form-control fikyseparator ratakanan hitung"   onClick="this.select();"  required>
                                    </div>
                                </div>
                                <!--<div class="form-group">
                                    <label class="col-sm-4">Tunjangan Jobgrade</label>
                                    <div class="col-sm-8">
                                        <input type="text"  name="tj_jobgrade" data-inputmask='"mask": "999999999"' data-mask="" class="form-control">
                                    </div>
                                </div>-->
                                <div class="form-group">
                                    <label class="col-sm-4">Tunjangan Masa Kerja</label>
                                    <div class="col-sm-8">
                                        <input type="text"  id="tj_masakerja" name="tj_masakerja"  value="<?php  echo (int)trim(str_replace('.','', $dtl['tj_masakerja']));?>" class="form-control fikyseparator ratakanan hitung" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Tunjangan Prestasi</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="tj_prestasi" name="tj_prestasi"  value="<?php  echo (int)trim(str_replace('.','', $dtl['tj_prestasi']));?>" class="form-control fikyseparator ratakanan hitung" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Total Gaji Tetap</label>
                                    <div class="col-sm-8">
                                        <input id="ttltarget" type="text"  name="ttltarget"  value="<?php  echo (int)trim(str_replace('.','', $dtl['gajitetap']));?>" class="form-control fikyseparator ratakanan" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Gaji BPJS KES</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="type1" name="gajibpjs"  value="<?php  echo (int)trim(str_replace('.','', $dtl['gajibpjs1']));?>"class="form-control fikyseparator  ratakanan" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Gaji BPJS NAKER</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="type1" name="gajinaker"  value="<?php  echo (int)trim(str_replace('.','', $dtl['gajinaker1']));?>"class="form-control fikyseparator  ratakanan" >
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
        vala = parseInt(a.replace(/[^-?(\d*\.)?\d+$;]/g,''));
        valb = parseInt(b.replace(/[^-?(\d*\.)?\d+$;]/g,''));
        valc = parseInt(c.replace(/[^-?(\d*\.)?\d+$;]/g,''));
        vald = parseInt(d.replace(/[^-?(\d*\.)?\d+$;]/g,''));

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
        url = "<?php echo site_url('payroll/tetap/add_detail')?>";

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
