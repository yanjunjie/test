//Commi, session, course wise datatable
$(document).on("click", "#commSessCourseSubmit", function(event){
    event.preventDefault();
    event.stopPropagation();

    //var data = $("#sesCourseComForm").serializeArray();

    var DEGREE_ID = $('#DEGREE_ID').val();
    if(!DEGREE_ID){
        alert("Please slect Course");
        return false;
    }
    var SESSION_ID = $('#SESSION_ID').val();

    if(!SESSION_ID){
        alert("Please slect Session");
        return false;
    }
    var COMMITTEE_ID = $('#COMMITTEE_ID').val();

    if(!COMMITTEE_ID){
        alert("Please slect Committee");
        return false;
    }

    var urlData = {DEGREE_ID:DEGREE_ID, SESSION_ID:SESSION_ID, COMMITTEE_ID:COMMITTEE_ID};

    //Meritlist button enable
    committeeMemberCheck(urlData);

    //Ajax for course and session wise merit list
    ajaxCourseAndSesWiseMeritlist(urlData);

    //Destroy the old datatable
    $('.dataTables').dataTable().fnDestroy();

    //Datatable
    $('.dataTables').DataTable({
        //Options
        //"processing": true,  // Show processing
        "serverSide": true,  // Server side processing
        "pageLength": 5,    // 5 rows per page
        "bDestroy": true,   //For reinitialize
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]], //Select Box

        //Load data for the table's content
        ajax:{
            url :  '<?= site_url("admission/dataTables"); ?>',
            type : "POST",
            data: urlData,

        },

        "initComplete":function( settings, json){
            console.log(settings);

        },

        //Style
        aoColumnDefs: [
            { "sWidth": "20%", "aTargets": 0 }, //<- start from zero
            { "sWidth": "10%", "aTargets": 1 },
            { "sWidth": "10%", "aTargets": 2 },
            { "sWidth": "10%", "aTargets": 3 },
            { "sWidth": "10%", "aTargets": 4 }
        ],

        order: [[ 2, "desc" ]],

        //Set column definition initialisation properties.
        columns: [
            null,
            null,
            null,
            { "searchable": false, "orderable": false },
            { "searchable": false, "orderable": false }
        ]

    });
    //End datatable


});
//End Commi, session, course wise datatable

