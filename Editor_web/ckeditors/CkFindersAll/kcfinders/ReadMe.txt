 $(function() {
        $('.ck_editor').each(function(){
            CKEDITOR.replace( $(this).attr('id'),
            {
                skin :'office2013',//kama,office2013,moonocolor,moono-lisa (default)
                toolbarCanCollapse : true,
                height : 160,
                startupFocus : 'start',
                extraPlugins : 'uploadimage,uploadwidget,clipboard,dialog,notification,toolbar,widget,filetools,notificationaggregator,lineutils,widgetselection',
                //
                filebrowserBrowseUrl : '<?php echo base_url(); ?>assets/ckeditor/kcfinder/browse.php?opener=ckeditor&type=files',
                filebrowserImageBrowseUrl : '<?php echo base_url(); ?>assets/ckeditor/kcfinder/browse.php?opener=ckeditor&type=images',
                filebrowserFlashBrowseUrl : '<?php echo base_url(); ?>assets/ckeditor/kcfinder/browse.php?opener=ckeditor&type=flash',
                filebrowserUploadUrl : '<?php echo base_url(); ?>assets/ckeditor/kcfinder/upload.php?opener=ckeditor&type=files',
                filebrowserImageUploadUrl : '<?php echo base_url(); ?>assets/ckeditor/kcfinder/upload.php?opener=ckeditor&type=images',
                filebrowserFlashUploadUrl : '<?php echo base_url(); ?>assets/ckeditor/kcfinder/upload.php?opener=ckeditor&type=flash',
                //
            });
        });
    });


//Steps:

1. go to kcfinder>conf>config.php

Set 'disabled' => false,
