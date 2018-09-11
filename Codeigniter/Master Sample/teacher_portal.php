<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <?php $this->load->view("teacher_portal/head"); ?>
</head>
<body>
<div id="wrapper">
    <?php $this->load->view("teacher_portal/navbar"); ?>
    <div id="page-wrapper" class="gray-bg">
        <?php $this->load->view("teacher_portal/top_menu"); ?>
        <div class="wrapper wrapper-content">
            <div class="msg">
                <?php
                if ($this->session->flashdata('Success') != false) {
                    echo '<div role="alert" class="alert alert-success alert-dismissible">';
                    echo '<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>';
                    echo '<p>' . $this->session->flashdata('Success') . '</p>';
                    echo '</div>';
                } elseif ($this->session->flashdata('Error') != false) {
                    echo '<div role="alert" class="alert alert-danger alert-dismissible">';
                    echo '<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>';
                    echo '<p>' . $this->session->flashdata('Error') . '</p>';
                    echo '</div>';
                } elseif ($this->session->flashdata('Info') != false) {
                    echo '<div role="alert" class="alert alert-info alert-dismissible">';
                    echo '<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>';
                    echo '<p>' . $this->session->flashdata('Info') . '</p>';
                    echo '</div>';
                }
                ?>
            </div>
            <?php echo $_content; ?>
        </div>
        <?php $this->load->view("teacher_portal/footer"); ?>
    </div>
    <?php $this->load->view("teacher_portal/theme_settings"); ?>
</div>
<?php $this->load->view("teacher_portal/footer_lib"); ?>
</body>
</html>
