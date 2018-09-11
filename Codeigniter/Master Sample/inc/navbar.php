<?php
$controller = $this->uri->segment(1);
$action = $this->uri->segment(2);
$user_session = $this->session->userdata('logged_in');

$organization_info=$this->utilities->findByAttribute('SA_ORGANIZATIONS', array('STATUS' => 1));
$ABBR=$organization_info->ABBR;
$WEBSITE=$organization_info->WEBSITE;
$ORG_NAME=$organization_info->ORG_NAME;
$EMAIL=$organization_info->EMAIL;
$PHONE=$organization_info->PHONE;
//$org_log= base_url('upload/organization/logo/'.$organization_info->LOGO);
$org_log= base_url('upload/organization/logo/logo.png');

?>
<nav class="navbar-default navbar-static-side" role="navigation">

    <div class="sidebar-collapse">

        <ul class="nav sidebar-menu" id="side-menu">
            <li class="nav-header" >
                <div class="dropdown profile-element" >

                    <img alt="image" style="width:80px;height: 80px" class="img-rectange"
                         src="<?php echo $org_log; ?>" />


                </div>
                <span style="color: white;margin-left: 20px;"><b> <?php /*echo $ABBR */?></b> </span>
                <div class="logo-element">
                    <?php //echo $ABBR ?>
                </div>
            </li>

            <li>
                <a href="<?php echo site_url('admin'); ?>"><i class="fa fa-dashboard"></i> <span class="nav-label">Dashboard</span> </a>
            </li>
            <?php
            if ($user_session["IS_ADMIN"] == 1) {
                ?>
                <li>
                    <a href="#"><i class="fa fa-cogs"></i> <span class="nav-label">Security & Access</span> <span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?php echo site_url(); ?>/securityAccess/moduleSetup"> Modules</a></li>
                        <li><a href="<?php echo site_url(); ?>/securityAccess/createModuleLink"> Module Link</a></li>
                        <li><a href="<?php echo site_url(); ?>/securityAccess/orgModuleSetup"> Organization Modules</a>
                        </li>
                        <li><a href="<?php echo site_url(); ?>/securityAccess/allGroup"> User Groups</a></li>
                        <li><a href="<?php echo site_url(); ?>/securityAccess/assignModuleToGroup"> Assign Module</a>
                        </li>
                    </ul>
                </li>
                <?php
            }


            $dtls = $this->security_model->getOrgModules();


            foreach ($dtls as $dtl) {
                $modid = $dtl->SA_MODULE_ID;

                //var_dump($this->security_model->get_all_module_links($modid));


                $session_info = $this->session->userdata('logged_in');
                if ($session_info["USERGRP_ID"] != "") {
                    $links = $this->security_model->get_all_module_links($modid);
                } else {
                    $links_user = $this->careProvider_model->get_all_module_links_from_user($modid);
                }
                if (!empty($links)) {

                    $lang_ses = $this->session->userdata("site_lang");
                    ?>
                    <li>
                        <a href="#" aria-expanded="true">

                            <i class="<?php echo ($dtl->MODULE_ICON !='')? "$dtl->MODULE_ICON" : "fa fa-th-large" ?>"></i>
                            <span class="nav-label">
                                <?php
                                echo ($lang_ses == "bangla") ? $dtl->MODULE_NAME_BN : $dtl->SA_MODULE_NAME;
                                ?>
                            </span>
                            <?php
                            if ($links[0]->URL_URI != '') {
                                ?>
                                <span class="fa arrow"></span>
                                <?php
                            }
                            ?>
                        </a>
                        <ul class="nav nav-second-level" aria-expanded="true">
                            <?php
                            foreach ($links as $link) {
                                ?>
                                <li class="<?php echo ($this->uri->uri_string() == $link->URL_URI) ? 'active' : '' ?>"><?php echo anchor($link->URL_URI, ($lang_ses == "bangla") ? $link->LINK_NAME_BN : $link->LINK_NAME); ?></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>


    </div>
</nav>