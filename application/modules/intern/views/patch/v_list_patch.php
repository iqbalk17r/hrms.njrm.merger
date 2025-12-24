<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
            });

            var observe;
            if (window.attachEvent) {
                observe = function (element, event, handler) {
                    element.attachEvent('on'+event, handler);
                };
            }
            else {
                observe = function (element, event, handler) {
                    element.addEventListener(event, handler, false);
                };
            }
            function init () {
                var text = document.getElementById('text');
                function resize () {
                    text.style.height = 'auto';
                    text.style.height = text.scrollHeight+'px';
                }
                /* 0-timeout to get the already changed text */
                function delayedResize () {
                    window.setTimeout(resize, 0);
                }
                observe(text, 'change',  resize);
                observe(text, 'cut',     delayedResize);
                observe(text, 'paste',   delayedResize);
                observe(text, 'drop',    delayedResize);
                observe(text, 'keydown', delayedResize);

                text.focus();
                text.select();
                resize();
            }

					
</script>
<style>
    textarea {
        overflow-y: scroll;
        height: 100px;

    }
</style>
<div class="pull-right">Versi: <?php echo $version; ?></div>
<!--div class="nav-tabs-custom"-->
<legend><?php echo $title;?></legend>

<?php echo $message;?>

<div class="row">
	<div class="col-sm-3">	
		<!--div class="container"--->
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter"  href="#">Filter Pencarian</a></li> 
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#InPatch"  href="#">Input Patch</a></li>
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("ga/ajustment/input_ajustment_in_trgd")?>">Input Patch</a></li-->
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
											<th width="2%">No.</th>
											<th>ID</th>
											<th>PATCH DATE</th>
											<th>PATCH BY</th>
											<th>HOLD</th>
											<th>STATUS</th>
											<th>DESCRIPTION</th>
											<th width="8%">ACTION</th>
										</tr>
							</thead>
							<tbody>
									<?php $no=0; foreach($list_patch as $row): $no++;?>
								<tr>									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->id;?></td>
									<td><?php if (empty($row->patchdate)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($row->patchdate))); } ?></td>
									<td><?php echo $row->patchby;?></td>
									<td><?php echo $row->patchhold;?></td>
									<td><?php echo $row->nmstatus;?></td>
									<td><?php echo $row->description;?></td>
									<td width="8%">
                                        <?php if (trim($row->patchstatus)=='I') { ?>
                                        <a href="<?php echo site_url("intern/patch/editPatch".'/'.$this->fiky_hexstring->b2h($this->encrypt->encode(trim($row->id))))?>" class="btn btn-primary  btn-sm"><i class="fa fa-gear"></i> </a>
                                        <?php } ?>
                                        <a href="<?php echo site_url("intern/patch/detailPatch".'/'.$this->fiky_hexstring->b2h($this->encrypt->encode(trim($row->id))))?>" class="btn btn-default  btn-sm"><i class="fa fa-bars"></i> </a>
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



<div class="modal fade" id="InPatch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel"> INPUT PATCH QUERY </h4>
	  </div>
<form action="<?php echo site_url('intern/patch/save_patch')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">
                            <input type="hidden" name="type" id="inputPatch" value="inputPatch" class="form-control "  >
                            <div class="form-group">
                                <label class="col-sm-2">Sisipkan Query Patch</label>
                                <div class="col-sm-10" >
                                    <textarea onload="init();" type="text" style="font-size: 10px; font-family:monospace; height: 340px" id="patchtext" name="patchtext" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-2">Keterangan</label>
                                <div class="col-sm-10" >
                                    <textarea onload="init();" type="text" id="description" name="description"   style="text-transform:uppercase" class="form-control" required></textarea>
                                </div>
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
	//Date range picker
    	$("#tgl").datepicker(); 
    	$(".tglan").datepicker(); 
</script>