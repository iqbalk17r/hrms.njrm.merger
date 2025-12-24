<?php 
/*
	@author : junis 10-12-2012\m/
	@update : fiky 24-12-2016
*/	
	$this->load->model(array('trans/m_stspeg','master/m_akses'));
	$list_karpen=$this->m_stspeg->q_list_karpen()->result();
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();                             
				$("#dateinput").datepicker();                               
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();	
            });
</script>


'<head>
		  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		  <title>Tempo-Responsive Email Template</title>
		  
		  <style type="text/css">
			 /* Client-specific Styles */
			 div, p, a, li, td { -webkit-text-size-adjust:none; }
			 #outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
			 html{width: 100%; }
			 body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
			 /* Prevent Webkit and Windows Mobile platforms from changing default font sizes, while not breaking desktop design. */
			 .ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */
			 .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing. */
			 #backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
			 img {outline:none; text-decoration:none;border:none; -ms-interpolation-mode: bicubic;}
			 a img {border:none;}
			 .image_fix {display:block;}
			 p {margin: 0px 0px !important;}
			 table td {border-collapse: collapse;}
			 table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
			 a {color: #33b9ff;text-decoration: none;text-decoration:none!important;}
			 /*STYLES*/
			 table[class=full] { width: 100%; clear: both; }
			 /*IPAD STYLES*/
			 @media only screen and (max-width: 640px) {
			 a[href^="tel"], a[href^="sms"] {
			 text-decoration: none;
			 color: #33b9ff; /* or whatever your want */
			 pointer-events: none;
			 cursor: default;
			 }
			 .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
			 text-decoration: default;
			 color: #33b9ff !important;
			 pointer-events: auto;
			 cursor: default;
			 }
			 table[class=devicewidth] {width: 440px!important;text-align:center!important;}
			 table[class=devicewidthinner] {width: 420px!important;text-align:center!important;}
			 img[class=banner] {width: 440px!important;height:220px!important;}
			 img[class=col2img] {width: 440px!important;height:220px!important;}
			 
			 
			 }
			 /*IPHONE STYLES*/
			 @media only screen and (max-width: 480px) {
			 a[href^="tel"], a[href^="sms"] {
			 text-decoration: none;
			 color: #33b9ff; /* or whatever your want */
			 pointer-events: none;
			 cursor: default;
			 }
			 .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
			 text-decoration: default;
			 color: #33b9ff !important; 
			 pointer-events: auto;
			 cursor: default;
			 }
			 table[class=devicewidth] {width: 280px!important;text-align:center!important;}
			 table[class=devicewidthinner] {width: 260px!important;text-align:center!important;}
			 img[class=banner] {width: 280px!important;height:140px!important;}
			 img[class=col2img] {width: 280px!important;height:140px!important;}
			 
			
			 }
		  </style>
	   </head>
	   <body>
		<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="preheader" >
		   <tbody>
			  <tr>
				 <td>
					<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
					   <tbody>
						  <tr>
							 <td width="100%">
								<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
								   <tbody>
									  <!-- Spacing -->
									  <tr>
										 <td width="100%" height="20"></td>
									  </tr>
									  <!-- Spacing -->
									  <tr>
										
									  </tr>
									  <!-- Spacing -->
									  <tr>
										 <td width="100%" height="20"></td>
									  </tr>
									  <!-- Spacing -->
								   </tbody>
								</table>
							 </td>
						  </tr>
					   </tbody>
					</table>
				 </td>
			  </tr>
		   </tbody>
		</table>
		<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="header">
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table width="600" bgcolor="#004d1a" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                              <tr>
                                 <td>
                                    <!-- logo -->
                                    <table bgcolor="#004d1a" width="140" align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
                                       <tbody>
                                          <tr>
                                             <td width="140" height="50" align="center">
                                                <div class="imgpop">
                                                   <a target="_blank" href="#">
                                                   <img src="http://i.share.pho.to/126dc839_o.png" alt="" border="0" width="250" height="50" style="display:block; border:none; outline:none; text-decoration:none;">
                                                   </a>
                                                </div>
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                    <!-- end of logo -->
                                    <!-- start of menu -->
                                    <table bgcolor="#009933" width="250" height="50" border="0" align="right" valign="middle" cellpadding="0" cellspacing="0" border="0" class="devicewidth">
                                       <tbody>
                                          <tr>
                                             <td height="50" align="center" valign="middle" style="font-family: Helvetica, arial, sans-serif; font-size: 13px;color: #282828" st-content="menu">
                                                <a href="#" style="color: #282828;text-decoration: none;"></a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="#" style="color: #282828;text-decoration: none;"></a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="#" style="color: #282828;text-decoration: none;"></a>
                                                &nbsp;&nbsp;&nbsp;
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                    <!-- end of menu -->
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of Header -->
<!-- Start of seperator -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
   <tbody>
      <tr>
         <td>
            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
               <tbody>
                  <tr>
                     <td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of seperator --> 
<!-- Start of main-banner -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="banner">
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                           <tbody>
                              <tr>
                                 <!-- start of image -->
                                 <td align="center" st-image="banner-image">
                                    <div class="imgpop">
                                       <a target="_blank" href="#"><img width="600" border="0" height="300" alt="" border="0" style="display:block; border:none; outline:none; text-decoration:none;" src="http://i.share.pho.to/293bb558_o.jpeg" class="banner"></a>
                                    </div>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                        <!-- end of image -->
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of main-banner -->  
<!-- Start of seperator -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
   <tbody>
      <tr>
         <td>
            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
               <tbody>
                  <tr>
                     <td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of seperator -->   
     
<!-- Start of seperator -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
   <tbody>
      <tr>
         <td>
            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
               <tbody>
                  <tr>
                     <td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of seperator -->   
<!-- start of Full text -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="full-text">
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table bgcolor="#ffffff" width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                              <!-- Spacing -->
                              <tr>
                                 <td height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                              </tr>
                              <!-- Spacing -->
                              <tr>
                                 <td>
                                    <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner">
                                       <tbody>
                                          <!-- Title -->
                                          <tr>
                                             <td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #282828; text-align:center; line-height: 24px;">
                                                Reminder Karyawan Pensiun
                                             </td>
                                          </tr>
                                          <!-- End of Title -->
                                          <!-- spacing -->
                                          <tr>
                                             <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                          </tr>
                                          <!-- End of spacing -->
                                          <!-- content -->
                                          <tr>
                                             <td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #889098; text-align:center; line-height: 24px;">
												
																	<table id="example2" class="table table-bordered table-striped" style="border:3px solid black;">
																		<thead>
																			<tr>
																				<th style="border:2px solid black; font-size: 14px;">No.</th>
																				<th style="border:2px solid black; font-size: 14px;">NIK</th>
																				<th style="border:2px solid black; font-size: 14px;">Nama Karyawan</th>
																				<th style="border:2px solid black; font-size: 14px;">No Dokumen</th>
																				<th style="border:2px solid black; font-size: 14px;">Nama Status</th>							
																				<th style="border:2px solid black; font-size: 14px;">Tanggal Mulai</th>							
																				<th style="border:2px solid black; font-size: 14px;">Tanggal Berakhir</th>																	
																																		
																																					
																								
																			</tr>
																		</thead>
																		<tbody>
																			<?php $no=0; foreach($list_karpen as $lu): $no++;?>
																			<tr>										
																				<td width="2%" style="border:2px solid black;"><?php echo $no;?></td>																							
																				<td style="border:2px solid black; font-size: 10px;"><?php echo $lu->nik;?></td>
																				<td style="border:2px solid black; font-size: 10px;"><?php echo $lu->nmlengkap;?></td>
																				<td style="border:2px solid black; font-size: 10px;"><?php echo $lu->nodok;?></td>
																				<td style="border:2px solid black; font-size: 10px;"><?php echo $lu->nmkepegawaian;?></td>
																				<td style="border:2px solid black; font-size: 10px;"><?php echo $lu->tgl_mulai1;?></td>
																				<td style="border:2px solid black; font-size: 10px;"><?php echo $lu->tgl_selesai1;?></td>
																				
																			</tr>
																			<?php endforeach;?>
																		</tbody>
																	</table>
											
                                             </td>
                                          </tr>
                                          <!-- End of content -->
                                          <!-- Spacing -->
                                          <tr>
                                             <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                          </tr>
                                          <!-- Spacing -->
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                              <!-- Spacing -->
                              <tr>
                                 <td height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                              </tr>
                              <!-- Spacing -->
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of Full Text -->
<!-- Start of seperator -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
   <tbody>
      <tr>
         <td>
            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
               <tbody>
                  <tr>
                     <td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of seperator --> 

<!-- Start of seperator -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
   <tbody>
      <tr>
         <td>
            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
               <tbody>
                  <tr>
                     <td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of seperator -->
<!-- Start of footer -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="footer">
   <tbody>
      <tr>
         <td>
            <table width="600" bgcolor="#eacb3c" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table bgcolor="#eacb3c" width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                              <!-- Spacing -->
                              <tr>
                                 <td height="10" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                              </tr>
                              <!-- Spacing -->
                              <tr>
                                 <td>
                                    <!-- Social icons -->
                                    <table  width="150" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
                                       <tbody>
                                          <tr>
                                             <td width="43" height="43" align="center">
                                                <div class="imgpop">
                                                   <a target="_blank" href="#">
                                                   <img src="http://i.share.pho.to/e1e3d850_o.jpeg" alt="" border="0" width="60" height="43" style="display:block; border:none; outline:none; text-decoration:none;">
                                                   </a>
                                                </div>
                                             </td>
                                             <td align="left" width="20" style="font-size:1px; line-height:1px;">&nbsp;&nbsp;</td>
                                             <td width="43" height="43" align="center">
                                                <div class="imgpop">
                                                   <a target="_blank" href="#">
                                                   <img src="http://i.share.pho.to/e1e3d850_o.jpeg" alt="" border="0" width="60" height="43" style="display:block; border:none; outline:none; text-decoration:none;">
                                                   </a>
                                                </div>
                                             </td>
                                             <td align="left" width="20" style="font-size:1px; line-height:1px;">&nbsp;&nbsp;</td>
                                             <td width="43" height="43" align="center">
                                                <div class="imgpop">
                                                   <a target="_blank" href="#">
                                                   <img src="http://i.share.pho.to/e1e3d850_o.jpeg" alt="" border="0" width="60" height="43" style="display:block; border:none; outline:none; text-decoration:none;">
                                                   </a>
                                                </div>
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                    <!-- end of Social icons -->
                                 </td>
                              </tr>
                              <!-- Spacing -->
                              <tr>
                                 <td height="10" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                              </tr>
                              <!-- Spacing -->
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of footer -->
<!-- Start of Postfooter -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="postfooter" >
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <!-- Spacing -->
                  <tr>
                     <td width="100%" height="20"></td>
                  </tr>
                  <!-- Spacing -->
                  <tr>
                     <td align="center" valign="middle" style="font-family: Helvetica, arial, sans-serif; font-size: 13px;color: #282828" st-content="preheader">
                       Copyright IT Nusantara Group 2016 <a href="#" style="text-decoration: none; color: #eacb3c">Subscribe </a> 
                     </td>
                  </tr>
                  <!-- Spacing -->
                  <tr>
                     <td width="100%" height="20"></td>
                  </tr>
                  <!-- Spacing -->
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of postfooter -->      
   </body>









