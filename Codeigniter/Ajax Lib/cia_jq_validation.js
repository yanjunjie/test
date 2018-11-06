//Jquery Validation
function cia_jq_validation(thisForm) {

/*
    ### This Form Validation is made by Bablu Ahmed
    ### This is based on Jquery Validation Plugin, https://jqueryvalidation.org 
    ### For debugging, check erro message in browser console

    *** Dynamic Settings:
        1. For required only i.e,
            <input type='text' name='bablu' class='cia_required'>
        2. To upload valid file formats i.e,
            <input type='file' name='bablu' class='cia_required_file' data-file-type="jpg,jpeg,doc,docx,pdf">

    *** Default Settings:
    */
    let fileTypeD = '';
    //End Default Settings

    //Attributes:

    let cia_required_elements = thisForm.find('.cia_required');
    let cia_required_file_elements = thisForm.find('.cia_required_file');

    //Rules:
    let cia_validation_rules = {};
    let cia_validation_msgs = {};

    //Validate only for Required Fields
    cia_required_elements.each(function(index, element) {
        let nameAttr = $(this).attr('name');
        cia_validation_rules.nameAttr={required: true};
    });

    console.log(cia_validation_rules);

    //Validate Required File Types
    cia_required_file_elements.each(function(index, element) {
        let nameAttr = $(this).attr('name');
        let dataFileType = $(this).attr('data-file-type');
        let fileType = dataFileType?dataFileType:fileTypeD;
        let fileTypeArr = fileType.split(/[\s,|]+/);
        let fileTypeStr = fileTypeArr.join('|');
        //Set Required Formats
        /*cia_validation_rules.nameAttr={
            required: true,
            extension: fileTypeStr
        };*/
        //Set Messages
        /*cia_validation_msgs.nameAttr= {
            extension: "Please upload "+fileTypeStr+" file formats"
        }*/
    });

    //Call Validate Function to execute rules
    thisForm.validate({
        rules: cia_validation_rules
        //messages: cia_validation_msgs
    });


    /*thisForm.validate({
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
    });*/
}