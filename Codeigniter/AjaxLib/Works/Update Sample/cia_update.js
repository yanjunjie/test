//Ajax Form Submission/Update by ID
    $(document).on("click", ".cia_update", function (e) {
        /*
            ### This Ajax Form Submission is made by Bablu Ahmed
            ### For debugging, check erro message in browser console
            *** Dynamic Settings:
                1. i.Form Action, ii. Refresh Area OR iii. Window Reload (If set '1' or 'true' the #ii will not work)
                    i.e,
                    <button type="submit" class="btn btn-primary btn-sm cia_update"
                        data-id="<--?php echo base_url('student/')?>"
                        data-action="<--?php echo base_url('student/')?>"
                    data-refresh-id="cia_refresh_area"
                    data-window-reload="1">
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
        //End Default Settings

        e.preventDefault();
        e.stopPropagation();

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

        //Submit Button
        let thisBtn = $(this);
        //Form
        let thisForm = thisBtn.closest("form");

        //First check 'data-id' otherwise check default id 'IdD'
        id = dataId?dataId:(IdD?IdD:'');
        if(!id)
        {
            console.log("Please set the data-id or default id");
        }

        //First check 'data-action' otherwise check default action 'actionD'
        url = dataAction?dataAction:(actionD?actionD:'');
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
            console.log("Please set the 'data-refresh-id'");
        }

        //After Inserting, Updating, and Deleting Data, Refresh the Data View Area
        let refreshAreaExists = $('#cia_refresh_area').length;
        if(!refreshAreaExists)
        {
            console.log("Please set 'cia_refresh_area' id on the Data View Area");
        }

        //Window Reload
        windowReload = thisBtn.attr("data-window-reload"); //Boolean Value, i.e, 0 or 1
        if(windowReload)
        {
            console.log("Window will be reloaded");
        }

        //Add data id to FormData API
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
                    alert('Success! Record inserted successfully');
                    if(!windowReload)
                        $("#"+refreshArea).load(location.href + " #"+refreshArea);
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

