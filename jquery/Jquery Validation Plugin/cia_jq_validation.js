//Jquery Validation
function cia_jq_validation(thisForm) {

/*
    ### This Form Validation is made by Bablu Ahmed
    ### This is based on Jquery Validation Plugin, https://jqueryvalidation.org 
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


    thisForm.validate({
        rules: {
            CM_TITLE: {required: true},
            DEPT_ID: {required: true},
            YSESSION_ID: {required: true},
            PROGRAM_ID: {required: true},
            BATCH_ID: {required: true},
            SECTION_ID: {required: true},
            COURSE_ID: {required: true},
            LKP_ID: {required: true},
            ATTACHMENT: {
                required: true,
                extension: "doc|docx|jpg|jpeg|pdf"
            }
        },
        messages: {
            ATTACHMENT: {
                required: "Attachment required",
                extension: "Please upload valid file formats"
            },
            LKP_ID:"Category required"
        }
    });
}