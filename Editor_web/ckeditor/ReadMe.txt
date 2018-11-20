<script src="<?php echo base_url('assets/ckeditor/ckeditor.js');?>"></script>
<script type="text/javascript">
    $(function() {
        $('.ck_editor').each(function(){
            CKEDITOR.replace( $(this).attr('id') );
        });
    });
</script>
