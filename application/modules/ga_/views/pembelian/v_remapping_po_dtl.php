<style>
.ratakanan { text-align : right; }
</style>

<legend><?php echo $title;?></legend>
<span id="postmessages"></span>

<div class="box">
	<div class="box-content">
	  <div class="box-header">
		<h4 class="box-title" id="myModalLabel">MAPPING PEMBELIAN BARANG</h4>
	  </div>
<!--<form action="#" method="post" id="formfull" name="inputformPbk">-->
<form action="<?php echo site_url('ga/pembelian/save_po')?>" method="post" id="formfull" name="inputformPbk">
<div class="box-body">
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4">NO DOKUMEN REFERENSI</label>
                                        <div class="col-sm-8">
                                        <?php if(trim($po_dtl['status'])=='I') { ?>
                                            <input type="hidden" id="type" name="type"  value="MAP_PODTL_ITEM" class="form-control" style="text-transform:uppercase">
                                        <?php } else if (trim($po_dtl['status'])=='E') { ?>
                                            <input type="hidden" id="type" name="type"  value="MAP_PODTL_ITEM_EDIT" class="form-control" style="text-transform:uppercase">
                                        <?php } ?>
                                            <input type="text" id="nodok" name="nodok"  value="<?php echo trim($po_dtl['nodok']);?>" class="form-control" style="text-transform:uppercase" readonly>
                                            <input type="hidden" id="id" name="id"  value="<?php echo trim($po_dtl['id']);?>" class="form-control" style="text-transform:uppercase">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-sm-4" for="inputsm">Kode Barang</label>
                                        <div class="col-sm-8">
                                            <input type="hidden" name="kdgroup"  id="mpkdgroup" value="<?php echo trim($po_dtl['kdgroup']);?>" class="form-control "  readonly >
                                            <input type="hidden" name="kdsubgroup"  id="mpkdsubgroup"  value="<?php echo trim($po_dtl['kdsubgroup']);?>" class="form-control "  readonly >
                                            <input type="input" name="kdbarang"   id="mpkdbarang" value="<?php echo trim($po_dtl['stockcode']);?>" class="form-control "  readonly>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-sm-4" for="inputsm">Nama Barang</label>
                                        <div class="col-sm-8">
                                            <input type="input" name="nmbarang"   value="<?php echo trim($po_dtl['nmbarang']);?>" class="form-control "  readonly >
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-sm-4">LOKASI GUDANG</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="mploccode" name="loccode"   value="<?php echo trim($po_dtl['loccode']);?>" class="form-control "  readonly >

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">


                                    <?php if (trim($po_dtl['kdgroup'])!='JSA') { ?>
                                        <div class="form-group drst">
                                            <label class="col-sm-4">QTY TERKECIL</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="qtykecil" name="qtykecil"  value="<?php echo trim($po_dtl['qtykecil']);?>"   placeholder="0" class="form-control drst ratakanan" readonly >
                                            </div>
                                        </div>
                                        <div class="form-group drst">
                                            <label class="col-sm-4">SATUAN TERKECIL</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="mpnmsatkecil"  value="<?php echo trim($po_dtl['nmsatkecil']);?>"   class="form-control " readonly >
                                                <input type="hidden" id="mpsatkecil" name="satkecil"  value="<?php echo trim($po_dtl['satkecil']);?>"  class="form-control drst" readonly >
                                            </div>
                                        </div>
                                        <div class="form-group drst">
                                            <label class="col-sm-4">Quantity Permintaan</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="qtyminta" name="qtyminta"  value="<?php echo trim($po_dtl['qtyminta']);?>"   placeholder="0" class="form-control ratakanan cal fikyseparator" readonly >
                                            </div>
                                        </div>
                                        <!---?php if (empty(trim($po_dtl['satminta'])) or trim($po_dtl['satminta'])=='' ) { ?>
                                            <div class="form-group">
                                                <label class="col-sm-4" for="inputsm">Kode Satuan Permintaan</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control input-sm"  name="satminta" id="satminta" required>
                                                     <!--option  value="">---PILIH KDSATUAN || NAMA SATUAN--</option-->
                                        <!--/select>
                                    </div>
                                </div>
                            <!--?php } else { ?--->

                                        <div class="form-group">
                                            <label class="col-sm-4" for="inputsm">Kode Satuan Permintaan</label>
                                            <div class="col-sm-8">
                                                <select class="form-control input-sm cal"  name="satminta" id="satminta" required>
                                                    <option  value="">---PILIH KDSATUAN || NAMA SATUAN--</option>
                                                    <?php foreach($trxqtyunit as $sc){?>
                                                        <option <?php if (trim($sc->kdtrx)==trim($po_dtl['satminta'])) { echo 'selected';}?>  value="<?php echo trim($sc->kdtrx);?>"><?php echo trim($sc->nmsatbesar).' || '.trim($sc->kdtrx);?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <input type="hidden" id="qtyminta" name="qtyminta"  value="<?php echo trim($po_dtl['qtykecil']);?>"   placeholder="0" class="form-control drst" readonly >
                                        <input type="hidden" name="mpnmsatkecil"  value="<?php echo trim($po_dtl['nmsatkecil']);?>"   class="form-control" readonly >
                                        <input type="hidden" id="mpsatkecil" name="satkecil"  value="<?php echo trim($po_dtl['satkecil']);?>"  class="form-control drst" readonly >
                                        <input type="hidden" id="qtykecil" name="qtykecil"  value="<?php echo trim($po_dtl['qtykecil']);?>"   placeholder="0" class="form-control drst" readonly >
                                        <input type="hidden"  id="satminta" name="satminta"  value="<?php echo str_replace('.',',',trim($po_dtl['satkecil']));?>" readonly>
                                    <?php }  ?>
							</div>
                            </div>
							<div class="form-group row">
								<label class="col-sm-2">Harga Per Satuan (Rp) </label>
								<div class="col-sm-4"> 
									<input type="text"  id="unitprice" name="unitprice"  value="<?php echo number_format($po_dtl['unitprice'], 2,',','.');?>"  placeholder="0" class="form-control  fikyseparator ratakanan cal" required>
								</div>
							</div>	
						<!---?php } ?---->	
							
							<div class="form-group row">
								<label class="col-sm-2">Harga Brutto (Rp)</label>
								<div class="col-sm-4"> 
									<input type="text"  id="ttlbrutto" name="ttlbrutto"  value="<?php echo number_format(round($po_dtl['ttlbrutto'], 0), 0,',','.');?>"  placeholder="0" class="form-control fikyseparator ratakanan cal" readonly>
								</div>
							</div>
							<div class="form-group row diskonform">
								<label class="col-sm-2">DISKON</label>
								<span class="col-sm-2"> 
									<label class="col-sm-2">1+</label>
									<input type="text"  value="<?php echo round(number_format(trim($po_dtl['disc1'])));?>" id="disc1" name="disc1" placeholder="0" value="0" class="form-control col-sm-1 ratakanan fikyseparator cal" maxlength="3">
								</span>	                                                                                          
								<span class="col-sm-2">                                                                           
									<label class="col-sm-4">2+</label>                                                
									<input type="text"  value="<?php echo round(number_format(trim($po_dtl['disc2'])));?>" id="disc2" name="disc2" placeholder="0" value="0" class="form-control col-sm-1 ratakanan fikyseparator cal"  maxlength="3">
								</span>	                                                                                           
								<span class="col-sm-2">                                                                            
									<label class="col-sm-4">3+</label>                                                 
									<input type="text"  value="<?php echo round(number_format(trim($po_dtl['disc3'])));?>"  id="disc3" name="disc3" placeholder="0" value="0" class="form-control col-sm-1 ratakanan fikyseparator cal"  maxlength="3">
								</span>									
							</div>
							<div class="form-group row">
								<label class="col-sm-2">Sub Harga DPP (Rp)</label>
								<div class="col-sm-4">    
									<!--input type="input" id="qtytotalpriceview" name="qtytotalpriceview"  placeholder="0" class="form-control" readonly --->
									<input type="text" value="<?php echo number_format(round($po_dtl['ttldpp'], 0), 0,',','.');?>"  id="ttldpp" name="ttldpp" placeholder="0" class="form-control ratakanan fikyseparator" readonly >
								</div>	
								<span class="col-sm-4"> 	
									<label class="col-sm-4">PPN</label>
									<span class="col-sm-6"> 
									<!--input type="hidden" id="pkp" value="<!?php echo trim($po_mst['pkp']); ?>" name="pkp" readonly-->
									<select class="form-control col-sm-12 cal"  id="checkppn"   name="pkp" readonly>
										<?php if (trim($po_mst['pkp'])=='NO') { ?>
											<option  <?php if (trim($po_mst['pkp'])=='NO') { echo 'selected';}?>  value="NO"> NO </option>
										<?php }else{ ?>
											<option  <?php if (trim($po_mst['pkp'])=='YES') { echo 'selected';}?>  value="YES"> YES </option>
										<?php } ?>
									</select>
									</span>
								</span>
							</div>
							<div class="form-group">
								<label class="col-sm-2">Sub Harga PPN (Rp)</label>
								<div class="col-sm-4">    
									<!--input type="input" id="qtytotalpriceview" name="qtytotalpriceview"  placeholder="0" class="form-control" readonly --->
									<input type="input" id="ttlppn" name="ttlppn" value="<?php echo number_format(round($po_dtl['ttlppn'], 0), 0,',','.');?>"  placeholder="0" class="form-control ratakanan fikyseparator" readonly >
								</div>
								<span class="col-sm-4"> 	
									<label class="col-sm-4">INCLUDE/EXCLUDE</label>
									<span class="col-sm-6">
									<select class="form-control col-sm-12 cal" name="exppn" id="exppn">
										<option  <?php if ('INC'==trim($po_dtl['exppn'])) { echo 'selected';}?>  value="INC"> INCLUDE </option> 	
										<option  <?php if ('EXC'==trim($po_dtl['exppn'])) { echo 'selected';}?> value="EXC"> EXCLUDE </option> 		 
									</select>
									</span>
								</span>								
							</div>
							<div class="form-group row">
								<label class="col-sm-2">Sub Harga Diskon (Rp)</label>
								<div class="col-sm-4">    
									<!--input type="input" id="qtytotalpriceview" name="qtytotalpriceview"  placeholder="0" class="form-control" readonly --->
									<input type="input" value="<?php echo number_format(round($po_dtl['ttldiskon'], 0), 0,',','.');?>"  id="ttldiskon" name="ttldiskon" placeholder="0" class="form-control ratakanan" readonly >
								</div>	
							</div>
							<div class="form-group">
								<label class="col-sm-2">Sub Harga Netto (Rp)</label>
								<div class="col-sm-4">    
									<!--input type="input" id="qtytotalpriceview" name="qtytotalpriceview"  placeholder="0" class="form-control" readonly --->
									<input type="input" value="<?php echo number_format(round($po_dtl['ttlnetto'], 0), 0,',','.');?>" id="ttlnetto" name="ttlnetto" placeholder="0" class="form-control ratakanan fikyseparator" readonly >
								</div>							
							</div>
							<div class="form-group">
								<label class="col-sm-2">Keterangan</label>
								<div class="col-sm-8">    
									<input type="input" id="keterangan" name="keterangan"   style="text-transform:uppercase" class="form-control cal" value="<?php echo trim($po_dtl['keterangan']);?>">
								</div>
							</div>		
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="box-footer">
		<?php if(trim($po_dtl['status'])=='I') { ?>
			<a href="<?php echo site_url('ga/pembelian/input_po');?>" type="button" class="btn btn-default"/> Kembali</a>
		<?php } else if (trim($po_dtl['status'])=='E') { ?>	

			<a href="<?php $enc_nodoktmp=bin2hex($this->encrypt->encode(trim($po_mst['nodoktmp'])));
			echo site_url("ga/pembelian/edit_po_atk/$enc_nodoktmp");?>" type="button" class="btn btn-default"/> Kembali</a>
		<?php } ?>
		<!--button type="button" class="btn btn-default" data-dismiss="box">Close</button--->
        <button type="submit" id="submit"  class="btn btn-primary pull-right">SIMPAN</button>
      </div>
	  </form>
</div></div>


<script type="text/javascript">
    $(".cal").change(function(){
        calcutlation();
        console.log(('Kalkulasi'))
    });

    function calcutlation() {
        bqtyminta = $("#qtyminta").val().toString();
        bunitprice = $("#unitprice").val().toString();
        bdisc1 = $("#disc1").val().toString();
        bdisc2 = $("#disc2").val().toString();
        bdisc3 = $("#disc3").val().toString();
        bqtykecil = $("#qtykecil").val().toString();
        valqtykecil = parseInt(bqtykecil.replace(/[^-?(\d*\)?\d+$;]/g,''));
        valqtyminta = parseInt(bqtyminta.replace(/[^-?(\d*\)?\d+$;]/g,''));
        let valunitprice = parseFloat(bunitprice.replace(/\./g, '').replace(',', '.'));
        valdisc1 = parseInt(bdisc1.replace(/[^-?(\d*\)?\d+$;]/g,''));
        valdisc2 = parseInt(bdisc2.replace(/[^-?(\d*\)?\d+$;]/g,''));
        valdisc3 = parseInt(bdisc3.replace(/[^-?(\d*\)?\d+$;]/g,''));
        checkdisc = $("#checkdisc").val();
        checkppn = $("#checkppn").val();
        exppn = $("#exppn").val();
        satminta = $("#satminta").val();
        satkecil = $("#satkecil").val();
        kdgroup = $("#mpkdgroup").val();
        kdsubgroup = $("#mpkdsubgroup").val();
        stockcode = $("#mpkdbarang").val();
        keterangan = $("#keterangan").val();

            $("#loadMe").modal({
                backdrop: "static", //remove ability to close modal with click
                keyboard: false, //remove option to close with keyboard
                show: true //Display loader!
            });
            var urlx = "<?php echo site_url('ga/pembelian/calculation_remap_detail')?>";
            $.ajax(urlx, {
                type: "POST",
                data: JSON.stringify({
                    'success' : true,
                    'key': 'KUNCI',
                    'message' : '',
                    'body' : {
                        qtyminta: valqtyminta,
                        qtykecil: valqtykecil,
                        unitprice: valunitprice,
                        checkdisc: checkdisc,
                        disc1: valdisc1,
                        disc2: valdisc2,
                        disc3: valdisc3,
                        checkppn: checkppn,
                        exppn: exppn,
                        satminta: satminta,
                        satkecil: satkecil,
                        kdgroup: kdgroup,
                        kdsubgroup: kdsubgroup,
                        stockcode: stockcode,
                        keterangan: keterangan,
                             },
                }),
                contentType: "application/json",
            }).done(function (data) {
                var js = jQuery.parseJSON(data);
                if( js.enkript === 'KUNCI') {
                    $('[name="ttlbrutto"]').val(js.fill.ttlbrutto);
                    $('[name="ttlnetto"]').val(js.fill.ttlnetto);
                    $('[name="ttldpp"]').val(js.fill.ttldpp);
                    $('[name="ttldiskon"]').val(js.fill.ttldiskon);
                    $('[name="ttlppn"]').val(js.fill.ttlppn);
                    $('[name="keterangan"]').val(js.fill.keterangan);


                    console.log(js.fill.ttlbrutto);
                    console.log(js.fill.unitprice);
                    console.log(js.fill.disc1);
                    console.log('success');
                } else { console.log('Fail Key');}
                $("#loadMe").modal("hide");
            }).fail(function (xhr, status, error) {
                alert("Could not reach the API: " + error);
                $("#loadMe").modal("hide");
                return true;
            });

    }
</script>
