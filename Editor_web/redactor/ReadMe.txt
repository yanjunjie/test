//Initialize Reductor

<!--  Reductor Editor -->
<link rel="stylesheet" href="<?php echo base_url(); ?>dist/redactor/redactor.css"/>
<script src="<?php echo base_url(); ?>dist/redactor/redactor.min.js"></script>
<script type="text/javascript">
    $(document).ready(
        function () {
            $('.redactor').redactor();
        });
</script>

//Use Reductor
<div class="col-sm-3">
   <?php echo form_textarea(array('name' => 'remarks', "class" => "form-control redactor", 'required'=>'required','placeholder' => 'Remarks', 'cols' => '12','rows' => '4')); ?>
</div>
