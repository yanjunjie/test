//***Prototypes-------------------------------------------------------------------------------
//Host Name
let host = window.location.protocol + "//" + window.location.host + "/"; //http://localhost/
/*
* Project's Base Url
    i.e, host+'test_crud/'
*/
let baseUrl = host+"";
//After the Insert, Update, Delete and Read operation refresh a certain area of the page
let refreshArea = '';
//After the Insert, Update, Delete and Read operation refresh the whole page
let windowReload = '';

/*
* ***Classes:
* cia_insert
* cia_update
* cia_delete
* cia_read
* cia_attr_exists
* cia_submit_btn
*/

/*
* ***IDs:
* cia_refresh_area
*/

/*
* ***Data Attributes:
* data-table
* data-attr
* data-action
* data-refresh-id
* data-window-reload
*/

//-------------------------------------------------------------------------------------------

//Validate any Field has duplicate value
$(document).on('keyup change', ".cia_attr_exists", function () {
    /*
        ### Server side duplicate checking is made by Bablu Ahmed
        ### For debugging, check erro message in browser console
        *** Dynamic Settings:
            1. i) data-table (table name), ii) data-attr (table's attr name), iii) data-action
                i.e,
                <input type="text"
                data-table="NM_APPLICATION"
                data-attr="REGISTRATION_NUMBER"
                data-action="<?php echo base_url('admission')?>"/>

            2. Add a class 'cia_submit_btn' to submit button
            3. Add a span element with red text color after input element
        *** Default Settings:
     */
    let tableD = "";
    let attrD = "";
    let actionD = "";  //baseUrl+"ci_ajax_lib/is_existence"
    //End Default Settings


    //Input Value
    let id = $(this).val();
    //let cia_settings = $(this).siblings('.cia_settings');

    //Label Text
    let label =$(this).closest('.form-group').find('label').text();
    label =label.replace(/[:*]/g,"");

    //Table Name
    let dataTableName = $(this).attr('data-table');
    //data-table or Default table
    let table = dataTableName?dataTableName:tableD;

    //Table's Attribute
    let dataAttr = $(this).attr('data-attr');
    //data-attr or default attribute
    let attr = dataAttr?dataAttr:attrD;

    //Action
    let dataAction = $(this).attr('data-action');
    //data-action or default action
    let url = dataAction?dataAction:actionD;

    //Span Element Select
    let spanElement = $(this).nextAll('span');
    //Span Element Exists or Not
    let spanExists = $(this).nextAll('span').length;
    if(!spanExists)
    {
        console.log('Please create an span tag after input element');
    }

    //Submit Button
    let submitBtn = $(this).closest('form').find('.cia_submit_btn');
    //Submit Button Exists or Not
    let submitBtnExists = $(this).closest('form').find('.cia_submit_btn').length;
    if(!submitBtnExists)
    {
        console.log('Please add a class "cia_submit_btn" to the submit button');
    }

    $.ajax({
        type: "POST",
        url: url,
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

    /*
        ### This Ajax Form Submission is made by Bablu Ahmed
        ### For debugging, check erro message in browser console
        *** Dynamic Settings:
            1. i.Form Action, ii. Refresh Area OR iii. Window Reload (If set #ii will not work)
                i.e,
                <button type="submit" class="btn btn-primary btn-sm cia_insert"
                    data-action="<?php echo base_url('student/assignments')?>"
                    data-refresh-id="cia_refresh_area"
                    data-window-reload="1">
                    Submit
                </button>
            2. Add a class called 'cia_submit_btn' to submit button
            3. Remove 'action' attribute from form
        *** Default Settings:
     */
    let actionD = "";  //baseUrl+"ci_ajax_lib/is_existence"
    //End Default Settings

    //Submit Button
    let thisBtn = $(this);
    //Form
    let thisForm = thisBtn.closest("form");
    //Form Action
    let dataAction = thisBtn.attr("data-action");
    //let formAction = thisForm.attr('action');

    //First check 'data-action' otherwise check default action 'actionD'
    let url = dataAction?dataAction:(actionD?actionD:'');
    if(!url)
    {
        console.log("Please set the data-action or default action");
    }

    //Form Data
    let formData = new FormData(thisForm[0]);
    if(!formData)
    {
        console.log("No Form Data Found!");
    }

    //Refresh Area
    refreshArea = thisBtn.attr("data-refresh-id");  //i.e, cia_refresh_area
    if(!refreshArea)
    {
        console.log("Please set the data-refresh-id");
    }

    //Window Reload
    refreshArea = thisBtn.attr("data-window-reload"); //Boolean Value, i.e, 0 or 1
    if(refreshArea)
    {
        console.log("Window will be reloaded");
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
                if(!windowReload)
                    $("#"+refreshArea).load(location.href + " #"+refreshArea);
                else
                    location.reload();
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
        $(document).on('click','.cia_delete',function(e){
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









