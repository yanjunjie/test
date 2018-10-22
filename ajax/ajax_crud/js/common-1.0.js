import * as config from './config.js';
/*
Author: Md. Bablu Mia
Copyright: Copyright all rights reserved, 2018
Version: v.1.0
Website: w3public.com
Description: This plugin is made for Ajax CRUD operation for PHP Raw, Frameworks i.e, Codeigniter, Laravel etc.

Insert: For inserting data into database follow the below instructions
1. Create a container with an id "create_read", remember the form must be inside the container 
	   and if you want to see inserted data in the same page then that will also have inside the container
2. Now write a class called "submit" to the submit button
3. There are two options to set action
	i) You can set your action using form action attribute
	ii) You can set your action using data-action attribute in the submit button i.e, data-action="..."
	N.B, If you don't mention any action then by default the action will be the same page
	     and this is good for framework i.e, Laravel, Codeigniter
4. In the action page, after successfully inserting data echo "yes" and for error echo "no"
5. For performing the insert action we must have a data-action-type attribute
	and value will be i.e, create or c or insert or i
6. For Raw insert operation (not any framework i.e, raw PHP) set extra attrubute called data-env="raw"
	And catch the url data using $_GET['id'] or $_POST['id']

*/

window.onload = function() {
  $(document).on('click','.acb',function(e){
		e.preventDefault();
		e.stopPropagation();
		//Ajax CRUD Button (ACB)
		var thisBtn = $(this);

		/*
		*Data-Action-Type
	  	*For which an action will perform i.e, create or c or insert or i, read or r or v, update or u or m, delete or d or destroy
	  	*/

	  	var dataActionType = $.trim(thisBtn.attr("data-action-type"));
	  	if(!dataActionType)
		{
			alert('Please set the value of data-action-type attribute');
			return false;
		}
		if(dataActionType=='create'||dataActionType=='c'||dataActionType=='insert'||dataActionType=='i')
		{
            dataActionType='c';
		}
		else if(dataActionType=='read'||dataActionType=='r'||dataActionType=='view'||dataActionType=='v')
		{
		  dataActionType='r';
		}
		else if(dataActionType=='update'||dataActionType=='u'||dataActionType=='modify'||dataActionType=='m')
		{
		  dataActionType='u';
		}
		else if(dataActionType=='delete'||dataActionType=='d'||dataActionType=='destroy')
		{
		  dataActionType='d';
		}
		else
		{
            alert('You don\'t set appropriate value of data-action-type attribute');
            return false;
		}

		//Form
        var thisForm = thisBtn.closest("form");
        //Data Action
        var dataAction = thisBtn.attr("data-action");
        	dataAction = dataAction?dataAction:'';
		//Data Param
		var dataParam = thisBtn.attr("data-param");
			dataParam = dataParam?dataParam:'';
		//Method
        var method = thisForm.attr('method');
        	method = method?method:"POST";
		//Form Data
        var formData = new FormData(thisForm[0]);

        //Form action raw //First check 'form action' otherwise check 'data action'
		var formAction = thisForm.attr('action');
      	var action = formAction?formAction:dataAction?dataAction:'';

		//Action Param
		var actionParam = action.substr(action.lastIndexOf('/') + 1);
        	actionParam = actionParam?actionParam:dataParam?dataParam:'';

        //Action Param must be number or number+character i.e, 1,2,3... or foo3bar5 //Checking Action Param or not
		var pattern =/\d+/;
		var isNumberTheParam = pattern.test(actionParam); //true
        	actionParam=isNumberTheParam?actionParam:''; 

		//Form action without parameter <---------------
	  	action = actionParam?action.replace( new RegExp(actionParam), '' ):action;

      	//First check 'form action parameter' otherwise check 'data param' <---------------
      	var param = actionParam?actionParam:dataParam?dataParam:'';

		//URLs
        var baseUrl = window.location.protocol + "//" + window.location.host + "/"; //http://localhost/
        var samePageUrl = window.location.href; //http://localhost/test/ajax/ajax_crud/
        var customUrl = config.baseURL('test/'); //http://localhost/test/

        //Check action param set or not for update/delete action
        if(dataActionType=='u'||dataActionType=='d')
		{
			if(!param)
			{
				alert("Please set the value of the action parameter");
				return false;
			}

			//To access param using $_POST['id']
      		formData.append('id', param);
      		//Action type i.e, create, read, update, delete
      		formData.append('actionType', dataActionType);
		}

		//Middleware env i.e, raw, laravel or lara, codeigniter or ci
	  	let formURL = 'error/404'; //temp url
      	var dataEnv = thisBtn.attr("data-env");
	  	if(dataEnv=="raw" && (dataActionType=='u'||dataActionType=='d'))
	  	{
            formURL=param?action+'?id='+param:action;
		}
		else
		{
            formURL=param?action+'/'+param:action;
		}
		
		//Ajax for CRUD
		$.ajax({
            type: method,
            data: formData,
            url: formURL,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".loadingImg").html("");
            },
            success: function (data) {
				if($.trim(data)=="yes")
				{
					if(dataActionType=='c')
					{
						alert("Success! Record inserted successfully");
					}
                    else if(dataActionType=='u')
                    {
                        alert("Success! Record updated successfully");
                    }
                    else if(dataActionType=='d')
                    {
                        alert("Success! Record deleted successfully");
                    }
                    else
					{
						//An unknown action performed
                        alert("Oops! An error occurred, an unknown action performed");
					}

					//Refresh a part of the page
					$("#create_read").load(location.href + " #create_read");
				}
				else if($.trim(data)=="no")
				{
					alert('Sorry, we can\'t perform this action. Please try again');
				}
				else
				{
					//Server side error
					alert('Internal Error! Please try again later');
				}
            }
        });
        //End Ajax
	});
	//End Submit
}
//End window load