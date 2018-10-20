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
  $(document).on('click','.submit',function(e){
		e.preventDefault();
		e.stopPropagation();
		var thisBtn = $(this);
        var thisForm = thisBtn.closest("form");
        var dataAction = thisBtn.attr("data-action");
        	dataAction = dataAction?dataAction:'';
		var dataParam = thisBtn.attr("data-param");
			dataParam = dataParam?dataParam:'';
        var method = thisForm.attr('method');
        	method = method?method:"POST";
        var formData = new FormData(thisForm[0]);

        //Form action
		var formAction = thisForm.attr('action');
			formAction = formAction?formAction:'';

		//Form action's parameter
		var actionParam = formAction.substr(formAction.lastIndexOf('/') + 1);
        	actionParam = actionParam?actionParam:'';

        //Action Param must be number or number+character i.e, 1,2,3... or foo3bar5
		var pattern =/\d+/;
		var isNumberTheParam = pattern.test(actionParam); //true
        	actionParam=isNumberTheParam?actionParam:''; 

		//Form action without parameter
        var str = formAction.substr(formAction.lastIndexOf('/') + 1) + '$';
			formAction = formAction.replace( new RegExp(str), '' ); 
		
		//New Form action
		var newFormAction = formAction?formAction:dataAction?dataAction:window.location.href;		
        var baseUrl = window.location.protocol + "//" + window.location.host + "/";
		
console.log(formAction);
console.log(actionParam);
		$.ajax({
            type: method,
            data: formData,
            url: formAction+actionParam,
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