/*
*Prototypes
*/
let host = window.location.protocol + "//" + window.location.host + "/"; //http://localhost/
//Config your project's base_url
let baseUrl = host+""; //i.e, host+'test_crud/'
let refreshArea = ''; //i.e, 'cia_refresh_area'
//cia is Codeigniter Ajax and it is a prefix
//-------------------------------------------------------------------------------------------

//Existence checking, exists or not a value in a table ++++++++++++++++++++++++++++++++++++++++++++++++++++

    $(document).on('keyup change', "cia_is_existence", function () {
        let id = $(this).val();
        let label =$(this).parent().parent().find('label').text();
        label =label.replace("*", "");
        //Add the following data attributes
        let url = ($(this).attr('data-url'))?($(this).attr('data-url')):(baseUrl+"ci_ajax_lib/is_existence"); //1. data-url, or 2. Custom url
        let attr = ($(this).attr('data-attr'))?($(this).attr('data-attr')):(($(this).attr('name'))?($(this).attr('name')):''); //1. table's attr by data-attr, or 2. Field Name
        let table = $(this).attr('data-table');

        $.ajax({
            type: "POST",
            url: url, //check_existence
            data: {table:table, attr:attr, id:id },
            success: function (data) {
                if($.trim(data)=='yes')
                {
                    $('#custom_reg_no_exists').html(label+" already exists");
                    $('#admission_form_btn').attr('disabled','disabled');
                }
                else
                {
                    $('#custom_reg_no_exists').html('');
                    $('#admission_form_btn').removeAttr('disabled','disabled');
                }
            }
        });
    });

//Ajax Form Submission/Creation +++++++++++++++++++++++++++++++++++++++++++++++++++++++
$(document).on("click", ".cia_insert", function (e) {
    e.preventDefault();
    e.stopPropagation();
    //Submit Button
    let thisBtn = $(this);
    //Form
    let thisForm = thisBtn.closest("form");
    //Form Data
    let formData = new FormData(thisForm[0]);
    //Form Action
    let dataAction = thisBtn.attr("data-action");
    let formAction = thisForm.attr('action');
    //First check 'form action' otherwise check 'data action'
    let action = formAction?formAction:(dataAction?dataAction:'');
    //After Inserting, Updating, and Deleting Data, Refresh the Data View Area
    refreshArea = refreshArea?refreshArea:thisBtn.parent().closest("#cia_refresh_area").attr('id'); //1. Set refresh area id, or 2. Use closest id

    $.ajax({
        type: "POST",
        url: action,
        data: formData,
        processData: false,
        contentType: false,
        success:function(data){
            if($.trim(data)=='yes')
            {
                alert('Success! Data inserted successfully');
                $("#"+refreshArea).load(location.href + " #"+refreshArea);
            }
            else if($.trim(data)=='no')
            {
                alert('Error! Data not inserted successfully')
            }
            else
            {
                alert('Error! Try again');
            }
        }
    });
});

//Ajax Delete by ID ++++++++++++++++++++++++++++++++++++++++++++++++++++
    window.onload = function() {
        $(document).on('click','.cia_delete_by_id',function(e){
            e.preventDefault();
            e.stopPropagation();
            let thisBtn = $(this);
            //Add the following data attributes
            let id = $(this).attr('data-id');
            let url = ($(this).attr('data-url'))?($(this).attr('data-url')):(baseUrl+"ci_ajax_lib/cia_delete_by_id"); //1. data-url, or 2. custom url
            let attr = ($(this).attr('data-attr'))?($(this).attr('data-attr')):(($(this).attr('name'))?($(this).attr('name')):''); //1. table's attr by data-attr, or 2. Field Name
            let table = $(this).attr('data-table');
            //After Inserting, Updating, and Deleting Data, Refresh the Data View Area
            refreshArea = refreshArea?refreshArea:thisBtn.parent().closest("#cia_refresh_area").attr('id'); //1. Set refresh area id, or 2. Use closest id

            if (confirm('Are you sure to delete?')) {
                $.ajax({
                    type:'post',
                    url:url,
                    data:{table:table,attr:attr,id:id},
                    success:function(data){
                        if ($.trim(data)=='yes') {
                            alert("Deleted successfully");
                            $("#"+refreshArea).load(location.href + " #"+refreshArea);
                        }
                    },
                    error:function(){
                        alert('Error deleting');
                    }
                });
            }
        });
	//End Delete
    }
    //End Window Load

//Ajax Find View by ID //One to Many relationship ++++++++++++++++++++++++++++++++++++++++++++++
    $(document).on("change", "#FACULTY_ID", function () {
        let FACULTY_ID = $(this).val();
        $.ajax({

            type: "POST",
            url: "<?=base_url();?>lab_schedule/ajax_find_view_by_id",
            data:  {table:'INS_PROGRAM',attr:'FACULTY_ID', attr_val:FACULTY_ID, url_data:'', view:'admin/lab_schedule/program_dependency'},
            success:function(data){
                if(data != "no"){
                    $('#PROGRAM_ID_DEPEN').html(data);
                }
                else
                {
                    console.log('No data found');
                }
            }
        });
    });


//Ajax Find View by Detail Table ID //Many to One relationship
   
    $(document).on("change", "#PROGRAM_ID", function () {
        let PROGRAM_ID = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>lab_schedule/ajax_find_view_by_detail_id",
            data:  {master_table:'INS_DEGREE', detail_table:'INS_PROGRAM', attr_master:'DEGREE_ID',  attr_detail:'DEGREE_ID', attr_detail_val:PROGRAM_ID, view:'admin/lab_schedule/degree_dependency'},
            success:function(data){
                if(data != "no" && data != "err")
                {
                    $('#DEGREE_ID_DEPEN').html(data);
                }
                else if(data == "err")
                {
                    $('#DEGREE_ID_DEPEN').html('<b class="text-danger text-center ">No data found!</b>');
                }
                else
                {
                    console.log('No data found');
                }
            }
        });
    });


//Ajax Find View by Master Table ID  //One to Many and Many to One

    $(document).on("change", "#PROGRAM_ID", function () {
        let PROGRAM_ID = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>lab_schedule/ajax_find_view_by_map",
            data:  {master_table1:'INS_PROGRAM', attr_master1_val:PROGRAM_ID, master_table2:'ACA_BATCH', attr_master2:'BATCH_ID', detail_table:'ACA_BATCH_PROG', attr_detail:'PROGRAM_ID', view:'admin/lab_schedule/batch_dependency'},
            success:function(data){
                if(data != "no" && data != "err")
                {
                    $('#BATCH_ID_DEPEN').html(data);
                }
                else if(data == "err")
                {
                    $('#BATCH_ID_DEPEN').html('<b class="text-danger text-center ">No data found!</b>');
                }
                else
                {
                    console.log('No data found');
                }
            }
        });
    });









