//Jquery Validation
function cia_jq_validation(thisForm) {
    $.validator.setDefaults({ ignore: ":hidden:not(select)" }); //for all hidden select elements
    /*
        ### This Form Validation is made by Bablu Ahmed
        ### This is based on Jquery Validation Plugin, https://jqueryvalidation.org
        ### For debugging, check erro message in browser console

        *** Dynamic Settings:
            1. For required only i.e,
                <input type='text' name='bablu' class='cia_required'>
            2. To upload valid file formats i.e,
                <input name="myfile" type="file" class="form-control cia_required_file" data-file-type="jpg png jpeg">

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
        cia_validation_rules[nameAttr]={required: true};
    });

    //Validate Required File Types
    cia_required_file_elements.each(function(index, element) {
        let nameAttr = $(this).attr('name');
        let dataFileType = $(this).attr('data-file-type');
        let fileType = dataFileType?dataFileType:fileTypeD;
        let fileTypeArr = fileType.split(/[\s,|]+/);
        let fileTypeStr = fileTypeArr.join('|');
        //Set Required Formats
        cia_validation_rules[nameAttr]={
            required: true,
            extension: fileTypeStr
        };
        //Set Messages
        cia_validation_msgs[nameAttr]= {
            extension: "Please upload a valid file. Allowed types are "+fileTypeStr
        }
    });

    //Call Validate Function to execute rules and messages
    thisForm.validate({
        rules: cia_validation_rules,
        messages: cia_validation_msgs
    });

}