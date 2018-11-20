//js:
<script src="<?php echo base_url('assets/ckeditor/ckeditor.js');?>"></script>
<script type="text/javascript">
    $(function() {
        $('.ck_editor').each(function(){
            CKEDITOR.replace( $(this).attr('id'),
            {
                skin :'office2013',//kama,office2013,moonocolor,moono-lisa (default)
                toolbarCanCollapse : true,
                height : 180
            });
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


/*
* Available options:
*/

/*toolbar_Basic : [
    [ 'Source', '-', 'Bold', 'Italic' ]
],
toolbar : 'Basic',
*/
skin :'office2013',//kama,office2013,moonocolor,moono-lisa (default)
toolbarCanCollapse : true,
height : 180,
//removeButtons : 'Underline,JustifyCenter',
//removePlugins : 'elementspath,save,font',
//uiColor :'#F7F7F7'
/*toolbar : [
    { name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },
    { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
    '/',
    { name: 'basicstyles', items: [ 'Bold', 'Italic' ] }
],*/
//config.contentsCss : [ '/css/mysitestyles.css', '/css/anotherfile.css' ],
//toolbarLocation: 'bottom',
//extraPlugins: 'sharedspace',
/*sharedSpaces: {
    top: 'top',
    bottom: 'bottom'
}*/
//customConfig: '/myconfig.js',




