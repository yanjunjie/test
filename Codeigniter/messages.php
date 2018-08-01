<!--Session Alert List-->
<?php if($alert = $this->session->userdata('success')): ?>
    <div class="alert alert-success alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> <?php echo $alert; $this->session->unset_userdata('success');?>
    </div>
<?php endif; ?>

<?php if($alert = $this->session->userdata('failure')): ?>
    <div class="alert alert-danger alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Failure!</strong> <?php echo $alert; $this->session->unset_userdata('failure');?>
    </div>
<?php endif; ?>
<!--End Session Alert List-->

<!--Flash Alert List-->
<?php
/*if ($this->session->flashdata('Success') != false) {
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
}*/
?>
<!--End Flash Alert List-->
