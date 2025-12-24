<table id="reported" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th width="1%">No</th>
            <th width="10%">Nama</th>
            <th width="8%">Departemen</th>
            <th width="5%">Jabatan</th>
            <th width="10%">Atasan 1</th>
            <th width="10%">Atasan 2</th>
            <th width="5%">Hapus</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=0; foreach ($dtl as $key => $value) : $no++;?>
            <tr>
                <td><?= $no ?></td>
                <td><?= $value->nmlengkap ?></td>											
                <td><?= $value->nmdept ?></td>											
                <td><?= $value->nmjabatan ?></td>		
                <td><?= $value->nmatasan1 ?></td>		
                <td><?= $value->nmatasan2 ?></td>	
                <td><button class="btn btn-danger btn-sm btn-flat" id="delete" data-docno='<?= $value->docno ?>' data-nik='<?= $value->nik ?>'><span class="fa fa-trash"></span></button></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<script>
    $("#reported").dataTable();

    $('#reported').on('click', 'button#delete', function(){
        var docno = $(this).data("docno");
        var nik = $(this).data("nik");
        
        $.ajax({
            url: "<?php echo site_url('trans/sberitaacara/deleteTmp')?>",
            type: "POST",
            data: {"nik":nik,"docno":docno},
            dataType: "JSON",
            success: function (data) {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Berhasil dihapus!",
                    showConfirmButton: false,
                    timer: 1500,
                    willClose: () => {
                        $.ajax({
                            url: "<?php echo site_url('trans/sberitaacara/viewTmpReported')?>",
                            type: "GET",
                            success: function (data) {
                                $('div.tableTmp').html(data);
                            },
                        });
                    }
                });
                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Gagal Menghapus');
            }
        });
    });
</script>