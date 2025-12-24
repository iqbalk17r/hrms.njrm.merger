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
            "url": "<?php echo site_url('master/kec/ajax_list')?>",
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
        url : "<?php echo site_url('master/kec/ajax_edit/')?>/" + id,
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

    function save()
    {
      var url;
      if(save_method == 'add') 
      {
          url = "<?php echo site_url('master/kec/ajax_add')?>";
		  data = $('#form').serialize();
      }
      else
      {
        url = "<?php echo site_url('master/kec/ajax_update')?>";
		data = $('#editform').serialize();
      }

       // ajax adding data to database
          $.ajax({
            url : url,
            type: "POST",
            //data: $('#form').serialize(),
            data: data,
            dataType: "JSON",
            success: function(data)
            {
               //if success close modal and reload ajax table
               $('#modal_form').modal('hide');
               $('#edit_form').modal('hide');
               reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
    }

    function delete_person(id)
    {
      if(confirm('Are you sure delete this data?'))
      {
        // ajax delete data to database
          $.ajax({
            url : "<?php echo site_url('master/kec/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               //if success reload ajax table
               $('#modal_form').modal('hide');
               reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
         
      }
    }

  </script>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Kecamatan</a>
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

<!--Modal untuk Input SUB-kec-SUB-->
<div class="modal fade" id="input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Kecamatan</h4>
      </div>
	  <form action="<?php echo site_url('master/kec/save')?>" method="post">
      <div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">Kode Kecamatann</label>	
								<div class="col-sm-8">
									<input type="hidden" class="form-control input-sm" value="input" id="tipe" name="tipe" required>																								
									<input type="text" style="text-transform:uppercase;" class="form-control input-sm" value="" id="tipe" maxlength='10' name="kdkec" required>									
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">Nama Kecamatan</label>	
								<div class="col-sm-8">    
									<input type="text" style="text-transform:uppercase;" class="form-control input-sm" value="" id="tipe" maxlength='25' name="namakec" required>
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