<?php 
/*
	@author : hanif_anak_metal \m/
*/
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example4").dataTable();
				//datemask
				//$("#datemaskinput").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});                               
				//$("#datemaskinput").daterangepicker();                              
				$("#dateinput").datepicker(); 
				$('#nik').selectize();				
            });
			//form validation
			
			window.onload = function () {
				document.getElementById("password1").onchange = validatePassword;
				document.getElementById("password2").onchange = validatePassword;
			}
			function validatePassword(){
			var pass2=document.getElementById("password2").value;
			var pass1=document.getElementById("password1").value;
			if(pass1!=pass2)
				document.getElementById("password2").setCustomValidity("Passwords Tidak Sama");
			else
				document.getElementById("password2").setCustomValidity(''); 			
			//empty string means no validation error
			}
            $(document).ready(function() {
                $('table#example1').on('click','a.reset-password', function () {
                    var row = $(this);
                    $.getJSON(row.attr('data-href'), {})
                        .done(function (data) {
                            if (data.canreset) {
                                Swal.mixin({
                                    customClass: {
                                        confirmButton: 'btn btn-sm btn-success ml-3',
                                        cancelButton: 'btn btn-sm btn-warning ml-3',
                                        denyButton: 'btn btn-sm btn-danger ml-3',
                                    },
                                    buttonsStyling: false,
                                }).fire({
                                    position: 'top',
                                    icon: 'question',
                                    title: 'Perhatian',
                                    html: 'Apakah anda yakin akan mengatur ulang password untuk user ini ?',
                                    showCloseButton: true,
                                    showConfirmButton: true,
                                    showDenyButton: true,
                                    denyButtonText: `Batal`,
                                    confirmButtonText: `Konfirmasi`,
                                }).then(function (result) {
                                    if(result.isConfirmed){
                                        $.ajax({
                                            url: data.next,
                                            method: 'POST',
                                            success: function (data) {
                                                Swal.mixin({
                                                    customClass: {
                                                        confirmButton: 'btn btn-sm btn-success ml-3',
                                                        cancelButton: 'btn btn-sm btn-warning ml-3',
                                                        denyButton: 'btn btn-sm btn-danger ml-3',
                                                    },
                                                    buttonsStyling: false,
                                                }).fire({
                                                    position: 'top',
                                                    title: 'Berhasil',
                                                    html: data.message,
                                                    icon: 'success',
                                                    showCloseButton: false,
                                                }).then(function (result) {});
                                            },
                                            error: function (xhr, status, thrown) {
                                                Swal.mixin({
                                                    customClass: {
                                                        confirmButton: 'btn btn-sm btn-success ml-3',
                                                        cancelButton: 'btn btn-sm btn-warning ml-3',
                                                        denyButton: 'btn btn-sm btn-danger ml-3',
                                                    },
                                                    buttonsStyling: false,
                                                }).fire({
                                                    position: 'top',
                                                    icon: 'error',
                                                    title: 'Gagal Dibuat',
                                                    html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                                    showCloseButton: true,
                                                    showConfirmButton: false,
                                                    showDenyButton: true,
                                                    denyButtonText: `Tutup`,
                                                }).then(function(){ });
                                            }
                                        });
                                    }
                                });
                            }
                        })
                        .fail(function(xhr, status, thrown) {
                            Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-success ml-3',
                                    cancelButton: 'btn btn-sm btn-warning ml-3',
                                    denyButton: 'btn btn-sm btn-danger ml-3',
                                },
                                buttonsStyling: false,
                            }).fire({
                                position: 'top',
                                icon: 'error',
                                title: 'Gagal Memuat Data',
                                html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                showCloseButton: true,
                                showConfirmButton: false,
                                showDenyButton: true,
                                denyButtonText: `Tutup`,
                            }).then(function () {
                            });
                        });
                })
                $('table#example1').on('click','a.give-access', function () {
                    var row = $(this);
                    $.getJSON(row.attr('data-href'), {})
                        .done(function (data) {
                            if (data.canupdate) {
                                Swal.mixin({
                                    customClass: {
                                        confirmButton: 'btn btn-sm btn-success ml-3',
                                        cancelButton: 'btn btn-sm btn-warning ml-3',
                                        denyButton: 'btn btn-sm btn-danger ml-3',
                                    },
                                    buttonsStyling: false,
                                }).fire({
                                    position: 'top',
                                    icon: 'question',
                                    title: 'Perhatian',
                                    html: 'Apakah anda yakin akan membuka akses user ini ?',
                                    showCloseButton: true,
                                    showConfirmButton: true,
                                    showDenyButton: true,
                                    denyButtonText: `Batal`,
                                    confirmButtonText: `Konfirmasi`,
                                }).then(function (result) {
                                    if(result.isConfirmed){
                                        $.ajax({
                                            url: data.next,
                                            method: 'POST',
                                            success: function (data) {
                                                Swal.mixin({
                                                    customClass: {
                                                        confirmButton: 'btn btn-sm btn-success ml-3',
                                                        cancelButton: 'btn btn-sm btn-warning ml-3',
                                                        denyButton: 'btn btn-sm btn-danger ml-3',
                                                    },
                                                    buttonsStyling: false,
                                                }).fire({
                                                    position: 'top',
                                                    title: 'Berhasil',
                                                    html: data.message,
                                                    icon: 'success',
                                                    showCloseButton: false,
                                                    timer: 3000,
                                                }).then(function () {
                                                    window.location.reload()
                                                });
                                            },
                                            error: function (xhr, status, thrown) {
                                                Swal.mixin({
                                                    customClass: {
                                                        confirmButton: 'btn btn-sm btn-success ml-3',
                                                        cancelButton: 'btn btn-sm btn-warning ml-3',
                                                        denyButton: 'btn btn-sm btn-danger ml-3',
                                                    },
                                                    buttonsStyling: false,
                                                }).fire({
                                                    position: 'top',
                                                    icon: 'error',
                                                    title: 'Gagal Dibuat',
                                                    html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                                    showCloseButton: true,
                                                    showConfirmButton: false,
                                                    showDenyButton: true,
                                                    denyButtonText: `Tutup`,
                                                }).then(function(){ });
                                            }
                                        });
                                    }
                                });
                            }
                        })
                        .fail(function(xhr, status, thrown) {
                            Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-success ml-3',
                                    cancelButton: 'btn btn-sm btn-warning ml-3',
                                    denyButton: 'btn btn-sm btn-danger ml-3',
                                },
                                buttonsStyling: false,
                            }).fire({
                                position: 'top',
                                icon: 'error',
                                title: 'Gagal Memuat Data',
                                html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                showCloseButton: true,
                                showConfirmButton: false,
                                showDenyButton: true,
                                denyButtonText: `Tutup`,
                            }).then(function () {
                            });
                        });
                })
            })
			
</script>
<style>
    .btn-twitter {
        color: #ffffff;
        background-color: #202121 !important;
        border-color: rgba(0, 0, 0, 0.2);
    }
    .ml-3{
        margin-left: 3px;
    }
</style>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-12">		
		<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px">Input User</a>
	</div>
</div>
</br>
<div class="row">
	<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>NIK</th>
							<th>NAMA</th>
							<th>Expire Date</th>											
							<th>Hold</th>						
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_user as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->nik; ?></td>
							<td><?php echo $lu->username;?></td>																																																																											
							<td><?php echo $lu->expdate;?></td>											
							<td><?php echo $lu->hold_id;?></td>											
							<td>
								<a href='<?php $nik=trim($lu->nik); $username=trim($lu->username); echo site_url("master/user/edit/$nik/$username")?>' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
								<a href='<?php echo site_url("master/user/akses/$nik/$username")?>' onclick="return confirm('Anda Yakin Ubah Hak Akses User ini?')" class="btn btn-default  btn-sm">
                                    <i class="fa fa-key"></i> Akses User
                                </a>
								<a href='<?php echo site_url("master/user/hps/$nik/$username")?>' onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
                                    <i class="fa fa-trash-o"></i> Hapus
                                </a>
                                <a href="javascript:void(0)" data-href="<?php echo site_url('master/user/resetpassword/'.bin2hex(json_encode(array('nik'=>$lu->nik,'username'=>$lu->username))))?>"  class="btn btn-twitter btn-sm m-1 reset-password" title="Reset Password">
                                    <i class="fa fa-retweet"></i>
                                </a>
                                <?php if (checkAccessSidia(trim($lu->nik))){ ?>
                                    <!--<a href="javascript:void(0)" data-href="<?php /*echo site_url('master/user/resetpassword/'.bin2hex(json_encode(array('nik'=>$lu->nik,'username'=>$lu->username))))*/?>"  class="btn btn-info btn-sm m-1 give-access" title="Tutup Akses Sidia">
                                        <i class="fa fa-unlock"></i>
                                    </a>-->
                                <?php }else{ ?>
                                    <a href="javascript:void(0)" data-href="<?php echo site_url('master/user/giveaccesssidia/'.bin2hex(json_encode(array('nik'=>$lu->nik,'username'=>$lu->username))))?>"  class="btn btn-google btn-sm m-1 give-access" title="Buka Akses Sidia">
                                        <i class="fa fa-lock"></i>
                                    </a>
                                <?php } ?>

							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->				
	</div>
</div>


<!--Modal untuk Input-->
<div class="modal fade" id="input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input User</h4>
      </div>
	  <form action="<?php echo site_url('master/user/save')?>" method="post">
      <div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">NIK | NAMA PEGAWAI</label>	
								<div class="col-sm-8">
									<input type="hidden" class="form-control input-sm-4" value="input" id="tipe" name="tNipe" required>
									<select class="form-control input-sm-4" id="nik" name="nik" class="col-sm-12">
									<option value=""><?php echo '--PILIH KARYAWAN--';?></option>	
										<?php
											foreach ($list_kary as $lk){
												echo '<option value="'.$lk->nik.'">'.$lk->nik.'|'.$lk->nmlengkap.'</option>';
											}
										?>																																					
									</select>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">USERNAME</label>	
								<div class="col-sm-8">    
									<input type="input" class="form-control input-sm-4" id="username" name="username" style="text-transform: uppercase">
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">PASSWORD</label>	
								<div class="col-sm-8">    
									<input type="password" class="form-control input-sm-4" id="password1" name="passwordweb" pattern=".{6,}" required title="Panjang minimal 6 Karakter, dan terdiri dari angka dan huruf">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">ULANG PASSWORD</label>	
								<div class="col-sm-8">    
									<input type="password" class="form-control input-sm-4" id="password2" name="passwordweb2" pattern=".{6,}" required title="Masukan Ulang Password Sama dengan sebelumnya"></input>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">LEVEL ID</label>	
							<div class="col-sm-8">
									<input type="hidden" class="form-control input-sm-4" value="input" id="tipe" name="tipe" required>
									<select class="form-control input-sm-4" id="lvlid" name="lvlid" class="col-sm-12">
									<option value=""><?php echo '--LEVEL ID--';?></option>	
										<?php
											foreach ($list_lvljbt as $lk){
												echo '<option value="'.$lk->kdlvl.'">'.$lk->kdlvl.'|'.$lk->nmlvljabatan.'</option>';
											}
										?>																																					
									</select>
							</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">LEVEL AKSES</label>	
							<div class="col-sm-8">
									<input type="hidden" class="form-control input-sm-4" value="input" id="tipe" name="tipe" required>
									<select class="form-control input-sm-4" id="lvlakses" name="lvlakses" class="col-sm-12">
									<option value=""><?php echo '--LEVEL AKSES--';?></option>	
										<?php
											foreach ($list_lvljbt as $lk){
												echo '<option value="'.$lk->kdlvl.'">'.$lk->kdlvl.'|'.$lk->nmlvljabatan.'</option>';
											}
										?>																																					
									</select>
							</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">HOLD</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm-4" name="hold" class="col-sm-12">
										<option value="N">TIDAK</option>;																																													
										<option value="Y">IYA</option>;																																																							
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">EXPIRED DATE</label>	
									<div class="col-sm-8">    
										<input type="text" class="form-control input-sm-4" name="expdate" id="dateinput" required data-date-format="dd-mm-yyyy"></input>
									</div>
							</div>
                            <div class="form-group">
                                <label class="col-sm-4">INITIAL</label>
                                <div class="col-sm-8">
                                    <input type="input" class="form-control input-sm-4" id="initial" name="initial" style="text-transform: uppercase" maxlength="3">
                                </div>
                            </div>
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>					
		</div><!--row-->
		</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
    </div>
  </div>
</div>
