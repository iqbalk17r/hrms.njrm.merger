<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php
                $imgr = trim($user_menu['image']);
                if (!empty($imgr) && file_exists(FCPATH . "assets/img/profile/$imgr")) {
                    $img_src = base_url("assets/img/profile/$imgr");
                } else {
                    $img_src = base_url("assets/img/admin.jpg");
                }
                ?>
                <img width="100%" height="80%" src="<?php echo $img_src; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $user_menu['nmlengkap'];    ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" id="search" name="q" class="form-control" placeholder="Cari...">
                <span class="input-group-btn">
                    <a class="btn btn-flat" style="cursor: default;"><i class="fa fa-search"></i></a>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <?php
            $user_name = $user_menu['username'];
            $timestamp = Date('Y-m-d H:i:s');
            $secret_key = $this->config->item('secret_key');

            $data = [
                'user_name' => $user_name,
                'timestamp' => $timestamp
            ];

            $token = openssl_encrypt(json_encode($data), 'aes-256-cbc', $secret_key, 0, $iv = '1234567890123456');
            $encoded_token = base64_encode($token);

            //url hrms0
            $data['urldcms'] = trim(strtolower($this->m_menu->q_menu_url_dcms()));
            $url = !empty($data['urldcms']) ? $data['urldcms'] : '/dms/login/login_with_token?';

            foreach ($list_menu_main as $lm) { ?>
                <li class="treeview sidebar-link">
                    <a href="<?php if (!empty($lm->linkmenu)) {
                                    echo site_url(trim($lm->linkmenu));
                                } else {
                                    echo '#';
                                } ?>" id="<?= trim($lm->kodemenu) ?>">
                        <i class="fa <?php echo trim($lm->iconmenu); ?>"></i> <span><?php echo trim($lm->namamenu); ?></span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <?php foreach ($list_menu_sub as $lms) {
                            if (trim($lms->parentmenu) == trim($lm->kodemenu)) {
                        ?>
                                <li class="sidebar-link">
                                    <a href="<?php if (!empty($lms->linkmenu)) {
                                                    echo site_url(trim($lms->linkmenu));
                                                } else {
                                                    echo '#';
                                                } ?>" id="<?= trim($lms->kodemenu) ?>">
                                        <i class="fa <?php if (!empty($lms->iconmenu)) {
                                                            echo trim($lms->iconmenu);
                                                        } else {
                                                            echo 'fa-angle-double-right';
                                                        } ?>"></i> <?php echo trim($lms->namamenu); ?>
                                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <?php foreach ($list_menu_submenu as $lmp) {
                                            if (trim($lmp->parentmenu) == trim($lm->kodemenu) and trim($lmp->parentsub) == trim($lms->kodemenu)) { ?>
                                                <!--<li><a href='<?php /*if (!empty($lmp->linkmenu)) {echo site_url(trim($lmp->linkmenu));} else { echo '#';}*/ ?>'><i class="fa <?php /*if (!empty($lmp->iconmenu)) { echo trim($lmp->iconmenu);} else { echo 'fa-angle-double-right';}*/ ?>"></i><strong><font face="arial" size="1%"  color="green"><?php /*echo trim($lmp->namamenu);*/ ?></font></strong></p></a>-->
                                                <li class="sidebar-link">
                                                    <a onclick="crutz('<?php echo trim($lmp->kodemenu); ?>')"
                                                        href="<?php if (!empty($lmp->linkmenu) && $lm->urut == "11") {
                                                                    echo $url . "token=$encoded_token" . "&redirect=" . trim($lmp->linkmenu);
                                                                } elseif (!empty($lmp->linkmenu)) {
                                                                    echo site_url(trim($lmp->linkmenu));
                                                                } else {
                                                                    echo '#';
                                                                } ?>"
                                                        id="<?= trim($lmp->kodemenu) ?>">
                                                        <i class="fa <?php if (!empty($lmp->iconmenu)) {
                                                                            echo trim($lmp->iconmenu);
                                                                        } else {
                                                                            echo 'fa-angle-double-right';
                                                                        } ?>">
                                                        </i>
                                                        <?php echo trim($lmp->namamenu); ?>
                                                    </a>
                                                </li>
                                        <?php }
                                        }
                                        ?>
                                    </ul>
                                </li>
                        <?php }
                        } ?>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<script>
    $(document).ready(function() {
        $("#search").on("keyup", function() {
            if (this.value.length > 0) {
                $("li.sidebar-link").hide().filter(function() {
                    return $(this).text().toLowerCase().indexOf($("#search").val().toLowerCase()) != -1;
                }).show();
            } else {
                $("li.sidebar-link").show();
            }
        });
    });
</script>

<script>
    function crutz(xx) {
        console.log(xx);
    }
</script>