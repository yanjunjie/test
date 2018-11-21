For intregration:
https://ckeditor.com/docs/ckfinder/ckfinder3/#!/guide/dev_ckeditor

//OR

filebrowserBrowseUrl: '<?php echo base_url(); ?>assets/ckeditor/ckfinder/ckfinder.html',
filebrowserImageBrowseUrl: '<?php echo base_url(); ?>assets/ckeditor/ckfinder/ckfinder.html?type=Images',
filebrowserFlashBrowseUrl: '<?php echo base_url(); ?>assets/ckeditor/ckfinder/ckfinder.html?type=Flash',
filebrowserUploadUrl: '<?php echo base_url(); ?>assets/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
filebrowserImageUploadUrl: '<?php echo base_url(); ?>assets/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
filebrowserFlashUploadUrl: '<?php echo base_url(); ?>assets/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'

In config.php,

Change to 

$config['authentication'] = function () {
    return true;
};
