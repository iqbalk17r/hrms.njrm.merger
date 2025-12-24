<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 5/16/19 2:45 PM
 *  * Last Modified: 5/16/19 2:45 PM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */

?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();                             
                $("#dirlist1").dataTable();                             
				$("#dateinput").datepicker();                               
				$("#tglawal").datepicker(); 
				$("#tglakhir").datepicker(); 	
				$("#tglawal1").datepicker(); 
				$("#tglakhir1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();
				$("#nodokdir").selectize();	
            });
		
</script>


<ol class="breadcrumb">
    <div class="pull-right"><i style="color:transparent;"><?php echo $t; ?></i> Versi: <?php echo $version; ?></div>
    <?php foreach ($y as $y1) { ?>
        <?php if( trim($y1->kodemenu)!=trim($kodemenu)) { ?>
            <li><a href="<?php echo site_url( trim($y1->linkmenu)) ; ?>"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo  trim($y1->namamenu); ?></a></li>
        <?php } else { ?>
            <li class="active"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo trim($y1->namamenu); ?></li>
        <?php } ?>
    <?php } ?>
</ol>
<h3><?php echo $title; ?></h3>


<div class="col-xs-12">

    <div class="box">
        <div class="box-header">
            <div class="col-xs-12">
                <h4>EXPORT DATA LIST</h4>
            </div>
        </div>
        <div class="box-body">
            <div class="form-horizontal">
    <form action="<?php echo site_url('payroll/import/e_csv_mstkaryawan_all')?>" method="post">
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="form-horizontal">
                                <div class="box-body table-responsive" style='overflow-x:scroll;'>
                                    <table id="dirlist1" name="dirlist"class="table table-bordered table-striped" >
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No Dokumen.</th>
                                                <th>NAMA LIST</th>
                                                <th>DIRECTORY</th>
                                                <th>SOURCE</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=0; foreach($li_dir as $ld): $no++;?>
                                            <tr>
                                                <td><?php echo $no;?></td>
                                                <td><?php echo $ld->nodok;?></td>
                                                <td><?php echo $ld->nmlisting;?></td>
                                                <td><?php echo $ld->dir_list;?></td>
                                                <td><?php echo $ld->dir_source;?></td>


                                            </tr>
                                            <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->


                                </div>

                            </div>
                        </div>
                    </div>

        <div align="right">
            <button type="submit"  class="btn btn-primary">PROSES</button>
        </div>
    </form>
    </div>
        </div>
</div>
