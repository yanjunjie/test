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



Options:

$('.redactor').redactor({
    linebreaks: true,
    paragraphy: false,
    "enterKey": false,
    "pastePlainText": true,
    buttons: ['bold', 'italic', 'link'],
    minHeight: 50,
    paragraphize: false,
    replaceDivs: false,
    linebreaks: true,
    enterKey: false,
    deniedTags: ['br']
});
