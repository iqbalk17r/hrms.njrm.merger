<?php 
/*
	@author : Junis pusaba
	@email	: junis_pusaba@mail.ugm.ac.id
	7-9-2014
*/
?>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<?php echo validation_errors();?>
<form class="form-horizontal" action="" method="post">
    <div class="form-group">
        <label class="col-lg-3 control-label">Username</label>
        <div class="col-lg-5">
            <input type="hidden" name="id" value="<?php echo $userosin['userid'];?>">
            <input type="text" name="user" value="<?php echo $userosin['userlname'];?>" readonly="readonly" class="form-control">
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-lg-3 control-label">Password</label>
        <div class="col-lg-5">
            <input type="password" name="password" value="<?php echo $userosin['passwordweb'];?>" class="form-control">
        </div>
		 <p class="col-md-3">Harap hapus dulu password yang lama baru di inputkan password baru!!</p>
    </div>
    
    <div class="form-group well">
        <div class="col-lg-5">
            <button id="simpan" class="btn btn-primary"><i class="glyphicon glyphicon-saved"></i> Simpan</button>
            <a href="<?php echo site_url('dashboard/userosin');?>" class="btn btn-default">Kembali</a>
        </div>
    </div>
</form>