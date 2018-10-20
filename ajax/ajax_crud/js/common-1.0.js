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
5. For the insert, submit button's text must be "Submit" or "Save" 

*/

window.onload = function() {
  $(document).on('click','.acb',function(e){
		e.preventDefault();
		e.stopPropagation();
		//Ajax CRUD Button (ACB)
		var thisBtn = $(this);
		//Form
        var thisForm = thisBtn.closest("form");
        //Type //which action will perform i.e, create c or insert i, read r, update u, delete d
      	/*var dataType = thisBtn.attr("data-type");
      	if(!dataType)
		{
			alert('Please enter action type simply data-type');
			return false;
		}*/
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
        var baseUrl = window.location.protocol + "//" + window.location.host + "/";
        var samePageUrl = window.location.href;

		$.ajax({
            type: method,
            data: formData,
            url: param?action+'/'+param:action,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".loadingImg").html("");
            },
            success: function (data) {
				if($.trim(data)=="yes")
				{
					alert('Success!');
					$("#create_read").load(location.href + " #create_read");
				}
				else
				{
					alert('Error! Please try again');
				}
            }
        });
        //End Ajax
	});
	//End Submit
}
//End window load