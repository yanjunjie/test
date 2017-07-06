//Image upload v.01
$(document).ready(function (e) {
    $('#imageUploadForm').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                console.log("success");
                console.log(data);
            },
            error: function(data){
                console.log("error");
                console.log(data);
            }
        });
    }));

    $("#ImageBrowse").on("change", function() {
        $("#imageUploadForm").submit();
    });
});

//Image upload v.02
var form = $('form')[0]; // You need to use standard javascript object here
var formData = new FormData(form);
or specify exact data for FormData()

var formData = new FormData();
formData.append('section', 'general');
formData.append('action', 'previewImg');
// Attach file
formData.append('image', $('input[type=file]')[0].files[0]); 
Sending form

Ajax request with jquery will looks like this:

$.ajax({
    url: 'Your url here',
    data: formData,
    type: 'POST',
    contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
    processData: false, // NEEDED, DON'T OMIT THIS
    // ... Other options like success and etc
});
After this it will send ajax request like you submit regular form with enctype="multipart/form-data"

//Image upload v.03
<form id="upload_form" enctype="multipart/form-data">
jQuery with CodeIgniter file upload:

var formData = new FormData($('#upload_form')[0]);

formData.append('tax_file', $('input[type=file]')[0].files[0]);

$.ajax({
    type: "POST",
    url: base_url + "member/upload/",
    data: formData,
    //use contentType, processData for sure.
    contentType: false,
    processData: false,
    beforeSend: function() {
        $('.modal .ajax_data').prepend('<img src="' +
            base_url +
            '"asset/images/ajax-loader.gif" />');
        //$(".modal .ajax_data").html("<pre>Hold on...</pre>");
        $(".modal").modal("show");
    },
    success: function(msg) {
        $(".modal .ajax_data").html("<pre>" + msg +
            "</pre>");
        $('#close').hide();
    },
    error: function() {
        $(".modal .ajax_data").html(
            "<pre>Sorry! Couldn't process your request.</pre>"
        ); // 
        $('#done').hide();
    }
});

you can use.

var form = $('form')[0]; 
var formData = new FormData(form);     
formData.append('tax_file', $('input[type=file]')[0].files[0]);
or

var formData = new FormData($('#upload_form')[0]);
formData.append('tax_file', $('input[type=file]')[0].files[0]); 