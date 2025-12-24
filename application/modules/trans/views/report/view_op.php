<script src="<?php echo base_url('assets/datatables/js/dataTables.rowsGroup.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.buttons.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/datatables/js/jszip.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/datatables/js/pdfmake.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/datatables/js/vfs_fonts.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/datatables/js/buttons.html5.min.js');?>" type="text/javascript"></script>
<style>
    .dt-buttons {
        float: right;
    }
</style>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<input type="hidden" id="idbu" value="<?php echo $idbu; ?>"/>
<input type="hidden" id="tanggal_awal" value="<?php echo $tanggal_awal; ?>"/>
<input type="hidden" id="tanggal_selesai" value="<?php echo $tanggal_selesai; ?>"/>
<script type="text/javascript">
    $(function() {
        $("#example1").DataTable({
            ajax: {
                url: 'op_json?idbu=' + $("#idbu").val() + "&tanggal_awal=" + $("#tanggal_awal").val() + "&tanggal_selesai=" + $("#tanggal_selesai").val(),
                dataSrc: ''
            },
            rowsGroup: [1,2,3,4,5],
            order: [],
            ordering: false,
            pageLength: 25,
            bDestroy: true,
            responsive: true,
            dom: "<'row'<'col-sm-6'l><'col-sm-6'fB>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                {
                    extend: 'pdfHtml5',
                    customize: function(doc) {
                        doc.styles.tableHeader.fontSize = 9;
                        doc.defaultStyle.fontSize = 8;
                        doc.content[1].table.widths = [
                            'auto',
                            'auto',
                            'auto',
                            'auto',
                            'auto',
                            'auto',
                            '20%',
                            'auto'
                        ]
                    }
                }, 'excel'
            ]
        });
    });
</script>
<div class="row">
    <div class="col-xs-12">
    <a href="<?php echo site_url('trans/report/op_index');?>" class="btn btn-primary" style=" margin:10px"><i class="glyphicon glyphicon-plus"></i><font color="#fffff"><b> FILTER</b></font></a>

    <div class="box">
            <div class="box-header">

            </div><!-- /.box-header -->
            <div class="box-body table-responsive" style='overflow-x:scroll;'>
                <table id="example1" class="table table-bordered table-striped" style="width:100%;" >
                    <thead>
                        <tr>
                          <th align="justify" style="width: 1%;"><div align="center">No</div></th>
                          <th align="justify"><div align="center">NIP</div></th>
                          <th align="justify"><div align="center">Sales</div></th>
                          <th align="justify"><div align="center">IDBU</div></th>
                          <th align="justify"><div align="center">Tgl OP</div></th>
                          <th align="justify"><div align="center">Jml OP</div></th>
                          <th align="justify" style="width: 20%;"><div align="center">Order ID</div></th>
                          <th align="justify"><div align="center">Status</div></th>
                      </tr>
                    </thead>
                </table>
      </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>
