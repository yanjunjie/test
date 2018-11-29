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
*-------------Classes-------------
***CRUD:
* cia_insert
* cia_update
* cia_delete
* cia_read
* cia_attr_exists
* cia_submit_btn
***Form Validation:
* cia_required
* cia_required_file
* cia_required_number
* cia_required_min
* cia_required_max
* cia_required_email
*-------------/Classes-------------
*/

/*
* --------Data Attributes---------
***CRUD Related:
* data-table, Set table name
* data-attr, Set table attribute name
* data-action, Set an action
* data-reload-id, Set an area id
* data-reload, Set 0 or 1
* data-redirect, i.e: "admin/index"
* data-trigger-click, Set an id in a button where will be clicked. i.e: id='submit_btn'
***Form Validation:
* data-file-type, i.e: jpg,jpeg,doc,docx,pdf etc.
* --------/Data Attributes---------
*/

//------------------------------------/Prototypes----------------------------------------

// This function is used to get error message for all ajax calls
function getJqXhrError(jqXHR, exception) {
    var msg = '';
    if (jqXHR.status === 0) {
        msg = 'Not connect.\n Verify Network.';
    } else if (jqXHR.status == 404) {
        msg = 'Requested page not found. [404]';
    } else if (jqXHR.status == 500) {
        msg = 'Internal Server Error [500].';
    } else if (exception === 'parsererror') {
        msg = 'Requested JSON parse failed.';
    } else if (exception === 'timeout') {
        msg = 'Time out error.';
    } else if (exception === 'abort') {
        msg = 'Ajax request aborted.';
    } else {
        msg = 'Uncaught Error.\n' + jqXHR.responseText;
    }
    //$('#post').html(msg);
    alert(msg);
}

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
    e.preventDefault();
    e.stopPropagation();

    /*
        ### This Ajax Form Submission is made by Bablu Ahmed
        ### For debugging, check erro message in browser console
        *** Dynamic Settings:
            1. i.Form Action, ii. Refresh Area OR iii. Window Reload (If set '1' or 'true' the #ii will not work)
                i.e,
                <button type="submit"
                class="btn btn-primary btn-sm cia_insert"
                    data-action="<--?php echo base_url('student/assignments')?>"
                    data-redirect=""
                    data-reload=""
                    data-trigger-click="find_courses_btn"
                    data-reload-id="cia_reload_area">
                    Submit
                </button>
            2. Add a class called 'cia_insert' to submit button
            3. Remove 'action' attribute from form
        *** Default Settings:
    */

    let IdD = '';
    let tableD = "";
    let attrD = "";
    let actionD = "";
    let windowReloadD = "";
    let windowRedirectD = "";
    let triggerClickD = "";
    //End Default Settings

    //Data attributes:
    let dataId = $(this).attr('data-id');
    let dataTable = $(this).attr('data-table');
    let dataAttr = $(this).attr('data-attr');
    let dataAction = $(this).attr('data-action');
    let dataReload = $(this).attr('data-reload');
    let dataRedirect = $(this).attr('data-redirect');
    let reloadArea = $(this).attr("data-reload-id");
    let dataTriggerClick = $(this).attr("data-trigger-click");

    //Ajax attributes:
    let id = dataId?dataId:(IdD?IdD:'');
    let table = dataTable?dataTable:(tableD?tableD:'');
    let attr = dataAttr?dataAttr:(attrD?attrD:'');
    let url = dataAction?dataAction:(actionD?actionD:'');
    let windowReload = dataReload?dataReload:(windowReloadD?windowReloadD:'');
    let windowRedirect = dataRedirect?dataRedirect:(windowRedirectD?windowRedirectD:'');
    let triggerClick = dataTriggerClick?dataTriggerClick:(triggerClickD?triggerClickD:'');


    //Submit Button
    let thisBtn = $(this);
    //Form
    let thisForm = thisBtn.closest("form");

    //Check action
    if(!url)
    {
        console.log("Please set the data-action or default action");
    }

    //Ck Editor
    if(typeof CKEDITOR != "undefined")
    {
        //Update CkEdotor's Value
        for (instance in CKEDITOR.instances) 
        {
            CKEDITOR.instances[instance].updateElement();
        }
    }

    //Set Form Data
    let formData = new FormData(thisForm[0]);
    if(!formData)
    {
        console.log("No Form Data Found!");
    }

    //After Inserting, Refresh the Data View Area
    if(reloadArea)
    {
        let reloadAreaExists = $('#'+reloadArea).length;
        if(!reloadAreaExists)
        {
            console.log("Please set an id of area for reload");
        }
    }

    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        async: false,
        beforeSend: function(){
            /*cia_jq_validation(thisForm);
            if(!thisForm.valid())
            {
                return false;
            }*/
        },
        success:function(data){
            if($.trim(data)=='yes')
            {
                alert('Success! Record inserted successfully');
                if(windowRedirect)
                    window.location =windowRedirect; //Redirect path
                else if(windowReload) //1 or 0
                    location.reload();
                else if(triggerClick)
                    $("#"+triggerClick).trigger("click");
                else
                    $("#"+reloadArea).load(location.href + " #"+reloadArea);
            }
            else if($.trim(data)=='no')
            {
                alert('Error! Record not inserted successfully')
            }
            else
            {
                alert('Error! Required field was missing. Please try again');
            }
        }
    });
});

//Ajax Delete by ID ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
window.onload = function() {
    $(document).on('click','.cia_delete',function(e){
        e.preventDefault();
        e.stopPropagation();

        /*
            ### Ajax deletion is made by Bablu Ahmed
            ### For debugging, check erro message in browser console
            *** Dynamic Settings:
                1. i.Form Action, ii. Refresh Area OR iii. Window Reload (If set #ii will not work)
                    i.e,
                    <button type="button" title="Click For Delete" style="margin: 0; font-size: 11px; padding: 1px 3px; color: #fff; font-weight: 600; line-height: 1.3;"
                            class="btn btn-danger btn-xs cia_delete"
                            data-id="<--?php echo $row->CM_ID; ?>"
                            data-table="--UMS_COURSE_MATERIALS"
                            data-attr="--CM_ID"
                            data-action="<--?php echo base_url('assignment/ajax_delete')?>"
                            data-redirect-=""
                            data-reload=""
                            data-reload-id="--cia_reload_area"
                            data-trigger-click="">
                        Delete
                    </button>
                2. Remove 'action' attribute from form
            *** Default Settings:
        */
        let IdD = '';
        let tableD = "";
        let attrD = "";
        let actionD = "";
        let windowReloadD = "";
        let windowRedirectD = "";
        let triggerClickD = "";
        //End Default Settings

        //Data attributes:
        let dataId = $(this).attr('data-id');
        let dataTable = $(this).attr('data-table');
        let dataAttr = $(this).attr('data-attr');
        let dataAction = $(this).attr('data-action');
        let dataReload = $(this).attr('data-reload');
        let dataRedirect = $(this).attr('data-redirect');
        let reloadArea = $(this).attr("data-reload-id");
        let dataTriggerClick = $(this).attr("data-trigger-click");

        //Ajax Params:
        let id = dataId?dataId:(IdD?IdD:'');
        let table = dataTable?dataTable:(tableD?tableD:'');
        let attr = dataAttr?dataAttr:(attrD?attrD:'');
        let url = dataAction?dataAction:(actionD?actionD:'');
        let windowReload = dataReload?dataReload:(windowReloadD?windowReloadD:'');
        let windowRedirect = dataRedirect?dataRedirect:(windowRedirectD?windowRedirectD:'');
        let triggerClick = dataTriggerClick?dataTriggerClick:(triggerClickD?triggerClickD:'');

        let thisBtn = $(this);

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
                    if($.trim(data)=='yes')
                    {
                        alert('Success! Record deleted successfully');
                        if(windowRedirect)
                            window.location =windowRedirect; //Redirect path
                        else if(windowReload) //1 or 0
                            location.reload();
                        else if(triggerClick)
                            $("#"+triggerClick).trigger("click");
                        else
                            $("#"+reloadArea).load(location.href + " #"+reloadArea);
                    }
                    else if($.trim(data)=='no')
                    {
                        alert('Error! Record not deleted successfully')
                    }
                    else
                    {
                        alert('Error! Required id to be deleted is missing. Please try again');
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

//Ajax Form Submission/Update by ID
$(document).on("click", ".cia_update", function (e) {
    e.preventDefault();
    e.stopPropagation();
    /*
        ### This Ajax Form Submission is made by Bablu Ahmed
        ### For debugging, check erro message in browser console
        *** Dynamic Settings:
            1. i.Form Action, ii. Refresh Area OR iii. Window Reload (If set '1' or 'true' the #ii will not work)
                i.e,
                <button type="submit" class="btn btn-primary btn-sm cia_update"
                    data-id="<--?php echo base_url('student/')?>"
                    data-action="<--?php echo base_url('student/')?>"
                    data-redirect=""
                    data-reload=""
                    data-trigger-click="find_courses_btn"
                    data-reload-id="cia_reload_area">
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
    let triggerClickD = "";
    //End Default Settings

    //Data attributes:
    let dataId = $(this).attr('data-id');
    let dataTable = $(this).attr('data-table');
    let dataAttr = $(this).attr('data-attr');
    let dataAction = $(this).attr('data-action');
    let dataReload = $(this).attr('data-reload');
    let dataRedirect = $(this).attr('data-redirect');
    let reloadArea = $(this).attr("data-reload-id");
    let dataTriggerClick = $(this).attr("data-trigger-click");

    //Ajax Params:
    let id = dataId?dataId:(IdD?IdD:'');
    let table = dataTable?dataTable:(tableD?tableD:'');
    let attr = dataAttr?dataAttr:(attrD?attrD:'');
    let url = dataAction?dataAction:(actionD?actionD:'');
    let windowReload = dataReload?dataReload:(windowReloadD?windowReloadD:'');
    let windowRedirect = dataRedirect?dataRedirect:(windowRedirectD?windowRedirectD:'');
    let triggerClick = dataTriggerClick?dataTriggerClick:(triggerClickD?triggerClickD:'');

    //Submit Button
    let thisBtn = $(this);
    //Form
    let thisForm = thisBtn.closest("form");
    //Ck Editor
    if(typeof CKEDITOR != "undefined")
    {
        //Update CkEdotor's Value
        for (instance in CKEDITOR.instances)
        {
            CKEDITOR.instances[instance].updateElement();
        }
    }
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
                else if(triggerClick)
                    $("#"+triggerClick).trigger("click");
                else
                    $("#"+reloadArea).load(location.href + " #"+reloadArea);
            }
            else if($.trim(data)=='no')
            {
                alert('Error! Record not updated successfully')
            }
            else
            {
                alert('Error! Required field was missing. Please try again');
            }
        }
    });
});

//Ajax input's row update by id +++++++++++++++++++++++++++++++++++++++++++++++++++++++
$(document).on("click", ".cia_update_row", function (e) {
    e.preventDefault();
    e.stopPropagation();

    /*
        ### This Ajax Form Submission is made by Bablu Ahmed
        ### For debugging, check erro message in browser console
        *** Dynamic Settings:
            1. i.Form Action, ii. Refresh Area OR iii. Window Reload (If set '1' or 'true' the #ii will not work)
                i.e,
                <button type="submit" class="btn btn-primary btn-sm cia_update_row"
                        data-id="<--?php echo $CM_ID;?>"
                        data-action="<--?php echo base_url('assignment/course_materials_edit')?>"
                        data-redirect="<--?php echo base_url('assignment/course_materials')?>"
                        data-reload=""
                        data-trigger-click="find_courses_btn"
                        data-reload-id="cia_reload_area">
                    Update
                </button>
            2. Add a class called 'cia_update_row' to Update button
            3. Remove 'action' attribute from form
        *** Default Settings:
    */
    let IdD = '';
    let tableD = "";
    let attrD = "";
    let actionD = "";
    let windowReloadD = "";
    let windowRedirectD = "";
    let triggerClickD = "";
    //End Default Settings

    //Data attributes:
    let dataId = $(this).attr('data-id');
    let dataTable = $(this).attr('data-table');
    let dataAttr = $(this).attr('data-attr');
    let dataAction = $(this).attr('data-action');
    let dataReload = $(this).attr('data-reload');
    let dataRedirect = $(this).attr('data-redirect');
    let reloadArea = $(this).attr("data-reload-id");
    let dataTriggerClick = $(this).attr("data-trigger-click");

    //Ajax Params:
    let id = dataId?dataId:(IdD?IdD:'');
    let table = dataTable?dataTable:(tableD?tableD:'');
    let attr = dataAttr?dataAttr:(attrD?attrD:'');
    let url = dataAction?dataAction:(actionD?actionD:'');
    let windowReload = dataReload?dataReload:(windowReloadD?windowReloadD:'');
    let windowRedirect = dataRedirect?dataRedirect:(windowRedirectD?windowRedirectD:'');
    let triggerClick = dataTriggerClick?dataTriggerClick:(triggerClickD?triggerClickD:'');

    //Button
    let thisBtn = $(this);

    //Form Data
    let formData = new FormData();
    let thisRow = thisBtn.closest("tr");
    thisRow.find("input").each(function() {
        //alert(this.value)
        formData.append($(this).attr('name'), $(this).val());
    });

    //Custom Form Data
    /*
    $('.find_course_area :input').each(function() {
        formData.append($(this).attr('name'), $(this).val());
    });
    //Works except undefined
    $('.find_course_area').find('select[name],input[name]').each(function() {
        formData.append($(this).attr('name'), $(this).val());
    });
    */

    //Check Form Data
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
    formData.append('id',id);

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
                else if(triggerClick)
                    $("#"+triggerClick).trigger("click");
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


//Content shown on Modal +++++++++++++++++++++++++++++++++++++++++++++++++++++++
$(document).on("click", ".cia_modal_btn", function (e) {
    e.preventDefault();
    e.stopPropagation();
    /*
        ### This Ajax Modal View is made by Bablu Ahmed
        ### For debugging, check erro message in browser console
        *** Dynamic Settings:
            1. i.e,
                <button type="button" class="btn btn-info btn-xs cia_modal_btn" title="Click For Details" style="margin: 0; font-size: 11px; padding: 1px 3px; color: #fff; font-weight: 600; line-height: 1.3;"
                        data-id="<--?php echo $row->CM_ID; ?>"
                        data-table="UMS_COURSE_MATERIALS"
                        data-attr="CM_ID"
                        data-action="<--?php echo base_url('assignment/material_details')?>"
                        data-redirect=""
                        data-reload=""
                        data-trigger-click="find_courses_btn"
                        data-reload-id="cia_reload_area">
                    Details
                </button>
            2. Add a class called 'cia_modal_btn' to the modal button
            3. Add a class called 'cia_modal' to the modal

        *** Default Settings:
    */
    let IdD = '';
    let tableD = "";
    let attrD = "";
    let actionD = "";
    let windowReloadD = "";
    let windowRedirectD = "";
    let titleD = "";
    let modalTitleD = "";
    let headerBgD = "";
    let modalTypeD = "";
    let modalContentD = "";
    //End Default Settings

    //Attributes:
    let dataId = $(this).attr('data-id');
    let dataTable = $(this).attr('data-table');
    let dataAttr = $(this).attr('data-attr');
    let dataAction = $(this).attr('data-action');
    let dataReload = $(this).attr('data-reload');
    let dataRedirect = $(this).attr('data-redirect');
    let reloadArea = $(this).attr("data-reload-id");
    let dataTitle = $(this).attr("data-title");
    let dataModalTitle = $(this).attr("data-modal-title");
    let dataHeaderBg = $(this).attr("data-header-bg");
    let dataModalType = $(this).attr("data-modal-type");
    let dataModalContent = $(this).attr("data-modal-content");

    //Ajax Params:
    let id = dataId?dataId:(IdD?IdD:'');
    let table = dataTable?dataTable:(tableD?tableD:'');
    let attr = dataAttr?dataAttr:(attrD?attrD:'');
    let url = dataAction?dataAction:(actionD?actionD:'');
    let windowReload = dataReload?dataReload:(windowReloadD?windowReloadD:'');
    let windowRedirect = dataRedirect?dataRedirect:(windowRedirectD?windowRedirectD:'');
    let title = dataTitle?dataTitle:(titleD?titleD:'');
    let modalTitle = dataModalTitle?dataModalTitle:(modalTitleD?modalTitleD:'');
    let headerBg = dataHeaderBg?dataHeaderBg:(headerBgD?headerBgD:'');
    let modalType = dataModalType?dataModalType:(modalTypeD?modalTypeD:'');
    let modalContent = dataModalContent?dataModalContent:(modalContentD?modalContentD:'');

    //Modal elements
    let cia_modal = $('.cia_modal');
    let modal_dialog = cia_modal.find('.modal-dialog');
    let modal_header = cia_modal.find('.modal-header');
    let modal_title = cia_modal.find('.modal-title');
    let modal_body = cia_modal.find('.modal-body');
    let modal_footer = cia_modal.find('.modal-footer');

    //Set modal show/hide
    cia_modal.modal('toggle');

    //Set Modal Title
    if(modalTitle && (modalTitle!=null))
    {
        modal_title.html(modalTitle);
    }
    //Set Modal Header Background
    if(headerBg && (headerBg!=null))
    {
        modal_header.attr('class', 'modal-header');
        modal_header.addClass(headerBg);
    }
    //Set Modal Size
    if(modalType && (modalType!=null))
    {
        modal_dialog.attr('class', 'modal-dialog');
        modal_dialog.addClass(modalType);
    }
    //Set Form Data
    let formData = new FormData();
    formData.append('id',id);
    formData.append('table',table);
    formData.append('attr',attr);
    formData.append('modalContent',modalContent);

    $.ajax({
        type: 'post',
        url: url,
        data: formData,
        contentType: false,
        processData: false,
        async: false,
        beforeSend: function () {
            //modal_body.html(""); /*<img src='<--?php echo base_url(); ?>assets/img/loader.gif' />*/
        },
        success: function (data) {
            //Ck Editor
            if(typeof CKEDITOR != "undefined")
            {
                //Destroy old instances
                for(name in CKEDITOR.instances)
                {
                    CKEDITOR.instances[name].destroy(true);
                }
            }

            modal_body.html(data);
        },
        error: function(){
            alert('Error! Please check form data');
        }
    });
});

//Normal Modal +++++++++++++++++++++++++++++++++++++++++++++++++++++++
$(document).on('click','.modal_btn', function () {
    //Default Settings
    let titleD = "";
    let headerBgD = "";
    let modalTypeD = "";
    //End Default Settings

    //Attributes:
    let dataTitle = $(this).attr("data-title");
    let dataHeaderBg = $(this).attr("data-header-bg");
    let dataModalType = $(this).attr("data-modal-type");

    //Settings:
    let title = dataTitle?dataTitle:(titleD?titleD:'');
    let headerBg = dataHeaderBg?dataHeaderBg:(headerBgD?headerBgD:'');
    let modalType = dataModalType?dataModalType:(modalTypeD?modalTypeD:'');
    
    //Modal elements
    let cia_modal = $('.cia_modal');
    let modal_dialog = cia_modal.find('.modal-dialog');
    let modal_header = cia_modal.find('.modal-header');
    let modal_title = cia_modal.find('.modal-title');
    let modal_body = cia_modal.find('.modal-body');
    let modal_footer = cia_modal.find('.modal-footer');

    //Set modal show/hide
    cia_modal.modal('toggle');

    //Set Modal Title
    if(title && (title!=null))
    {
        modal_title.html(title);
    }
    //Set Modal Header Background
    if(headerBg && (headerBg!=null))
    {
        modal_header.attr('class', 'modal-header');
        modal_header.addClass(headerBg);
    }
    //Set Modal Size
    if(modalType && (modalType!=null))
    {
        modal_dialog.attr('class', 'modal-dialog');
        modal_dialog.addClass(modalType);
    }
    
});

/*
* Dependency Start ---------------------------------------------------------------------------
*/

//Ajax Find Dependency by Own ID //One to Many Relationship
$(document).on("change", ".cia_dependency_one_to_many", function () {

    /*
        ### This Ajax Dependency is made by Bablu Ahmed
        ### For debugging, check erro message in browser console
        *** Dynamic Settings:
            1. i.e,
                <select class="
                     cia_dependency_one_to_many"
                     data-table="INS_PROGRAM"
                     data-attr="DEPT_ID"
                     data-action="<--?php echo base_url('assignment/cia_dependency_by_id')?>"
                     data-view="admin/assignment/dept_dependency"
                     data-reload-id="PROGRAM_ID" >
            2. Add a class called 'cia_dependency_one_to_many' to the Select element

        *** Default Settings:
    */

    let IdD = '';
    let tableD = "";
    let attrD = "";
    let actionD = "";
    let windowReloadD = "";
    let windowRedirectD = "";
    let titleD = "";
    let headerBgD = "";
    let viewD = "";
    //End Default Settings

    //Attributes:
    let thisId = $(this).val();
    let dataId = $(this).attr('data-id');
    let dataTable = $(this).attr('data-table');
    let dataAttr = $(this).attr('data-attr');
    let dataAction = $(this).attr('data-action');
    let dataReload = $(this).attr('data-reload');
    let dataRedirect = $(this).attr('data-redirect');
    let reloadArea = $(this).attr("data-reload-id");
    let dataTitle = $(this).attr("data-title");
    let dataHeaderBg = $(this).attr("data-header-bg");
    let dataView = $(this).attr("data-view");

    //Ajax Params:
    let id = thisId?thisId:(IdD?IdD:'');
    let table = dataTable?dataTable:(tableD?tableD:'');
    let attr = dataAttr?dataAttr:(attrD?attrD:'');
    let url = dataAction?dataAction:(actionD?actionD:'');
    let windowReload = dataReload?dataReload:(windowReloadD?windowReloadD:'');
    let windowRedirect = dataRedirect?dataRedirect:(windowRedirectD?windowRedirectD:'');
    let title = dataTitle?dataTitle:(titleD?titleD:'');
    let headerBg = dataHeaderBg?dataHeaderBg:(headerBgD?headerBgD:'');
    let view = dataView?dataView:(viewD?viewD:'');

    //Form Data
    let formData = new FormData();
    formData.append('id', id);
    formData.append('table', table);
    formData.append('attr', attr);
    formData.append('view', view);


    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        success:function(data){
            if($.trim(data) != "no"){
                $("#"+reloadArea).html(data);
                $("#"+reloadArea).trigger("chosen:updated");
            }
            else
            {
                console.log('Error! Please check form data');
            }
        }
    });
});

//Ajax Find Dependency by Join Two Table //One to Many Relationship by Foreign ID
$(document).on("change", ".cia_dependency_by_join_two_tbl", function () {
    /*
        ### This Ajax Dependency is made by Bablu Ahmed
        ### For debugging, check erro message in browser console
        *** Dynamic Settings:
            1. i.e,
                <select class="
                    cia_dependency_by_join_two_tbl"
                    data-table="INS_PROGRAM"
                    data-table2="ACA_COURSE"
                    data-attr="PROGRAM_ID"
                    data-attr2="DEPT_ID"
                    data-action="<--?php echo base_url('assignment/cia_dependency_by_join_two_tbl')?>"
                    data-view="admin/assignment/course_dependency"
                    data-reload-id="COURSE_ID" >
            2. Add a class called 'cia_dependency_by_join_two_tbl' to the Select element

        *** Default Settings:
    */

    let IdD = '';
    let tableD = "";
    let tableD2 = "";
    let attrD = "";
    let attrD2 = "";
    let actionD = "";
    let windowReloadD = "";
    let windowRedirectD = "";
    let titleD = "";
    let headerBgD = "";
    let viewD = "";
    //End Default Settings

    //Attributes:
    let thisId = $(this).val();
    let dataId = $(this).attr('data-id');
    let dataTable = $(this).attr('data-table');
    let dataTable2 = $(this).attr('data-table2');
    let dataAttr = $(this).attr('data-attr');
    let dataAttr2 = $(this).attr('data-attr2');
    let dataAction = $(this).attr('data-action');
    let dataReload = $(this).attr('data-reload');
    let dataRedirect = $(this).attr('data-redirect');
    let reloadArea = $(this).attr("data-reload-id");
    let dataTitle = $(this).attr("data-title");
    let dataHeaderBg = $(this).attr("data-header-bg");
    let dataView = $(this).attr("data-view");

    //Ajax Params:
    let id = thisId?thisId:(IdD?IdD:'');
    let table = dataTable?dataTable:(tableD?tableD:'');
    let table2 = dataTable2?dataTable2:(tableD2?tableD2:'');
    let attr = dataAttr?dataAttr:(attrD?attrD:'');
    let attr2 = dataAttr2?dataAttr2:(attrD2?attrD2:'');
    let url = dataAction?dataAction:(actionD?actionD:'');
    let windowReload = dataReload?dataReload:(windowReloadD?windowReloadD:'');
    let windowRedirect = dataRedirect?dataRedirect:(windowRedirectD?windowRedirectD:'');
    let title = dataTitle?dataTitle:(titleD?titleD:'');
    let headerBg = dataHeaderBg?dataHeaderBg:(headerBgD?headerBgD:'');
    let view = dataView?dataView:(viewD?viewD:'');

    //Form Data
    let formData = new FormData();
    formData.append('id', id);
    formData.append('table', table);
    formData.append('table2', table2);
    formData.append('attr', attr);
    formData.append('attr2', attr2);
    formData.append('view', view);


    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        success:function(data){
            if($.trim(data) != "no"){
                $("#"+reloadArea).html(data);
                $("#"+reloadArea).trigger("chosen:updated");
            }
            else
            {
                console.log('Queried but no result found');
            }
        },
        error: function (jqXHR, exception) {
            getJqXhrError(jqXHR, exception);
        }
    });
});

//Ajax Find Dependency by Joining Three Tables //One to Many and Many to One Relationship
$(document).on("change", ".cia_dependency_by_one_to_many_to_one", function () {
    /*
        ### This Ajax Dependency is made by Bablu Ahmed
        ### For debugging, check erro message in browser console
        *** Dynamic Settings:
            1. i.e,
                <select class="
                    cia_dependency_by_one_to_many_to_one"
                    data-table="INS_FACULTY"
                    data-table2="INS_FAC_DEPT"
                    data-table3="INS_DEPT"
                    data-attr="FACULTY_ID"
                    data-attr2="DEPT_ID"
                    data-action="<--?php echo base_url('assignment/cia_dependency_by_one_to_many_to_one')?>"
                    data-view="admin/assignment/dept_dependency"
                    data-reload-id="DEPT_ID" >
            2. Add a class called 'cia_dependency_by_one_to_many_to_one' to the Select element

        *** Default Settings:
    */

    let IdD = '';
    let tableD = "";
    let tableD2 = "";
    let tableD3 = "";
    let attrD = "";
    let attrD2 = "";
    let actionD = "";
    let windowReloadD = "";
    let windowRedirectD = "";
    let titleD = "";
    let headerBgD = "";
    let viewD = "";
    //End Default Settings

    //Attributes:
    let thisId = $(this).val();
    let dataId = $(this).attr('data-id');
    let dataTable = $(this).attr('data-table');
    let dataTable2 = $(this).attr('data-table2');
    let dataTable3 = $(this).attr('data-table3');
    let dataAttr = $(this).attr('data-attr');
    let dataAttr2 = $(this).attr('data-attr2');
    let dataAction = $(this).attr('data-action');
    let dataReload = $(this).attr('data-reload');
    let dataRedirect = $(this).attr('data-redirect');
    let reloadArea = $(this).attr("data-reload-id");
    let dataTitle = $(this).attr("data-title");
    let dataHeaderBg = $(this).attr("data-header-bg");
    let dataView = $(this).attr("data-view");

    //Ajax Params:
    let id = thisId?thisId:(IdD?IdD:'');
    let table = dataTable?dataTable:(tableD?tableD:'');
    let table2 = dataTable2?dataTable2:(tableD2?tableD2:'');
    let table3 = dataTable3?dataTable3:(tableD3?tableD3:'');
    let attr = dataAttr?dataAttr:(attrD?attrD:'');
    let attr2 = dataAttr2?dataAttr2:(attrD2?attrD2:'');
    let url = dataAction?dataAction:(actionD?actionD:'');
    let windowReload = dataReload?dataReload:(windowReloadD?windowReloadD:'');
    let windowRedirect = dataRedirect?dataRedirect:(windowRedirectD?windowRedirectD:'');
    let title = dataTitle?dataTitle:(titleD?titleD:'');
    let headerBg = dataHeaderBg?dataHeaderBg:(headerBgD?headerBgD:'');
    let view = dataView?dataView:(viewD?viewD:'');

    //Form Data
    let formData = new FormData();
    formData.append('id', id);
    formData.append('table', table);
    formData.append('table2', table2);
    formData.append('table3', table3);
    formData.append('attr', attr);
    formData.append('attr2', attr2);
    formData.append('view', view);


    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        success:function(data){
            if($.trim(data) != "no"){
                $("#"+reloadArea).html(data);
                $("#"+reloadArea).trigger("chosen:updated");
            }
            else
            {
                console.log('Queried but no result found');
            }
        },
        error: function (jqXHR, exception) {
            getJqXhrError(jqXHR, exception);
        }
    });
});

//-----------------------/End Dependency--------------------------------


//Ajax DataTable ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
window.onload = function() {

    //-------Start Settings------
    let table = 'UMS_FORUM_MST';
    // presentable all columns
    let presentable_cols = ['FORUM_TITLE','CRE_DT'];
    // sortable/searchable columns
    let searchable_cols = ['FORUM_TITLE','CRE_DT'];
    // unsortable/searchable columns
    let unorderable_cols = ['FORUM_TITLE'];
    //------End Settings-------

    let allColumns = [];
    for (let presentable_col of presentable_cols)
    {
        if(unorderable_cols.length > 0)
        {
            let found = unorderable_cols.indexOf(presentable_col);
            if(found != -1)
            {
                allColumns.push({"bSortable": false,"searchable": false, "orderable": false});
            }
            else
            {
                allColumns.push(null);
            }
        }
        else
        {
            allColumns.push(null);
        }
    }

    // destroy if have initialized an old datatable
    $('.cia_datatable').dataTable().fnDestroy();

    // new datatable
    $('.cia_datatable').DataTable({
        //"processing": true,  // show loader
        "serverSide": true,  // enable ajax
        "pageLength": 10,    // 10 records shown
        "bDestroy": true,   // reinitialize datatable
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]], // select box
        ajax:{
            url :  '<?php echo site_url("student/cia_datatable"); ?>',
            type : "POST",
            dataType:'json',
            data: function( d ) {
                d.searchable_cols = JSON.stringify(searchable_cols);
                d.presentable_cols = JSON.stringify(presentable_cols);
                d.table = table;
            }
        },

        //order: [[ 1, "desc" ]],
        "columns": allColumns,
    });
};
//End datatable





