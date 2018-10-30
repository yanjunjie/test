/*
*Prototypes
*/
let host = window.location.protocol + "//" + window.location.host + "/"; //http://localhost/
//Config your project's base_url
let baseUrl = host+""; //i.e, host+'test_crud/'
let refreshArea = ''; //i.e, 'cia_refresh_area'
//cia is Codeigniter Ajax and it is a prefix
//-------------------------------------------------------------------------------------------

//Validate any Field has duplicate value
$(document).on('keyup change', ".cia_attr_exists", function () {
    /*
        ### Server side duplicate checking is made by Bablu Ahmed
        ### For debugging, check erro message in browser console
        *** Dynamic Settings:
            * 1. data-table (table name), 2. data-attr (table's attr name), 3. data-action
            * Keep an hidden input field beside this for settings i.e, <input class="cia_settings" type="hidden" data-table="NM_APPLICATION" data-attr="REGISTRATION_NUMBER" data-action="<---?php echo base_url('admission/cia_attr_exists')?>">
            * Add a class called 'cia_submit_btn' to submit button
        *** Default Settings:
     */
    let tableD = "";
    let attrD = "";
    let actionD = "<?php echo base_url('admission/cia_attr_existsasdf')?>";  //baseUrl+"ci_ajax_lib/is_existence"
    //End Default Settings

    let id = $(this).val();
    let cia_settings = $(this).siblings('.cia_settings');
    let label =$(this).closest('.form-group').find('label').text();
    label =label.replace("*", "");

    let dataAction = cia_settings.attr('data-action');
    //data-url or Manually set url
    let url = dataAction?dataAction:actionD;
    //data-attr or 2. Manually set table's attribute name
    let dataAttr = cia_settings.attr('data-attr');
    let attr = dataAttr?dataAttr:attrD;
    let dataTableName = cia_settings.attr('data-table');
    //data-table or 2. Manually set table name
    let table = dataTableName?dataTableName:tableD;

    let spanElement = $(this).nextAll('span');
    let spanExists = $(this).nextAll('span').length;
    if(!spanExists)
    {
        console.log('Please create an span tag after input element');
    }

    let submitBtn = $(this).closest('form').find('.cia_submit_btn');
    let submitBtnExists = $(this).closest('form').find('.cia_submit_btn').length;
    if(!submitBtnExists)
    {
        console.log('Please add a class to the submit button named "cia_submit_btn"');
    }

    $.ajax({
        type: "POST",
        url: url, //check_existence
        data: {table:table, attr:attr, id:id },
        success: function (data) {
            if($.trim(data)=='yes')
            {
                $(spanElement).html(label+" already exists");
                $(submitBtn).attr('disabled','disabled');
                $(submitBtn).off('click');
            }
            else
            {
                $(spanElement).html('');
                $(submitBtn).removeAttr('disabled','disabled');
                $(submitBtn).on('click');
            }
        }
    });
});

//Ajax Form Submission/Insertion +++++++++++++++++++++++++++++++++++++++++++++++++++++++
$(document).on("click", ".cia_insert", function (e) {
    e.preventDefault();
    e.stopPropagation();
    //Submit Button
    let thisBtn = $(this);
    //Form
    let thisForm = thisBtn.closest("form");
    /*
        ### This Ajax Form Submission is made by Bablu Ahmed
        ### For debugging, check erro message in browser console
        *** Dynamic Settings:
        * 1. Action, 2. Form Data, 3. Refresh Area (After Inserting refresh a part of the page)
        * Keep an hidden input field beside this for settings i.e, <input type="hidden" class="cia_settings" data-action="" data-refresh-id="cia_refresh_area">
        * Add a class called 'cia_submit_btn' to submit button
        *** Default Settings:
     */

    let actionD = "<?php echo base_url('admission/cia_attr_existsasdf')?>";  //baseUrl+"ci_ajax_lib/is_existence"
    //End Default Settings

    let cia_settings = thisForm.find(".cia_settings");
    //Form Action
    let dataAction = cia_settings.attr("data-action");
    let formAction = thisForm.attr('action');
    //First check 'data action' otherwise check 'form action'
    //let action = dataAction?dataAction:(formAction?formAction:'');
    //data-url or Manually set url
    let url = dataAction?dataAction:(formAction?formAction:actionD);
    if(!url)
    {
        console.log("Please set the data-action or form-action or default action");
    }

    //Form Data
    let formData = new FormData(thisForm[0]);
    if(!formData)
    {
        console.log("No Form Data Found!");
    }

    //Refresh Area
    let dataRefreshId= cia_settings.attr("data-refresh-id");
    refreshArea = dataRefreshId?dataRefreshId:(refreshArea?refreshArea:'');
    if(!refreshArea)
    {
        console.log("Please set the data-refresh-id");
    }

    $.ajax({
        type: "POST",
        url: url,
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









