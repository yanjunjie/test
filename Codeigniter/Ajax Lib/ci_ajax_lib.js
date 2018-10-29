/*
*Prototypes
*/
let host = window.location.protocol + "//" + window.location.host + "/"; //http://localhost/
//Config your project's base_url
let baseUrl = host+""; //i.e, host+'test_crud/'
let refreshArea = ''; //i.e, 'cia_refresh_area'
//cia is Codeigniter Ajax and it is a prefix
//-------------------------------------------------------------------------------------------

//Existence checking, exists or not a value in a table +++++++++++++++++++++++++++++++++++++
$(document).on('keyup change', "cia_is_existence", function () {
    let id = $(this).val();
    let label =$(this).closest('.form-group').find('label').text();
    label =label.replace("*", "");
    /*
        *** Dynamic Settings:
            1. data-url, 2. data-attr (table's attr name), 3. data-table (table name)
        *** Default Settings:
     */
    let urlD = "<?php echo base_url('admission/is_existence')?>";  //baseUrl+"ci_ajax_lib/is_existence"
    let attrD = "";
    let tableD = "";
    let submitBtnD = ""; //For id "#submitBtn" and class ".submitBtn"
    //End Default Settings

    let dataUrl = $(this).attr('data-url');
    //data-url or Manually set url
    let url = dataUrl?dataUrl:urlD;
    //data-attr or 2. Manually set table's attribute name
    let dataAttr = $(this).attr('data-attr');
    let attr = dataAttr?dataAttr:attrD;
    let dataTableName = $(this).attr('data-table');
    //data-table or 2. Manually set table name
    let table = dataTableName?dataTableName:tableD;
    
    let msgSpan = $(this).next('span');
    if(!msgSpan)
    {
        console.log('Please create an span tag after input element');
    }
    
    let submitBtn = $(this).closest('form').find('.submitBtn');
    let submitButton=submitBtn?submitBtn:submitBtnD;
    if(!submitButton)
    {
        console.log('Please add a class to the submit button named "submitBtn"');
    }

    $.ajax({
        type: "POST",
        url: url, //check_existence
        data: {table:table, attr:attr, id:id },
        success: function (data) {
            if($.trim(data)=='yes')
            {
                $(msgSpan).html(label+" already exists");
                $(submitButton).attr('disabled','disabled');
            }
            else
            {
                $(msgSpan).html('');
                $(submitButton).removeAttr('disabled','disabled');
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
    /*
        Settings:
        1. Action, 2. Form Data, 3. Refresh Area (After Inserting, Updating, and Deleting Data, Refresh a part of the page)
        For Example:
        <input type="hidden" class="cia_settings" data-action="" data-refresh-id="cia_refresh_area">
     */
    let cia_settings = thisForm.find(".cia_settings");
    //Form Action
    let dataAction = cia_settings.attr("data-action");
    let formAction = thisForm.attr('action');
    //First check 'data action' otherwise check 'form action'
    let action = dataAction?dataAction:(formAction?formAction:'');
    if(!action)
    {
        alert("Please set the data-action or form-action");
        return false;
    }

    //Form Data
    let formData = new FormData(thisForm[0]);
    if(!formData)
    {
        alert("No Form Data Found!");
        return false;
    }

    //Refresh Area
    let dataRefreshId= cia_settings.attr("data-refresh-id");
    refreshArea = dataRefreshId?dataRefreshId:(refreshArea?refreshArea:'');
    if(!refreshArea)
    {
        alert("Please set the data-refresh-id");
        return false;
    }

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









