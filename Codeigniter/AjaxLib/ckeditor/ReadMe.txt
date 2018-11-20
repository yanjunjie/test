//js:
<script src="<?php echo base_url('assets/ckeditor/ckeditor.js');?>"></script>
<script type="text/javascript">
    $(function() {
        $('.ck_editor').each(function(){
            CKEDITOR.replace( $(this).attr('id') );
        });
    });
</script>

//html:
<textarea class="ck_editor" name="ffff" id="asdfff" cols="30" rows="10"></textarea>

//For Ajax:
$.ajax({
    type: 'post',
    url: url,
    data: formData,
    contentType: false,
    processData: false,
    beforeSend: function () {
        //modal_body.html(""); /*<img src='<--?php echo base_url(); ?>assets/img/loader.gif' />*/
    },
    success: function (data) {
        //Destroy old instances
        for(name in CKEDITOR.instances)
        {
            CKEDITOR.instances[name].destroy(true);
        }
        modal_body.html(data);
    },
    error: function(){
        alert('Error! Please check form data');
    }
});




