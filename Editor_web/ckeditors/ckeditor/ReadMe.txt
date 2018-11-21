//CkEditor Initialization:

CKEDITOR.replace('editor1',
{
    on :
    {
        instanceReady : function( ev )
        {
            CKEDITOR.instances.editor1.focus();
        }
    }
} );

//OR

CKEDITOR.replace('editor1',
{
    on :
    {
        instanceReady : function( ev )
        {
            this.focus();
        }
    }
} );

//OR

$('.ck_editor').each(function(){
    CKEDITOR.replace($(this).attr('id'));
});


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

toolbar_Basic : [
    [ 'Source', '-', 'Bold', 'Italic' ]
],
toolbar : 'Basic',

skin :'office2013',//kama,office2013,moonocolor,moono-lisa (default)
toolbarCanCollapse : true,
height : 180,
removeButtons : 'Underline,JustifyCenter',
removePlugins : 'elementspath,save,font',
uiColor :'#F7F7F7'
toolbar : [
    { name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },
    { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
    '/',
    { name: 'basicstyles', items: [ 'Bold', 'Italic' ] }
],
config.contentsCss : [ '/css/mysitestyles.css', '/css/anotherfile.css' ],
toolbarLocation: 'bottom',
extraPlugins: 'sharedspace',
sharedSpaces: {
    top: 'top',
    bottom: 'bottom'
}
customConfig: '/myconfig.js',
startupFocus : 'start',
removeDialogTabs:'image:advance; link:advance',
format_tags: 'p;h1;h2;h3;pre',
extraPlugins : 'uploadimage,uploadwidget,clipboard,dialog,notification,toolbar,widget,filetools,notificationaggregator,lineutils,widgetselection',

//ckfinder integration
filebrowserBrowseUrl: '<?php echo base_url(); ?>assets/ckeditor/ckfinder/ckfinder.html',
filebrowserImageBrowseUrl: '<?php echo base_url(); ?>assets/ckeditor/ckfinder/ckfinder.html?type=Images',
filebrowserFlashBrowseUrl: '<?php echo base_url(); ?>assets/ckeditor/ckfinder/ckfinder.html?type=Flash',
filebrowserUploadUrl: '<?php echo base_url(); ?>assets/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
filebrowserImageUploadUrl: '<?php echo base_url(); ?>assets/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
filebrowserFlashUploadUrl: '<?php echo base_url(); ?>assets/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',

//kcfinder integration
filebrowserBrowseUrl : '<?php echo base_url(); ?>assets/ckeditor/kcfinder/browse.php?opener=ckeditor&type=files',
filebrowserImageBrowseUrl : '<?php echo base_url(); ?>assets/ckeditor/kcfinder/browse.php?opener=ckeditor&type=images',
filebrowserFlashBrowseUrl : '<?php echo base_url(); ?>assets/ckeditor/kcfinder/browse.php?opener=ckeditor&type=flash',
filebrowserUploadUrl : '<?php echo base_url(); ?>assets/ckeditor/kcfinder/upload.php?opener=ckeditor&type=files',
filebrowserImageUploadUrl : '<?php echo base_url(); ?>assets/ckeditor/kcfinder/upload.php?opener=ckeditor&type=images',
filebrowserFlashUploadUrl : '<?php echo base_url(); ?>assets/ckeditor/kcfinder/upload.php?opener=ckeditor&type=flash',







