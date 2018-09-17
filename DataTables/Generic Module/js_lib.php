 <!-- Datatable CSS -->
 <style type="text/css">
   .dataTables_wrapper .dt-buttons {
      float:none;
      position: absolute;  
      text-align:center;
      margin-left: 400px;  

  }

</style>
<!-- Datatable CSS -->
 <link href="<?php echo base_url(); ?>assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">


<div   class="modal   inmodal commonModal"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span
                    class="sr-only">Close</span></button>
                    <h4 class="modal-title"></h4>
                    <small class="font-bold"></small>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-sm btn-outline btn-danger" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal inmodal bigModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated">
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span
                        class="sr-only">Close</span></button>
                        <h4 class="modal-title"></h4>
                        <small class="font-bold"></small>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-white" type="button">Close</button>
                    </div>
                </div>
            </div>
        </div>  
        <div class="modal inmodal commonCourseModal">
            <div class="modal-dialog">
                <div class="modal-content animated">
                    <div class="modal-header">
                        <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span
                            class="sr-only">Close</span></button>
                            <h4 class="modal-title"></h4>
                            <small class="font-bold"></small>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-white" type="button">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal inmodal commonPrerequisiteModal">
                <div class="modal-dialog">
                    <div class="modal-content animated">
                        <div class="modal-header">
                            <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span
                                class="sr-only">Close</span></button>
                                <h4 class="modal-title"></h4>
                                <small class="font-bold"></small>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <button data-dismiss="modal" class="btn btn-white" type="button">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal inmodal commonSuccessModal">
                    <div class="modal-dialog">
                        <div class="modal-content animated">
                            <div class="modal-header">
                                <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span
                                    class="sr-only">Close</span></button>
                                    <h4 class="modal-title"></h4>
                                    <small class="font-bold"></small>
                                </div>
                                <div class="modal-body" style="background-color: #dff0d8;"></div>

                            </div>
                        </div>
                    </div>
                    <div class="modal inmodal commonPreModal">
                        <div class="modal-dialog">
                            <div class="modal-content animated">
                                <div class="modal-header">
                                    <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span
                                        class="sr-only">Close</span></button>
                                        <h4 class="modal-title"></h4>
                                        <small class="font-bold"></small>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <button data-dismiss="modal" class="btn btn-white" type="button">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">

                            $(document).ready(function () {
        // Tooltips demo
        $('.tooltip-demo').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });

/*        $(".gridTable").dataTable({
            No ordering applied by DataTables during initialisation 
           "order": []
       });*/
        // THIS CODE IS WRITTEN FOR SELECT 2 FIREFOX COMPATIBLE  ON BOOT STRAP MODAL
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        // Autocomplete Dropdown Initialization
        $(".select2Dropdown").select2({
            theme: "classic"
        });



        // Autocomplete Dropdown Initialization - AJAX Example
        $(".select2DropdownAjax").each(function () {

            //$(document).on("click",".select2DropdownAjax",function(){
                var action_uri = $(this).attr("data-action");
                $(this).select2({

                    ajax: {
                        url: action_uri,
                        dataType: 'json',
                        data: function (params) {
                            return {
                                term: params.term
                            }
                        },
                        results: function (data) {
                            var courseResults = [];
                            $.each(data, function (index, item) {
                                courseResults.push({
                                    'id': item.id,
                                    'text': item.text
                                });
                            });
                            return {
                                results: courseResults
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 1
                });
            });

    
        $(document).on("click", "#checkAll", function () {
            $('.checkList').prop('checked', this.checked);
        });

        // Date Picker Initialization
/*        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '1950:+0'
        });*/

        // Clock Picker Initialization
        $('.clockpicker').clockpicker();
        
        $('.uppercase').keyup(function() {
            $(this).val($(this).val().toUpperCase());
        });

        //$('.redactor').redactor();
        $(document).on("click", ".openModal", function () {
            $(".commonModal").modal();
            var param_value = "";
            var action_type = $(this).attr("data-type");
            var action_uri = $(this).attr("data-action");
            var title = $(this).attr("title");
            if (action_type == "edit") {
                param_value = $(this).attr("id");
            }
            if (action_type == "delete") {
                param_value = $(this).attr("id");
            }
            $.ajax({
                type: "post",
                url: "<?php echo site_url(); ?>/" + action_uri,
                data: {param: param_value},
                beforeSend: function () {
                    $(".commonModal .modal-title").html(title);
                    $(".commonModal .modal-body").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
                },
                success: function (data) {
                    $(".commonModal .modal-body").html(data);
                    $(".select2Dropdown").select2();
                    $( ".datepicker" ).datepicker();
                }
            });
        });

        $(document).on("click", ".openBigModal", function () {
            $(".bigModal").modal();
            var param_value = "";
            var dept_id = "";
            var action_type = $(this).attr("data-type");
            var action_uri = $(this).attr("data-action");
            var title = $(this).attr("title");
            if (action_type == "edit") {
                param_value = $(this).attr("id");
            }
            if (action_type == "delete") {
                param_value = $(this).attr("id");
            }
            $.ajax({
                type: "post",
                url: "<?php echo site_url(); ?>/" + action_uri,
                data: {param: param_value},
                beforeSend: function () {
                    $(".bigModal .modal-title").html(title);
                    $(".bigModal .modal-body").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
                },
                success: function (data) {
                    $(".bigModal .modal-body").html(data);
                    $( ".datepicker" ).datepicker();
                }
            });
        });

        $(document).on("click", ".formSubmit", function () {
            var isValid = 0;
            $('.required').each(function () {
                $(this).keyup(function () {
                    $(this).css("border", "1px solid #ccc");
                });
                if ($(this).val() == "") {
                    var label = $(this).parent().siblings("label").text();
                    //alert(label + " Is Empty");
                    $(this).siblings(".validation").html(label + " is required");
                    $(this).css("border", "1px solid red");
                    isValid = 1;
                    //return false;
                } else {
                    $(this).siblings(".validation").html("");
                    $(this).css("border", "1px solid #ccc");
                }
            });
            if (isValid == 0) {

                if (confirm("Are You Sure?")) {
                    var frmContent = $(".frmContent").serialize();

                    //console.log(frmContent);

                    var action_uri = $(this).attr("data-action");
                    var type = $(this).attr("data-type");
                    var success_action_uri = $(this).attr("data-su-action");
                    var ac_type = $(this).attr("");
                    var param = "";
                    if (type != "list") {
                        param = $(".rowID").val();
                    }
                    var sn = $("#loader_" + param).siblings("span").text();
                    $.ajax({
                        type: "post",
                        data: frmContent,
                        url: "<?php echo site_url(); ?>/" + action_uri,
                        beforeSend: function () {
                            $(".loadingImg").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
                        },
                        success: function (data) {
                            $(".loadingImg").html("");
                            $(".frmMsg").html(data);
                            $.ajax({
                                type: "post",
                                data: {param: param},
                                url: "<?php echo site_url(); ?>/" + success_action_uri,
                                beforeSend: function () {
                                    if (type != "list") {
                                        $("#loader_" + param).removeClass("hidden").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' style='width:10px;' />").siblings("span").addClass("hidden");
                                    }
                                },
                                success: function (data1) {
                                    //$(".loadingImg").html("");
                                    if (type == "list") {
                                        $(".contentArea").html(data1);
                                        $(".gridTable").dataTable();
                                    } else if (type == "msg") {
                                        $('#rinci').html(response).modal();
                                    } else {
                                        $("#loader_" + param).addClass("hidden").html("").siblings("span").removeClass("hidden");
                                        $("#row_" + param).html(data1);
                                        $("#loader_" + param).siblings("span").html(sn);
                                    }
                                }
                            });
                        }
                    });
                } else {
                    return false;
                }
            } else {
                return false;
            }
        });


        $(document).on("click", ".PreviewSubmit", function () {
            if (confirm("Are You Sure?")) {
                $(".bigModal").modal('hide');
                $(".commonModal").modal('hide');
                $(".commonSuccessModal").modal('show');
                var title = $(this).attr("title");
                var frmContent = $("#course_offer").serialize();
                var action_uri = $(this).attr("data-action");
                var success_action_uri = $(this).attr("data-su-action");
                $.ajax({
                    type: "post",
                    data: frmContent,
                    url: "<?php echo site_url(); ?>/" + action_uri,
                    beforeSend: function () {
                        $(".commonSuccessModal .modal-title").html(title);
                        $(".commonSuccessModal .modal-body").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
                    },
                    success: function (data) {
                        $(".commonSuccessModal .modal-body").html(data);
                    }
                });
            } else {
                return false;
            }
        });
        $(document).on("click", ".deleteItem", function () {
            if (confirm("Are You Sure?")) {
                var item_id = $(this).attr("id");
                var data_field = $(this).attr("data-field");
                var data_tbl = $(this).attr("data-tbl");
                $.ajax({
                    type: "post",
                    url: "<?php echo site_url('setup/deleteItem'); ?>/",
                    data: {item_id: item_id, data_field: data_field, data_tbl: data_tbl},
                    beforeSend: function () {
                        $("#loader_" + item_id).html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
                    },
                    success: function (data) {
                        if (data == "Y") {

                            //$("#post").ajax.reload();
                            $("#row_" + item_id).remove();
                        } else {
                            alert("Row Delete Field");
                        }
                    }
                });
            } else {
                return false;
            }
        });

        $(document).on("click", ".deleteItem2", function () {
            if (confirm("Are You Sure?")) {
                var item_id = $(this).attr("id");
                var data_field = $(this).attr("data-field");
                var data_action = $(this).attr("data-action");
                var data_tbl = $(this).attr("data-tbl");

                //alert(data_action);

                $.ajax({
                    type: "post",
                    url: "<?php echo site_url(); ?>/" + data_action,
                    data: {item_id: item_id, data_field: data_field, data_tbl: data_tbl},
                    beforeSend: function () {
                        $("#loader_" + item_id).html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
                    },
                    success: function (data) {
                        if (data == "Y") {

                            //$("#post").ajax.reload();
                            $("#row_" + item_id).remove();
                        } else {
                            alert("Row Delete Field");
                        }
                    }
                });
            } else {
                return false;
            }
        });

        $(document).on("click", ".deleteItemFinance", function () {
            if (confirm("Are You Sure?")) {
                var item_id = $(this).attr("id");
                var data_field = $(this).attr("data-field");
                var data_tbl = $(this).attr("data-tbl");
                $.ajax({
                    type: "post",
                    url: "<?php echo site_url('finance/deleteItem'); ?>/",
                    data: {item_id: item_id, data_field: data_field, data_tbl: data_tbl},
                    beforeSend: function () {
                        $("#loader_" + item_id).html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
                    },
                    success: function (data) {
                        if (data == "Y") {

                            //$("#post").ajax.reload();
                            $("#row_" + item_id).remove();
                        } else {
                            alert("Row Delete Field");
                        }
                    }
                });
            } else {
                return false;
            }
        });
        $(document).on('click', '.itemStatus', function () {
            if (confirm("Are You Sure?")) {
                var item_id = $(this).attr("id");
                var status = $(this).attr("data-status");
                var data_tbl = $(this).attr("data-tbl");
                var data_field = $(this).attr("data-field");
                var data_fieldId = $(this).attr("data-fieldId");
                var data_su_url = $(this).attr("data-su-url");
                var success_url = "<?php echo site_url() ?>/" + data_su_url;
                var sn = $("#loader_" + item_id).siblings("span").text();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url() ?>/setup/statusItem',
                    data: {
                        item_id: item_id,
                        status: status,
                        data_tbl: data_tbl,
                        data_field: data_field,
                        data_fieldId: data_fieldId
                    },
                    beforeSend: function () {
                        $("#loader_" + item_id).html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
                    },
                    success: function (data) {
                        if (data == "Y") {
                            $.ajax({
                                type: 'POST',
                                url: success_url,
                                data: {param: item_id},
                                beforeSend: function () {
                                    $("#loader_" + item_id).removeClass("hidden").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' style='width:10px;' />").siblings("span").addClass("hidden");
                                },
                                success: function (data1) {
                                    $("#loader_" + item_id).addClass("hidden").html("").siblings("span").removeClass("hidden");
                                    $("#row_" + item_id).html(data1);
                                    $("#loader_" + item_id).siblings("span").html(sn);
                                }
                            });
                        } else {
                            return false;
                        }
                    }
                });
            } else {
                return false;
            }
        });
        $(document).on('click', '.itemStatus2', function () {
            if (confirm("Are You Sure?")) {
                var item_id = $(this).attr("id");
                var status = $(this).attr("data-status");
                var data_tbl = $(this).attr("data-tbl");
                var data_field = $(this).attr("data-field");
                var data_fieldId = $(this).attr("data-fieldId");
                var data_su_url = $(this).attr("data-su-url");
                var data_action = $(this).attr("data-action");
                var success_url = "<?php echo site_url() ?>/" + data_su_url;
                var sn = $("#loader_" + item_id).siblings("span").text();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url() ?>' + "/" + data_action,
                    data: {
                        item_id: item_id,
                        status: status,
                        data_tbl: data_tbl,
                        data_field: data_field,
                        data_fieldId: data_fieldId
                    },
                    beforeSend: function () {
                        $("#loader_" + item_id).html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
                    },
                    success: function (data) {
                        if (data == "Y") {
                            $.ajax({
                                type: 'POST',
                                url: success_url,
                                data: {param: item_id},
                                beforeSend: function () {
                                    $("#loader_" + item_id).removeClass("hidden").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' style='width:10px;' />").siblings("span").addClass("hidden");
                                },
                                success: function (data1) {
                                    $("#loader_" + item_id).addClass("hidden").html("").siblings("span").removeClass("hidden");
                                    $("#row_" + item_id).html(data1);
                                    $("#loader_" + item_id).siblings("span").html(sn);
                                }
                            });
                        } else {
                            return false;
                        }
                    }
                });
            } else {
                return false;
            }
        });
        $(document).on('click', '.itemStatusFinance', function () {
            if (confirm("Are You Sure?")) {
                var item_id = $(this).attr("id");
                var status = $(this).attr("data-status");
                var data_tbl = $(this).attr("data-tbl");
                var data_field = $(this).attr("data-field");
                var data_fieldId = $(this).attr("data-fieldId");
                var data_su_url = $(this).attr("data-su-url");
                var success_url = "<?php echo site_url() ?>/" + data_su_url;
                var sn = $("#loader_" + item_id).siblings("span").text();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url() ?>/finance/statusItem',
                    data: {
                        item_id: item_id,
                        status: status,
                        data_tbl: data_tbl,
                        data_field: data_field,
                        data_fieldId: data_fieldId
                    },
                    beforeSend: function () {
                        $("#loader_" + item_id).html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
                    },
                    success: function (data) {
                        if (data == "Y") {
                            $.ajax({
                                type: 'POST',
                                url: success_url,
                                data: {param: item_id},
                                beforeSend: function () {
                                    $("#loader_" + item_id).removeClass("hidden").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' style='width:10px;' />").siblings("span").addClass("hidden");
                                },
                                success: function (data1) {
                                    $("#loader_" + item_id).addClass("hidden").html("").siblings("span").removeClass("hidden");
                                    $("#row_" + item_id).html(data1);
                                    $("#loader_" + item_id).siblings("span").html(sn);
                                }
                            });
                        } else {
                            return false;
                        }
                    }
                });
            } else {
                return false;
            }
        });
        $('.commonModal').on('hidden.bs.modal', function () {
            $(".frmMsg").html("");
        })

        $('body').on('keyup', '.numbersOnly', function () {
            var val = $(this).val();
            if (isNaN(val)) {
                val = val.replace(/[^0-9\.]/g, '');
                if (val.split('.').length > 2) {
                    val = val.replace(/\.+$/, "");
                }
            }
            $(this).val(val);
        });
        // getting Department by Faculty
        $(document).on('change', '.faculty_dropdown', function () {
            $('.dept_dropdown').html("");
            $('.program_dropdown').html("<option>--Select--</option>");
            $('.course_dropdown').html("");
            var faculty_id = $(this).val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url(); ?>/common/departmentByFaculty',
                data: {faculty_id: faculty_id},
                beforeSend: function () {
                    $(".dept_dropdown").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
                },
                success: function (data) {
                    $('.dept_dropdown').html(data);
                }
            });
        });
        // getting Program By Department
        $(document).on('change', '.dept_dropdown', function () {
            $('.program_dropdown').html("");
            $('.course_dropdown').html("");
            var department_id = $(this).val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url() ?>/common/programByDepartment',
                data: {department_id: department_id},
                beforeSend: function () {

                    $(".program_dropdown").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
                },
                success: function (data) {
                    $('.program_dropdown').html(data);
                }
            });
        });
        // getting Course By Program
        $(document).on('change', '.program_dropdown', function () {
            $('.course_dropdown').html("");
            var FACULTY_ID = $("#FACULTY_ID").val();
            var DEPT_ID = $("#DEPT_ID").val();
            var PROGRAM_ID = $(this).val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url() ?>/common/getOfferedCoursesByProgram',
                data: {FACULTY_ID: FACULTY_ID, DEPT_ID: DEPT_ID, PROGRAM_ID: PROGRAM_ID},
                beforeSend: function () {
                    $(".course_dropdown").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
                },
                success: function (data) {
                    $('.course_dropdown').html(data);
                }
            });
        });
    });

 $('body').on('click', function (e) {
        //did not click a popover toggle or popover
        if ($(e.target).data('toggle') !== 'popover'
            && $(e.target).parents('.popover.in').length === 0) {
            $('[data-toggle="popover"]').popover('hide');
    }
});
 $(document).on("click", ".openPrerequisiteModal", function () {
    $(".commonPrerequisiteModal").modal();
    var action_uri = $(this).attr("data-action");
    var title = $(this).attr("title");
    var faculty = $(this).attr("faculty");
    var dept = $(this).attr("dept");
    var program = $(this).attr("program");
    var course = $(this).attr("course");
    $.ajax({
        type: "post",
        url: "<?php echo site_url(); ?>/" + action_uri,
        data: {faculty: faculty, dept: dept, program: program, course: course},
        beforeSend: function () {
            $(".commonPrerequisiteModal .modal-title").html(title);
            $(".commonPrerequisiteModal .modal-body").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
        },
        success: function (data) {
            $(".commonPrerequisiteModal .modal-body").html(data);
        }
    });
})

 $(document).on("click", ".openCourseDetailsModal", function () {
    $(".commonCourseModal").modal();
    var action_uri = $(this).attr("data-action");
    var title = $(this).attr("title");
    var faculty = $(this).attr("faculty");
    var dept = $(this).attr("dept");
    var program = $(this).attr("program");
    var course = $(this).attr("course");
    $.ajax({
        type: "post",
        url: "<?php echo site_url(); ?>/" + action_uri,
        data: {faculty: faculty, dept: dept, program: program, course: course},
        beforeSend: function () {
            $(".commonCourseModal .modal-title").html(title);
            $(".commonCourseModal .modal-body").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
        },
        success: function (data) {
            $(".commonCourseModal .modal-body").html(data);
        }
    });
});
//########## Datatable print ####################################################################
<?php
$organization_info=$this->utilities->findByAttribute('SA_ORGANIZATIONS', array('STATUS' => 1));
      $ABBR=$organization_info->ABBR;
      $WEBSITE=$organization_info->WEBSITE;
     $ORG_NAME=$organization_info->ORG_NAME;
     $EMAIL=$organization_info->EMAIL;
     $PHONE=$organization_info->PHONE;
     $org_log= base_url('upload/organization/logo/'.$organization_info->LOGO); 
?>
var logo= "<?php    echo  $org_log;  ?>"
var date= new Date().toLocaleString();
var table_title=$(".gridTable").attr("table-title");
var table_msg=$(".gridTable").attr("table-msg");
if(table_title =''){
    table_title='';
}
if(table_msg =''){
    table_msg='';
}
        //alert(table_title);
        $('.gridTable').DataTable( {

            dom: 'Blfrtip',                
            buttons: [
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> Print',
                title: table_title,
                messageTop: table_msg,
                className: 'btn btn-xs btn-outline btn-success',
                exportOptions: {
                    columns: ':visible', 

                }, 
                customize: function ( win ) {
                   $(win.document.body)
                   .css( 'font-size', '10pt' )
                   .prepend(
                    '<div><img src="'+ logo  +'" style="position:relative; display:inline-block; top:0; left:0;width:60px; vertical-align:middle;" /><h1 style="display:inline-block;vertical-align:middle; margin-left:20px; "><?php echo $ORG_NAME; ?></h1><span style="float:right">'+ date +'</span><hr style="border-color:orange;"></div>'
                    );



               },
               footer: true,
               autoPrint: true,

           },                                
           {
            extend: 'pdf',
            text: '<i class="fa fa-file-pdf-o"></i> PDF',
            className: 'btn btn-xs btn-outline btn-danger',
            title: $('h1').text(),
            exportOptions: {
                columns: ':visible', 
            } ,
            footer: true
        }, 
        {
            extend: 'colvis',
            text: '<i class="fa fa-eye"></i> Visible',
            title: $('h1').text(),
            className: 'btn btn-xs btn-outline btn-primary',
            exportOptions: {
                columns: ':visible',  
            },
            footer: true,
            autoPrint: true,
        },
        ], 
    });
//########## Datatable print ####################################################################


//############################ sweet alart and save ######################
$(document).on("click", ".form_submit", function () {
    var this_btn = $(this);
    var this_form= $(this).closest("form").attr('id');
    if($("#"+this_form).valid() == true) {
            //return false;
            swal({
                title: "Are you sure?",
                text: "Want to update your information?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#F8AC59",
                confirmButtonText: "Yes, update it!",
                closeOnConfirm: true
            }, function () {

                var formData = new FormData($('#'+this_form)[0]);
                var action_uri = this_btn.attr("data-action");               
                var success_action_uri = this_btn.attr("data-su-action");
                var action_param = this_btn.attr("data-param");                
                var data_view_div = this_btn.attr("data-view-div");
                
                $.ajax({
                    type: "post",
                    data: formData,
                    url: "<?php echo site_url(); ?>/" + action_uri + '/' + action_param,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $(".loadingImg").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
                    },

                    success: function (data) {
                        $(".loadingImg").html("");
                        $(".frmMsg").html(data);
//                        $(".frmMsg").html('<?php //echo $this->session->flashdata('msg'); ?>//').show();
                        /*//show form data
                        for (var [key, value] of formData.entries()) { 
                            console.log(key, value);
                        }  */ 
                        $.ajax({
                            type: "post",
                            data: formData,
                            url: "<?php echo site_url(); ?>/" + success_action_uri + '/' + action_param,
                            processData: false,
                            contentType: false,
                            beforeSend: function () {
                                $(".loadingImg").html("");
//                                $(".loadingImg").html("<img src='<?php //echo base_url(); ?>//assets/img/loader.gif' />");
},
success: function (data) {
    $('#'+data_view_div).html(data);
    setTimeout(function () {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000
        };

        toastr.warning('Successfully Inserted', 'Done');
    }); 
}
});
                    }
                });

            });
        }
    });


//############################ end sweet alart and save ######################

//percentage calcultaion 

function percentCalculation(obtain_marks, percentage){
  var percentage_marks = (parseFloat(obtain_marks)*parseFloat(percentage))/100;
  return parseFloat(percentage_marks);
}


</script>

 <script src="<?php echo base_url(); ?>assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
 <script>
     $( function() {
         $( ".datepicker" ).datepicker({
             changeMonth: true,
             changeYear: true,
             dateFormat: 'dd-mm-yy' ,
             yearRange: "-50:+0",
             autoclose:true,
              
         });
     } );

     $(document).on('click', '#status', function () {
         var status = ($(this).is(':checked') ) ? 1 : 0;
         $("#status").val(status);
     });
 </script>

