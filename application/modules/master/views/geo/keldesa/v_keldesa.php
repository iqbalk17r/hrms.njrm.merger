<?php 
/*
	@author : junis \m/
*/
?>
<script type="text/javascript">

    var save_method; //for save method string
    var table;
    $(document).ready(function() {
      table = $('#table').DataTable({ 
        
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('master/keldesa/ajax_list')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
        },
        ],

      });
    });
	
    function add_person()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Input Mutasi / Promosi'); // Set Title to Bootstrap modal title
    }

    function edit_person(id)
    {
      save_method = 'update';
	  
	  $('#editform')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('master/keldesa/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
           
			$('[name="nodokumen"]').val(data.nodokumen);
            $('[name="nik"]').val(data.nik);                        
            
            // show bootstrap modal when complete loaded
			$('#modal_form').modal('hide');
			$('#edit_form').modal('show');
            $('.modal-title').text('Edit Mutasi / Promosi'); // Set title to Bootstrap modal title
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
    }

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }
  </script>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Kelurahan / Desa</a>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No.</th>
							<th>Kode</th>
							<th>Negara</th>																	
							<th>Provinsi</th>																	
							<th>Kota / Kabupaten</th>																	
							<th>Kecamatan</th>																	
							<th>Kelurahan / Desa</th>																	
							<th>Kode Pos</th>																	
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>						
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>

<!--Modal untuk Input SUB-keldesa-SUB-->
<div class="modal fade" id="input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Kelurahan/ Desa</h4>
      </div>
	  <form action="<?php echo site_url('master/keldesa/save')?>" method="post">
      <div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">Kode Kelurahan / Desa</label>	
								<div class="col-sm-8">
									<input type="hidden" class="form-control input-sm" value="input" id="tipe" name="tipe" required>																								
									<input type="text" style="text-transform:uppercase;" class="form-control input-sm" value="" id="tipe" maxlength='10' name="kdkeldesa" required>									
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">Nama Kelurahan / Desa</label>	
								<div class="col-sm-8">    
									<input type="text" style="text-transform:uppercase;" class="form-control input-sm" value="" id="tipe" maxlength='75' name="namakeldesa" required>
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">Kode Pos</label>	
								<div class="col-sm-8">    
									<input type="text" style="text-transform:uppercase;" class="form-control input-sm" value="" id="tipe" maxlength='75' name="kodepos">
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">Negara</label>	
								<div class="col-sm-8">    
									<select name="negara" id='negara' class="col-sm-12" required>										
										<?php foreach ($list_opt_neg as $lon){ ?>
										<option value="<?php echo trim($lon->kodenegara);?>"><?php echo trim($lon->namanegara);?></option>																																																			
										<?php };?>
									</select>
								</div>
							</div>
							<script type="text/javascript" charset="utf-8">
							  $(function() {	
								$("#provinsi").chained("#negara");		
								$("#kotakab").chained("#provinsi");		
								$("#kec").chained("#kotakab");		
							  });
							</script>
							<div class="form-group">
								<label class="col-sm-4">Provinsi</label>	
								<div class="col-sm-8">    
									<select name="provinsi" id='provinsi' class="col-sm-12" required>
										<option value="">-KOSONG-</option>
										<?php foreach ($list_opt_prov as $lop){ ?>
										<option value="<?php echo trim($lop->kodeprov);?>" class="<?php echo trim($lop->kodenegara);?>"><?php echo trim($lop->namaprov);?></option>																																																			
										<?php };?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Kota/Kabupaten</label>	
								<div class="col-sm-8">    
									<select name="kotakab" id='kotakab' class="col-sm-12" required>
										<option value="">-KOSONG-</option>
										<?php foreach ($list_opt_kotakab as $lok){ ?>
										<option value="<?php echo trim($lok->kodekotakab);?>" class="<?php echo trim($lok->kodeprov);?>"><?php echo trim($lok->namakotakab);?></option>																																																			
										<?php };?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Kecamatan</label>	
								<div class="col-sm-8">    
									<select name="kec" id='kec' class="col-sm-12" required>
										<option value="">-KOSONG-</option>
										<?php foreach ($list_opt_kec as $lokc){ ?>
										<option value="<?php echo trim($lokc->kodekec);?>" class="<?php echo trim($lokc->kodekotakab);?>"><?php echo trim($lokc->namakec);?></option>																																																			
										<?php };?>
									</select>
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