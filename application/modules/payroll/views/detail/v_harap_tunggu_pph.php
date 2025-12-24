<script type="text/javascript">
            $(function() {

                $("#example2").dataTable();
                $("#example3").dataTable();
                $("#tgl").datepicker();
				$("[data-mask]").inputmask();
				$("#inputstockcode").chained("#inputmgroup");	
				//gr_payroll();
				
				setTimeout(function(){ gr_payroll(); }, 5000);
				
                $('#example5').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
			});
			
			function gr_payroll() {
				//var param1 = $('#tgl').val();
				//var param2 = $('#tglawalfix').val();
				//var param3 = $('#tglakhirfix').val();
				var param4 = $('#kdgroup_pg').val();
				var param5 = $('#kddept').val();
				var param6 = $('#periode').val();
				var param7 = $('#keluarkerja').val();
			
				//alert(param1+param2+param3+param4+param5);
				$('#download').attr('disabled',true);
				$('#download').text('Sedang Processing....!!');
				
				setInterval(function(){
					setTimeout(function() {$('#download').text('HARAP TUNGGU PROSES GENERATE MASIH BERJALAN....!!');
					}, 3000);
					setTimeout(function() {$('#download').text('PERINGATAN !!-----JANGAN TUTUP WINDOWS....!!');
					}, 6000);
					setTimeout(function() {$('#download').text('HARAP TUNGGU PROSES GENERATE MASIH BERJALAN....!!');
					}, 9000);
				}, 10000);
				
				setInterval(function(){ 
					window.open("<?php echo site_url('/dashboard')?>");
				}, 240000);
			     $.ajax({
					url : "<?php echo site_url('/payroll/detail_payroll/generate_pph')?>/"+param4+'/'+param5+'/'+param6+'/'+param7,
					type: "POST",
					dataType: "JSON",
					success: function(data)
					{
						console.log('Sukses');	
			 		   if (data.status==true){
							   setTimeout(function() {
							   $("#message").hide('blind', {}, 500)
							   }, 5000);
							   $('#download').text('FINISH');
							   $('#download').attr('disabled',false);
							  // window.open("<?php echo site_url('/payroll/detail_payroll/master')?>/"+param4+'/'+param5+'/'+param6+'/'+param7);
							   window.location.replace("<?php echo site_url('/payroll/detail_payroll/master_pph')?>/"+param4+'/'+param5+'/'+param6+'/'+param7);
					   } else {
								console.log('GAGAL');
								window.location.replace("<?php echo site_url('/payroll/detail_payroll/master_pph')?>/"+param4+'/'+param5+'/'+param6+'/'+param7)
					   }					   					   
					    
								

					}  ,
					error: function (jqXHR, textStatus, errorThrown)
					{
						if(textStatus=='timeout'){
							console.log('GAGAL TIMEOUT');
							window.location.replace("<?php echo site_url('/payroll/detail_payroll/master_pph')?>/"+param4+'/'+param5+'/'+param6+'/'+param7)
						} else {
							console.log('COK');
							window.location.replace("<?php echo site_url('/payroll/detail_payroll/master_pph')?>/"+param4+'/'+param5+'/'+param6+'/'+param7)
						}
						
						//window.location.replace("<?php echo site_url('/payroll/detail_payroll/master')?>/"+param4+'/'+param5+'/'+param6+'/'+param7)
						//$('#download').text('COBA');
						//$('#download').attr('disabled',false);						
					}  
				}); 
			}
				
/* start progrss bar*/
$(document).ready(function() {

/*   // progressbar 1
  $("#progressbar").progressbar({
    value: 37
  }); */

  // progressbar 2
  var progressbar = $("#progressbar2"),
    progressLabel = $(".progress-label");

  progressbar.progressbar({
    value: false,
    change: function() {
      progressLabel.text(progressbar.progressbar("value") + "%");
    },
    complete: function() {
      progressLabel.text("Complete!");
    }
  });

  function progress() {
    var val = progressbar.progressbar("value") || 0;

    progressbar.progressbar("value", val + 2);

    if (val < 1000) {
      setTimeout(progress, 80);
    }
  }

  setTimeout(progress, 2000);

  // progressbar 3
  var progressTimer,
    progressbar = $("#progressbar3"),
    progressLabel = $(".progress-label"),
    dialogButtons = [{
      text: "Cancel Download",
      click: closeDownload
    }],
    dialog = $("#dialog").dialog({
      autoOpen: false,
      closeOnEscape: false,
      resizable: false,
      buttons: dialogButtons,
      open: function() {
        progressTimer = setTimeout(progress, 2000);
      },
      beforeClose: function() {
        downloadButton.button("option", {
          disabled: false,
          label: "Start Download"
        });
      }
    }),
    downloadButton = $("#downloadButton")
    .button()
    .on("click", function() {
      $(this).button("option", {
        disabled: true,
        label: "Downloading..."
      });
      dialog.dialog("open");
    });

  progressbar.progressbar({
    value: false,
    change: function() {
      progressLabel.text("Current Progress: " + progressbar.progressbar("value") + "%");
    },
    complete: function() {
      progressLabel.text("Complete!");
      dialog.dialog("option", "buttons", [{
        text: "Close",
        click: closeDownload
      }]);
      $(".ui-dialog button").last().focus();
    }
  });

  function progress() {
    var val = progressbar.progressbar("value") || 0;

    progressbar.progressbar("value", val + Math.floor(Math.random() * 3));

    if (val <= 10000) {
      progressTimer = setTimeout(progress, 50);
    }
  }

  function closeDownload() {
    clearTimeout(progressTimer);
    dialog
      .dialog("option", "buttons", dialogButtons)
      .dialog("close");
    progressbar.progressbar("value", false);
    progressLabel
      .text("Starting download...");
    downloadButton.focus();
  }

});	
				
         

     	




		
</script>
<style>
.ball {
    background-color: rgba(0,0,0,0);
    border: 5px solid rgba(0,183,229,0.9);
    opacity: .9;
    border-top: 5px solid rgba(0,0,0,0);
    border-left: 5px solid rgba(0,0,0,0);
    border-radius: 50px;
    box-shadow: 0 0 35px #2187e7;
    width: 150px;
    height: 150px;
    margin: 0 auto;
    -moz-animation: spin .5s infinite linear;
    -webkit-animation: spin .5s infinite linear;
}

.ball1 {
    background-color: rgba(0,0,0,0);
    border: 5px solid rgba(0,183,229,0.9);
    opacity: .9;
    border-top: 5px solid rgba(0,0,0,0);
    border-left: 5px solid rgba(0,0,0,0);
    border-radius: 50px;
    box-shadow: 0 0 15px #2187e7;
    width: 90px;
    height: 90px;
    margin: 0 auto;
    position: relative;
    top: -50px;
    -moz-animation: spinoff .5s infinite linear;
    -webkit-animation: spinoff .5s infinite linear;
}

@-moz-keyframes spin {
    0% {
        -moz-transform: rotate(0deg);
    }

    100% {
        -moz-transform: rotate(360deg);
    };
}

@-moz-keyframes spinoff {
    0% {
        -moz-transform: rotate(0deg);
    }

    100% {
        -moz-transform: rotate(-360deg);
    };
}

@-webkit-keyframes spin {
    0% {
        -webkit-transform: rotate(0deg);
    }

    100% {
        -webkit-transform: rotate(360deg);
    };
}

@-webkit-keyframes spinoff {
    0% {
        -webkit-transform: rotate(0deg);
    }

    100% {
        -webkit-transform: rotate(-360deg);
    };
}


.circle {
    background-color: rgba(0,0,0,0);
    border: 5px solid rgba(0,183,229,0.9);
    opacity: .9;
    border-right: 5px solid rgba(0,0,0,0);
    border-left: 5px solid rgba(0,0,0,0);
    border-radius: 50px;
    box-shadow: 0 0 35px #2187e7;
    width: 150px;
    height: 150px;
    margin: 0 auto;
    -moz-animation: spinPulse 1s infinite ease-in-out;
    -webkit-animation: spinPulse 1s infinite linear;
}

.circle1 {
    background-color: rgba(0,0,0,0);
    border: 5px solid rgba(0,183,229,0.9);
    opacity: .9;
    border-left: 5px solid rgba(0,0,0,0);
    border-right: 5px solid rgba(0,0,0,0);
    border-radius: 50px;
    box-shadow: 0 0 15px #2187e7;
    width: 90px;
    height: 90px;
    margin: 0 auto;

    -moz-animation: spinoffPulse 1s infinite linear;
    -webkit-animation: spinoffPulse 1s infinite linear;
}

@-moz-keyframes spinPulse {
    0% {
        -moz-transform: rotate(160deg);
        opacity: 0;
        box-shadow: 0 0 1px #2187e7;
    }

    50% {
        -moz-transform: rotate(145deg);
        opacity: 1;
    }

    100% {
        -moz-transform: rotate(-320deg);
        opacity: 0;
    };
}

@-moz-keyframes spinoffPulse {
    0% {
        -moz-transform: rotate(0deg);
    }

    100% {
        -moz-transform: rotate(360deg);
    };
}

@-webkit-keyframes spinPulse {
    0% {
        -webkit-transform: rotate(160deg);
        opacity: 0;
        box-shadow: 0 0 1px #2187e7;
    }

    50% {
        -webkit-transform: rotate(145deg);
        opacity: 1;
    }

    100% {
        -webkit-transform: rotate(-320deg);
        opacity: 0;
    };
}

@-webkit-keyframes spinoffPulse {
    0% {
        -webkit-transform: rotate(0deg);
    }

    100% {
        -webkit-transform: rotate(360deg);
    };
}




.barlittle {
    background-color: #2187e7;
    background-image: -moz-linear-gradient(45deg, #2187e7 25%, #a0eaff);
    background-image: -webkit-linear-gradient(45deg, #2187e7 25%, #a0eaff);
    border-left: 1px solid #111;
    border-top: 1px solid #111;
    border-right: 1px solid #333;
    border-bottom: 1px solid #333;
    width: 80px;
    height: 80px;
    float: left;
    margin-left: 100px;
    opacity: 0.1;
    -moz-transform: scale(0.7);
    -webkit-transform: scale(0.7);
    -moz-animation: move 1s infinite linear;
    -webkit-animation: move 1s infinite linear;
}

#block_1 {
    -moz-animation-delay: .4s;
    -webkit-animation-delay: .4s;
}

#block_2 {
    -moz-animation-delay: .3s;
    -webkit-animation-delay: .3s;
}

#block_3 {
    -moz-animation-delay: .2s;
    -webkit-animation-delay: .2s;
}

#block_4 {
    -moz-animation-delay: .3s;
    -webkit-animation-delay: .3s;
}

#block_5 {
    -moz-animation-delay: .4s;
    -webkit-animation-delay: .4s;
}

#block_6 {
    -moz-animation-delay: .4s;
    -webkit-animation-delay: .4s;
}

@-moz-keyframes move {
    0% {
        -moz-transform: scale(1.2);
        opacity: 1;
    }

    100% {
        -moz-transform: scale(0.7);
        opacity: 0.1;
    };
}

@-webkit-keyframes move {
    0% {
        -webkit-transform: scale(1.2);
        opacity: 1;
    }

    100% {
        -webkit-transform: scale(0.7);
        opacity: 0.1;
    };
}
</style>
<legend><?php //echo $title;?></legend>

				<div class="col-sm-12">		
					<center><h1 id="download">SEDANG MEMPROSES JANGAN TUTUP WINDOWS......</h1></center>
					<!--button id='download' class="btn btn-large btn-success" style="width:550px;height:250px; color:#000000;"><h1><center><b>COBA DONK</b></center></h1></button-->
				</div>

        <div class="form-group input-sm ">		
			
			<div class="form-group">
				<div class="col-sm-8">    
					 <!--input type="input"  class="form-control input-sm rs" id="tgl" value="<?php echo trim($tgl); ?>" readonly--->
					 <!--input type="input"  class="form-control input-sm rs" id="tglawalfix" value="<?php echo trim($tglawalfix); ?>" readonly-->
					 <!--input type="input"  class="form-control input-sm rs" id="tglakhirfix" value="<?php echo trim($tglakhirfix); ?>" readonly-->
					 <input type="hidden"  class="form-control input-sm rs" id="kdgroup_pg" value="<?php echo trim($kdgroup_pg); ?>" readonly>
					 <input type="hidden"  class="form-control input-sm rs" id="kddept" value="<?php echo trim($kddept); ?>" readonly>
					 <input type="hidden"  class="form-control input-sm rs" id="periode" value="<?php echo trim($periode); ?>" readonly>
					 <input type="hidden"  class="form-control input-sm rs" id="keluarkerja" value="<?php echo trim($keluarkerja); ?>" readonly>
				</div>
			</div>		
		</div>
<br/>
<br/><br/>
<br/><br/>
<br/>		
<!--div id="progressbar"></div>

<br/>
<br/-->


<!--div id="progressbar2">
  <div class="progress-label">Loading...</div>
</div>

<br/>
<br/>

<div id="dialog" title="File Download">
  <div class="progress-label">Starting download...</div>
  <div id="progressbar3"></div>
</div>
<button id="downloadButton">Start Download</button-->

<!--div class="ball"></div-->
<div class="ball1"></div>

<!--div class="circle"></div-->
<!--div class="circle1"></div--->
<div> 	<center>
<div id="block_1" class="barlittle"></div>
<div id="block_2" class="barlittle"></div>
<div id="block_3" class="barlittle"></div>
<div id="block_4" class="barlittle"></div>
<div id="block_5" class="barlittle"></div> 	
<div id="block_6" class="barlittle"></div> 	

</center> </div>