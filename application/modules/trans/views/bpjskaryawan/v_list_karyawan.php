<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 7/24/19 8:42 AM
 *  * Last Modified: 7/24/19 8:35 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */

?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
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

<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th  width="1%">No.</th>
							<th  width="2%">Action</th>
							<th>NIK</th>
							<th>Nama Karyawan</th>					
							<th>Jabatan</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_karyawan as $lu): $no++;?>
						<tr>										
							<td width="1%"><?php echo $no;?></td>
							<td  width="2%">
								<a href="<?php echo site_url('trans/bpjskaryawan/index'.'/'.$this->fiky_encryption->enkript(trim($lu->nik)))?>" onclick="return confirm('Detail BPJS Per Karyawan?')" class="btn btn-info  btn-sm">
									<i class="fa fa-gear"></i> Lihat BPJS
								</a>
							</td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->nmjabatan;?></td>

							
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>





