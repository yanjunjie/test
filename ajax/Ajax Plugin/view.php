//Ajax Modal By ID
$(".student_details").on("click", function () {
var id = $(this).attr('data-user-id');

$.ajax({
    type: 'post',
    url: '<?php echo site_url()?>/student/ajaxModalById',
    data: {id: id, table:'', ajax_view:'student/details_modal_view'},
    success: function (data) {
        $("#applicant_modal .modal-body").html(data);
    }
});
});
