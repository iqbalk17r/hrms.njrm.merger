<?php 
/*
	@author : Junis
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
            "url": "<?php echo site_url('master/trxtype/ajax_list')?>",
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
      $('.modal-title').text('Input Kode Trxtype'); // Set Title to Bootstrap modal title
    }

    function edit_person(id)
    {
      save_method = 'update';
	  
	  $('#editform')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('master/trxtype/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
           
			$('[name="kdtrx"]').val(data.kdtrx);
            $('[name="jenistrx"]').val(data.jenistrx);            
            $('[name="uraian"]').val(data.uraian);
            
            // show bootstrap modal when complete loaded
			$('#modal_form').modal('hide');
			$('#edit_form').modal('show');
            $('.modal-title').text('Edit Kode Trxtype'); // Set title to Bootstrap modal title
            
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
          url = "<?php echo site_url('master/trxtype/ajax_add')?>";
		  data = $('#form').serialize();
      }
      else
      {
        url = "<?php echo site_url('master/trxtype/ajax_update')?>";
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
            url : "<?php echo site_url('master/trxtype/ajax_delete')?>/"+id,
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
					<!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Negara</a>-->
					<button class="btn btn-primary" onclick="add_person()" style="margin:10px; color:#ffffff;"><i class="glyphicon glyphicon-plus"></i> Input Trxtype</button>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No.</th>
							<th>KODE</th>
							<th>Jenis Trxtype</th>																	
							<th>Uraian</th>																	
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


 <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Form Kode Trxtype</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <!--<input type="hidden" value="" name="id"/> -->
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Kode Trxtype</label>
              <div class="col-md-9">
                <input name="kdtrx" placeholder="Kode Trxtype" class="form-control" type="text" maxlength="6">
              </div>
            </div>
			<div class="form-group">
              <label class="control-label col-md-3">Jenis Trxtype</label>
              <div class="col-md-9">
                <input name="jenistrx" placeholder="Jenis Trxtype" class="form-control" type="text" maxlength="20">
              </div>
            </div>						           
            <div class="form-group">
              <label class="control-label col-md-3">Uraian</label>
              <div class="col-md-9">
                <textarea name="uraian" placeholder="Uraian"class="form-control" maxlength="60"></textarea>
              </div>
            </div>
          </div>
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal --> 
  
  <!-- Bootstrap modal -->
  <div class="modal fade" id="edit_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Form Kode Trxtype</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="editform" class="form-horizontal">
          <!--<input type="hidden" value="" name="id"/> -->
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Kode Trxtype</label>
              <div class="col-md-9">
                <input name="kdtrx" placeholder="Kode Trxtype" class="form-control" type="text" readonly>
              </div>
            </div>
			<div class="form-group">
              <label class="control-label col-md-3">Jenis Trxtype</label>
              <div class="col-md-9">
                <input name="jenistrx" placeholder="Jenis Trxtype" class="form-control" type="text" maxlength="20">
              </div>
            </div>						           
            <div class="form-group">
              <label class="control-label col-md-3">Uraian</label>
              <div class="col-md-9">
                <textarea name="uraian" placeholder="Uraian"class="form-control" maxlength="60"></textarea>
              </div>
            </div>
          </div>
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
