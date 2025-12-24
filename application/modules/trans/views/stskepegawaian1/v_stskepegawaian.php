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
            "url": "<?php echo site_url('trans/stspeg/ajax_list')?>",
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
      $('.modal-title').text('Input Status Kepegawaian'); // Set Title to Bootstrap modal title
    }

    function edit_person(id)
    {
      save_method = 'update';
	  
	  $('#editform')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('trans/stspeg/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
           
			$('[name="kdkepegawaian"]').val(data.kdkepegawaian);
            $('[name="nmkepegawaian"]').val(data.nmkepegawaian);                                    			
            // show bootstrap modal when complete loaded
			$('#modal_form').modal('hide');
			$('#edit_form').modal('show');
            $('.modal-title').text('Edit Status Kepegawaian'); // Set title to Bootstrap modal title
            
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
          url = "<?php echo site_url('trans/stspeg/ajax_add')?>";
		  data = $('#form').serialize();
      }
      else
      {
        url = "<?php echo site_url('trans/stspeg/ajax_update')?>";
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
			   //$('#message').show();
			   $("#message").html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b>Data Sukses Di simpan</b> </div>");		
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
            url : "<?php echo site_url('trans/stspeg/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               //if success reload ajax table
               $('#modal_form').modal('hide');
               reload_table();
				$("#message").html("<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b> Hapus Data Sukses</b></div>");
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
<div id="message" >
	
</div>
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Negara</a>-->
					<button class="btn btn-primary" onclick="add_person()" style="margin:10px; color:#ffffff;"><i class="glyphicon glyphicon-plus"></i> Input Status Kepegawaian</button>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No.</th>
							<th>Kode</th>
							<th>Kepegawaian</th>																								
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
        <h3 class="modal-title">Form Kode kepegawaiantype</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <!--<input type="hidden" value="" name="id"/> -->
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Kode Status Kepegawaian</label>
              <div class="col-md-9">
                <input name="kdkepegawaian" placeholder="Kode kepegawaiantype" style="text-transform:uppercase;" class="form-control" type="text">
              </div>
            </div>
			<div class="form-group">
              <label class="control-label col-md-3">Status Kepegawaian</label>
              <div class="col-md-9">
                <input name="nmkepegawaian" placeholder="Jenis kepegawaiantype" style="text-transform:uppercase;" class="form-control" type="text">
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
        <h3 class="modal-title">Form Kode kepegawaiantype</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="editform" class="form-horizontal">
          <!--<input type="hidden" value="" name="id"/> -->
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Kode Status Kepegawaian</label>
              <div class="col-md-9">
                <input name="kdkepegawaian" placeholder="Kode kepegawaiantype" class="form-control" type="text" readonly>
              </div>
            </div>
			<div class="form-group">
              <label class="control-label col-md-3">Status Kepegawaian</label>
              <div class="col-md-9">
                <input name="nmkepegawaian" placeholder="Jenis kepegawaiantype" style="text-transform:uppercase;" class="form-control" type="text">
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
