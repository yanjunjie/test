//------------------------------------------Prototypes-------------------------------------

/*
* ***Host Name:
    For Example: //http://localhost/
*/
let host = window.location.protocol + "//" + window.location.host + "/"; 

/*
* ***Setting Base Url:
    For Example: host+'test_crud/'
*/
let baseUrl = host+"";

//After the Insert, Update, Delete and Read operation refresh a certain area of the page
let reloadArea = '';
//After the Insert, Update, Delete and Read operation refresh the whole page
let windowReload = '';

/*
* ***Data Attributes:
*/
let dataTable='';
let dataAttr='';
let dataId='';
let dataAction='';
let dataReload='';
let dataRedirect='';

/*
* ***Ajax Params:
*/
let table = "";
let attr = "";
let id = "";
let url = '';
let windowReload = '';
let windowRedirect = '';
let formData = {};

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
* cia_reload_area
*/

/*
* ***Data Attributes:
* data-table
* data-attr
* data-action
* data-reload-id
* data-reload
* data-redirect
*/

//------------------------------------/Prototypes----------------------------------------

//Validate any Field has duplicate value +++++++++++++++++++++++++++++++++++++++++++++++++++++++
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
    let actionD = "";
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
    /*
        ### This Ajax Form Submission is made by Bablu Ahmed
        ### For debugging, check erro message in browser console
        *** Dynamic Settings:
            1. i.Form Action, ii. Refresh Area OR iii. Window Reload (If set '1' or 'true' the #ii will not work)
                i.e,
                <button type="submit" class="btn btn-primary btn-sm cia_insert"
                    data-action="<--?php echo base_url('student/assignments')?>"
                    data-reload-id="cia_reload_area"
                    data-reload="1">
                    Submit
                </button>
            2. Add a class called 'cia_insert' to submit button
            3. Remove 'action' attribute from form
        *** Default Settings:
    */

    let actionD = ""; 
    let windowReloadD = ""; 
    //End Default Settings

    e.preventDefault();
    e.stopPropagation();

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
    reloadArea = thisBtn.attr("data-reload-id");  //i.e, cia_reload_area
    if(!reloadArea)
    {
        console.log("Please set the 'data-reload-id'");
    }

    //After Inserting, Updating, and Deleting Data, Refresh the Data View Area
    let reloadAreaExists = $('#cia_reload_area').length;
    if(!reloadAreaExists)
    {
        console.log("Please set 'cia_reload_area' id on the Data View Area");
    }


    //Window Reload
    windowReload = thisBtn.attr("data-reload"); //Boolean Value, i.e, 0 or 1
    if(windowReload)
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
                alert('Success! Record inserted successfully');
                if(!windowReload)
                    $("#"+reloadArea).load(location.href + " #"+reloadArea);
                else
                    location.reload();
            }
            else if($.trim(data)=='no')
            {
                alert('Error! Record not inserted successfully')
            }
            else
            {
                alert('Error! Required field is missing. Please try again');
            }
        }
    });
});

//Ajax Delete by ID ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    window.onload = function() {
        $(document).on('click','.cia_delete',function(e){
            /*
                ### Ajax deletion is made by Bablu Ahmed
                ### For debugging, check erro message in browser console
                *** Dynamic Settings:
                    1. i.Form Action, ii. Refresh Area OR iii. Window Reload (If set #ii will not work)
                        i.e,
                        <button type="submit" class="btn btn-danger btn-xs cia_delete" title="Click For Delete" style="margin: 0; font-size: 11px; padding: 1px 3px; color: #fff; font-weight: 600; line-height: 1.3;"
                                data-id="<?php echo $row->CM_ID; ?>"
                                data-table="UMS_COURSE_MATERIALS"
                                data-attr="CM_ID"
                                data-action="<--?php echo base_url('assignment/ajax_delete')?>"
                                data-reload-id="cia_reload_area"
                                data-reload="">
                            Delete
                        </button>
                    2. Remove 'action' attribute from form
                *** Default Settings:
            */
            let IdD = '';
            let tableD = '';
            let attrD = '';
            let actionD = '';  
            //End Default Settings

            e.preventDefault();
            e.stopPropagation();
            let thisBtn = $(this);

            //Data attributes:            
            let dataId = $(this).attr('data-id');
            let dataTable = $(this).attr('data-table');
            let dataAttr = $(this).attr('data-attr');
            let dataAction = $(this).attr('data-action');

            //Ajax Params:
            let id = dataId?dataId:IdD;
            let table = dataTable?dataTable:tableD;
            let attr = dataAttr?dataAttr:attrD;
            let url = dataAction?dataAction:actionD;


            //First check 'data-id' otherwise check default id 'IdD'
            id = dataId?dataId:(IdD?IdD:'');
            if(!id)
            {
                console.log("Please set the data-id or default id");
            }

            //Refresh Area
            reloadArea = thisBtn.attr("data-reload-id");  //i.e, cia_reload_area
            if(!reloadArea)
            {
                console.log("Please set the 'data-reload-id'");
            }

            //After Inserting, Updating, and Deleting Data, Refresh the Data View Area
            let reloadAreaExists = $('#cia_reload_area').length;
            if(!reloadAreaExists)
            {
                console.log("Please set 'cia_reload_area' id on the Data View Area");
            }


            if (confirm('Are you sure to delete?')) {
                $.ajax({
                    type:'post',
                    url:url,
                    data:{table:table,attr:attr,id:id},
                    success:function(data){
                        if ($.trim(data)=='yes') {
                            alert("Deleted successfully");
                            $("#"+reloadArea).load(location.href + " #"+reloadArea);
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


//Ajax Form Submission/Update by ID +++++++++++++++++++++++++++++++++++++++++++++++++++++++
    $(document).on("click", ".cia_update", function (e) {
        /*
            ### This Ajax Form Submission is made by Bablu Ahmed
            ### For debugging, check erro message in browser console
            *** Dynamic Settings:
                1. i.Form Action, ii. Refresh Area OR iii. Window Reload (If set '1' or 'true' the #ii will not work)
                    i.e,
                    <button type="submit" class="btn btn-primary btn-sm cia_update"
                            data-id="<?php echo $CM_ID;?>"
                            data-action="<?php echo base_url('assignment/course_materials_edit')?>"
                            data-reload-id="cia_refresh_area"
                            data-reload=""
                            data-redirect="<?php echo base_url('assignment/course_materials')?>">
                        Update
                    </button>
            2. Add a class called 'cia_update' to Update button
            3. Remove 'action' attribute from form
        *** Default Settings:
    */
        let IdD = '';
        let tableD = "";
        let attrD = "";
        let actionD = "";
        let windowReloadD = "";
        let windowRedirectD = "";
        //End Default Settings

        e.preventDefault();
        e.stopPropagation();

        //Data attributes:
        let dataId = $(this).attr('data-id');
        let dataTable = $(this).attr('data-table');
        let dataAttr = $(this).attr('data-attr');
        let dataAction = $(this).attr('data-action');
        let dataReload = $(this).attr('data-reload');
        let dataRedirect = $(this).attr('data-redirect');
        let reloadArea = $(this).attr("data-reload-id");
        
        //Ajax Params:
        let id = dataId?dataId:(IdD?IdD:'');
        let table = dataTable?dataTable:(tableD?tableD:'');
        let attr = dataAttr?dataAttr:(attrD?attrD:'');
        let url = dataAction?dataAction:(actionD?actionD:'');
        let windowReload = dataReload?dataReload:(windowReloadD?windowReloadD:'');
        let windowRedirect = dataRedirect?dataRedirect:(windowRedirectD?windowRedirectD:'');
        
        //Submit Button
        let thisBtn = $(this);
        //Form
        let thisForm = thisBtn.closest("form");
        //Form Data
        let formData = new FormData(thisForm[0]);
        if(!formData)
        {
            console.log("No Form Data Found!");
        }
        //Update by ID
        if(!id)
        {
            console.log("Please set the data-id or default id");
        }
        //Action
        if(!url)
        {
            console.log("Please set the data-action or default action");
        }

        //Find out the cia_reload_area id exists or not
        let reloadAreaExists = $('#cia_reload_area').length;

        //Redirect path
        if(windowRedirect)
        {
            console.log("Window will be redirected");
        }
        //Window Reload
        else if(windowReload)
        {
            console.log("Window will be reloaded");
        }
        //Reload an Area of the page
        else if(reloadAreaExists)
        {
            console.log("The Data View Area has been reloaded");
        }
        //At least set a reload area
        else
            console.log("Please set 'cia_reload_area' id on the Data View Area");

        //Add data-id to the FormData API
        formData.append('id',id)

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success:function(data){
                if($.trim(data)=='yes')
                {
                    alert('Success! Record updated successfully');
                    if(windowRedirect)
                        window.location =windowRedirect; //Redirect path
                    else if(windowReload) //1 or 0
                        location.reload();
                    else
                        $("#"+reloadArea).load(location.href + " #"+reloadArea);
                }
                else if($.trim(data)=='no')
                {
                    alert('Error! Record not updated successfully')
                }
                else
                {
                    alert('Error! Required field is missing. Please try again');
                }
            }
        });
    });

//Ajax Find View by ID //One to Many relationship +++++++++++++++++++++++++++++++++++++++++++++++++++++++
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


//Ajax Find View by Detail Table ID //Many to One relationship +++++++++++++++++++++++++++++++++++++++++++++++++++++++
   
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


//Ajax Find View by Master Table ID  //One to Many and Many to One +++++++++++++++++++++++++++++++++++++++++++++++++++++++

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









