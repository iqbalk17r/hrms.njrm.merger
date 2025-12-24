<script type="text/javascript">
$(function() {
    $("#example1").dataTable();
    $("#example2").dataTable();
    $("#example3").dataTable();
    $("#dateinput").datepicker();
    $("#dateinput1").datepicker();
    $("#dateinput2").datepicker();
    $("#dateinput3").datepicker();
    $("#tgl_kerja").datepicker();
    $("#jam_awal").clockpicker();
    $("#jam_selesai").clockpicker();
    $("#jam_telat").clockpicker();
    $("[data-mask]").inputmask();
});
</script>
<legend><?php echo $title;?></legend>
<span id="postmessages"></span>
<!--Modal untuk Edit Nama Bpjs-->
<?php foreach ($list_ijin_karyawan_dtl as $lb){?>

<form action="<?php echo site_url('trans/ijin_karyawan/edit_ijin_karyawan')?>" method="post">
<div class="modal-body">
<?php echo $message;?>										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">No. Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="status" name="nodok"  value="<?php echo trim($lb->nodok); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($lb->nik); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="status" name="status"  value="I" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Karyawan</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlvljabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlengkap); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="kdlvl"  value="<?php echo trim($lb->kdlvljabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
							</div>
							</div>								
							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="department"  value="<?php echo trim($lb->nmdept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="subdepartment"  value="<?php echo trim($lb->nmsubdept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							
							<!--<div class="form-group">
								<label class="col-sm-4">Level Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdlvl"  value="<?php echo trim($lb->nmlvljabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>-->	
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="jabatan"  value="<?php echo trim($lb->nmjabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">NIK Atasan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="atasan"  value="<?php echo trim($lb->nmatasan1); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
								<label class="col-sm-4">Tipe Ijin</label>	
									<div class="col-sm-8">
									<select class="form-control input-sm" name="kdijin_absensi" id="kdijin_absensi">
									<option value="" ><?php echo '-- PILIH TYPE IJIN ---';?></option>			
									 <?php foreach($list_ijin as $listkan){?>
									  <option <?php if (trim($lb->kdijin_absensi)==trim($listkan->kdijin_absensi)) { echo 'selected';}?> value="<?php echo trim($listkan->kdijin_absensi);?>" ><?php echo $listkan->nmijin_absensi;?></option>						  
									  <?php }?>
									</select>
									</div>
							</div>
		
							<div class="form-group">
								<label class="col-sm-4">Kategori</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="ktgijin" id="ktgijin" onchange="cekTanggal()">
									 <option <?php if (trim($lb->type_ijin)=='PB') { echo 'selected';}?> value="PB" ><?php echo 'IJIN PRIBADI';?></option>	
									 <option <?php if (trim($lb->type_ijin)=='DN') { echo 'selected';}?> value="DN" ><?php echo 'IJIN DINAS';?></option>	
									  
									</select>
								</div>
							</div>


							<div class="form-group a tgl_kerja">
								<label class="col-sm-4">Tanggal Kerja</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl_kerja" value="<?php echo trim($lb->tgl_kerja1); ?>" name="tgl_kerja" data-date-format="dd-mm-yyyy"  class="form-control">
								</div>
							</div>
							<div class="form-group a jam_awal">
								<label class="col-sm-4">Jam Awal</label>
                                <div class="col-sm-4 tgl_jam_awal">
                                    <input type="text" id="tgl_jam_awal" name="tgl_jam_awal" value="<?php echo substr($lb->tgl_mulai1, 0, -3); ?>" data-date-format="dd-mm-yyyy" class="form-control" readonly >
                                </div>
								<div class="col-sm-4">
									<input type="text" id="jam_awal" name="jam_awal" value="<?php echo substr($lb->tgl_jam_mulai,0,-3); ?>" class="form-control" onchange="cekTanggal();" required >
								</div>
							</div>
							<div class="form-group a jam_selesai">
								<label class="col-sm-4">Jam Selesai</label>
                                <div class="col-sm-4 tgl_jam_selesai">
                                    <input type="text" id="tgl_jam_selesai" name="tgl_jam_selesai" value="<?php echo substr($lb->tgl_selesai1, 0, -3); ?>" data-date-format="dd-mm-yyyy" class="form-control" readonly >
                                </div>
								<div class="col-sm-4">
									<input type="text" id="jam_selesai" name="jam_selesai" value="<?php echo substr($lb->tgl_jam_selesai,0,-3); ?>" class="form-control" onchange="cekTanggal();" required >
										
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Tanggal Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl1" name="tgl_dok"  value="<?php echo trim($lb->tgl_dok1);?>"class="form-control" readonly>
								</div>
							</div>		
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control" ><?php echo trim($lb->keterangan);?></textarea>
									<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
									<input type="hidden" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly>
									
								</div>
							</div>		
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
	
	
      <div class="modal-footer">
        <a type="button" class="btn btn-default" href="<?php echo site_url("trans/ijin_karyawan/index");?>">Close</a>
         <button type="submit"  class="btn btn-primary">SIMPAN</button>  
	  </div>
	  </form>
		
<?php } ?>

<script type="text/javascript">
    $(function() {
        $("#dateinput<?php echo trim($lb->nodok);?>").datepicker();
    });

    function cekTanggal() {
        checkDateIsEmpty()
        $('#postmessages').empty();
        var type = $('#kdijin_absensi').val()
        $('#submit').prop('disabled', true);
        if ($('#tgl_kerja').val() != "" && ($('#kdijin_absensi').val() == 'DT' || $('#kdijin_absensi').val() == 'PA' || $('#kdijin_absensi').val() == 'IK')) {
            var fillData = {
                'success': true,
                'key': '1203jD0j120dkjjKODNOoimdi)D(J)Jmjid0sjd0ijme09wjei0kjisdjfDSojiodksOjO',
                'message': '',
                'body': {
                    docno: $('input[name=\'nodok\']').val(),
                    config:'UPDATE',
                    category : $('#ktgijin').val(),
                    type: $('#kdijin_absensi').val(),
                    awal: $('#jam_awal').val(),
                    selesai: $('#jam_selesai').val(),
                    tanggal: $('#tgl_kerja').val().toString(),
                    nik: $('#nik').val()
                },
            };
            if ($('#ktgijin').val().length === 0){
                Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-sm btn-success ml-3',
                        cancelButton: 'btn btn-sm btn-warning ml-3',
                        denyButton: 'btn btn-sm btn-default ml-3',
                    },
                    buttonsStyling: false,
                }).fire({
                    position: 'top',
                    icon: 'error',
                    title: 'Peringatan',
                    html: 'Pilih kategori ijin',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showCloseButton: false,
                    showConfirmButton: false,
                    showDenyButton: true,
                    denyButtonText: `Tutup`,
                }).then(function (result) {
                    if (result.isDenied) {
                        // $('#tgl_kerja').val('')
                        $('#jam_awal').val('')
                        $('#jam_selesai').val('')
                    }
                })
            }
            if ($('#tgl_kerja').val().length > 0 && ( $('#jam_awal').val().length > 0 || $('#jam_selesai').val().length > 0 ) ){
                $.ajax({
                    type: "POST",
                    url: HOST_URL + 'trans/ijin_karyawan/getJadwal',
                    dataType: 'json',
                    contentType: "application/json",
                    data: JSON.stringify(fillData),
                    success: function (datax) {
                        if (!datax.status || datax.kode === "OFF") {
                            $('#submit').prop('disabled', false);
                        } else {
                        }
                    },
                    error: (function (xhr, status, thrown) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-warning ml-3',
                                denyButton: 'btn btn-sm btn-default ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            position: 'top',
                            icon: 'error',
                            title: 'Peringatan',
                            html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showCloseButton: false,
                            showConfirmButton: false,
                            showDenyButton: true,
                            denyButtonText: `Tutup`,
                        }).then(function (result) {
                            if (result.isDenied) {
                                $('#jam_awal').val('')
                                $('#jam_selesai').val('')
                                // $('#tgl_kerja').val('')
                            }
                        })
                    })
                });
            }

        } else {
            $('#submit').prop('disabled', false);
        }
    }
    function checkDateIsEmpty(){
        if ($('#tgl_kerja').val().length === 0){
            Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-sm btn-success ml-3',
                    cancelButton: 'btn btn-sm btn-warning ml-3',
                    denyButton: 'btn btn-sm btn-default ml-3',
                },
                buttonsStyling: false,
            }).fire({
                position: 'top',
                icon: 'error',
                title: 'Peringatan',
                html: 'Pilih tanggal',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCloseButton: false,
                showConfirmButton: false,
                showDenyButton: true,
                denyButtonText: `Tutup`,
            }).then(function (result) {
                if (result.isDenied) {
                    $('#jam_awal').val('')
                    $('#jam_selesai').val('')
                    $('#tgl_kerja').val('')
                }
            })
        }
    }
    $(document).on('ready', function (){
        $('input[name=\'tgl_kerja\']').on('change',function (){
            if ($("#tgl_kerja").val().length == 0){
                Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-sm btn-success ml-3',
                        cancelButton: 'btn btn-sm btn-warning ml-3',
                        denyButton: 'btn btn-sm btn-default ml-3',
                    },
                    buttonsStyling: false,
                }).fire({
                    position: 'top',
                    icon: 'error',
                    title: 'Peringatan',
                    html: 'Pilih tanggal terlebih dahulu',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showCloseButton: false,
                    showConfirmButton: false,
                    showDenyButton: true,
                    denyButtonText: `Tutup`,
                }).then(function (result) {
                    $("#tgl_kerja").val('')
                })
            }else{
                var fillData = {
                    'key': '1203jD0j120dkjjKODNOoimdi)D(J)Jmjid0sjd0ijme09wjei0kjisdjfDSojiodksOjO',
                    'body': {
                        begindate: $('#tgl_kerja').val(),
                        enddate: $('#tgl_kerja').val(),
                        nik: $('#nik').val()
                    },
                };
                $.ajax({
                    url: '<?php echo site_url('trans/dinas/dutiecheck') ?>',
                    method: 'POST',
                    dataType: 'json',
                    contentType: "application/json",
                    data: JSON.stringify(fillData),
                    success: function (data) {
                        console.log(data)
                    },
                    error: (function (xhr, status, thrown) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-warning ml-3',
                                denyButton: 'btn btn-sm btn-default ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            position: 'top',
                            icon: 'error',
                            title: 'Peringatan',
                            html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showCloseButton: false,
                            showConfirmButton: false,
                            showDenyButton: true,
                            denyButtonText: `Tutup`,
                        }).then(function (result) {
                            if (result.isDenied) {
                                $('#tgl_kerja').val('');
                            }
                        })
                    })
                })
            }
        });

        var beginsetup = new Date();
        var endsetup = new Date();
        $(function() {
            $('.a').hide();
            $('#submit').prop('disabled', true);

            var tpeijin=$('#kdijin_absensi').val();
            if(tpeijin=='DT'){
                $('.tgl_kerja').show();

                $('.tgl_jam_awal').show();
                $('.jam_awal').show();
                $('#jam_awal').prop('required',true);

                $('.tgl_jam_selesai').hide();
                $('#tgl_jam_selesai').val('');
                $('.jam_selesai').hide();
                $('#jam_selesai').removeAttr('required');
                $('#jam_selesai').val('');

                $('#submit').prop('disabled', false);
            } else if(tpeijin=='IK'){
                $('.tgl_kerja').show();

                $('.tgl_jam_awal').hide();
                $('#tgl_jam_awal').val('');
                $('.jam_awal').show();
                $('#jam_awal').prop('required',true);

                $('.tgl_jam_selesai').hide();
                $('#tgl_jam_selesai').val('');
                $('.jam_selesai').show();
                $('#jam_selesai').prop('required',true);

                $('#submit').prop('disabled', false);
            } else if(tpeijin==''){
                $('.a').hide();
                $('#submit').prop('disabled', true);
            } else if(tpeijin=='PA') {
                $('.tgl_kerja').show();

                $('.tgl_jam_awal').hide();
                $('#tgl_jam_awal').val('');
                $('.jam_awal').hide();
                $('#jam_awal').removeAttr('required');
                $('#jam_awal').val('');

                $('.tgl_jam_selesai').show();
                $('.jam_selesai').show();
                $('#jam_selesai').prop('required',true);

                $('#submit').prop('disabled', false);
            } else if (tpeijin=='AL' || tpeijin=='KD' || tpeijin=='IM') {
                $('.tgl_kerja').show();

                $('.tgl_jam_awal').hide();
                $('#tgl_jam_awal').val('');
                $('.jam_awal').hide();
                $('#jam_awal').removeAttr('required');
                $('#jam_awal').val('');

                $('.tgl_jam_selesai').hide();
                $('#tgl_jam_selesai').val('');
                $('.jam_selesai').hide();
                $('#jam_selesai').removeAttr('required');
                $('#jam_selesai').val('');

                $('#submit').prop('disabled', false);
            } else {
                $('.tgl_kerja').show();
                $('#tgl_jam_awal').val('');
                $('.jam_awal').hide();
                $('#jam_awal').removeAttr('required');
                $('#jam_awal').val('');

                $('.tgl_jam_selesai').hide();
                $('#tgl_jam_selesai').val($('#tgl_kerja').val());
                $('.jam_selesai').hide();
                $('#jam_selesai').removeAttr('required');
                $('#submit').prop('disabled', false);
            }

            $('#kdijin_absensi').change(function() {
                var tpeijin=$('#kdijin_absensi').val();
                if(tpeijin=='DT'){
                    $('.tgl_kerja').show();

                    $('.tgl_jam_awal').show();
                    $('#tgl_jam_awal').val($('#tgl_kerja').val());
                    $('.jam_awal').show();
                    $('#jam_awal').prop('required',true);

                    $('.tgl_jam_selesai').hide();
                    $('#tgl_jam_selesai').val('');
                    $('.jam_selesai').hide();
                    $('#jam_selesai').removeAttr('required');
                    $('#jam_selesai').val('');

                    $('#submit').prop('disabled', false);
                } else if(tpeijin=='IK'){
                    $('.tgl_kerja').show();

                    $('.tgl_jam_awal').hide();
                    $('#tgl_jam_awal').val('');
                    $('.jam_awal').show();
                    $('#jam_awal').prop('required',true);

                    $('.tgl_jam_selesai').hide();
                    $('#tgl_jam_selesai').val('');
                    $('.jam_selesai').show();
                    $('#jam_selesai').prop('required',true);

                    $('#submit').prop('disabled', false);
                } else if(tpeijin==''){
                    $('.a').hide();
                    $('#submit').prop('disabled', true);
                } else if(tpeijin=='PA') {
                    $('.tgl_kerja').show();

                    $('.tgl_jam_awal').hide();
                    $('#tgl_jam_awal').val('');
                    $('.jam_awal').hide();
                    $('#jam_awal').removeAttr('required');
                    $('#jam_awal').val('');

                    $('.tgl_jam_selesai').show();
                    $('#tgl_jam_selesai').val($('#tgl_kerja').val());
                    $('.jam_selesai').show();
                    $('#jam_selesai').prop('required',true);

                    $('#submit').prop('disabled', false);
                } else if (tpeijin=='AL' || tpeijin=='KD' || tpeijin=='IM') {
                    $('.tgl_kerja').show();

                    $('.tgl_jam_awal').hide();
                    $('#tgl_jam_awal').val('');
                    $('.jam_awal').hide();
                    $('#jam_awal').removeAttr('required');
                    $('#jam_awal').val('');

                    $('.tgl_jam_selesai').hide();
                    $('#tgl_jam_selesai').val('');
                    $('.jam_selesai').hide();
                    $('#jam_selesai').removeAttr('required');
                    $('#jam_selesai').val('');

                    $('#submit').prop('disabled', false);
                }
            });

            $("#tgl_kerja").datepicker().on('changeDate',function(ev){
                var tglpicker1 = ($(this).val().toString());
                //str.replace(/#|_/g,'');
                //var tglpicker2 = tglpicker1.replace(/-/g,'/');
                var tglpicker2 = tglpicker1.substring(5,3)+'/'+tglpicker1.substring(0,2)+'/'+tglpicker1.substring(10,6);
                var tglm = new Date(Date.parse(tglpicker2));
                //var tgl1 = $('#tgl7').val();
                var tgl7 = new Date($('#tgl7').val());
                var userhr = $('#userhr').val();
                var level_akses = $('#level_akses').val();

                //alert(userhr);

                if((tgl7)>(tglm) && userhr==0 && level_akses !='A'){
                    $('#postmessages').empty().append("<div class='alert alert-danger'>PERINGATAN MAKSIMAL TANGGAL H-1</div>");
                    $('#submit').prop('disabled', true);
                }else{
                    $('#postmessages').empty();
                    $('#submit').prop('disabled', false);
                }

                if ($('#kdijin_absensi').val() == "DT") {
                    $('#tgl_jam_awal').val($('#tgl_kerja').val());
                    $('#jam_awal').val('');
                } else if ($('#kdijin_absensi').val() == "PA") {
                    $('#tgl_jam_selesai').val($('#tgl_kerja').val());
                    $('#jam_selesai').val('');
                }
                cekTanggal();
            });
        });
        $('form.formupdate').on('submit', function (){
            $('#submit').prop('disabled', true);
        })
    })
</script>
