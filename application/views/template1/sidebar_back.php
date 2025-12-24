
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar sidebar-mini ">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
					<?php foreach ($list_menu_main as $lm) { ?>
						<li class="treeview">
                            <a href="<?php if (!empty($lm->linkmenu)) {echo site_url(trim($lm->linkmenu));} else { echo '#';}?>">
                                <i class="fa <?php echo trim($lm->iconmenu);?>"></i><span><?php echo trim($lm->namamenu);?></span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
							<ul class="treeview-menu">
                                <?php foreach ($list_menu_sub as $lms) {
								if (trim($lms->parentmenu)==trim($lm->kodemenu)){
								?>								
								<li class="treeview"><a href='<?php if (!empty($lms->linkmenu)) {echo site_url(trim($lms->linkmenu));} else { echo '#';}?>'><i class="fa <?php if (!empty($lms->iconmenu)) { echo trim($lms->iconmenu);} else { echo 'fa-angle-double-right';}?>"></i><?php echo trim($lms->namamenu);?></a>
									<ul class="treeview-menu">
										<?php foreach ($list_menu_submenu as $lmp){
											if (trim($lmp->parentmenu)==trim($lm->kodemenu) and trim($lmp->parentsub)==trim($lms->kodemenu)){?>
											<li><a href='<?php if (!empty($lmp->linkmenu)) {echo site_url(trim($lmp->linkmenu));} else { echo '#';}?>'><i class="fa <?php if (!empty($lmp->iconmenu)) { echo trim($lmp->iconmenu);} else { echo 'fa-angle-double-right';}?>"></i><strong><font face="arial" size="1%"  color="green"><?php echo trim($lmp->namamenu);?></font></strong></p></a>
										<?php }}?>
									</ul>
								</li>                                
								<?php };}?>
							</ul>
						</li>						
					<?php }?>
					
					
	
					
						<!--li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>HRD</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
							<ul class="treeview-menu">
                                <li class="treeview"><a><i class="fa fa-angle-double-right"></i>Pegawai</a>
									<ul class="treeview-menu">
										<li><a><i class="fa fa-angle-double-right"></i>COBA 1</a></li>
										<li>COBA 2</li>
										<li>COBA 3</li>
									</ul>
								</li>
                                <li><a><i class="fa fa-angle-double-right"></i>Cuti</a></li>
							</ul>
						</li-->
					
                    </ul>
					
                </section>
                <!-- /.sidebar -->
            </aside>
