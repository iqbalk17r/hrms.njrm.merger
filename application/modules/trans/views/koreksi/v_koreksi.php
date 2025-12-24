<?php echo $message; ?>

<legend><?php echo $title;?></legend>
<div>
<!--a href="<!?php echo site_url("trans/koreksi/kcutibersama");?>"  class="btn btn-success">KoreksiCB</a> &nbsp;&nbsp;

<a href="<!?php echo site_url("trans/koreksi/koreksi_khusus");?>"  class="btn btn-warning">KoreksiCutiKhusus</a> &nbsp;&nbsp;

<a href="<!?php echo site_url("trans/cuti_karyawan/cutilalu");?>"  class="btn btn-default">Lihat Cuti Lalu</a> &nbsp;&nbsp;
-->

</div>

<div class="row">
    <div class="col-sm-3">
        <!--div class="container"--->
        <div class="dropdown ">
            <button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
                <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
                <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#Filter"  href="#"><i class="fa fa-search"></i>Filter Pencarian</a></li>
                <!--li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#ChoiceOfLetter"  href="#"><i class="fa fa-plus"></i>INPUT KOREKSI CUTI</a></li-->
                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("trans/koreksi/inputkoreksi");?>"><i class="fa fa-plus"></i>INPUT KOREKSI CUTI</a></li>
                <!--li role="presentation"><a role="menuitem" tabindex="-1" href="<!?php echo site_url("trans/koreksi/kcutibersama");?>">Koreksi Cuti Bersama</a></li-->
                <!--li role="presentation"><a role="menuitem" tabindex="-1" href="<!?php echo site_url("trans/koreksi/koreksi_khusus");?>">Koreksi Cuti Khusus</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="<!php echo site_url("trans/cuti_karyawan/cutilalu");?>">Lihat Cuti Lalu</a></li--->
            </ul>
        </div>
        <!--/div-->
    </div><!-- /.box-header -->
</div>
</br>
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" style='overflow-x:scroll;'>
                        <table id="example1" class="table table-bordered table-striped" >
                            <thead>
                            <tr>
                                <th width="1%">No.</th>
                                <th>DOKUMEN</th>
                                <th class="col-xs-1">TGL DOC </th>
                                <th>NAMA</th>
                                <th>DEPARTMENT</th>
                                <th>JABATAN</th>
                                <th>TYPE</th>
                                <th>OPERATOR</th>
                                <th class="col-xs-1">TGL AWAL</th>
                                <th class="col-xs-1">TGL AKHIR</th>
                                <th>STATUS</th>
                                <th>KETERANGAN</th>
                                <th width="10%">AKSI</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $no=0; foreach($list_koreksi as $row): $no++;?>
                                <tr>
                                    <td width="1%"><?php echo $no;?></td>
                                    <td><?php echo $row->nodok;?></td>
                                    <td  class="col-xs-1"><?php if (empty($row->tgl_dok)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($row->tgl_dok))); }?></td>
                                    <td><strong><b><?php echo $row->nmlengkap;?></b></strong></td>
                                    <td><?php echo $row->nmdept;?></td>
                                    <td><?php echo $row->nmjabatan;?></td>
                                    <td><?php echo $row->nmdoctype;?></td>
                                    <td><?php echo $row->nmoperator;?></td>
                                    <td  class="col-xs-1"><?php if (empty($row->tgl_awal)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($row->tgl_awal))); }?></td>
                                    <td  class="col-xs-1"><?php if (empty($row->tgl_akhir)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($row->tgl_akhir))); }?></td>
                                    <td><?php echo $row->nmstatus;?></td>
                                    <td><?php echo $row->keterangan;?></td>
                                    <td  width="10%">
                                        <a href="<?php
                                        $enc_nodok=bin2hex($this->encrypt->encode(trim($row->nodok)));
                                        echo site_url("trans/koreksi/detailkcb").'/'.$enc_nodok ?>" class="btn btn-default  btn-sm"  title="Detail"><i class="fa fa-bars"></i> </a>
                                        <?php if (trim($row->status) == 'I') { ?>
                                        <a href="<?php
                                        $enc_nodok=bin2hex($this->encrypt->encode(trim($row->nodok)));
                                        echo site_url("trans/koreksi/editkcb").'/'.$enc_nodok ?>" class="btn btn-primary  btn-sm"  title="Edit Koreksi"><i class="fa fa-gear"></i> </a>
                                        <a href="<?php
                                        $enc_nodok=bin2hex($this->encrypt->encode(trim($row->nodok)));
                                        echo site_url("trans/koreksi/approvkcb").'/'.$enc_nodok ?>" class="btn btn-success  btn-sm"  title="Approval Koreksi"><i class="fa fa-check"></i> </a>
                                        <a href="<?php
                                        $enc_nodok=bin2hex($this->encrypt->encode(trim($row->nodok)));
                                        echo site_url("trans/koreksi/cancelkcb").'/'.$enc_nodok ?>" class="btn btn-danger  btn-sm" title="Batal Koreksi"><i class="fa fa-trash-o"></i> </a>
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
    </div>
</div><!--/ nav -->




<div class="modal fade" id="Filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> FILTER PENCARIAN (PERIODE/NIK)</h4>
            </div>
            <form action="<?php echo site_url('trans/koreksi')?>" method="post" >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-horizontal">
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">PILIH PERIODE </label>
                                            <div class="col-sm-8">
                                                <input type="input" name="tglYM" id="tglYM" class="form-control input-sm  tglYM"  >
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">PILIH NAMA KARYAWAN </label>
                                            <div class="col-sm-8">
                                                <select class="form-control input-sm inputfill" name="nik" id="nik">
                                                    <option value=""><tr><th width="20%">-- NIK |</th><th width="80%">| NAMA KARYAWAN --</th></tr></option>
                                                    <?php foreach($list_nik as $sc){?>
                                                        <option value="<?php echo trim($sc->nik);?>" ><tr><th width="20%"><?php echo trim($sc->nik);?>  |</th><th width="80%">| <?php echo trim($sc->nmlengkap);?></th></tr></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>

                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit"  class="btn btn-primary">SIMPAN</button>
                    </div>
            </form>
        </div></div></div>

<script>

    $(function() {
        $("#example1").dataTable();
        //Date range picker
        $("#tgl").datepicker();
        $(".tglan").datepicker();
    });

</script>